<?php

namespace Accurateweb\SettingBundle\Model\SettingConfiguration;

use Symfony\Component\Form\DataTransformerInterface;

class BooleanSettingConfiguration extends AbstractSettingConfiguration implements DataTransformerInterface
{
  public function getModelTransformer ()
  {
    return $this;
  }

  public function getFormType ()
  {
    return 'Symfony\Component\Form\Extension\Core\Type\CheckboxType';
  }

  public function getFormOptions ($value)
  {
    return array(
      'required' => false,
      'label' => $this->getDescription(),
    );
  }

  public function transform ($value)
  {
    return (boolean)$value;
  }

  public function reverseTransform ($value)
  {
    return (boolean)$value;
  }

  public function toString ($value)
  {
    return $value?'Да':'Нет';
  }
}