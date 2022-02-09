<?php

namespace AppBundle\Entity\Package;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="data_packages")
 */
class DataPackage
{
  /**
   * @var int
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   * @ORM\Column(type="integer")
   */
  private $id;

  /**
   * @var string
   * @ORM\Column(type="string", length=255, nullable=true)
   */
  private $name;

  /**
   * @var int
   * @ORM\Column(type="integer", nullable=false)
   */
  private $code;

  /**
   * @var integer
   * @ORM\Column(type="integer", nullable=false)
   */
  private $period;

  /**
   * @var float
   * @ORM\Column(type="float", nullable=false)
   */
  private $volume;

  /**
   * @var float
   * @ORM\Column(type="float", nullable=false)
   */
  private $activationFee;

  /**
   * @var float
   * @ORM\Column(type="float", nullable=false)
   */
  private $orderFee;

  /**
   * @var string
   * @ORM\Column(type="string", length=3, nullable=false)
   */
  private $currency = 'EUR';

  /**
   * @var string
   * @ORM\Column(type="string", length=50, nullable=false)
   */
  private $activationType;

  /**
   * @return int
   */
  public function getId ()
  {
    return $this->id;
  }

  /**
   * @return string
   */
  public function getName ()
  {
    return $this->name;
  }

  /**
   * @param string $name
   * @return $this
   */
  public function setName ($name)
  {
    $this->name = $name;
    return $this;
  }

  /**
   * @return int
   */
  public function getCode ()
  {
    return $this->code;
  }

  /**
   * @param int $code
   * @return $this
   */
  public function setCode ($code)
  {
    $this->code = $code;
    return $this;
  }

  /**
   * @return int
   */
  public function getPeriod ()
  {
    return $this->period;
  }

  /**
   * @param int $period
   * @return $this
   */
  public function setPeriod ($period)
  {
    $this->period = $period;
    return $this;
  }

  /**
   * @return float
   */
  public function getVolume ()
  {
    return $this->volume;
  }

  /**
   * @param float $volume
   * @return $this
   */
  public function setVolume ($volume)
  {
    $this->volume = $volume;
    return $this;
  }

  /**
   * @return float
   */
  public function getActivationFee ()
  {
    return $this->activationFee;
  }

  /**
   * @param float $activationFee
   * @return $this
   */
  public function setActivationFee ($activationFee)
  {
    $this->activationFee = $activationFee;
    return $this;
  }

  /**
   * @return float
   */
  public function getOrderFee ()
  {
    return $this->orderFee;
  }

  /**
   * @param float $orderFee
   * @return $this
   */
  public function setOrderFee ($orderFee)
  {
    $this->orderFee = $orderFee;
    return $this;
  }

  /**
   * @return string
   */
  public function getCurrency ()
  {
    return $this->currency;
  }

  /**
   * @param string $currency
   * @return $this
   */
  public function setCurrency ($currency)
  {
    $this->currency = $currency;
    return $this;
  }

  /**
   * @return string
   */
  public function getActivationType ()
  {
    return $this->activationType;
  }

  /**
   * @param string $activationType
   * @return $this
   */
  public function setActivationType ($activationType)
  {
    $this->activationType = $activationType;
    return $this;
  }

  public function __toString ()
  {
    return sprintf('[%s] %s', $this->getCode(), $this->getName());
  }
}