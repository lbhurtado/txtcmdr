<?php

namespace App\App\Stages;

use League\Pipeline\StageInterface;

class OnboardCommanderStage implements StageInterface
{
    public function __invoke($parameters)
    {
    	\Log::info('OnboardCommanderStage::__invoke');
    	\Log::info($parameters);

    	return $parameters;
    }
}