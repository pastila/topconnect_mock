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

namespace Accurateweb\SettingBundle\Twig;

use Accurateweb\SettingBundle\Exception\SettingNotFoundException;
use Accurateweb\SettingBundle\Model\Manager\SettingManagerInterface;
use Accurateweb\SettingBundle\Model\SettingConfiguration\SettingConfigurationPool;

class SettingsExtension extends \Twig_Extension
{
  private $settingManager;
  private $settingConfigurationPool;

  public function getName ()
  {
    return 'settings_extension';
  }

  public function __construct (SettingManagerInterface $settingManager, SettingConfigurationPool $settingConfigurationPool)
  {
    $this->settingManager = $settingManager;
    $this->settingConfigurationPool = $settingConfigurationPool;
  }

  public function getFunctions ()
  {
    return array(
      new \Twig_SimpleFunction('setting', array($this, 'getValue')),
      new \Twig_SimpleFunction('settingString', array($this, 'getSettingString')),
      new \Twig_SimpleFunction('settingDescription', array($this, 'getSettingDescription')),
    );
  }

  public function getValue ($name)
  {
    return $this->settingManager->getValue($name);
  }

  public function getSettingDescription($name)
  {
    try
    {
      $setting = $this->settingConfigurationPool->getSettingConfiguration($name);
    }
    catch (SettingNotFoundException $e)
    {
      return '';
    }

    return $setting->getDescription();
  }

  public function getSettingString($name)
  {
    try
    {
      $setting = $this->settingConfigurationPool->getSettingConfiguration($name);
    }
    catch (SettingNotFoundException $e)
    {
      return '';
    }

    return $setting->toString($this->settingManager->getValue($name));
  }
}