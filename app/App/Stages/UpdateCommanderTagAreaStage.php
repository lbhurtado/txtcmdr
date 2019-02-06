<?php

namespace App\App\Stages;

use App\Campaign\Jobs\UpdateCommanderTagArea;

class UpdateCommanderTagAreaStage extends BaseStage
{
	protected $area;

    protected function enabled()
    {
        $this->area = $this->getCommander()->areas()->first();

        return $this->area;
    }

    public function execute()
    {
        $this->dispatch(new UpdateCommanderTagArea($this->getCommander(), $this->area));
    }
}