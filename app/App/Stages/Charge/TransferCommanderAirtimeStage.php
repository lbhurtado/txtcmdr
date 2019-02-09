<?php

namespace App\App\Stages\Charge;

use App\App\Stages\BaseStage;
use App\Charging\Jobs\TransferCommanderAirtime;

class TransferCommanderAirtimeStage extends BaseStage
{
    public function execute()
    {
        $this->dispatch(new TransferCommanderAirtime($this->getCommander()));
    }
}
