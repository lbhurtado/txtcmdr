<?php

namespace App\App\Stages;

use League\Pipeline\StageInterface;

class NotifyUplineStage implements StageInterface
{
    public function __invoke($parameters)
    {
    	\Log::info('NotifyUplineStage::__invoke');
    	\Log::info($parameters);

    	return $parameters;
    }
}