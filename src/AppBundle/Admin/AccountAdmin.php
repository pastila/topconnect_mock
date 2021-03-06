<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Validator\Constraints\NotBlank;

class AccountAdmin extends AbstractAdmin
{
  protected function configureListFields (ListMapper $list)
  {
    $list
      ->add('name')
      ->add('balance')
      ->add('apiLogin')
      ->add('apiPassword')
      ->add('_action', null, [
        'actions' => [
          'edit' => [],
          'delete' => [],
        ]
      ])
    ;
  }

  protected function configureFormFields (FormMapper $form)
  {
    $form
      ->add('name', null, [
        'constraints' => [
          new NotBlank(),
        ],
      ])
      ->add('apiLogin', null, [
        'constraints' => [
          new NotBlank(),
        ],
      ])
      ->add('apiPassword', null, [
        'constraints' => [
          new NotBlank(),
        ],
      ])
      ->add('balance', null, [
        'constraints' => [
          new NotBlank(),
        ],
      ])
      ->add('currency', null, [
        'constraints' => [
          new NotBlank(),
        ],
      ])
      ->add('activeAt',  'sonata_type_datetime_picker', [
        'required' => true,
        'dp_side_by_side' => true,
        'dp_use_seconds' => false,
        'format' => 'dd.MM.yyyy',
      ])
      ->add('expireAt',  'sonata_type_datetime_picker', [
        'required' => true,
        'dp_side_by_side' => true,
        'dp_use_seconds' => false,
        'format' => 'dd.MM.yyyy',
      ])
    ;
  }
}