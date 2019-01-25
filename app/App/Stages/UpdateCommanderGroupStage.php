<?php

namespace App\App\Stages;

use App\Campaign\Jobs\UpdateCommanderGroup;
use App\Campaign\Domain\Repositories\GroupRepository;

class UpdateCommanderGroupStage extends BaseStage
{
	protected $group;

    protected function enabled()
    {
        return $this->group = app(GroupRepository::class)->findByField('name', $this->parameters['group'])->first();
    }

    public function execute()
    {
       	UpdateCommanderGroup::dispatch($this->group);
    }
}