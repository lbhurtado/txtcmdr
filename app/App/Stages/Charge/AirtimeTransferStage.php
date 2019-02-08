<?php

namespace App\App\Stages\Charge;

use App\App\Stages\BaseStage;
use App\Charging\Jobs\AirtimeTransfer;

class AirtimeTransferStage extends BaseStage
{
    public function execute()
    {
        $this->dispatch(new AirtimeTransfer('639081877788'));
    }
}