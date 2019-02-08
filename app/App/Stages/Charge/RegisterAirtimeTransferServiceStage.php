<?php

namespace App\App\Stages\Charge;

use App\App\Stages\BaseStage;
use App\Charging\Jobs\RegisterAirtimeTransferService;

class RegisterAirtimeTransferServiceStage extends BaseStage
{
    protected function enabled()
    {
        return empty($this->getCommander()->telerivetId);
    }

    public function execute()
    {
        $this->dispatch(new RegisterAirtimeTransferService($this->getCommander()));
    }
}