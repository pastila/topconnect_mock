<?php


namespace AppBundle\Entity\Card;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="card_services")
 */
class CardService
{
  /**
   * @var int
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   * @ORM\Column(type="integer")
   */
  protected $id;

  /**
   * @var string
   * @ORM\Column(type="string", length=50, nullable=false)
   */
  protected $number;

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
  public function getNumber ()
  {
    return $this->number;
  }

  /**
   * @param string $number
   * @return $this
   */
  public function setNumber ($number)
  {
    $this->number = $number;
    return $this;
  }

  public function __toString ()
  {
    return $this->number;
  }


}