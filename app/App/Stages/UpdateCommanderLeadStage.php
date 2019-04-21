<?php

namespace App\App\Stages;

use Illuminate\Support\Arr;
use App\Campaign\Jobs\UpdateCommanderLead;

class UpdateCommanderLeadStage extends BaseStage
{
    protected $lead;

    protected function enabled()
    {
        return $this->lead = Arr::get($this->getParameters(), 'models.lead');
    }

    function execute()
    {
        $this->dispatch(new UpdateCommanderLead($this->getCommander(), $this->lead));
    }
}
