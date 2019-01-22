<?php

namespace App\App\Stages;

use League\Pipeline\StageInterface;
use App\Campaign\Jobs\UpdateContactGroup;

class UpdateContactGroupStage implements StageInterface
{
    public function __invoke($parameters)
    {
    	\Log::info('UpdateContactGroupStage::__invoke');
    	\Log::info($parameters);
    	
    	UpdateContactGroup::dispatch($parameters);
    	
    	return $parameters;
    }
}