<?php

namespace Accurateweb\SettingBundle\Model\SettingConfiguration;


use Symfony\Component\Form\DataTransformerInterface;

abstract class AbstractSettingConfiguration implements SettingConfigurationInterface
{
  protected $name;
  protected $description;
  protected $defaultValue;

  public function __construct ($name, $description, $defaultValue=null)
  {
    $this->name = $name;
    $this->description = $description;
    $this->defaultValue = $defaultValue;
  }

  public function getName ()
  {
    return $this->name;
  }

  public function getDescription ()
  {
    return $this->description;
  }

  public function getModelTransformer ()
  {
    return null;
  }

  public function getFormType ()
  {
    return 'Symfony\Component\Form\Extension\Core\Type\TextType';
  }

  public function getFormOptions ($value)
  {
    return array(
      'required' => false,
    );
  }

  public function toString ($value)
  {
    return (string)$value;
  }

  public function getDefaultValue ()
  {
    return $this->defaultValue;
  }
}