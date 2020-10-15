<?php


namespace AppBundle\Admin;


use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class ServiceAdmin extends AbstractAdmin
{
  protected function configureListFields (ListMapper $list)
  {
    $list
      ->add('number')
      ->add('_action', null, [
        'actions' => [
          'edit' => [],
          'delete' => [],
        ]
      ]);
  }

  protected function configureFormFields (FormMapper $form)
  {
    $form
      ->add('number');
  }
}