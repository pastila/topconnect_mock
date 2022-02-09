<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class DataPackageRecordAdmin extends AbstractAdmin
{
  protected function configureListFields (ListMapper $list)
  {
    $list
      ->add('id')
      ->add('msisdn')
      ->add('activatedAt')
      ->add('expireAt')
      ->add('package')
      ->add('_action', null, [
        'actions' => [
          'delete' => [],
        ]
      ])
    ;
  }

  protected function configureRoutes (RouteCollection $collection)
  {
    parent::configureRoutes($collection);
    $collection->remove('create');
  }
}