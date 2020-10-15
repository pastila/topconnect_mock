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

namespace Accurateweb\SettingBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
  /**
   * {@inheritdoc}
   */
  public function getConfigTreeBuilder ()
  {
    $treeBuilder = new TreeBuilder();
    $rootNode = $treeBuilder->root('accurateweb_setting');

    $rootNode
      ->addDefaultsIfNotSet()
      ->children()
        ->arrayNode('configuration')
          ->addDefaultsIfNotSet()
          ->children()
            ->scalarNode('storage')->defaultValue('aw.settings.storage.doctrine')->isRequired()->end()
            ->scalarNode('class')->isRequired()->end()
          ->end()
        ->end()
      ->end();

    return $treeBuilder;
  }
}
