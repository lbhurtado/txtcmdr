<?php

namespace App\App\Stages;

use App\Campaign\Jobs\UpdateCommanderTagCampaign;
use App\Campaign\Domain\Repositories\CampaignRepository;

class UpdateCommanderTagCampaignStage extends BaseStage
{
	protected $campaign;

    protected function enabled()
    {
        return $this->campaign = app(CampaignRepository::class)->findByField('name', $this->parameters['campaign'])->first();
    }

    public function execute()
    {
       	UpdateCommanderTagCampaign::dispatch($this->campaign);
    }
}