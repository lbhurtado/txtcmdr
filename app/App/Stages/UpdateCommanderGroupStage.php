<?php

namespace App\App\Stages;

use App\Campaign\Jobs\UpdateCommanderGroup;

class UpdateCommanderGroupStage extends BaseStage
{
	protected $group;

    protected function enabled()
    {
        return $this->group = array_get($this->parameters, 'models.group');
    }

    public function execute()
    {
        $this->dispatch(new UpdateCommanderGroup($this->getCommander(), $this->group));
    }
}