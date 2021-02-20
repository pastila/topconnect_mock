<?php


namespace AppBundle\Service\Balance;


use AppBundle\Entity\Account\Account;
use AppBundle\Entity\Transaction\Transaction;
use Doctrine\ORM\EntityManagerInterface;

class TransactionHistoryBuilder
{
  protected $entityManager;

  public function __construct (EntityManagerInterface $entityManager)
  {
    $this->entityManager = $entityManager;
  }

  public function getHistory (Account $account, $params)
  {
    $onum = $params['onum'];
    $started = new \DateTime($params['started']);
    $finished = new \DateTime($params['finished']);
    $finished->modify('+1 day');

    /** @var Transaction[] $transactions */
    $transactions = $this->entityManager
      ->getRepository('AppBundle:Transaction\Transaction')
      ->createQueryBuilder('t')
      ->join('t.card', 'c')
      ->where('c.msisdn = :onum')
      ->setParameter('onum', $onum)
      ->andWhere('t.createdAt >= :from')
      ->andWhere('t.createdAt <= :to')
      ->setParameter('from', $started)
      ->setParameter('to', $finished)
      ->getQuery()
      ->getResult();

    $xml = new \SimpleXMLElement('<sbalance/>');

    foreach ($transactions as $transaction)
    {
      $recordCard = $xml->addChild('record');
      $recordCard->addChild('added', $transaction->getCreatedAt()->format('Y-m-d H:i:s'));
      $recordCard->addChild('type', 'card');
      $recordCard->addChild('orderid', $transaction->getOrderId());
      $recordCard->addChild('uname', $transaction->getCard()->getAccount()->getApiLogin());
      $recordCard->addChild('address', '127.0.0.1');
      $recordCard->addChild('command', 'sbalance');
      $recordCard->addChild('inum', $transaction->getCard()->getINum());
      $recordCard->addChild('onum', $transaction->getCard()->getMsisdn());
      $recordCard->addChild('balance', sprintf('%s %s', $transaction->getCard()->getBalance(), $transaction->getCard()->getCurrency()));
      $recordCard->addChild('amount', sprintf('%s %s', $transaction->getAmount() > 0 ? '+'.$transaction->getAmount() : $transaction->getAmount(), $transaction->getCurrency()));

      $recordClient = $xml->addChild('record');
      $recordClient->addChild('added', $transaction->getCreatedAt()->format('Y-m-d H:i:s'));
      $amount = $transaction->getAmount() * -1;
      $recordClient->addChild('amount', sprintf('%s %s', $amount > 0 ? '+'.$amount : $amount, $transaction->getCurrency()));
      $recordClient->addChild('orderid', $transaction->getOrderId());
      $recordClient->addChild('type', 'client');
      $recordClient->addChild('uname', $transaction->getCard()->getAccount()->getApiLogin());
      $recordClient->addChild('address', '127.0.0.1');
      $recordClient->addChild('command', 'sbalance');
      $recordClient->addChild('balance', sprintf('%s %s', $transaction->getCard()->getAccount()->getBalance(), $transaction->getCard()->getAccount()->getCurrency()));
    }

    return $xml->asXML();
  }
}