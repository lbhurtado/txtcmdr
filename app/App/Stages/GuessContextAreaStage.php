<?php

namespace App\App\Stages;

use League\Pipeline\StageInterface;

class GuessContextAreaStage implements StageInterface
{
    public function __invoke($parameters)
    {
    	\Log::info('GuessContextAreaStage::__invoke');
    	\Log::info($parameters);
    	
    	return $parameters;
    }
}