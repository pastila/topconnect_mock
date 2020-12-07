<?php

namespace AppBundle\Entity\Record;

use AppBundle\Entity\Card\Card;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\MappedSuperclass()
 * @ORM\Entity
 * @ORM\Table(name="records")
 * @ORM\InheritanceType(value="JOINED")
 * @ORM\DiscriminatorColumn(type="string", length=20, name="type")
 * @ORM\DiscriminatorMap({
 *   "sms"="AppBundle\Entity\Record\SmsRecord",
 *   "call"="AppBundle\Entity\Record\CallRecord",
 *   "data"="AppBundle\Entity\Record\DataRecord"
 *   })
 */
abstract class Record
{
  use TimestampableEntity;

  const DIRECTION_INCOMING = 'incoming';
  const DIRECTION_OUTCOMING = 'outcoming';
  /**
   * @var integer
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   * @ORM\Column(type="integer")
   */
  protected $id;

  /**
   * @var Card
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Card\Card", inversedBy="records")
   * @ORM\JoinColumn(onDelete="CASCADE")
   */
  protected $card;

  /**
   * @var string
   * @ORM\Column(type="string", length=20, nullable=false)
   */
  protected $direction;

  /**
   * @var string
   * @ORM\Column(type="string", length=50, nullable=true)
   */
  protected $secondPhoneNumber;

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
  public function getDirection ()
  {
    return $this->direction;
  }

  /**
   * @param string $direction
   * @return $this
   */
  public function setDirection ($direction)
  {
    if (!in_array($direction, [self::DIRECTION_INCOMING, self::DIRECTION_OUTCOMING]))
    {
      throw new \InvalidArgumentException();
    }

    $this->direction = $direction;
    return $this;
  }

  /**
   * @return string
   */
  public function getSecondPhoneNumber ()
  {
    return $this->secondPhoneNumber;
  }

  /**
   * @param string $secondPhoneNumber
   * @return $this
   */
  public function setSecondPhoneNumber ($secondPhoneNumber)
  {
    $this->secondPhoneNumber = $secondPhoneNumber;
    return $this;
  }

  abstract public function getType ();

  public function __toString ()
  {
    return sprintf('%s %s', $this->getDirection() === self::DIRECTION_INCOMING ? 'Входящий' : 'Исходящий', $this->getType());
  }


}