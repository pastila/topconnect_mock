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

/**
 * Copyright (c) 2017. Denis N. Ragozin <dragozin@accurateweb.ru>
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Accurateweb\SettingBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class AccuratewebSettingExtension extends Extension
{
  public function load(array $config, ContainerBuilder $container)
  {
    $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
    $loader->load('services.yml');
    $config = $config[0];

    if (isset($config['configuration']))
    {
      $storage = isset($config['configuration']['storage']) ? $config['configuration']['storage'] : 'aw.settings.storage.doctrine';
      $container->setAlias('aw.settings.storage', $storage);

      $class = $config['configuration']['class'];

      if ($storage == 'aw.settings.storage.doctrine')
      {
        $repository = $container->getDefinition('aw.settings.repository');
        $repository->setArgument(1, $class);
      }
    }
  }
}