<?php

namespace App\App\Stages;

use App\Campaign\Jobs\UpdateCommanderUpline;

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
        return optional(array_get($this->parameters, 'models.tag'))->tagger;
    }
}
