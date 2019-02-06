<?php

namespace App\App\Stages;

use App\Campaign\Jobs\UpdateCommanderTagGroup;
use App\Campaign\Domain\Repositories\GroupRepository;

class UpdateCommanderTagGroupStage extends BaseStage
{
	protected $group;

    protected function enabled()
    {
        return $this->group = $this->getGroup();
    }

    public function execute()
    {
        $this->dispatch(new UpdateCommanderTagGroup($this->getCommander(), $this->group));
    }

    protected function getGroup()
    {
        return $this->getGroupFromParameters() ?? $this->getGroupFromCommander();
    }

    protected function getGroupFromParameters()
    {
        return app(GroupRepository::class)
            ->findByField([
                'name' => array_get($this->parameters, 'group')
            ])->first();
    }

    protected function getGroupFromCommander()
    {
        return $this->getCommander()->groups()->first();
    }
}
