<?php

namespace App\App\Stages;

use Illuminate\Support\Arr;
use App\Campaign\Domain\Models\Lead;
use App\Campaign\Domain\Repositories\LeadRepository;

class SanitizeCommanderLeadStage extends BaseStage
{
    protected $lead;

    protected function enabled()
    {
        return $this->lead = $this->getSanitizedLead($this->getSanitizedInputCode());
    }

    public function execute()
    {
        $handle = $this->getSanitizedHandle();
        $area = $this->lead->area;
        $group = $this->lead->group;

        Arr::set($this->parameters, 'handle', $handle);
        Arr::set($this->parameters, 'area', $area);
        Arr::set($this->parameters, 'group', $group);
        Arr::set($this->parameters, 'models.lead', $this->lead);
    }

    protected function getSanitizedLead($input): ?Lead
    {
        return app(LeadRepository::class)->findByField('code', $input)->first();
    }

    protected function getSanitizedInputCode(): string
    {
        $input_code = trim(Arr::get($this->getParameters(), 'id'));

        return $input_code;
    }

    protected function getSanitizedHandle(): string
    {
        $handle = trim(Arr::get($this->getParameters(), 'handle')) ?? $this->lead->name;

        return $handle;
    }
}
