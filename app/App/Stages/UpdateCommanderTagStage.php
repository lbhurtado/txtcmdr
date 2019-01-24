<?php

namespace App\App\Stages;

use App\Campaign\Jobs\UpdateCommanderTag;

class UpdateCommanderTagStage extends BaseStage
{
    public function execute()
    {
       	UpdateCommanderTag::dispatch($this->getParameters());
    }
}