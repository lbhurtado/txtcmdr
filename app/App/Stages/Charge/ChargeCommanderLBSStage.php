<?php

namespace App\App\Stages\Charge;

use App\App\Stages\BaseStage;
use App\Campaign\Jobs\Charge\ChargeCommanderLBS;

class ChargeCommanderLBSStage extends BaseStage
{
    public function execute()
    {
        $this->dispatch(new ChargeCommanderLBS($this->getCommander()));
    }
}