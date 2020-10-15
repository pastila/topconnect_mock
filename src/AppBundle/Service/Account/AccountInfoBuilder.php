<?php


namespace AppBundle\Service\Account;


use AppBundle\Entity\Account\Account;
use Doctrine\ORM\EntityManagerInterface;

class AccountInfoBuilder
{
  protected $entityManager;

  public function __construct (EntityManagerInterface $entityManager)
  {
    $this->entityManager = $entityManager;
  }

  public function buildInfo (Account $account)
  {
    $xml = new \SimpleXMLElement('<account/>');
    $xml->addChild('name', $account->getName());
    $xml->addChild('balance', $account->getBalance());
    $xml->addChild('currency', $account->getCurrency());
    $lastOrderId = (int)$this->entityManager->getRepository('AppBundle:Transaction\Transaction')
      ->createQueryBuilder('t')
      ->join('t.card', 'c')
      ->select('MAX(t.orderId)')
      ->where('c.account = :account')
      ->setParameter('account', $account)
      ->getQuery()
      ->getSingleScalarResult();
    $xml->addChild('orderid', $lastOrderId);
    $xml->addChild('active', $account->getActiveAt() ? $account->getActiveAt()->format('Y-m-d') : null);
    $xml->addChild('expire', $account->getExpireAt() ? $account->getExpireAt()->format('Y-m-d') : null);
    return $xml->asXML();
  }
}