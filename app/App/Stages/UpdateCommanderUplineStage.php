<?php

namespace App\App\Stages;


use App\Campaign\Jobs\UpdateCommanderUpline;
use App\Campaign\Domain\Repositories\TagRepository;


class UpdateCommanderUplineStage extends BaseStage
{
	protected $tagger;

	protected function enabled()
    {
        $this->tagger = $this->getTagger();

        return ! $this->getCommander()->parent && $this->tagger;
    }

    public function execute()
    {
        array_set($this->parameters, 'tagger', $this->tagger);

        $this->dispatch(new UpdateCommanderUpline($this->getCommander(), $this->tagger));
    }

    protected function getTagger()
    {
        $code = array_get($this->parameters, 'tag');

        return optional(app(TagRepository::class)->findByField(compact('code'))->first())->tagger;
    }
}