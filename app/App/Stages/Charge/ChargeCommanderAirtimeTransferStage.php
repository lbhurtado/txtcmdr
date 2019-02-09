<?php

namespace App\App\Stages\Charge;

use App\App\Stages\BaseStage;
use App\Campaign\Jobs\Charge\ChargeCommanderAirtimeTransfer;

class ChargeCommanderAirtimeTransferStage extends BaseStage
{
    public function execute()
    {
        $this->dispatch(new ChargeCommanderAirtimeTransfer($this->getCommander()));
    }
}
