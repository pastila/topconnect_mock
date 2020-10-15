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

namespace Accurateweb\SettingBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class SettingSetEvent extends Event
{
  /**
   * @var string
   */
  private $name;
  /**
   * @var mixed
   */
  private $value;

  public function __construct ($name, $value)
  {
    $this->name = $name;
    $this->value = $value;
  }

  /**
   * @return string
   */
  public function getName ()
  {
    return $this->name;
  }

  /**
   * @return mixed
   */
  public function getValue ()
  {
    return $this->value;
  }
}