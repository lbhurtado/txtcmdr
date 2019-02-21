<?php

namespace App\App\Stages;

use App\Campaign\Jobs\UpdateCommanderGroupFromUplineTagGroup;

class UpdateCommanderGroupFromUplineTagGroupStage extends BaseStage
{
	protected $group;

    protected function enabled()
    {
        $this->group = $this->getGroup();

        return $this->group && ($this->group->id != optional($this->getCommander()->group)->id);
    }

    public function execute()
    {
        $this->dispatch(new UpdateCommanderGroupFromUplineTagGroup($this->getCommander(), $this->group));
    }

    protected function getGroup()
    {
        return optional(array_get($this->parameters, 'models.tag'), function ($tag) {

            return $tag->groups()->first();
        });
    }
}