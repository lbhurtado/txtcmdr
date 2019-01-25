<?php

namespace App\App\Stages;

use App\Campaign\Domain\Repositories\TagRepository;
use App\Campaign\Jobs\UpdateCommanderAreaFromUplineTagArea;

class UpdateCommanderAreaFromUplineTagAreaStage extends BaseStage
{
	protected $area;

    protected function enabled()
    {
        $code = array_get($this->parameters, 'tag');

        $this->area = app(TagRepository::class)->findByField(compact('code'))->first()->areas()->first();

        return $this->area;
    }

    public function execute()
    {
       	UpdateCommanderAreaFromUplineTagArea::dispatch($this->area);
    }
}