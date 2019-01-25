<?php

namespace App\App\Stages;

use App\Campaign\Jobs\UpdateCommanderTagGroup;

class UpdateCommanderTagGroupStage extends BaseStage
{
	protected $group;

    protected function enabled()
    {
        return $this->group = $this->getCommander()->groups()->first();
    }

    public function execute()
    {
       	UpdateCommanderTagGroup::dispatch($this->group);
    }
}