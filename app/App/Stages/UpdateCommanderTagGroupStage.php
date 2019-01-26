<?php

namespace App\App\Stages;

use App\Campaign\Jobs\UpdateCommanderTagGroup;

class UpdateCommanderTagGroupStage extends BaseStage
{
	protected $group;

    protected function enabled()
    {
    	$this->group = $this->getCommander()->groups()->first();

        return $this->group && $this->getCommander()->tags()->count();
    }

    public function execute()
    {
       	UpdateCommanderTagGroup::dispatch($this->group);
    }
}