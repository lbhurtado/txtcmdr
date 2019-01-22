<?php

namespace App\App\Stages;

use League\Pipeline\StageInterface;

class NotifyHQStage implements StageInterface
{
    public function __invoke($parameters)
    {
    	\Log::info('NotifyHQStage::__invoke');
    	\Log::info($parameters);

    	return $parameters;
    }
}