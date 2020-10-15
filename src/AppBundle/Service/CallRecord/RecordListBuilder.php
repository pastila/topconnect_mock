<?php


namespace AppBundle\Service\CallRecord;


use AppBundle\Entity\Account\Account;
use AppBundle\Entity\Record\CallRecord;
use AppBundle\Entity\Record\Record;
use AppBundle\Entity\Record\SmsRecord;
use Doctrine\ORM\EntityManagerInterface;

class RecordListBuilder
{
  protected $entityManager;

  public function __construct (EntityManagerInterface $entityManager)
  {
    $this->entityManager = $entityManager;
  }

  public function getRecordList (Account $account, $params)
  {
    $started = new \DateTime($params['started']);
    $finished = new \DateTime($params['finished']);
    $finished->modify('+1 day');
    $onum = isset($params['onum']) ? $params['onum'] : null;
    
    $qb = $this->entityManager->getRepository('AppBundle:Record\Record')->createQueryBuilder('r')
      ->where('r.createdAt >= :started')
      ->andWhere('r.createdAt <= :finished')
      ->setParameter('started', $started)
      ->setParameter('finished', $finished)
    ;
    
    if ($onum !== null)
    {
      $qb
        ->join('r.card', 'c')
        ->andWhere('c.msisdn = :num')
        ->setParameter('num', $onum)
      ;
    }
    
    $records = $qb->getQuery()->getResult();
    $xml = new \SimpleXMLElement('<gccdr/>');

    foreach ($records as $record)
    {
      if ($record instanceof CallRecord)
      {
        $item = $xml->addChild('call');
        $item->addChild('tsimid', $record->getCard()->getId());
        $item->addChild('calldate', $record->getCreatedAt()->format('Y-m-d H:i:s'));
        $item->addChild('onum', $record->getCard()->getMsisdn());

        if ($record->getDirection() === Record::DIRECTION_INCOMING)
        {
          $item->addChild('anum', $record->getSecondPhoneNumber());
          $item->addChild('bnum', $record->getCard()->getMsisdn());
          $item->addChild('cdir', 'I');
        }
        else
        {
          $item->addChild('anum', $record->getCard()->getMsisdn());
          $item->addChild('bnum', $record->getSecondPhoneNumber());
          $item->addChild('cdir', 'O');
        }

        $item->addChild('rnum', '');
        $item->addChild('duration', $record->getDuration());
        $item->addChild('billsec', $record->getDuration());
        $item->addChild('ccost', $record->getCCost());
        $item->addChild('curr', $record->getCard()->getCurrency());
        $item->addChild('mcost', 0.00);
        $item->addChild('conn_cost', 0.00);
        $item->addChild('free_sec', 0);
        $item->addChild('bleg', 'false');
        $item->addChild('adest', 'Russia Mobile');
        $item->addChild('bdest', 'Extra%20Number');
        $item->addChild('rdest', null);
        $item->addChild('uniqueid', $record->getUniqId());
        $item->addChild('imsi', null);
      }
      elseif ($record instanceof SmsRecord)
      {
        $item = $xml->addChild('sms');
        $item->addChild('tsimid', $record->getCard()->getId());
        $item->addChild('calldate', $record->getCreatedAt()->format('Y-m-d H:i:s'));
        $item->addChild('onum', $record->getCard()->getMsisdn());

        if ($record->getDirection() === Record::DIRECTION_INCOMING)
        {
          $item->addChild('anum', $record->getSecondPhoneNumber());
          $item->addChild('bnum', $record->getCard()->getMsisdn());
          $item->addChild('cdir', 'I');
        }
        else
        {
          $item->addChild('anum', $record->getCard()->getMsisdn());
          $item->addChild('bnum', $record->getSecondPhoneNumber());
          $item->addChild('cdir', 'O');
        }

        $item->addChild('smst', $record->getText());
        $item->addChild('ccost', $record->getSmsCost());
        $item->addChild('curr', $record->getCard()->getCurrency());
        $item->addChild('imsi', null);
        $item->addChild('part', $record->getPart() . '/' . $record->getPart());
      }
    }

    return $xml->asXML();
  }

}