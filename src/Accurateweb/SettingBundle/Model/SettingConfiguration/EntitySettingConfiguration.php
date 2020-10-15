<?php

namespace Accurateweb\SettingBundle\Model\SettingConfiguration;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\DataTransformerInterface;

class EntitySettingConfiguration extends AbstractSettingConfiguration implements DataTransformerInterface
{
  private $repository;

  public function __construct ($name, EntityRepository $repository, $description)
  {
    $this->repository = $repository;
    parent::__construct($name, $description, null);
  }

  public function getModelTransformer ()
  {
    return $this;
  }

  public function getFormType ()
  {
    return 'Symfony\Component\Form\Extension\Core\Type\ChoiceType';
  }

  public function getFormOptions ($value)
  {
    return [
      'choices' => $this->getChoices(),
    ];
  }

  private function getChoices()
  {
    $choices = array();

    //    $meta = $em->getClassMetadata(get_class($entity));
    //    $identifier = $meta->getSingleIdentifierFieldName();
    foreach ($this->repository->findAll() as $item)
    {
      $choices[(string)$item] = $item->getId();
    }

    return $choices;
  }

  public function toString ($value)
  {
    if (is_null($value))
    {
      return '';
    }

    if (method_exists($value, '__toString'))
    {
      return $value->__toString();
    }

    return sprintf('%s[%s]', $this->repository->getClassName(), $value->getId());
  }

  public function transform ($value)
  {
    if (is_null($value))
    {
      return null;
    }

    if (is_object($value))
    {
      return $value->getId();
    }

    return null;
  }

  public function reverseTransform ($value)
  {
    if (is_null($value))
    {
      return null;
    }

    if (!is_object($value))
    {
      $value = $this->repository->find($value);
    }

    return $value;
  }

}