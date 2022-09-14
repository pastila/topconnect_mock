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
    $service = $params['servicetype'];

    if ($service === 'gprs')
    {
      return file_get_contents($this->webDir . '/gprs.xml');
    }

    return file_get_contents($this->webDir . '/voice.xml');
  }
}