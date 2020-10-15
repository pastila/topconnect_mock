<?php


namespace AppBundle\Entity\Record;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="sms_records")
 */
class SmsRecord extends Record
{
  /**
   * @var string
   * @ORM\Column(type="string", length=160, nullable=true)
   */
  protected $text;

  /**
   * @var float
   * @ORM\Column(type="decimal", precision=18, scale=2)
   */
  protected $smsCost;

  /**
   * @var integer
   * @ORM\Column(type="integer", nullable=false)
   */
  protected $part;

  /**
   * @return string
   */
  public function getText ()
  {
    return $this->text;
  }

  /**
   * @param string $text
   * @return $this
   */
  public function setText ($text)
  {
    $this->text = $text;
    return $this;
  }

  /**
   * @return float
   */
  public function getSmsCost ()
  {
    return $this->smsCost;
  }

  /**
   * @param float $smsCost
   * @return $this
   */
  public function setSmsCost ($smsCost)
  {
    $this->smsCost = $smsCost;
    return $this;
  }

  /**
   * @return int
   */
  public function getPart ()
  {
    return $this->part;
  }

  /**
   * @param int $part
   * @return $this
   */
  public function setPart ($part)
  {
    $this->part = $part;
    return $this;
  }

  public function getType ()
  {
    return 'Sms';
  }
}