<?php

namespace App\App\Stages;

use App\Campaign\Jobs\UpdateCommanderTagArea;
use App\Campaign\Domain\Repositories\AreaRepository;

class UpdateCommanderTagAreaStage extends BaseStage
{
	protected $area;

    protected function enabled()
    {
        return  $this->area = $this->getArea();
    }

    public function execute()
    {
        $this->dispatch(new UpdateCommanderTagArea($this->getCommander(), $this->area));
    }

    protected function getArea()
    {
        return $this->getAreaFromParameters() ?? $this->getAreaFromCommander();
    }

    protected function getAreaFromParameters()
    {
        return $this->area = app(AreaRepository::class)
            ->findByField([
                'name' => array_get($this->parameters, 'area')
            ])->first();
    }

    protected function getAreaFromCommander()
    {
        return $this->getCommander()->areas()->first();
    }
}