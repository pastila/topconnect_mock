<?php

namespace AppBundle\Service\Rate;

use AppBundle\Entity\Account\Account;

class RateBuilder
{
  private $webDir;

  public function __construct ($webDir)
  {
    $this->webDir = $webDir;
  }

  public function getRates (Account $account, $params)
  {
    $ratesId = $params['ratesid'] ? $params['ratesid'] :  null;
    $service = $params['servicetype'] ? $params['servicetype'] : null;
    $aservice = $params['aserviceid'] ? $params['aserviceid'] : null;

    if ($ratesId === null)
    {
      return file_get_contents($this->webDir . '/base.xml');
    }

    return file_get_contents($this->webDir . '/'.$service.'_'.$ratesId.'.xml');
  }
}