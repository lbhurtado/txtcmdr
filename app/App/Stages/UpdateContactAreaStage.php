<?php

namespace App\App\Stages;

use App\Campaign\Jobs\UpdateContactArea;

class UpdateContactAreaStage extends BaseStage
{
    public function execute()
    {
       	UpdateContactArea::dispatch($this->getParameters());
    }
}