<?php

namespace App\App\Stages;

use App\Campaign\Domain\Classes\InfoKey;

class LoadInfoKeyValueStage extends BaseStage
{
	protected function enabled()
    {
    	return $this->getCommander() != null;
    }

    public function execute()
    {
    	\Log::info('here');

    	switch (strtoupper(array_get($this->parameters, 'keyword'))) {
    		case 'AREA':
    			array_set($this->getCommander()->extra_attributes, 'payload', ['AREA' => 'Philam']);
    			break;
    		
    		default:
    			array_set($this->getCommander()->extra_attributes, 'payload', ['AREA' => 'Somewhere']);
    			break;
    	}

    	$this->getCommander()->save();
    }
}