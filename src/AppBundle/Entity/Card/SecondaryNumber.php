<?php


namespace AppBundle\Entity\Card;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="secondary_numbers")
 */
class SecondaryNumber
{
  /**
   * @var int
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   * @ORM\Column(type="integer")
   */
  protected $id;

  /**
   * @var Card
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Card\Card", inversedBy="secondaryNumbers")
   * @ORM\JoinColumn()
   */
  protected $card;

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


}