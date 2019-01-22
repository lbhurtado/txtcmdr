<?php

namespace App\App\Stages;

use League\Pipeline\StageInterface;

class UpdateContactGroupStage implements StageInterface
{
    public function __invoke($parameters)
    {
    	\Log::info('UpdateContactGroupStage::__invoke');
    	\Log::info($parameters);
    	
    	return $parameters;
    }
}