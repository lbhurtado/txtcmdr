<?php

namespace App\App\Stages;

use League\Pipeline\StageInterface;

class UpdateCommanderTagStage implements StageInterface
{
    public function __invoke($parameters)
    {
    	\Log::info('UpdateCommanderTagStage::__invoke');
    	\Log::info($parameters);
    	
    	return $parameters;
    }
}