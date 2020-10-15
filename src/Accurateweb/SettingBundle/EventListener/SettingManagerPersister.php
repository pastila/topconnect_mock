<?php

namespace Accurateweb\SettingBundle\EventListener;

use Accurateweb\SettingBundle\Model\Manager\SettingManager;
use Accurateweb\SettingBundle\Model\SettingConfiguration\SettingConfigurationPool;
use Accurateweb\SettingBundle\Model\Storage\SettingStorageInterface;
use Symfony\Component\Console\Event\ConsoleTerminateEvent;
use Symfony\Component\HttpKernel\Event\PostResponseEvent;

class SettingManagerPersister
{
  private $settingConfigurationPool;
  private $settingStorage;
  private $settingManager;

  public function __construct (
    SettingConfigurationPool $settingConfigurationPool,
    SettingStorageInterface $settingStorage,
    SettingManager $settingManager
  )
  {
    $this->settingConfigurationPool = $settingConfigurationPool;
    $this->settingStorage = $settingStorage;
    $this->settingManager = $settingManager;
  }

  public function onTerminate(PostResponseEvent $event)
  {
    $this->persistSettings();
  }

  public function onConsoleTerminate(ConsoleTerminateEvent $event)
  {
    $this->persistSettings();
  }

  protected function persistSettings()
  {
    foreach ($this->settingManager->getModifiedValues() as $item)
    {
      $configure = $this->settingConfigurationPool->getSettingConfiguration($item);
      $name = $configure->getName();
      $value = $this->settingManager->getValue($name);

//      if ($configure->getModelTransformer())
//      {
//        $value = $configure->getModelTransformer()->transform($value);
//      }

      $this->settingStorage->set($name, $value);
    }

    $this->settingStorage->commit();
  }
}