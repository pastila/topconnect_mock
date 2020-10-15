<?php

namespace Accurateweb\SettingBundle\Model\SettingConfiguration;


use Symfony\Component\Form\DataTransformerInterface;

interface SettingConfigurationInterface
{
  /**
   * @return string
   */
  public function getName();

  /**
   * @return string
   */
  public function getDescription();

  /**
   * @return DataTransformerInterface|null
   */
  public function getModelTransformer();

  /**
   * @return string
   */
  public function getFormType();

  /**
   * @return array
   */
  public function getFormOptions($value);

  /**
   * @param $value
   * @return string
   */
  public function toString ($value);

  /**
   * @return mixed
   */
  public function getDefaultValue();
}