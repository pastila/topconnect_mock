<?php

namespace AppBundle\Service\Package;

use AppBundle\Entity\Account\Account;
use AppBundle\Entity\Card\Card;
use AppBundle\Entity\Package\DataPackage;
use AppBundle\Entity\Package\DataPackageRecord;
use Doctrine\ORM\EntityManagerInterface;

class DataPackageService
{
  private $entityManager;

  public function __construct (EntityManagerInterface $entityManager)
  {
    $this->entityManager = $entityManager;
  }

  /**
   * @param Account $account
   * @param $params
   * @return DataPackageRecord
   * @throws \Exception
   */
  public function activatePackage (Account $account, $params)
  {
    /** @var Card $card */
    $card = $this->entityManager->getRepository('AppBundle:Card\Card')->findOneBy(['onum' => $params['onum']]);
    /** @var DataPackage $package */
    $package = $this->entityManager->getRepository('AppBundle:Package\DataPackage')->findOneBy(['code' => $params['packetid']]);
    $timeframe = $params['timeframes'];
    $from = new \DateTime($params['from']);
    $expire = clone $from;

    if ($card === null)
    {
      throw new \Exception('MSISDN not found');
    }

    if ($package === null)
    {
      throw new \Exception('Incorrect packetid value');
    }

    if ($timeframe < 1 || $timeframe > 12)
    {
      throw new \Exception('Incorrect timeframe value');
    }

    $expire->modify(sprintf('+%d days', $package->getPeriod() * $timeframe));

    if ($card->getBalance() < $package->getActivationFee())
    {
      throw new \Exception('Not enough money');
    }

    $record = new DataPackageRecord();
    $record->setActivatedAt($from);
    $record->setExpireAt($expire);
    $record->setCard($card);
    $record->setPackage($package);
    $record->setMsisdn($card->getMsisdn());
    $record->setTimeframes($timeframe);
    $record->setPrice($package->getActivationFee());
    $record->setBalanceBefore($card->getBalance());
    $newBalance = $card->getBalance() - $package->getActivationFee();
    $record->setBalanceAfter($newBalance);
    $card->setBalance($newBalance);
    $this->entityManager->persist($card);
    $this->entityManager->persist($record);
    $this->entityManager->flush();

    $xml = new \SimpleXMLElement('<record/>');
    $xml->addChild('onum', $record->getMsisdn());
    $xml->addChild('result', 'success');
    $xml->addChild('active', $record->getActivatedAt()->format('Y-m-d'));
    $xml->addChild('expire', $record->getExpireAt()->format('Y-m-d'));
    $xml->addChild('packetid', $record->getPackage()->getId());
    $xml->addChild('price', $record->getPrice());
    $xml->addChild('balance_before', $record->getBalanceBefore());
    $xml->addChild('balance_after', $record->getBalanceAfter());

    return $xml->asXML();
  }

  /**
   * @param Account $account
   * @param $params
   * @return bool|string
   * @throws \Exception
   */
  public function getPackageList (Account $account, $params)
  {
    $onum = $params['onum'];
    /** @var Card $card */
    $card = $this->entityManager->getRepository(Card::class)->createQueryBuilder('c')
      ->where('c.msisdn = :onum')
      ->setParameter('onum', $onum)
      ->getQuery()
      ->getOneOrNullResult();

    if ($card === null)
    {
      throw new \Exception(sprintf('Msisdn %s not found', $onum));
    }

    $records = $card->getDataPackageRecords();
    $xml = new \SimpleXMLElement('<records/>');

    foreach ($records as $record)
    {
      if ($record->getExpireAt() >= new \DateTime())
      {
        $item = $xml->addChild('record');
        $item->addChild('onum', $record->getCard()->getMsisdn());
        $item->addChild('active', $record->getActivatedAt()->format('Y-m-d'));
        $item->addChild('expire', $record->getExpireAt()->format('Y-m-d'));
        $item->addChild('packetid', $record->getPackage()->getId());
        $item->addChild('price', $record->getPrice());
        $item->addChild('status', 'enabled');
        $item->addChild('ordered', $record->getCreatedAt()->format('Y-m-d'));
        $item->addChild('queries_left', 5); //хз
        $item->addChild('queries_used', 3); //хз
      }
    }

    return $xml->asXML();
  }

  /**
   * @param Account $account
   * @param $params
   * @return bool|string
   * @throws \Exception
   */
  public function getPackageListHistory (Account $account, $params)
  {
    $onum = $params['onum'];
    $started = new \DateTime($params['started']);
    $finished = new \DateTime($params['finished']);
    $records = $this->entityManager->getRepository(DataPackageRecord::class)
      ->createQueryBuilder('r')
      ->where('r.createdAt >= :started')
      ->andWhere('r.createdAt <= :finished')
      ->andWhere('r.msisdn = :onum')
      ->setParameter('onum', $onum)
      ->setParameter('started', $started)
      ->setParameter('finished', $finished)
      ->getQuery()
      ->getResult();

    $xml = new \SimpleXMLElement('<result/>');

    foreach ($records as $record)
    {
      $item = $xml->addChild('record');
      $item->addChild('onum', $record->getCard()->getMsisdn());
      $item->addChild('active', $record->getActivatedAt()->format('Y-m-d'));
      $item->addChild('expire', $record->getExpireAt()->format('Y-m-d'));
      $item->addChild('packetid', $record->getPackage()->getId());
      $item->addChild('price', $record->getPrice());
      $item->addChild('ordered', $record->getCreatedAt()->format('Y-m-d'));
    }

    return $xml->asXML();
  }
}