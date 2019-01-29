<?php

namespace App\App\Stages;

use App\Campaign\Jobs\UpdateCommanderArea;
use App\Campaign\Domain\Repositories\AreaRepository;

class UpdateCommanderAreaStage extends BaseStage
{
	protected $area;

    protected function enabled()
    {
    	$name = $this->parameters['area'];

        return $this->area = app(AreaRepository::class)->findByField(compact('name'))->first();
    }

    public function execute()
    {
       	UpdateCommanderArea::dispatch($this->getCommander(), $this->area);
    }
}