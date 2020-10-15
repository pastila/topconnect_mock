<?php

namespace Accurateweb\SettingBundle\Model\SettingConfiguration;

use Symfony\Component\Form\DataTransformerInterface;

class NumericSettingConfiguration extends AbstractSettingConfiguration implements DataTransformerInterface
{
  public function getModelTransformer ()
  {
    return $this;
  }

  public function getFormType ()
  {
    return 'Symfony\Component\Form\Extension\Core\Type\NumberType';
  }

  public function transform ($value)
  {
    return $value;
  }

  public function reverseTransform ($value)
  {
    if (is_string($value))
    {
      $value = preg_replace('/\s+/', '', $value);
      $value = preg_replace('/\,/', '.', $value);

      return (float)$value;
    }

    return $value;
  }
}