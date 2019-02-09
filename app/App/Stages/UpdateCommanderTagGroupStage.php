<?php

namespace App\App\Stages;

use App\Campaign\Jobs\UpdateCommanderTagGroup;
use App\Campaign\Domain\Repositories\TagRepository;
use App\Campaign\Domain\Repositories\GroupRepository;

class UpdateCommanderTagGroupStage extends BaseStage
{
	protected $group;

    protected function enabled()
    {
        $this->group = $this->getGroup();

        return $this->existsCommanderTag() && $this->group;
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

    protected function existsCommanderTag()
    {
        dd( $this->isCommandTag());
        return $this->isCommanderTagPersisted() ?? $this->isCommandTag();
    }

    protected function isCommanderTagPersisted()
    {
        $contact_id = $this->getCommander()->id;

        return app(TagRepository::class)->findByField(compact('contact_id'))->first();
    }

    protected function isCommandTag()
    {
        return strtoupper(array_get($this->getParameters(), 'command')) == 'TAG';
    }
}
