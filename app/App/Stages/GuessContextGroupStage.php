<?php

namespace App\App\Stages;

use League\Pipeline\StageInterface;

class GuessContextGroupStage implements StageInterface
{
    public function __invoke($parameters)
    {
    	\Log::info('GuessContextGroupStage::__invoke');
    	\Log::info($parameters);
    	
    	return $parameters;
    }
}