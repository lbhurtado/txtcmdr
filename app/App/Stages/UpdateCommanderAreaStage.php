<?php

namespace App\App\Stages;

use App\Campaign\Jobs\UpdateCommanderArea;
use App\Campaign\Domain\Repositories\AreaRepository;

class UpdateCommanderAreaStage extends BaseStage
{
	protected $area;

    protected function enabled()
    {
        return $this->area = app(AreaRepository::class)->findByField('name', $this->parameters['area'])->first();
    }

    public function execute()
    {
       	UpdateCommanderArea::dispatch($this->area);
    }
}