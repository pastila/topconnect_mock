<?php


namespace AppBundle\Entity\Transaction;


use AppBundle\Entity\Card\Card;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="transactions")
 */
class Transaction
{
  use TimestampableEntity;
  /**
   * @var int
   * @ORM\Id()
   * @ORM\GeneratedValue()
   * @ORM\Column(type="integer")
   */
  private $id;

  /**
   * @var integer
   * @ORM\Column(type="integer",nullable=false)
   */
  private $orderId;

  /**
   * @var Card
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Card\Card")
   * @ORM\JoinColumn(onDelete="CASCADE", nullable=false)
   */
  private $card;

  /**
   * @var string
   * @ORM\Column(type="string", length=50, nullable=true)
   */
  private $availableAmount;

  /**
   * @var float
   * @ORM\Column(type="decimal", precision=18, scale=2)
   */
  private $amount;

  /**
   * curr
   * @var string
   * @ORM\Column(type="string", length=5, nullable=false)
   */
  protected $currency = 'EUR';

  /**
   * @return int
   */
  public function getId ()
  {
    return $this->id;
  }

  /**
   * @return int
   */
  public function getOrderId ()
  {
    return $this->orderId;
  }

  /**
   * @param int $orderId
   * @return $this
   */
  public function setOrderId ($orderId)
  {
    $this->orderId = $orderId;
    return $this;
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
  public function getAvailableAmount ()
  {
    return $this->availableAmount;
  }

  /**
   * @param string $availableAmount
   * @return $this
   */
  public function setAvailableAmount ($availableAmount)
  {
    $this->availableAmount = $availableAmount;
    return $this;
  }

  /**
   * @return float
   */
  public function getAmount ()
  {
    return $this->amount;
  }

  /**
   * @param float $amount
   * @return $this
   */
  public function setAmount ($amount)
  {
    $this->amount = $amount;
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
}