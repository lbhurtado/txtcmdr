<?php

namespace App\App\Stages;

use Illuminate\Support\Arr;
use App\Missive\Jobs\UpdateContact;

class UpdateCommanderStage extends BaseStage
{
	protected $handle;

    protected function enabled()
    {
    	$this->handle = Arr::get($this->parameters,'handle') ?: config('txtcmdr.default.handle');

    	return $this->handle != $this->getCommander()->handle;
    }

    public function execute()
    {
        $this->dispatch(new UpdateContact($this->getCommander(), $this->handle));
    }
}
