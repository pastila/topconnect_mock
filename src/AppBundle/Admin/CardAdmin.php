<?php

namespace AppBundle\Admin;

use Knp\Menu\ItemInterface as MenuItemInterface;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotNull;

class CardAdmin extends AbstractAdmin
{
  protected function configureListFields (ListMapper $list)
  {
    $list
      ->add('id')
      ->add('service')
      ->add('msisdn')
      ->add('iNum')
      ->add('balance')
      ->add('currency')
      ->add('prepayed')
      ->add('blocked')
      ->add('_action', null, [
        'actions' => [
          'calls' => [
            'template' => '@App/admin/card/calls_button.html.twig',
          ],
          'packages' => [
            'template' => '@App/admin/card/package_button.html.twig',
          ],
          'edit' => [],
          'delete' => [],
        ]
      ])
    ;
  }

  protected function configureFormFields (FormMapper $form)
  {
    $form
      ->add('account')
      ->add('service')
      ->add('iNum')
      ->add('msisdn')
      ->add('balance')
      ->add('overdraft')
      ->add('currency')
      ->add('iccid', null, [
        'constraints' => [
          new Length(['min' => 19, 'max' => 19]),
        ],
      ])
//      ->add('primaryNumber')
//      ->add('secondaryNumbers')
      ->add('lastUsageAt',  'sonata_type_datetime_picker', [
        'required' => true,
        'dp_side_by_side' => true,
        'dp_use_seconds' => false,
        'format' => 'dd.MM.yyyy',
      ])
      ->add('firstUsageAt',  'sonata_type_datetime_picker', [
        'required' => true,
        'dp_side_by_side' => true,
        'dp_use_seconds' => false,
        'format' => 'dd.MM.yyyy',
      ])
      ->add('prepayed')
      ->add('blocked')
    ;
  }

  protected function configureRoutes (RouteCollection $collection)
  {
    parent::configureRoutes($collection);
    $collection->remove('export');
    $collection->add('exportCards');
  }

  protected function configureTabMenu (MenuItemInterface $menu, $action, AdminInterface $childAdmin = null)
  {
    parent::configureTabMenu($menu, $action, $childAdmin);
    $menu->addChild('Выгрузить симки', [
      'uri' => $this->generateUrl('exportCards'),
    ]);

    if (!$childAdmin && !in_array($action, ['edit', 'show']))
    {
      return;
    }

    $admin = $this->isChild() ? $this->getParent() : $this;
    $id = $admin->getRequest()->get('id');

    if ($this->isGranted('EDIT'))
    {
      $menu->addChild('Звонки', [
        'uri' => $this->getConfigurationPool()->getContainer()->get('router')->generate('admin_app_card_card_record_record_list', [
          'id' => $id,
        ]),
      ]);
    }
  }

  protected function configureDatagridFilters (DatagridMapper $filter)
  {
    $filter->add('account');
    $filter->add('msisdn');
  }
}