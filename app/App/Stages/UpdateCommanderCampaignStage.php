<?php

namespace App\App\Stages;

use League\Pipeline\StageInterface;

class UpdateCommanderCampaignStage implements StageInterface
{
    public function __invoke($parameters)
    {
    	\Log::info('UpdateCommanderCampaignStage::__invoke');
    	\Log::info($parameters);
    	
    	return $parameters;
    }
}