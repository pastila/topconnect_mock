<?php


namespace AppBundle\Entity\Record;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="data_records")
 * @ORM\HasLifecycleCallbacks()
 */
class DataRecord extends Record
{
  /**
   * @var string
   * @ORM\Column(type="string", nullable=true, length=50)
   */
  protected $operatorCode = '123';

  /**
   * @var string
   * @ORM\Column(type="string", nullable=true, length=50)
   */
  protected $country = 'Russia';

  /**
   * @var string
   * @ORM\Column(type="string", nullable=true, length=50)
   */
  protected $operator = 'Mock';

  /**
   * @var string
   * @ORM\Column(type="string", nullable=true, length=50)
   */
  protected $ipAddress = '127.0.0.1';

  /**
   * @var string
   * @ORM\Column(type="string", nullable=true, length=50)
   */
  protected $sessionid;

  /**
   * @var integer
   * @ORM\Column(type="integer", nullable=true)
   */
  protected $inBytes;

  /**
   * @var integer
   * @ORM\Column(type="integer", nullable=true)
   */
  protected $outBytes;

  /**
   * @var float
   * @ORM\Column(type="float", nullable=true)
   */
  protected $rate;

  /**
   * @var float
   * @ORM\Column(type="float", nullable=true)
   */
  protected $cost;

  /**
   * @var string
   * @ORM\Column(type="string", length=50, nullable=true)
   */
  protected $quosid;

  /**
   * @var integer
   * @ORM\Column(type="integer", nullable=true)
   */
  protected $rg;

  /**
   * @var \DateTime
   * @ORM\Column(type="datetime", nullable=true)
   */
  protected $endAt;

  /**
   * @var integer
   * @ORM\Column(type="integer", nullable=true)
   */
  protected $usageBytes;

  public function __construct ()
  {
    $this->direction = Record::DIRECTION_OUTCOMING;
    $this->sessionid = uniqid('sess');
  }

  /**
   * @return string
   */
  public function getOperatorCode ()
  {
    return $this->operatorCode;
  }

  /**
   * @param string $operatorCode
   * @return $this
   */
  public function setOperatorCode ($operatorCode)
  {
    $this->operatorCode = $operatorCode;
    return $this;
  }

  /**
   * @return string
   */
  public function getCountry ()
  {
    return $this->country;
  }

  /**
   * @param string $country
   * @return $this
   */
  public function setCountry ($country)
  {
    $this->country = $country;
    return $this;
  }

  /**
   * @return string
   */
  public function getOperator ()
  {
    return $this->operator;
  }

  /**
   * @param string $operator
   * @return $this
   */
  public function setOperator ($operator)
  {
    $this->operator = $operator;
    return $this;
  }

  /**
   * @return string
   */
  public function getIpAddress ()
  {
    return $this->ipAddress;
  }

  /**
   * @param string $ipAddress
   * @return $this
   */
  public function setIpAddress ($ipAddress)
  {
    $this->ipAddress = $ipAddress;
    return $this;
  }

  /**
   * @return string
   */
  public function getSessionid ()
  {
    return $this->sessionid;
  }

  /**
   * @param string $sessionid
   * @return $this
   */
  public function setSessionid ($sessionid)
  {
    $this->sessionid = $sessionid;
    return $this;
  }

  /**
   * @return int
   */
  public function getInBytes ()
  {
    return $this->inBytes;
  }

  /**
   * @param int $inBytes
   * @return $this
   */
  public function setInBytes ($inBytes)
  {
    $this->inBytes = $inBytes;
    return $this;
  }

  /**
   * @return int
   */
  public function getOutBytes ()
  {
    return $this->outBytes;
  }

  /**
   * @param int $outBytes
   * @return $this
   */
  public function setOutBytes ($outBytes)
  {
    $this->outBytes = $outBytes;
    return $this;
  }

  /**
   * @return int
   */
  public function getRate ()
  {
    return $this->rate;
  }

  /**
   * @param int $rate
   * @return $this
   */
  public function setRate ($rate)
  {
    $this->rate = $rate;
    return $this;
  }

  /**
   * @return float
   */
  public function getCost ()
  {
    return $this->cost;
  }

  /**
   * @param float $cost
   * @return $this
   */
  public function setCost ($cost)
  {
    $this->cost = $cost;
    return $this;
  }

  /**
   * @return string
   */
  public function getQuosid ()
  {
    return $this->quosid;
  }

  /**
   * @param string $quosid
   * @return $this
   */
  public function setQuosid ($quosid)
  {
    $this->quosid = $quosid;
    return $this;
  }

  /**
   * @return int
   */
  public function getRg ()
  {
    return $this->rg;
  }

  /**
   * @param int $rg
   * @return $this
   */
  public function setRg ($rg)
  {
    $this->rg = $rg;
    return $this;
  }

  /**
   * @return \DateTime
   */
  public function getEndAt ()
  {
    return $this->endAt;
  }

  /**
   * @param \DateTime $endAt
   * @return $this
   */
  public function setEndAt ($endAt)
  {
    $this->endAt = $endAt;
    return $this;
  }

  /**
   * @return int
   */
  public function getUsageBytes ()
  {
    return $this->usageBytes;
  }

  /**
   * @param int $usageBytes
   * @return $this
   */
  public function setUsageBytes ($usageBytes)
  {
    $this->usageBytes = $usageBytes;
    $this->inBytes = round($usageBytes / 2);
    $this->outBytes = max($usageBytes - $this->inBytes, 1);
    $this->rate = $this->inBytes / $this->outBytes;

    return $this;
  }

  public function setDuration ($duration)
  {
    $startAt = clone ($this->createdAt ? $this->createdAt : new \DateTime());
    $this->setEndAt($startAt->modify(sprintf('+%s seconds', $duration)));
  }

  public function getDuration ()
  {
    if (!$this->getCreatedAt() || !$this->getEndAt())
    {
      return null;
    }

    return $this->getEndAt()->getTimestamp() - $this->getCreatedAt()->getTimestamp();
  }

  public function getType ()
  {
    return 'Трафик';
  }
}