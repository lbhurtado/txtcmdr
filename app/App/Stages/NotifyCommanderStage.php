<?php

namespace App\App\Stages;

use League\Pipeline\StageInterface;

class NotifyCommanderStage implements StageInterface
{
    public function __invoke($parameters)
    {
    	\Log::info('NotifyCommanderStage::__invoke');
    	\Log::info($parameters);

    	return $parameters;
    }
}