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

namespace Accurateweb\SettingBundle\Model\Setting;


use Symfony\Component\Form\DataTransformerInterface;

/**
 * @deprecated
 */
interface SettingInterface
{
  /**
   * @return string
   */
  public function getName();

  /**
   * @return mixed
   */
  public function getValue();

  /**
   * @param $value
   * @return SettingInterface
   */
  public function setValue($value);

  /**
   * @return string
   */
  public function getFormType();

  /**
   * @return array
   */
  public function getFormOptions();

  /**
   * @return string
   */
  public function getStringValue ();

  /**
   * @return string
   */
  public function getDescription();

  /**
   * @return DataTransformerInterface|null
   */
  public function getModelTransformer();
}