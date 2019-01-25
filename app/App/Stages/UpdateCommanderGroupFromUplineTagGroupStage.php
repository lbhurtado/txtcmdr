<?php

namespace App\App\Stages;

use App\Campaign\Domain\Repositories\TagRepository;
use App\Campaign\Jobs\UpdateCommanderGroupFromUplineTagGroup;

class UpdateCommanderGroupFromUplineTagGroupStage extends BaseStage
{
	protected $group;

    protected function enabled()
    {
        $code = array_get($this->parameters, 'tag');

        $this->group = app(TagRepository::class)->findByField(compact('code'))->first()->groups()->first();

        return $this->group;
    }

    public function execute()
    {
       	UpdateCommanderGroupFromUplineTagGroup::dispatch($this->group);
    }
}