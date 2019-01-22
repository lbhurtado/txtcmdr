<?php

namespace App\App\Stages;

use League\Pipeline\StageInterface;
use App\Missive\Jobs\UpdateContact;

class UpdateContactStage implements StageInterface
{
    public function __invoke($attributes)
    {
    	UpdateContact::dispatch($attributes);
    }
}