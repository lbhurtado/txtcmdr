<?php

namespace App\App\Stages;

use Illuminate\Support\Arr;
use App\Campaign\Domain\Repositories\LeadRepository;

class SanitizeCommanderStage extends BaseStage
{
    const ID_NDX        = 'ID';
    const HANDLE_NDX    = 'NAME';
    const AREA_NDX      = 'AREA';
    const GROUP_NDX     = 'GROUP';

    protected $input_id;

    protected $handle;

    protected $lead;

    protected function enabled()
    {

        $input_code = trim(Arr::get($this->getParameters(), 'id'));

        return $this->lead = $this->getSanitizedLead($input_code);
    }

    public function execute()
    {
        $handle = trim(Arr::get($this->getParameters(), 'handle')) ?? $this->lead->name;
        $area = $this->lead->area;
        $group = $this->lead->group;

        Arr::set($this->parameters, 'handle', $handle);
        Arr::set($this->parameters, 'area', $area);
        Arr::set($this->parameters, 'group', $group);
        Arr::set($this->parameters, 'models.lead', $this->lead);
    }

    protected function getSanitizedLead($input)
    {
        return app(LeadRepository::class)->findByField('code', $input)->first();
    }
}
