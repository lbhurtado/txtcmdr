<?php

namespace App\App\Stages;

use App\Campaign\Jobs\UpdateCommanderUnTagArea;

class UpdateCommanderUnTagAreaStage extends BaseStage
{
    public function execute()
    {
        $this->dispatch(new UpdateCommanderUnTagArea($this->getCommander()));
    }
}
