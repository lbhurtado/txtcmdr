<?php

namespace App\App\Stages;

use League\Pipeline\StageInterface;
use App\Missive\Jobs\UpdateContact;

class UpdateCommanderStage implements StageInterface
{
    public function __invoke($parameters)
    {
    	UpdateContact::dispatch($parameters);

    	return $parameters;
    }
}