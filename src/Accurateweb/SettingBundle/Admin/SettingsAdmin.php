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

namespace Accurateweb\SettingBundle\Admin;

use Accurateweb\SettingBundle\Model\SettingConfiguration\SettingConfigurationPool;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;

class SettingsAdmin extends AbstractAdmin
{
  protected $settingConfigurationPool;

  public function configureRoutes(RouteCollection $collection)
  {
    $collection->remove('create');
    $collection->remove('delete');
    parent::configureRoutes($collection);
  }

  public function __construct ($code, $class, $baseControllerName, SettingConfigurationPool $settingConfigurationPool)
  {
    $this->settingConfigurationPool = $settingConfigurationPool;
    parent::__construct($code, $class, $baseControllerName);
  }

  public function toString ($object)
  {
    $conf = $this->settingConfigurationPool->getSettingConfiguration($object->getName());
    return $conf->getDescription();
  }


  public function configureListFields(ListMapper $list)
  {
    $list
      ->add('name', null, array(
        'label' => 'Имя'
      ))
      ->add('value', null, array(
        'label' => 'Значение'
      ))
      ->add('comment', null, array(
        'label' => 'Описание'
      ))
      ->add('_action', null, array(
        'actions' => array(
          'edit' => array(),
        )
      ));
  }

  public function configureFormFields(FormMapper $form)
  {
    $subject = $this->getSubject();
    $conf = $this->settingConfigurationPool->getSettingConfiguration($subject->getName());
    $options = $conf->getFormOptions($subject->getValue());

    $options = array_replace(array(
      'label' => 'Значение'
    ), $options);

//    if (!isset($options['data']))
//    {
//      $options['data'] = $setting->getValue();
//    }

    $form->add('value', $conf->getFormType(), $options);
    $data_transformer = $conf->getModelTransformer();

    if ($data_transformer)
    {
      $form->get('value')->addModelTransformer($data_transformer);
    }
  }

  public function getTemplate($name)
  {
    $template = parent::getTemplate($name);
    return $template;
  }

  public function preUpdate ($object)
  {
    $this->getConfigurationPool()->getContainer()->get('aw.settings.manager')->setValue($object->getName(), $object->getValue());
    //Вообще нужен свой modelmanager
  }

  public function getDatagrid ()
  {
    $this->keepTableState();
    return parent::getDatagrid();
  }

  private function keepTableState()
  {
    $settings = $this->settingConfigurationPool->getSettingConfigurations();
    $settingsRepository = $this->getConfigurationPool()->getContainer()->get('aw.settings.storage');
    $storage = $this->getConfigurationPool()->getContainer()->get('aw.settings.storage');

    foreach ($settings as $setting)
    {
      if ($settingsRepository->get($setting->getName()) === null)
      {
        $val = $this->getConfigurationPool()->getContainer()->get('aw.settings.manager')->getValue($setting->getName());

        if ($val != $storage->get($setting->getName()) || is_null($val))
        {
          $storage->set($setting->getName(), $val);
        }
      }
    }

    $storage->commit();

    $pq = new ProxyQuery($this->createQuery()
      ->where('o.name NOT IN (:settingNames)')
      ->setParameter('settingNames', array_keys($settings))
    );
    $this->getModelManager()->batchDelete($this->getClass(), $pq);
  }
}