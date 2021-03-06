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

namespace Accurateweb\SettingBundle\Model\Storage;

class PropelSettingStorage implements SettingStorageInterface
{
  private $class;

  public function __construct ($class)
  {
    $this->class = $class;
  }

  public function get ($name)
  {
    $query = sprintf('%sQuery', $this->class);
    $setting = $query::create()->filterById($name)->findOneOrCreate();

    if ($setting->isNew())
    {
      $setting->setName($name);
      $setting->save();
      return null;
    }

    return $setting->getValue();
  }

  public function set ($name, $value)
  {
    $query = sprintf('%sQuery', $this->class);
    $setting = $query::create()->filterById($name)->findOneOrCreate();

    if ($setting->isNew())
    {
      $setting->setName($name);
      $setting->save();
    }

    $setting->setValue($value);
    $setting->save();
  }

  public function commit ()
  {

  }
}