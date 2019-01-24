<?php

namespace App\App\Stages;

use App\Campaign\Jobs\UpdateCommanderCampaign;

class UpdateCommanderCampaignStage extends BaseStage
{
    public function execute()
    {
       	UpdateCommanderCampaign::dispatch($this->getParameters());
    }
}