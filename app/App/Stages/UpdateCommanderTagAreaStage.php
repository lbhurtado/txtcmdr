<?php

namespace App\App\Stages;

use App\Campaign\Jobs\UpdateCommanderTagArea;

class UpdateCommanderTagAreaStage extends BaseStage
{
	protected $area;

    protected function enabled()
    {
        $this->area = $this->getCommander()->areas()->first();

        return $this->area && $this->getCommander()->tags()->count();
    }

    public function execute()
    {
       	UpdateCommanderTagArea::dispatch($this->area);
    }
}