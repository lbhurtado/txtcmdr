<?php

namespace App\App\Stages;

use App\Missive\Jobs\UpdateContact;

class UpdateCommanderStage extends BaseStage
{
	protected $handle;

    protected function enabled()
    {
    	$this->handle = array_get($this->parameters,'handle');

    	return $this->handle != $this->getCommander()->handle;
    }

    public function execute()
    {
        $this->dispatch(new UpdateContact($this->getCommander(), $this->handle));
    }
}