<?php


namespace AppBundle\Entity\Account;


use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="accounts")
 */
class Account
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
   * @var string
   * @ORM\Column(type="string", length=50, nullable=false)
   */
  private $name;

  /**
   * @var string
   * @ORM\Column(type="string", length=50, nullable=false, unique=true)
   */
  private $apiLogin;

  /**
   * @var string
   * @ORM\Column(type="string", length=50, nullable=false)
   */
  private $apiPassword;

  /**
   * @var \DateTime
   * @ORM\Column(type="datetime", nullable=true)
   */
  private $activeAt;

  /**
   * @var \DateTime
   * @ORM\Column(type="datetime", nullable=true)
   */
  private $expireAt;

  /**
   * @var float
   * @ORM\Column(type="decimal", precision=18, scale=2)
   */
  private $balance;

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
   * @return string
   */
  public function getApiLogin ()
  {
    return $this->apiLogin;
  }

  /**
   * @param string $apiLogin
   * @return $this
   */
  public function setApiLogin ($apiLogin)
  {
    $this->apiLogin = $apiLogin;
    return $this;
  }

  /**
   * @return string
   */
  public function getApiPassword ()
  {
    return $this->apiPassword;
  }

  /**
   * @param string $apiPassword
   * @return $this
   */
  public function setApiPassword ($apiPassword)
  {
    $this->apiPassword = $apiPassword;
    return $this;
  }

  /**
   * @return \DateTime
   */
  public function getActiveAt ()
  {
    return $this->activeAt;
  }

  /**
   * @param \DateTime $activeAt
   * @return $this
   */
  public function setActiveAt ($activeAt)
  {
    $this->activeAt = $activeAt;
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
   * @return float
   */
  public function getBalance ()
  {
    return $this->balance;
  }

  /**
   * @param float $balance
   * @return $this
   */
  public function setBalance ($balance)
  {
    $this->balance = $balance;
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

  public function __toString ()
  {
    return $this->name;
  }


}