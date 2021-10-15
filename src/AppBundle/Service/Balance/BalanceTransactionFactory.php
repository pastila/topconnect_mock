<?php


namespace AppBundle\Service\Balance;


use Accurateweb\SettingBundle\Model\Manager\SettingManagerInterface;
use AppBundle\Entity\Account\Account;
use AppBundle\Entity\Card\Card;
use AppBundle\Entity\Transaction\Transaction;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BalanceTransactionFactory
{
  private $entityManager;
  private $settingManager;

  public function __construct (
    EntityManagerInterface $entityManager,
    SettingManagerInterface $settingManager
  )
  {
    $this->entityManager = $entityManager;
    $this->settingManager = $settingManager;
  }

  public function makeTransaction (Account $account, $params)
  {
    if (!preg_match('/\d+\.\d{2}/', $params['amount'])
      && !preg_match('/\d+/', $params['amount']))
    {
      return $this->getErrorXml('Amount format is incorrect');
    }
    
    $amount = (float)$params['amount'];
    $curr = (string)$params['curr'];
    $orderId = (int)$params['orderid'];
    $onum = (string)$params['onum'];

    $lastOrderId = (int)$this->entityManager->getRepository('AppBundle:Transaction\Transaction')
      ->createQueryBuilder('t')
      ->join('t.card', 'c')
      ->where('c.account = :account')
      ->setParameter('account', $account)
      ->select('MAX(t.orderId)')
      ->setMaxResults(1)
      ->getQuery()
      ->getSingleScalarResult();

    if (($lastOrderId + 1) !== $orderId)
    {
      return $this->getErrorXml('Incorrect OrderID value, must be: ' . ($lastOrderId + 1));
    }

    /** @var Card $card */
    $card = $this->entityManager->getRepository('AppBundle:Card\Card')->findOneBy(['msisdn' => $onum]);

    if ($card === null)
    {
      return $this->getErrorXml('Not found');
    }

    if ($account->getBalance() < $amount)
    {
      return $this->getErrorXml('Debit balance limit exceeded');
    }

    $transaction = new Transaction();
    $transaction->setOrderId($orderId);
    $transaction->setCard($card);
    $transaction->setCurrency($curr);
    $transaction->setAmount($amount);
    $transaction->setAvailableAmount('Available amount');
    $account->setBalance($account->getBalance() - $amount);
    $card->setBalance($card->getBalance() + $amount);
    $card->setLastUsageAt(new \DateTime());
    $this->entityManager->persist($transaction);
    $this->entityManager->persist($card);
    $this->entityManager->persist($account);
    $this->entityManager->flush();

    $xml = new \SimpleXMLElement('<sbalance/>');
    $xml->addChild('aserviceid', $card->getService() ? $card->getService()->getId() : null);
    $xml->addChild('inum', $card->getINum());
    $xml->addChild('onum', $card->getMsisdn());
    $xml->addChild('amount', sprintf('%s %s', $transaction->getAmount() > 0 ? '+'.$transaction->getAmount() : $transaction->getAmount(), $transaction->getCurrency()));
    $xml->addChild('orderid', $orderId);
    $xml->addChild('av_amount', $transaction->getAvailableAmount());
    $cardXml = $xml->addChild('card');
    $cardXml->addChild('balance', sprintf('%s %s', $card->getBalance(), $card->getCurrency()));
    $cardXml->addChild('amount', sprintf('%s %s', $amount > 0 ? '+'.$amount : $amount, $card->getCurrency()));
    $clientXml = $xml->addChild('client');
    $clientXml->addChild('balance', sprintf('%s %s', $account->getBalance(), $account->getCurrency()));
    $cardAmount = $amount * -1;
    $clientXml->addChild('amount', sprintf('%s %s', $cardAmount > 0 ? '+'.$cardAmount : $cardAmount, $account->getCurrency()));

    return $xml->asXML();
  }

  private function getErrorXml ($message)
  {
    $xml = new \SimpleXMLElement('<sbalance/>');
    $xml->addChild('type', 'ERROR');
    $xml->addChild('text', $message);
    return $xml->asXML();
  }

}