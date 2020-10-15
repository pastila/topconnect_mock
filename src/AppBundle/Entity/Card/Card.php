<?php


namespace AppBundle\Entity\Card;


use AppBundle\Entity\Account\Account;
use AppBundle\Entity\Record\Record;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="cards")
 */
class Card
{
  /**
   * card ID
   * tsimid
   * @var string
   * @ORM\Id()
   * @ORM\GeneratedValue()
   * @ORM\Column(type="integer")
   */
  protected $id;

  /**
   * service_id
   * aserviceid
   * @var CardService
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Card\CardService")
   * @ORM\JoinColumn(nullable=false)
   */
  protected $service;

  /**
   * iNum
   * @var string
   * @ORM\Column(type="string", length=50, nullable=false)
   */
  protected $iNum;

  /**
   * MSISDN
   * onum
   * @var string
   * @ORM\Column(type="string", length=50, nullable=false)
   */
  protected $msisdn;

  /**
   * @var boolean
   * @ORM\Column(type="boolean", nullable=false, options={"default"=false})
   */
  protected $prepayed=false;

  /**
   * @var float
   * @ORM\Column(type="decimal", precision=18, scale=2, nullable=false, options={"default"=0})
   */
  protected $balance = 0;

  /**
   * curr
   * @var string
   * @ORM\Column(type="string", length=5, nullable=false)
   */
  protected $currency = 'EUR';
  /**
   * @var string
   * @ORM\Column(type="string", length=50, nullable=false)
   */
  protected $iccid;
  /**
   * @var string
   * @ORM\Column(type="string", length=50, nullable=true)
   */
  protected $primaryNumber;

  /**
   * @var ArrayCollection|SecondaryNumber[]
   * @ORM\OneToMany(targetEntity="AppBundle\Entity\Card\SecondaryNumber", mappedBy="card")
   */
  protected $secondaryNumbers;

  /**
   * @var \DateTime
   * @ORM\Column(type="datetime", nullable=false)
   * @Gedmo\Timestampable(on="create")
   */
  protected $createdAt;

  /**
   * @var \DateTime
   * @ORM\Column(type="datetime", nullable=true)
   */
  protected $lastUsageAt;

  /**
   * @var \DateTime
   * @ORM\Column(type="datetime", nullable=true)
   */
  protected $firstUsageAt;

  /**
   * @var float
   * @ORM\Column(type="decimal", precision=18, scale=2)
   */
  protected $overdraft;

  /**
   * @var boolean
   * @ORM\Column(type="boolean", nullable=false, options={"default"=false})
   */
  protected $blocked=false;

  /**
   * @var Account
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Account\Account")
   * @ORM\JoinColumn(nullable=false)
   */
  protected $account;

  /**
   * @var Record[]|ArrayCollection
   * @ORM\OneToMany(targetEntity="AppBundle\Entity\Record\Record", mappedBy="card")
   */
  protected $records;

  public function __construct ()
  {
    $this->records = new ArrayCollection();
  }


  /**
   * @return string
   */
  public function getId ()
  {
    return $this->id;
  }

  /**
   * @return CardService
   */
  public function getService ()
  {
    return $this->service;
  }

  /**
   * @param CardService $service
   * @return $this
   */
  public function setService ($service)
  {
    $this->service = $service;
    return $this;
  }
  /**
   * @return string
   */
  public function getINum ()
  {
    return $this->iNum;
  }

  /**
   * @param string $iNum
   * @return $this
   */
  public function setINum ($iNum)
  {
    $this->iNum = $iNum;
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
   * @return bool
   */
  public function isPrepayed ()
  {
    return $this->prepayed;
  }

  /**
   * @param bool $prepayed
   * @return $this
   */
  public function setPrepayed ($prepayed)
  {
    $this->prepayed = $prepayed;
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

  /**
   * @return string
   */
  public function getIccid ()
  {
    return $this->iccid;
  }

  /**
   * @param string $iccid
   * @return $this
   */
  public function setIccid ($iccid)
  {
    $this->iccid = $iccid;
    return $this;
  }

  /**
   * @return string
   */
  public function getPrimaryNumber ()
  {
    return $this->primaryNumber;
  }

  /**
   * @param string $primaryNumber
   * @return $this
   */
  public function setPrimaryNumber ($primaryNumber)
  {
    $this->primaryNumber = $primaryNumber;
    return $this;
  }

  /**
   * @return SecondaryNumber[]|ArrayCollection
   */
  public function getSecondaryNumbers ()
  {
    return $this->secondaryNumbers;
  }

  /**
   * @param SecondaryNumber[]|ArrayCollection $secondaryNumbers
   * @return $this
   */
  public function setSecondaryNumbers ($secondaryNumbers)
  {
    $this->secondaryNumbers = $secondaryNumbers;
    return $this;
  }

  /**
   * @return \DateTime
   */
  public function getCreatedAt ()
  {
    return $this->createdAt;
  }

  /**
   * @param \DateTime $createdAt
   * @return $this
   */
  public function setCreatedAt ($createdAt)
  {
    $this->createdAt = $createdAt;
    return $this;
  }

  /**
   * @return \DateTime
   */
  public function getLastUsageAt ()
  {
    return $this->lastUsageAt;
  }

  /**
   * @param \DateTime $lastUsageAt
   * @return $this
   */
  public function setLastUsageAt ($lastUsageAt)
  {
    $this->lastUsageAt = $lastUsageAt;
    return $this;
  }

  /**
   * @return \DateTime
   */
  public function getFirstUsageAt ()
  {
    return $this->firstUsageAt;
  }

  /**
   * @param \DateTime $firstUsageAt
   * @return $this
   */
  public function setFirstUsageAt ($firstUsageAt)
  {
    $this->firstUsageAt = $firstUsageAt;
    return $this;
  }

  /**
   * @return float
   */
  public function getOverdraft ()
  {
    return $this->overdraft;
  }

  /**
   * @param float $overdraft
   * @return $this
   */
  public function setOverdraft ($overdraft)
  {
    $this->overdraft = $overdraft;
    return $this;
  }

  /**
   * @return bool
   */
  public function isBlocked ()
  {
    return $this->blocked;
  }

  /**
   * @param bool $blocked
   * @return $this
   */
  public function setBlocked ($blocked)
  {
    $this->blocked = $blocked;
    return $this;
  }

  public function __toString ()
  {
    return $this->msisdn;
  }

  /**
   * @return Account
   */
  public function getAccount ()
  {
    return $this->account;
  }

  /**
   * @param Account $account
   * @return $this
   */
  public function setAccount ($account)
  {
    $this->account = $account;
    return $this;
  }

  /**
   * @return Record[]|ArrayCollection
   */
  public function getRecords ()
  {
    return $this->records;
  }

  /**
   * @param Record[]|ArrayCollection $records
   * @return $this
   */
  public function setRecords ($records)
  {
    $this->records = new ArrayCollection();

    foreach ($records as $record)
    {
      $this->addRecord($record);
    }

    return $this;
  }

  public function addRecord (Record $record)
  {
    $this->records->add($record);
    $record->setCard($this);
  }

  public function removeRecord (Record $record)
  {
    $this->records->removeElement($record);
  }

  public function getPin1 ()
  {
    return '0000';
  }

  public function getPin2 ()
  {
    return '1111';
  }

  public function getPuk1 ()
  {
    return '12345678';
  }

  public function getPuk2 ()
  {
    return '12345678';
  }

  public function getLpa ()
  {
    return sprintf('LPA:1$ecprsp.test.test$%s', base64_encode($this->msisdn));
  }
}
