<?php

namespace App\App\Stages;

use App\Campaign\Domain\Models\Tag;
use App\Campaign\Jobs\UpdateCommanderTagArea;
use App\Campaign\Domain\Repositories\TagRepository;
use App\Campaign\Domain\Repositories\AreaRepository;

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
        return app(AreaRepository::class)
            ->findByField([
                'name' => array_get($this->parameters, 'area')
            ])->first();
    }

    protected function getAreaFromCommander()
    {
        return $this->getCommander()->areas()->first();
    }

    protected function existsCommanderTag()
    {
//        $command = array_get($this->getParameters(), 'command');
//        return \DB::table('tags')->where('tagger_id', $this->getCommander()->id)->first();
        return app(TagRepository::class)
            ->findByField(
                'contact_id', $this->getCommander()->id
            )->first() ?? array_get($this->getParameters(), 'command') == 'TAG';
    }
}
