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

class NumericSetting extends StringSetting
{
  public function getValue ()
  {
    $value = $this->settingStorage->get($this->name);

    if (is_null($value))
    {
      return $this->default;
    }

    return (float)$value;
  }

  public function setValue ($value)
  {
    $this->settingStorage->set($this->name, (float)$value);
  }

  public function getFormType ()
  {
    return 'Symfony\Component\Form\Extension\Core\Type\NumberType';
  }
}