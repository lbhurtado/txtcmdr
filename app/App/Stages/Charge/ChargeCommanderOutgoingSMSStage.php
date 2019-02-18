<?php

namespace App\App\Stages\Charge;

use App\App\Stages\BaseStage;
use App\Campaign\Jobs\Charge\ChargeCommanderOutgoingSMS;

class ChargeCommanderOutgoingSMSStage extends BaseStage
{
    public function execute()
    {
        $this->dispatch(new ChargeCommanderOutgoingSMS($this->getCommander()));
    }
}
