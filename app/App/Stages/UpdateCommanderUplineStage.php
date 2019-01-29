<?php

namespace App\App\Stages;

use App\Campaign\Jobs\UpdateCommanderUpline;
use App\Campaign\Domain\Repositories\TagRepository;

class UpdateCommanderUplineStage extends BaseStage
{
	protected $tagger;

	protected function enabled()
    {
    	$code = array_get($this->parameters, 'tag');

    	$this->tagger = app(TagRepository::class)->findByField(compact('code'))->first()->tagger;

        return $this->tagger && ! $this->getCommander()->upline;
    }

    public function execute()
    {
    	UpdateCommanderUpline::dispatch($this->getCommander(), $this->tagger);
    }
}