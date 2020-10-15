<?php

namespace Accurateweb\SettingBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class SettingsConfigurationCompilerPass implements CompilerPassInterface
{
  public function process (ContainerBuilder $container)
  {
    $settings = $container->findTaggedServiceIds('aw.setting.configuration');
    $settingPool = $container->getDefinition('aw.settings.configuration_pool');

    foreach ($settings as $id => $setting)
    {
      $settingPool->addMethodCall('addSettingConfiguration', [new Reference($id)]);
    }
  }
}