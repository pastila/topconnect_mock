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

namespace Accurateweb\SettingBundle\Model\Manager;

interface SettingManagerInterface
{
  /**
   * @param string $name
   * @param $value
   * @return SettingManagerInterface
   */
  public function addValue($name, $value);
  /**
   * @param $name string
   * @return mixed
   */
  public function getValue($name);

  /**
   * @param $name string
   * @param $value mixed
   * @return SettingManagerInterface
   */
  public function setValue($name, $value);
}