<?php

namespace App\App\Stages;

use App\Campaign\Jobs\UpdateCommanderArea;

class UpdateCommanderAreaStage extends BaseStage
{
    public function execute()
    {
       	UpdateCommanderArea::dispatch($this->getParameters());
    }
}