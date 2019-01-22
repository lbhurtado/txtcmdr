<?php

namespace App\App\Stages;

use League\Pipeline\StageInterface;

class UpdateContactAreaStage implements StageInterface
{
    public function __invoke($parameters)
    {
    	\Log::info('UpdateContactAreaStage::__invoke');
    	\Log::info($parameters);
    	
    	return $parameters;
    }
}