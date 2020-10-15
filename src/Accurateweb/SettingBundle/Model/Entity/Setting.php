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

namespace Accurateweb\SettingBundle\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Setting
 * @package Accurateweb\SettingBundle\Model
 * @ORM\MappedSuperclass()
 */
abstract class Setting implements SettingEntityInterface
{
  /**
   * @var $name string
   * @ORM\Column(type="string", length=50, unique=true)
   * @ORM\Id()
   */
  protected $name;

  /**
   * @var string
   * @ORM\Column(type="text", nullable=true)
   */
  protected $value;

  /**
   * @return string
   */
  public function getName()
  {
    return $this->name;
  }

  /**
   * @param string $name
   */
  public function setName($name)
  {
    $this->name = $name;
  }

  /**
   * @return string
   */
  public function getValue()
  {
    return $this->value;
  }


  public function setValue($value)
  {
    $this->value = $value;
    return $this;
  }
}