<?php

namespace App\App\Stages;

use App\Campaign\Domain\Repositories\CampaignRepository;

class UpdateCommanderCampaignParametersStage extends BaseStage
{
    protected $campaign;

    protected function enabled()
    {
        return $this->campaign = $this->getCommanderUplineTagCampaign();
    }

    public function execute()
    {
        array_set($this->parameters, 'campaign', $this->getCommanderUplineTagCampaign()->name);
    }

    protected function getCommanderUplineTagCampaign()
    {
        return optional($this->getCommander()->upline, function ($upline) {
            return $upline->tags()->first()->campaigns()->first();
        });
    }
}