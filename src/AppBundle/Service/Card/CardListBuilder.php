<?php


namespace AppBundle\Service\Card;


use AppBundle\Entity\Account\Account;
use Doctrine\ORM\EntityManagerInterface;

class CardListBuilder
{
  protected $entityManager;

  public function __construct (EntityManagerInterface $entityManager)
  {
    $this->entityManager = $entityManager;
  }

  /**
   * @param array $params
   * @return string
   */
  public function buildList (Account $account, $params = [])
  {
    $cardQB = $this->entityManager->getRepository('AppBundle:Card\Card')
      ->createQueryBuilder('c')
      ->where('c.account = :account')
      ->setParameter('account', $account)
    ;

    if (isset($params['onum']))
    {
      $cardQB
        ->andWhere('c.msisdn = :onum')
        ->setParameter('onum', $params['onum'])
      ;
    }

    $cards = $cardQB->getQuery()->getResult();
    $xml = new \SimpleXMLElement('<records/>');

    foreach ($cards as $card)
    {
      $cardEl = $xml->addChild('card');
      $cardEl->addChild('tsimid', $card->getId());
      $cardEl->addChild('aserviceid', $card->getService() ? $card->getService()->getId() : null);
      $cardEl->addChild('inum', $card->getINum());
      $cardEl->addChild('onum', $card->getMsisdn());
      $cardEl->addChild('prepayed', $card->isPrepayed() ? 'true' : 'false');
      $cardEl->addChild('blocked', $card->isBlocked() ? 'true' : 'false');
      $cardEl->addChild('balance', $card->getBalance());
      $cardEl->addChild('curr', $card->getCurrency());
    }

    return $xml->asXML();
  }
}