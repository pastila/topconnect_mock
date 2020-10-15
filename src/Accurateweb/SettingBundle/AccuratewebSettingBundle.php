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

namespace Accurateweb\SettingBundle;

use Accurateweb\SettingBundle\DependencyInjection\Compiler\SettingCompilerPass;
use Accurateweb\SettingBundle\DependencyInjection\Compiler\SettingsConfigurationCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Created by PhpStorm.
 * User: evgeny
 * Date: 27.03.18
 * Time: 13:34
 */
class AccuratewebSettingBundle extends Bundle
{

  public function build(ContainerBuilder $container)
  {
    $container->addCompilerPass(new SettingCompilerPass());
    $container->addCompilerPass(new SettingsConfigurationCompilerPass());
  }
}