<?php

namespace App\App\Stages;

use App\Campaign\Jobs\UpdateCommanderUpline;

class UpdateCommanderUplineStage extends BaseStage
{
	protected function enabled()
    {
        return $this->getCommander()->upline;
    }

    public function execute()
    {
    	UpdateCommanderUpline::dispatch($this->getParameters());
    }
}