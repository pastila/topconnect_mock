<?php

namespace AppBundle\Entity\Package;

use AppBundle\Entity\Card\Card;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 *
 * @ORM\Entity
 * @ORM\Table(name="data_package_records")
 */
class DataPackageRecord
{
  use TimestampableEntity;

  /**
   * @var integer
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   * @ORM\Column(type="integer")
   */
  private $id;

  /**
   * @var Card
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Card\Card")
   * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
   */
  private $card;

  /**
   * @var string
   * @ORM\Column(type="string", length=255, nullable=true)
   */
  private $msisdn;

  /**
   * @var \DateTime
   * @ORM\Column(type="datetime", nullable=true)
   */
  private $activatedAt;

  /**
   * @var \DateTime
   * @ORM\Column(type="datetime", nullable=true)
   */
  private $expireAt;

  /**
   * @var DataPackage
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Package\DataPackage")
   * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
   */
  private $package;

  /**
   * @var float
   * @ORM\Column(type="float", nullable=true)
   */
  private $price;

  /**
   * @var float
   * @ORM\Column(type="float", nullable=true)
   */
  private $balanceBefore;

  /**
   * @var float
   * @ORM\Column(type="float", nullable=true)
   */
  private $balanceAfter;

  /**
   * @var bool
   * @ORM\Column(type="boolean", nullable=false, options={"default"=false})
   */
  private $disabled=false;

  /**
   * @var integer
   * @ORM\Column(type="integer", nullable=true)
   */
  private $timeframes;

  /**
   * @return int
   */
  public function getId ()
  {
    return $this->id;
  }

  /**
   * @return Card
   */
  public function getCard ()
  {
    return $this->card;
  }

  /**
   * @param Card $card
   * @return $this
   */
  public function setCard ($card)
  {
    $this->card = $card;
    return $this;
  }

  /**
   * @return string
   */
  public function getMsisdn ()
  {
    return $this->msisdn;
  }

  /**
   * @param string $msisdn
   * @return $this
   */
  public function setMsisdn ($msisdn)
  {
    $this->msisdn = $msisdn;
    return $this;
  }

  /**
   * @return \DateTime
   */
  public function getActivatedAt ()
  {
    return $this->activatedAt;
  }

  /**
   * @param \DateTime $activatedAt
   * @return $this
   */
  public function setActivatedAt ($activatedAt)
  {
    $this->activatedAt = $activatedAt;
    return $this;
  }

  /**
   * @return \DateTime
   */
  public function getExpireAt ()
  {
    return $this->expireAt;
  }

  /**
   * @param \DateTime $expireAt
   * @return $this
   */
  public function setExpireAt ($expireAt)
  {
    $this->expireAt = $expireAt;
    return $this;
  }

  /**
   * @return DataPackage
   */
  public function getPackage ()
  {
    return $this->package;
  }

  /**
   * @param DataPackage $package
   * @return $this
   */
  public function setPackage ($package)
  {
    $this->package = $package;
    return $this;
  }

  /**
   * @return float
   */
  public function getPrice ()
  {
    return $this->price;
  }

  /**
   * @param float $price
   * @return $this
   */
  public function setPrice ($price)
  {
    $this->price = $price;
    return $this;
  }

  /**
   * @return float
   */
  public function getBalanceBefore ()
  {
    return $this->balanceBefore;
  }

  /**
   * @param float $balanceBefore
   * @return $this
   */
  public function setBalanceBefore ($balanceBefore)
  {
    $this->balanceBefore = $balanceBefore;
    return $this;
  }

  /**
   * @return float
   */
  public function getBalanceAfter ()
  {
    return $this->balanceAfter;
  }

  /**
   * @param float $balanceAfter
   * @return $this
   */
  public function setBalanceAfter ($balanceAfter)
  {
    $this->balanceAfter = $balanceAfter;
    return $this;
  }

  /**
   * @return bool
   */
  public function isDisabled ()
  {
    return $this->disabled;
  }

  /**
   * @param bool $disabled
   * @return $this
   */
  public function setDisabled ($disabled)
  {
    $this->disabled = $disabled;
    return $this;
  }

  /**
   * @return int
   */
  public function getTimeframes ()
  {
    return $this->timeframes;
  }

  /**
   * @param int $timeframes
   * @return $this
   */
  public function setTimeframes ($timeframes)
  {
    $this->timeframes = $timeframes;
    return $this;
  }
}