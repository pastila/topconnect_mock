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

namespace Accurateweb\SettingBundle\Model\Setting;

use Accurateweb\SettingBundle\Model\Storage\SettingStorageInterface;
use Doctrine\ORM\EntityRepository;

class EntitySetting implements SettingInterface
{
  private $name;
  private $description;
  private $settingStorage;
  private $entityRepository;

  public function __construct (SettingStorageInterface $settingStorage, EntityRepository $entityRepository, $name, $description)
  {
    $this->settingStorage = $settingStorage;
    $this->name = $name;
    $this->description = $description;
    $this->entityRepository = $entityRepository;
  }

  public function getName ()
  {
    return $this->name;
  }

  public function getValue ()
  {
    $value = $this->settingStorage->get($this->name);

    if (is_null($value))
    {
      return null;
    }

    try
    {
      $value = $this->entityRepository->find($value);
    }
    catch (\Exception $e)
    {
      return null;
    }

    return $value;
  }

  public function setValue ($value)
  {
    $class = $this->entityRepository->getClassName();

    if (!$value instanceof $class)
    {
      $id = $value;
    }
    else
    {
      $id = $value->getId(); //бида
    }

    $this->settingStorage->set($this->name, $id);
  }

  public function getFormType ()
  {
//    return 'entity';
    return 'choice';
  }

  public function getFormOptions ()
  {
    return array(
//      'class' => $this->entityRepository->getClassName(),
      'choices' => $this->getChoices()
    );
  }

  public function getStringValue ()
  {
    if (is_null($this->getValue()))
    {
      return '';
    }

    if (method_exists($this->getValue(), '__toString'))
    {
      return $this->getValue()->__toString();
    }

    return sprintf('%s[%s]', $this->entityRepository->getClassName(), $this->getValue()->getId());
  }

  public function getDescription ()
  {
    return $this->description;
  }

  private function getChoices()
  {
    $choices = array();

//    $meta = $em->getClassMetadata(get_class($entity));
//    $identifier = $meta->getSingleIdentifierFieldName();
    foreach ($this->entityRepository->findAll() as $item)
    {
      $choices[(string)$item] = $item->getId();
    }

    return $choices;
  }

  public function getModelTransformer()
  {
    return null;
  }
}