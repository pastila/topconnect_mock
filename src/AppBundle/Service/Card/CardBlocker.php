<?php

namespace AppBundle\Service\Card;

use AppBundle\Entity\Account\Account;
use Doctrine\ORM\EntityManagerInterface;

class CardBlocker
{
  protected $entityManager;

  public function __construct (EntityManagerInterface $entityManager)
  {
    $this->entityManager = $entityManager;
  }

  public function blockCard (Account $account, $params)
  {
    $onum = $params['onum'];
    $block = $params['block'];

    $card = $this->entityManager->getRepository('AppBundle:Card\Card')->findOneBy(['msisdn' => $onum]);

    if ($card === null)
    {
      throw new \Exception(); //FIXME
    }

    $xml = new \SimpleXMLElement('<card/>');
    $xml->addChild('tsimid', $card->getId());
    $xml->addChild('inum', $card->getINum());
    $xml->addChild('onum', $card->getMsisdn());

    if ($block === 't')
    {
      $card->setBlocked(true);
      $this->entityManager->persist($card);
      $this->entityManager->flush();
    }
    elseif ($block === 'f')
    {
      $card->setBlocked(false);
      $this->entityManager->persist($card);
      $this->entityManager->flush();
    }

    $xml->addChild('blocked', $card->isBlocked());
  }

}