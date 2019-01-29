<?php

namespace App\App\Stages;

use App\Campaign\Jobs\UpdateCommanderAttribute;

class UpdateCommanderAttributeStage extends BaseStage
{
	protected $key;

	protected $value;

    protected function enabled()
    {
    	$this->key = array_get($this->parameters, 'key');

        $this->value = array_get($this->parameters, 'value');

    	return $this->key && $this->value;
    }

    public function execute()
    {
       	UpdateCommanderAttribute::dispatch($this->getCommander(), $this->key, $this->value);
    }
}