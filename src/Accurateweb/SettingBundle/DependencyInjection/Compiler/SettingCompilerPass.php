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

namespace Accurateweb\SettingBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

/*
 * Backward compatibility
 */
class SettingCompilerPass implements CompilerPassInterface
{
  public function process(ContainerBuilder $container)
  {
    $settings = $container->findTaggedServiceIds('aw.setting');
    $configurationPool = $container->findDefinition('aw.settings.configuration_pool');
//
    foreach ($settings as $id => $tags)
    {
      $def = $container->getDefinition($id);

      switch ($def->getClass())
      {
        case 'Accurateweb\SettingBundle\Model\Setting\StringSetting':
          $options = [
            'type' => 'string',
            'name' => $def->getArgument(1),
            'description' => $def->getArgument(2),
            'defaultValue' => $def->getArgument(3),
          ];
          break;
        case 'Accurateweb\SettingBundle\Model\Setting\EntitySetting':
          $options = [
            'type' => 'entity',
            'repository' => $def->getArgument(1),
            'name' => $def->getArgument(2),
            'description' => $def->getArgument(3),
          ];
          break;
        case 'Accurateweb\SettingBundle\Model\Setting\NumericSetting':
          $options = [
            'type' => 'numeric',
            'name' => $def->getArgument(1),
            'description' => $def->getArgument(2),
            'defaultValue' => $def->getArgument(3),
          ];
          break;
        case 'Accurateweb\SettingBundle\Model\Setting\BooleanSetting':
          $options = [
            'type' => 'boolean',
            'name' => $def->getArgument(1),
            'description' => $def->getArgument(2),
            'defaultValue' => $def->getArgument(3),
          ];
          break;
        default:
          throw new \RuntimeException(sprintf('unrecognized settings type %s', $def->getClass()));
      }

      $definition = $this->createSettingConfigurationDefinition($container, $options);
      $configurationPool->addMethodCall('addSettingConfiguration', [$definition]);
    }
  }

  /**
   * @param ContainerBuilder $container
   * @param $options
   * @return Definition
   */
  private function createSettingConfigurationDefinition(ContainerBuilder $container, $options)
  {
    switch ($options['type'])
    {
      case 'string':
        $className = 'Accurateweb\SettingBundle\Model\SettingConfiguration\StringSettingConfiguration';
        $def = new Definition($className, [$options['name'], $options['description'], $options['defaultValue']]);
        break;
      case 'numeric':
        $className = 'Accurateweb\SettingBundle\Model\SettingConfiguration\NumericSettingConfiguration';
        $def = new Definition($className, [$options['name'], $options['description'], $options['defaultValue']]);
        break;
      case 'boolean':
        $className = 'Accurateweb\SettingBundle\Model\SettingConfiguration\BooleanSettingConfiguration';
        $def = new Definition($className, [$options['name'], $options['description'], $options['defaultValue']]);
        break;
      case 'entity':
        $className = 'Accurateweb\SettingBundle\Model\SettingConfiguration\EntitySettingConfiguration';
        $def = new Definition($className, [$options['name'], $options['repository'], $options['description']]);
        break;
      default:
        $def = $container->getDefinition($options['type']);
    }

    return $def;
  }
}