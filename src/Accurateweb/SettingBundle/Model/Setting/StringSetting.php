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

use Accurateweb\SettingBundle\Model\Storage\SettingStorageInterface;

class StringSetting implements SettingInterface
{
  protected $name;
  protected $description;
  protected $default;
  protected $settingStorage;

  public function __construct (SettingStorageInterface $settingStorage, $name, $description, $default)
  {
    $this->settingStorage = $settingStorage;
    $this->name = $name;
    $this->description = $description;
    $this->default = $default;
  }

  public function getName ()
  {
    return $this->name;
  }

  public function getValue ()
  {
    $value = $this->settingStorage->get($this->name);

    if (is_null($value))
    {
      return $this->default;
    }

    return (string)$value;
  }

  public function setValue ($value)
  {
    $this->settingStorage->set($this->name, (string)$value);
  }

  public function getFormType ()
  {
    return 'Symfony\Component\Form\Extension\Core\Type\TextType';
  }

  public function getFormOptions ()
  {
    return array();
  }

  public function getStringValue ()
  {
    return (string)$this->getValue();
  }

  public function getDescription ()
  {
    return $this->description;
  }

  public function getModelTransformer()
  {
    return null;
  }
}