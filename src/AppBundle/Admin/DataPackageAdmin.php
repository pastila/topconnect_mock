<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;

class DataPackageAdmin extends AbstractAdmin
{
  protected function configureListFields (ListMapper $list)
  {
    $list
      ->add('id')
      ->add('name')
      ->add('code')
      ->add('period')
      ->add('volume')
      ->add('activationFee')
      ->add('orderFee')
      ->add('currency')
      ->add('activationType')
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
      ->add('name', TextType::class, [
        'constraints' => [
          new NotBlank(),
        ],
      ])
      ->add('code', NumberType::class, [
        'constraints' => [
          new NotBlank(),
        ],
      ])
      ->add('period', NumberType::class, [
        'constraints' => [
          new NotBlank(),
        ],
      ])
      ->add('volume', NumberType::class, [
        'constraints' => [
          new NotBlank(),
        ],
      ])
      ->add('activationFee', NumberType::class, [
        'constraints' => [
          new NotBlank(),
        ],
      ])
      ->add('orderFee', NumberType::class, [
        'constraints' => [
          new NotBlank(),
        ],
      ])
      ->add('currency', TextType::class, [
        'constraints' => [
          new NotBlank(),
        ],
      ])
      ->add('activationType', ChoiceType::class, [
        'choices' => [
          'order' => 'order',
          'auto' => 'auto',
        ],
      ]);
  }
}