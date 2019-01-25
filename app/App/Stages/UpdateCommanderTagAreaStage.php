<?php

namespace App\App\Stages;

use App\Campaign\Jobs\UpdateCommanderTagArea;

class UpdateCommanderTagAreaStage extends BaseStage
{
	protected $area;

    protected function enabled()
    {
        return $this->area = $this->getCommander()->areas()->first();
    }

    public function execute()
    {
       	UpdateCommanderTagArea::dispatch($this->area);
    }
}