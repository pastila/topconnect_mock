<?php


namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class ApiRequestType extends AbstractType
{
  public function buildForm (FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('command', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', [
        'constraints' => [
          new NotBlank(),
        ],
        'choices' => [
          'gbalance' => 'gbalance',
          'account' => 'account',
          'card_stat' => 'card_stat',
          'sbalance' => 'sbalance',
          'sblock' => 'sblock',
          'gccdr' => 'gccdr',
          'gprscdr' => 'gprscdr',
          'nav3' => 'nav3',
          'navstat3' => 'navstat3',
          'navcdr3' => 'navcdr3',
          'discount' => 'discount',
          'getrates' => 'getrates',
          'getserviceoptions' => 'getserviceoptions',
        ],
      ])
      ->add('uname', 'Symfony\Component\Form\Extension\Core\Type\TextType', [
        'constraints' => [
          new NotBlank(),
        ],
      ])
      ->add('upass', 'Symfony\Component\Form\Extension\Core\Type\TextType', [
        'constraints' => [
          new NotBlank(),
        ],
      ])
      ->add('plain', 'Symfony\Component\Form\Extension\Core\Type\TextType', [
        'constraints' => [
          new NotBlank(),
        ],
      ]);
  }
}