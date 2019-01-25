<?php

namespace App\App\Stages;

use App\Missive\Jobs\UpdateContact;

class UpdateCommanderStage extends BaseStage
{
	protected $name;

    protected function enabled()
    {
    	$this->name = array_get($this->parameters,'name');

    	return optional($this->getCommander(), function ($commander) {
    		return $commander->name != $this->name;  
    	});
    }

    public function execute()
    {
    	UpdateContact::dispatch($this->getCommander(), $this->name);
    }
}