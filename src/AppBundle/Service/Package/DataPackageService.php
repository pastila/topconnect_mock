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
    $card = $this->entityManager->getRepository('AppBundle:Card\Card')->findOneBy(['msisdn' => $params['onum']]);
    /** @var DataPackage $package */
    $package = $this->entityManager->getRepository('AppBundle:Package\DataPackage')->findOneBy(['code' => $params['packetid']]);
    $expire = new \DateTime();

    if ($card === null)
    {
      throw new \Exception('MSISDN not found');
    }

    if ($package === null)
    {
      throw new \Exception('Incorrect packetid value');
    }

    $expire->modify(sprintf('+%d days', $package->getPeriod()));

    if ($card->getBalance() < $package->getActivationFee())
    {
      throw new \Exception('Not enough money');
    }

    $existDataPackage = $this->entityManager->getRepository(DataPackageRecord::class)
      ->createQueryBuilder('dr')
      ->where('dr.expireAt > :now')
      ->andWhere('dr.card = :card')
      ->andWhere('dr.package = :package')
      ->setParameter('card', $card)
      ->setParameter('package', $package)
      ->setParameter('now', new \DateTime())
      ->getQuery()
      ->getOneOrNullResult();

    if ($existDataPackage !== null)
    {
      throw new \Exception('Package currently active');
    }

    $record = new DataPackageRecord();
    $record->setActivatedAt(new \DateTime());
    $record->setExpireAt($expire);
    $record->setCard($card);
    $record->setPackage($package);
    $record->setMsisdn($card->getMsisdn());
    $record->setPrice($package->getActivationFee());
    $record->setBalanceBefore($card->getBalance());
    $newBalance = $card->getBalance() - $package->getActivationFee();
    $record->setBalanceAfter($newBalance);
    $card->setBalance($newBalance);
    $this->entityManager->persist($card);
    $this->entityManager->persist($record);
    $this->entityManager->flush();

    $xml = new \SimpleXMLElement('<discount/>');
    $xml->addChild('result', 'Ok');

    return $xml->asXML();
  }

  /**
   * @param Account $account
   * @param $params
   * @return DataPackageRecord
   * @throws \Exception
   */
//  public function activatePackage (Account $account, $params)
//  {
//    /** @var Card $card */
//    $card = $this->entityManager->getRepository('AppBundle:Card\Card')->findOneBy(['msisdn' => $params['onum']]);
//    /** @var DataPackage $package */
//    $package = $this->entityManager->getRepository('AppBundle:Package\DataPackage')->findOneBy(['code' => $params['packetid']]);
//    $timeframe = $params['timeframes'];
//    $from = new \DateTime($params['from']);
//    $expire = clone $from;
//
//    if ($card === null)
//    {
//      throw new \Exception('MSISDN not found');
//    }
//
//    if ($package === null)
//    {
//      throw new \Exception('Incorrect packetid value');
//    }
//
//    if ($timeframe < 1 || $timeframe > 12)
//    {
//      throw new \Exception('Incorrect timeframe value');
//    }
//
//    $expire->modify(sprintf('+%d days', $package->getPeriod() * $timeframe));
//
//    if ($card->getBalance() < $package->getActivationFee())
//    {
//      throw new \Exception('Not enough money');
//    }
//
//    $record = new DataPackageRecord();
//    $record->setActivatedAt($from);
//    $record->setExpireAt($expire);
//    $record->setCard($card);
//    $record->setPackage($package);
//    $record->setMsisdn($card->getMsisdn());
//    $record->setTimeframes($timeframe);
//    $record->setPrice($package->getActivationFee());
//    $record->setBalanceBefore($card->getBalance());
//    $newBalance = $card->getBalance() - $package->getActivationFee();
//    $record->setBalanceAfter($newBalance);
//    $card->setBalance($newBalance);
//    $this->entityManager->persist($card);
//    $this->entityManager->persist($record);
//    $this->entityManager->flush();
//
//    $xml = new \SimpleXMLElement('<record/>');
//    $xml->addChild('onum', $record->getMsisdn());
//    $xml->addChild('result', 'success');
//    $xml->addChild('active', $record->getActivatedAt()->format('Y-m-d'));
//    $xml->addChild('expire', $record->getExpireAt()->format('Y-m-d'));
//    $xml->addChild('packetid', $record->getPackage()->getId());
//    $xml->addChild('price', $record->getPrice());
//    $xml->addChild('balance_before', $record->getBalanceBefore());
//    $xml->addChild('balance_after', $record->getBalanceAfter());
//
//    return $xml->asXML();
//  }

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
    $xml = new \SimpleXMLElement('<discount/>');

    foreach ($records as $record)
    {
      if ($record->getExpireAt() >= new \DateTime())
      {
        $item = $xml->addChild('gprs');
        $item->addChild('onum', $record->getCard()->getMsisdn());
        $item->addChild('tsimid', $record->getCard()->getMsisdn());
        $item->addChild('activation_date', $record->getCreatedAt()->format('Y-m-d H:i:s'));
        $item->addChild('expire_date', $record->getExpireAt()->format('Y-m-d H:i:s'));
        $item->addChild('type', $record->getPackage()->getName());
        $item->addChild('cost', $record->getPrice());
        $item->addChild('package_code', $record->getPackage()->getCode());
        $item->addChild('multistatus', 'active');
        $item->addChild('amount', '0');
        $item->addChild('dataLeft', '0');
        $item->addChild('nextCooldown', '0');
        $item->addChild('activation_number', '0');
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
//  public function getPackageList (Account $account, $params)
//  {
//    $onum = $params['onum'];
//    /** @var Card $card */
//    $card = $this->entityManager->getRepository(Card::class)->createQueryBuilder('c')
//      ->where('c.msisdn = :onum')
//      ->setParameter('onum', $onum)
//      ->getQuery()
//      ->getOneOrNullResult();
//
//    if ($card === null)
//    {
//      throw new \Exception(sprintf('Msisdn %s not found', $onum));
//    }
//
//    $records = $card->getDataPackageRecords();
//    $xml = new \SimpleXMLElement('<records/>');
//
//    foreach ($records as $record)
//    {
//      if ($record->getExpireAt() >= new \DateTime())
//      {
//        $item = $xml->addChild('record');
//        $item->addChild('onum', $record->getCard()->getMsisdn());
//        $item->addChild('active', $record->getActivatedAt()->format('Y-m-d'));
//        $item->addChild('expire', $record->getExpireAt()->format('Y-m-d'));
//        $item->addChild('packetid', $record->getPackage()->getId());
//        $item->addChild('price', $record->getPrice());
//        $item->addChild('status', 'enabled');
//        $item->addChild('ordered', $record->getCreatedAt()->format('Y-m-d'));
//        $item->addChild('queries_left', 5); //хз
//        $item->addChild('queries_used', 3); //хз
//      }
//    }
//
//    return $xml->asXML();
//  }

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
    $finished->modify('+1 day 00:00');
    /** @var DataPackageRecord[] $records */
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

    $xml = new \SimpleXMLElement('<discount/>');

    foreach ($records as $record)
    {
      $item = $xml->addChild('gprs');

      /*
<currency>EUR</currency>
<cooldown>20160</cooldown>
<amount>1048576000</amount>
<activation_number>0</activation_number>
<reorder_amount>0</reorder_amount>
       */

      $item->addChild('onum', $record->getCard()->getMsisdn());
      $item->addChild('activation_date', $record->getCreatedAt()->format('Y-m-d H:i:s'));
      $item->addChild('expire_date', $record->getExpireAt()->format('Y-m-d H:i:s'));
      $item->addChild('type', $record->getPackage()->getName());
      $item->addChild('cost', $record->getPrice());
      $item->addChild('tsimid', $record->getCard()->getId());
      $item->addChild('currency', 'EUR');
      $item->addChild('cooldown', $record->getPackage()->getVolume());
      $item->addChild('amount', $record->getPackage()->getVolume());
      $item->addChild('activation_number', '0');
      $item->addChild('reorder_amount', '0');
    }

    return $xml->asXML();
  }
}