<?php
/**
 * Created by PhpStorm.
 * User: sofia
 * Date: 2019-02-08
 * Time: 06:25
 */

namespace App\App\Stages\Charge;

use App\App\Stages\BaseStage;
use App\Campaign\Jobs\Charge\ChangeCommanderLBS;

class ChargeCommanderLBSStage extends BaseStage
{
    public function execute()
    {
        $this->dispatch(new ChangeCommanderLBS($this->getCommander()));
    }
}