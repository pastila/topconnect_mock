<?php

namespace Accurateweb\SettingBundle\Model\Manager;

use Accurateweb\SettingBundle\Event\SettingSetEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class SettingManager implements SettingManagerInterface
{
  private $values;
  private $modifiedValues;
  private $eventDispatcher;

  public function __construct (EventDispatcherInterface $eventDispatcher)
  {
    $this->values = [];
    $this->modifiedValues = [];
    $this->eventDispatcher = $eventDispatcher;
  }

  public function getValue ($name)
  {
    if (!isset($this->values[$name]))
    {
      return null;
      //      throw new SettingNotFoundException($name);
    }

    return $this->values[$name];
  }

  public function addValue ($name, $value)
  {
    if (isset($this->values[$name]))
    {
      throw new \RuntimeException();
    }

    $this->values[$name] = $value;

    return $this;
  }

  public function setValue ($name, $value)
  {
    $this->values[$name] = $value;
    $this->modifiedValues[] = $name;
    $this->eventDispatcher->dispatch('aw.setting.set', new SettingSetEvent($name, $value));

    return $this;
  }

  /**
   * @return array
   */
  public function getModifiedValues ()
  {
    return $this->modifiedValues;
  }
}