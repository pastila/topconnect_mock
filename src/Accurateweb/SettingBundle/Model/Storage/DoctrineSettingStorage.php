<?php
/**
 *  (c) 2019 ИП Рагозин Денис Николаевич. Все права защищены.
 *
 *  Настоящий файл является частью программного продукта, разработанного ИП Рагозиным Денисом Николаевичем
 *  (ОГРНИП 315668300000095, ИНН 660902635476).
 *
 *  Алгоритм и исходные коды программного кода программного продукта являются коммерческой тайной
 *  ИП Рагозина Денис Николаевича. Любое их использование без согласия ИП Рагозина Денис Николаевича рассматривается,
 *  как нарушение его авторских прав.
 *   Ответственность за нарушение авторских прав наступает в соответствии с действующим законодательством РФ.
 */

namespace Accurateweb\SettingBundle\Model\Storage;

use Accurateweb\SettingBundle\Repository\SettingRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\UnitOfWork;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class DoctrineSettingStorage implements SettingStorageInterface
{
  private $settingsRepository;
  private $em;
  private $settings;

  public function __construct (SettingRepository $settingsRepository, EntityManager $em)
  {
    $this->settings = [];
    $this->settingsRepository = $settingsRepository;
    $this->em = $em;
  }

  public function get ($name)
  {
    if (!isset($this->settings[$name]))
    {
      $this->settings[$name] = $this->settingsRepository->findOneBy(array('name' => $name));

      if (!$this->settings[$name])
      {
//        $class = $this->settingsRepository->getClassName();
//        $this->settings[$name] = new $class();
//        $this->settings[$name]->setName($name);
//        $this->em->persist($this->settings[$name]);
//        $this->em->flush();
        return null;
      }
    }

    return $this->settings[$name]->getValue();
  }

  public function set ($name, $value)
  {
    if (!isset($this->settings[$name]) ||
      $this->em->getUnitOfWork()->getEntityState($this->settings[$name]) !== UnitOfWork::STATE_MANAGED
    )
    {
      $this->settings[$name] = $this->settingsRepository->findOneBy(array('name' => $name));

      if (!$this->settings[$name])
      {
        $class = $this->settingsRepository->getClassName();
        $this->settings[$name] = new $class();
        $this->settings[$name]->setName($name);
      }
    }

    $this->settings[$name]->setValue($value);
  }

  public function commit ()
  {
    if ($this->em->isOpen())
    {
      $this->em->beginTransaction();

      try
      {
        $settings = [];

        foreach ($this->settings as $name => $value)
        {
          if ($value)
          {
            if ($this->em->getUnitOfWork()->getEntityState($value) !== UnitOfWork::STATE_MANAGED)
            {
              $value = $this->em->merge($value);
            }

            $this->em->persist($value);
            $settings[] = $value;
          }
        }

        $this->em->flush($settings);
        $this->em->commit();
      }
      catch (\Exception $e)
      {
        $this->em->rollback();
      }
    }
  }
}