<?php

namespace Accurateweb\SettingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TagType extends AbstractType
{
  private $newValues;

  public function __construct ()
  {
    $this->newValues = [];
  }

  public function buildForm (FormBuilderInterface $builder, array $options)
  {
    $builder->addEventListener(FormEvents::PRE_SUBMIT, [$this, 'preSubmitData']);
    $builder->addEventListener(FormEvents::SUBMIT, [$this, 'submitData']);
  }


  public function preSubmitData (FormEvent $event)
  {
    $this->newValues = $event->getData();
  }

  public function submitData (FormEvent $event)
  {
    $event->setData($this->newValues);
  }

  public function getBlockPrefix ()
  {
    return 'array_tag';
  }

  public function configureOptions (OptionsResolver $resolver)
  {
    $resolver->setDefault('allow_extra_fields', true);
  }
}