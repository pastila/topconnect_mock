<?php


namespace AppBundle\Controller\Admin;


use AppBundle\Entity\Card\Card;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CardAdminController extends CRUDController
{
  public function exportCardsAction (Request $request)
  {
    $cards = $this->getDoctrine()->getRepository('AppBundle:Card\Card')->findAll();
    
    return new StreamedResponse (function() use ($cards){
      $f = fopen('php://output', 'w+');
      fwrite($f, 'MSISDN/ICCID/LPA/PIN1/PUK1/PIN2/PUK2'. "\r\n\r\n");

      /** @var Card $card */
      foreach ($cards as $card)
      {
        fwrite($f, implode(' ', [
          $card->getMsisdn(),
          $card->getIccid(),
          $card->getLpa(),
          $card->getPin1(),
          $card->getPuk1(),
          $card->getPin2(),
          $card->getPuk2(),
        ]) . "\r\n");
      }

    }, 200 ,[
      'Content-Type' => 'text/text',
      'Content-Disposition' => 'attachment; filename="esims.qrdata"'
    ]);
  }
}