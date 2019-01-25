<?php

namespace App\App\Stages;

use App\Campaign\Jobs\UpdateCommanderTag;
use App\Campaign\Domain\Repositories\TagRepository;

class UpdateCommanderTagStage extends BaseStage
{
	protected $code;

    protected function enabled()
    {
    	$this->code = $this->parameters['tag'];

    	return app(TagRepository::class)->findByField('code', $this->code)->count() == 0;
    }

    public function execute()
    {
       	UpdateCommanderTag::dispatch($this->code);
    }
}