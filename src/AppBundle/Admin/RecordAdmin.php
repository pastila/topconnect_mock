<?php


namespace AppBundle\Admin;


use AppBundle\Entity\Record\Record;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Range;

class RecordAdmin extends AbstractAdmin
{
  public function __construct ($code, $class, $baseControllerName)
  {
    $this->setSubClasses([
      'sms' => 'AppBundle\Entity\Record\SmsRecord',
      'call' => 'AppBundle\Entity\Record\CallRecord',
    ]);
    parent::__construct($code, $class, $baseControllerName);
  }

  protected function configureListFields (ListMapper $list)
  {
    $list
      ->add('type')
      ->add('direction', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', [
        'choices' => [
          'Исходящий' => Record::DIRECTION_OUTCOMING,
          'Входящий' => Record::DIRECTION_INCOMING,
        ],
      ])
      ->add('secondPhoneNumber', null, [
        'label' => 'Абонент',
      ])
      ->add('createdAt')
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
      ->add('direction', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', [
        'choices' => [
          'Исходящий' => Record::DIRECTION_OUTCOMING,
          'Входящий' => Record::DIRECTION_INCOMING,
        ],
      ])
      ->add('secondPhoneNumber', null, [
        'label' => 'Номер абонента',
      ])
    ;

    if ($this->getClass() === 'AppBundle\Entity\Record\CallRecord')
    {
      $form
        ->add('duration')
        ->add('cCost', null, [
          'label' => 'Стоимость',
        ])
      ;
    }
    elseif ($this->getClass() === 'AppBundle\Entity\Record\SmsRecord')
    {
      $form
        ->add('text', null, [
          'constraints' => [
            new Length(['max' => 160]),
          ],
        ])
        ->add('smsCost')
        ->add('part', null, [
          'constraints' => [
            new Range(['min' => 1]),
          ],
        ])
      ;
    }
  }

  /**
   * @param Record $object
   */
  public function prePersist ($object)
  {
    if ($this->isChild())
    {
      $card = $this->getParent()->getSubject();
      $object->setCard($card);
    }
  }
}