<?php

namespace App\App\Stages;

use App\Campaign\Jobs\UpdateCommanderStatus;

class UpdateCommanderStatusStage extends BaseStage
{
	protected $status;

	protected $reason;

	protected $percent;

    protected function enabled()
    {
    	$this->reason = array_get($this->parameters, 'reason');

        $this->status = array_get($this->parameters, 'status');

		$this->percent = array_get($this->parameters, 'percent');

		if (! empty($this->percent)) {
			$this->reason = $this->status . ' ' . $this->reason;
			$this->status = $this->percent;	

		}

    	return $this->status;
    }

    public function execute()
    {
       	UpdateCommanderStatus::dispatch($this->getCommander(), $this->status, $this->reason);
    }
}