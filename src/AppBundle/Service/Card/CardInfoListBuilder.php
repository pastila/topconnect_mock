<?php


namespace AppBundle\Service\Card;


use AppBundle\Entity\Account\Account;
use AppBundle\Entity\Card\Card;
use AppBundle\Exception\CardStat\NotProvidedMsisdnAndIccidException;
use Doctrine\ORM\EntityManagerInterface;

class CardInfoListBuilder
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
      ->setMaxResults(1)
    ;

    if (isset($params['msisdn']))
    {
      $cardQB
        ->andWhere('c.msisdn = :msisdn')
        ->setParameter('msisdn', $params['msisdn']);
    }

    if (isset($params['iccid']))
    {
      $cardQB
        ->andWhere('c.msisdn = :iccid')
        ->setParameter('iccid', $params['iccid']);
    }

    /** @var Card $card */
    $card = $cardQB->getQuery()->getOneOrNullResult();

    if ($card === null)
    {
      if (!isset($params['msisdn']) && !isset($params['iccid']))
      {
        return $this->getErrorXml('Please provide MSISDN OR ICCID', 4);
      }
      elseif (isset($params['msisdn']))
      {
        return $this->getErrorXml('MSISDN not found', 1);
      }
      elseif (isset($params['iccid']))
      {
        return $this->getErrorXml('ICCID not found', 2);
      }
    }

    $xml = new \SimpleXMLElement('<card_stat/>');

    $cardEl = $xml->addChild('card');
    $cardEl->addChild('tsimid', $card->getId());
    $cardEl->addChild('aserviceid', $card->getService() ? $card->getService()->getId() : null);
    $cardEl->addChild('inum', $card->getINum());
    $cardEl->addChild('onum', $card->getMsisdn());
    $cardEl->addChild('prepayed', $card->isPrepayed() ? 'true' : 'false');
    $cardEl->addChild('blocked', $card->isBlocked() ? 'true' : 'false');
    $cardEl->addChild('balance', $card->getBalance());
    $cardEl->addChild('curr', $card->getCurrency());
    $cardEl->addChild('enum', $card->getPrimaryNumber());
    $cardEl->addChild('SEnum_list', '');
    $cardEl->addChild('create_date', $card->getCreatedAt() ? $card->getCreatedAt()->format('Y-m-d H:i:s') : null);
    $cardEl->addChild('FUsage_date', $card->getFirstUsageAt() ? $card->getFirstUsageAt()->format('Y-m-d H:i:s') : null);
    $cardEl->addChild('LUsage_date', $card->getLastUsageAt() ? $card->getLastUsageAt()->format('Y-m-d H:i:s') : null);
    $cardEl->addChild('overdraft', $card->getOverdraft());
    $xml->addChild('error_code', 0);
    $xml->addChild('error_text', 'Ok');

    return $xml->asXML();
  }

  private function getErrorXml ($message, $code)
  {
    $xml = new \SimpleXMLElement('<card_stat/>');
    $xml->addChild('error_code', $code);
    $xml->addChild('error_text', $message);
    return $xml->asXML();
  }
}