<?php

namespace Accurateweb\SettingBundle\Model\SettingConfiguration;

class SettingConfigurationPool
{
  /**
   * @var SettingConfigurationInterface[]
   */
  private $settingConfigurations;

  public function __construct ()
  {
    $this->settingConfigurations = [];
  }

  /**
   * @param SettingConfigurationInterface $settingConfiguration
   */
  public function addSettingConfiguration (SettingConfigurationInterface $settingConfiguration)
  {
    $this->settingConfigurations[$settingConfiguration->getName()] = $settingConfiguration;
  }

  /**
   * @param $name
   * @return SettingConfigurationInterface
   */
  public function getSettingConfiguration ($name)
  {
    return $this->settingConfigurations[$name];
  }

  /**
   * @param $name
   * @return bool
   */
  public function hasSettingConfiguration ($name)
  {
    return isset($this->settingConfigurations[$name]);
  }

  /**
   * @return SettingConfigurationInterface[]|array
   */
  public function getSettingConfigurations()
  {
    return $this->settingConfigurations;
  }
}