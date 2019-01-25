<?php

namespace App\App\Stages;

use App\Campaign\Jobs\UpdateCommanderTagCampaign;

class UpdateCommanderTagCampaignStage extends BaseStage
{
    public function execute()
    {
       	UpdateCommanderTagCampaign::dispatch($this->getParameters());
    }
}