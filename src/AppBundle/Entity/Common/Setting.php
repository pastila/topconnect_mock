<?php


namespace AppBundle\Entity\Common;

use Accurateweb\SettingBundle\Model\Entity\Setting as BaseSetting;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="settings", options={"charset"="utf8", "collate"="utf8_general_ci"})
 * @ORM\Entity()
 */
class Setting extends BaseSetting
{

}