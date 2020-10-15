<?php

namespace Accurateweb\SettingBundle\Model\SettingConfiguration;

class TextSettingConfiguration extends AbstractSettingConfiguration
{
  public function getFormType ()
  {
    return 'Symfony\Component\Form\Extension\Core\Type\TextareaType';
  }
}