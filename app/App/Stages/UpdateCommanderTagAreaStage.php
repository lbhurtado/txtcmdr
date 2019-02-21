<?php

namespace App\App\Stages;

use App\Campaign\Jobs\UpdateCommanderTagArea;
use App\Campaign\Domain\Repositories\TagRepository;

class UpdateCommanderTagAreaStage extends BaseStage
{
	protected $area;

    protected function enabled()
    {
        $this->area = $this->getArea();

        return $this->existsCommanderTag() && $this->area;
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
        return array_get($this->parameters, 'models.area');
    }

    protected function getAreaFromCommander()
    {
        return $this->getCommander()->areas()->first();
    }

    protected function existsCommanderTag()
    {
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
