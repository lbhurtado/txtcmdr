<?php

namespace App\App\Stages;

use App\Campaign\Domain\Repositories\TagRepository;
use App\Campaign\Jobs\UpdateCommanderAreaFromUplineTagArea;

class UpdateCommanderAreaFromUplineTagAreaStage extends BaseStage
{
	protected $area;

    protected function enabled()
    {
        $this->area = $this->getArea();

        return $this->area && ($this->area->id != optional($this->getCommander()->area)->id);
    }

    public function execute()
    {
        $this->dispatch(new UpdateCommanderAreaFromUplineTagArea($this->getCommander(), $this->area));
    }

    protected function getArea()
    {
        $code = array_get($this->parameters, 'tag');

        return optional(app(TagRepository::class)->findByField(compact('code'))->first(), function ($tag) {
            return $tag->areas()->first();
        });
    }
}