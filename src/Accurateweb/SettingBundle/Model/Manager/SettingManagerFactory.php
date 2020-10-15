<?php

namespace Accurateweb\SettingBundle\Model\Manager;

use Accurateweb\SettingBundle\Model\SettingConfiguration\SettingConfigurationPool;
use Accurateweb\SettingBundle\Model\Storage\SettingStorageInterface;
use ProxyManager\Factory\LazyLoadingValueHolderFactory;
use ProxyManager\Proxy\VirtualProxyInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class SettingManagerFactory
{
  private $settingConfigurationPool;
  private $settingStorage;
  private $eventDispatcher;

  public function __construct (
    SettingConfigurationPool $settingConfigurationPool,
    SettingStorageInterface $settingStorage,
    EventDispatcherInterface $eventDispatcher
  )
  {
    $this->settingConfigurationPool = $settingConfigurationPool;
    $this->settingStorage = $settingStorage;
    $this->eventDispatcher = $eventDispatcher;
  }

  /*
   * Создаем проксиобъект, который не будет прогружать настройки до первого их запроса
   * Игнорируем метод getModifiedValues для того, чтобы не было ошибок при сохранении настроек в случае, если не была вызвана ни одна из настроек
   */
  public function createSettingManager ()
  {
    $factory = new LazyLoadingValueHolderFactory();

    /** @var SettingManager|VirtualProxyInterface $proxy */
    $proxy = $factory->createProxy(
      'Accurateweb\SettingBundle\Model\Manager\SettingManager',
      function (& $wrappedObject, $proxy, $method, $parameters, & $initializer) {
        if ($method === 'getModifiedValues')
        {
          $wrappedObject = new SettingManager($this->eventDispatcher);
          return false;
        }

        $initializer = null;
        $wrappedObject = $this->_createSettingManager();

        return true;
      }
    );

    return $proxy;
  }

  /**
   * @return SettingManager
   */
  private function _createSettingManager()
  {
    $manager = new SettingManager($this->eventDispatcher);

    foreach ($this->settingConfigurationPool->getSettingConfigurations() as $item)
    {
      $name = $item->getName();
      $value = $this->settingStorage->get($name);

      if (is_null($value))
      {
        $value = $item->getDefaultValue();
      }
      elseif ($item->getModelTransformer())
      {
        $value = $item->getModelTransformer()->reverseTransform($value);
      }

      $manager->addValue($name, $value);
    }

    return $manager;
  }
}