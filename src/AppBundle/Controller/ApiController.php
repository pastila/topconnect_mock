<?php

namespace AppBundle\Controller;

use AppBundle\Service\Package\DataPackageService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends Controller
{
  /**
   * @Route(name="cards", path="tsim_xml/service/xmlgate")
   * @param Request $request
   */
  public function apiAction (Request $request)
  {
    $form = $this->createForm('AppBundle\Form\ApiRequestType', null, [
      'csrf_protection' => false,
      'allow_extra_fields' => true,
    ]);

    $form->submit($request->query->all());

    if ($form->isSubmitted() && $form->isValid())
    {
      $command = $form->get('command')->getData();
      $login = $form->get('uname')->getData();
      $pass = $form->get('upass')->getData();
      $account = $this->getDoctrine()->getRepository('AppBundle:Account\Account')->findOneBy(['apiLogin' => $login, 'apiPassword' => $pass]);

      if ($account === null)
      {
        $xml = new \SimpleXMLElement('<error/>');
        $xml->addChild('type', 'ERROR');
        $xml->addChild('text', 'Invalid login and/or password from ' . $_SERVER['REMOTE_ADDR']);

        return new Response($xml->asXml(), 200, [
          'Content-Type' => 'text/xml',
        ]);
      }

      $result = '';
      $qData = $request->query->all();

      try
      {
        switch ($command)
        {
          case 'gbalance':
            $result = $this->get('AppBundle\Service\Card\CardListBuilder')->buildList($account, $qData);
            break;
          case 'card_stat':
            $result = $this->get('AppBundle\Service\Card\CardInfoListBuilder')->buildList($account, $qData);
            break;
          case 'sbalance':
            if (isset($qData['started']) && isset($qData['finished']))
            {
              $result = $this->get('AppBundle\Service\Balance\TransactionHistoryBuilder')->getHistory($account, $qData);
            }
            else
            {
              $result = $this->get('AppBundle\Service\Balance\BalanceTransactionFactory')->makeTransaction($account, $qData);
            }
            break;
          case 'sblock':
            $result = $this->get('AppBundle\Service\Card\CardBlocker')->blockCard($account, $qData);
            break;
          case 'account':
            $result = $this->get('AppBundle\Service\Account\AccountInfoBuilder')->buildInfo($account);
            break;
          case 'gccdr':
            $result = $this->get('AppBundle\Service\CallRecord\RecordListBuilder')->getRecordList($account, $qData);
            break;
          case 'getrates':
            $result = $this->get('AppBundle\Service\Rate\RateBuilder')->getRates($account, $qData);
            break;
          case 'getserviceoptions':
            $result = $this->get('AppBundle\Service\Rate\RateBuilder')->getServiceOptions($account, $qData);
            break;
          case 'gprscdr':
            $result = $this->get('AppBundle\Service\CallRecord\RecordListBuilder')->getDataRecordList($account, $qData);
            break;
//          case 'nav3':
//            $result = $this->get(DataPackageService::class)->activatePackage($account, $qData);
//            break;
//          case 'navstat3':
//            $result = $this->get(DataPackageService::class)->getPackageList($account, $qData);
//            break;
//          case 'navcdr3':
//            $result = $this->get(DataPackageService::class)->getPackageListHistory($account, $qData);
//            break;
          case 'discount':
            if (isset($qData['packettype']))
            {
              $result = $this->get(DataPackageService::class)->activatePackage($account, $qData);
              break;
            }
            elseif (isset($qData['started']))
            {
              $result = $this->get(DataPackageService::class)->getPackageListHistory($account, $qData);
              break;
            }
            else
            {
              $result = $this->get(DataPackageService::class)->getPackageList($account, $qData);
            }
            break;
          case 'discountm':
            $result = $this->get(DataPackageService::class)->getPackageMList($account, $qData);
            break;
        }
      }
      catch (\Exception $e)
      {
        $xml = new \SimpleXMLElement('<error/>');
        $xml->addChild('type', 'ERROR');
        $xml->addChild('text', $e->getMessage());
        $result = $xml->asXML();
      }

      return new Response($result, 200, [
        'Content-Type' => 'text/xml',
      ]);
    }

    $xml = new \SimpleXMLElement('<error/>');
    $xml->addChild('type', 'ERROR');
    $xml->addChild('text', 'Invalid login and/or password from ' . $_SERVER['REMOTE_ADDR']);

    return new Response($xml->asXml(), 200, [
      'Content-Type' => 'text/xml',
    ]);
  }
}