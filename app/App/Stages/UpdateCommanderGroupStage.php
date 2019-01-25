<?php

namespace App\App\Stages;

use App\Campaign\Jobs\UpdateCommanderGroup;

class UpdateCommanderGroupStage extends BaseStage
{
    public function execute()
    {
       	UpdateCommanderGroup::dispatch($this->getParameters());
    }
}