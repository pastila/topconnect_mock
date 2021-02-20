<?php


namespace AppBundle\Admin;


use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class TransactionAdmin extends AbstractAdmin
{
  protected function configureListFields (ListMapper $list)
  {
    $list
      ->add('card')
      ->add('orderId')
      ->add('amount')
      ->add('createdAt')
//      ->add('_action', null, [
//        'actions' => [
//          'edit' => [],
//          'delete' => [],
//        ]
//      ])
    ;
  }

  protected function configureDatagridFilters (DatagridMapper $filter)
  {
    $filter
      ->add('card')
      ->add('orderId')
      ->add('amount')
      ->add('card.account');
  }

  protected function configureRoutes (RouteCollection $collection)
  {
    parent::configureRoutes($collection);
    $collection->remove('create');
  }
}