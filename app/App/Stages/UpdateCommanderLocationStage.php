<?php

namespace App\App\Stages;

use App\Campaign\Jobs\UpdateCommanderLocation;

class UpdateCommanderLocationStage extends BaseStage
{
    protected $area;

    protected function enabled()
    {
        \Log::info('UpdateCommanderLocationStage:enabled');

        return true;
    }

    public function execute()
    {
        $this->dispatch(new UpdateCommanderLocation($this->getCommander()))->onQueue('sms');
    }
}