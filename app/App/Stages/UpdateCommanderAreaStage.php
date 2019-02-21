<?php

namespace App\App\Stages;

use App\Campaign\Jobs\UpdateCommanderArea;

class UpdateCommanderAreaStage extends BaseStage
{
	protected $area;

    protected function enabled()
    {
        return $this->area = array_get($this->parameters, 'models.area');
    }

    public function execute()
    {
        $this->dispatch(new UpdateCommanderArea($this->getCommander(), $this->area));
    }
}