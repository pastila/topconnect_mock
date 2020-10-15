<?php


namespace Accurateweb\SettingBundle\Model\SettingConfiguration;


use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\DataTransformerInterface;

class TagSettingConfiguration extends AbstractSettingConfiguration implements DataTransformerInterface
{
  protected $delimiter;

  public function __construct ($name, $description, $delimiter = '|', $defaultValue = null)
  {
    $this->delimiter = $delimiter;
    parent::__construct($name, $description, $defaultValue);
  }

  public function getModelTransformer ()
  {
    return $this;
  }

  public function transform ($value)
  {
    if (is_scalar($value))
    {
      return explode($this->delimiter, $value);
    }

    if (is_array($value))
    {
      return $value;
    }

    return [];
  }

  public function reverseTransform ($value)
  {
    if (is_array($value))
    {
      return implode($this->delimiter, $value);
    }

    return $value;
  }

  public function getFormType ()
  {
    return 'Accurateweb\SettingBundle\Form\TagType';
  }

  public function toString ($value)
  {
    return is_array($value) ? implode(', ', $value) : $value;
  }
}