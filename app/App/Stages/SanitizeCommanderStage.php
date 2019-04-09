<?php

namespace App\App\Stages;

use Illuminate\Support\Arr;
use App\Missive\Domain\Repositories\ContactRepository;

class SanitizeCommanderStage extends BaseStage
{
    const ID_NDX        = 'ID';
    const HANDLE_NDX    = 'NAME';
    const AREA_NDX      = 'AREA';
    const GROUP_NDX     = 'GROUP';

    protected $input_id;

    protected $handle;

    protected function enabled()
    {
        $this->handle = trim(array_get($this->getParameters(), 'handle', null));
        return $this->input_id = trim(array_get($this->getParameters(), 'id'));
    }

    public function execute()
    {
        $array_record = excel_lookup($this->input_id);

        $handle   = $this->handle ?? $array_record[self::HANDLE_NDX];
        $area     = $array_record[self::AREA_NDX  ];
        $group    = $array_record[self::GROUP_NDX ];

		array_set($this->parameters, 'handle', $handle ?? $this->halt());
        array_set($this->parameters, 'area', $area);
        array_set($this->parameters, 'group', $group);
    }
}