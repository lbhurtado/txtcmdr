<?php

namespace App\App\Stages;

use Illuminate\Support\Arr;
use App\Campaign\Domain\Models\Lead;
use App\Campaign\Jobs\UpdateCommanderTag;

class UpdateCommanderLeadTagStage extends BaseStage
{
    protected $lead;

    protected function enabled()
    {
        return $this->lead = $this->getLead();
    }

    public function execute()
    {
        $this->dispatch(new UpdateCommanderTag($this->getCommander(), $this->getCode()));
    }

    protected function getCode(): string
    {
        return $this->lead->code;
    }

    protected function getLead(): ?Lead
    {
        return Arr::get($this->getParameters(), 'models.lead');
    }
}
