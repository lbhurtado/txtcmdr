<?php

namespace App\App\Stages;

use App\Campaign\Jobs\UpdateContactGroup;

class UpdateContactGroupStage extends BaseStage
{
    public function execute()
    {
       	UpdateContactGroup::dispatch($this->getParameters());
    }
}