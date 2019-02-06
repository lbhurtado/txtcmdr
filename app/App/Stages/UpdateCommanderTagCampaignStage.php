<?php

namespace App\App\Stages;

use App\Campaign\Jobs\UpdateCommanderTagCampaign;
use App\Campaign\Domain\Repositories\CampaignRepository;

class UpdateCommanderTagCampaignStage extends BaseStage
{
    protected $defaultCampaign = 'default';

	protected $campaign;

    protected function enabled()
    {
        return $this->campaign = $this->getCampaign();
    }

    public function execute()
    {
        $this->dispatch(new UpdateCommanderTagCampaign($this->getCommander(), $this->campaign));
    }

    public function getCampaign()
    {
    	$name = ! empty($name = trim(array_get($this->parameters, 'campaign')))
            ? $name
            : $this->defaultCampaign
        ;

    	return app(CampaignRepository::class)->findByField(compact('name'))->first();
    }
}