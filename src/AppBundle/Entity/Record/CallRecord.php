<?php


namespace AppBundle\Entity\Record;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="call_records")
 * @ORM\HasLifecycleCallbacks()
 */
class CallRecord extends Record
{
  /**
   * @var integer
   * @ORM\Column(type="integer", nullable=false)
   */
  protected $duration;

  /**
   * @var float
   * @ORM\Column(type="decimal", scale=2, precision=18)
   */
  protected $cCost;

  /**
   * @var string
   * @ORM\Column(type="string", length=64, nullable=false)
   */
  protected $uniqId;

  /**
   * @return int
   */
  public function getDuration ()
  {
    return $this->duration;
  }

  /**
   * @param int $duration
   * @return $this
   */
  public function setDuration ($duration)
  {
    $this->duration = $duration;
    return $this;
  }

  /**
   * @return float
   */
  public function getCCost ()
  {
    return $this->cCost;
  }

  /**
   * @param float $cCost
   * @return $this
   */
  public function setCCost ($cCost)
  {
    $this->cCost = $cCost;
    return $this;
  }

  /**
   * @return string
   */
  public function getUniqId ()
  {
    return $this->uniqId;
  }

  /**
   * @param string $uniqId
   * @return $this
   */
  public function setUniqId ($uniqId)
  {
    $this->uniqId = $uniqId;
    return $this;
  }

  /**
   * @ORM\PrePersist()
   */
  public function prePersist ()
  {
    $this->uniqId = uniqid('s', true);
  }

  public function getType ()
  {
    return 'Звонок';
  }
}