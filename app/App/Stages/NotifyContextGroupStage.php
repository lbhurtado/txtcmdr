<?php

namespace App\App\Stages;

use League\Pipeline\StageInterface;

class NotifyContextGroupStage implements StageInterface
{
    public function __invoke($parameters)
    {
    	\Log::info('NotifyContextAreaStage::__invoke');
    	\Log::info($parameters);
    	
    	return $parameters;
    }
}