<?php

namespace App\App\Stages;

use Illuminate\Support\Arr;
use App\Missive\Domain\Repositories\ContactRepository;

class SanitizeCommanderStage extends BaseStage
{
    const ID_NDX        = 'id';
    const HANDLE_NDX    = 'name';
    const AREA_NDX      = 'area';
    const GROUP_NDX     = 'group';

    protected $input_id;

    protected function enabled()
    {
        return $this->input_id = trim(array_get($this->getParameters(), 'id'));
    }

    public function execute()
    {
        $array_record = $this->getCommanderRecordFromExcel($this->input_id) ?? $this->halt();

        $handle   = $array_record[self::HANDLE_NDX];
        $area     = $array_record[self::AREA_NDX  ];
        $group    = $array_record[self::GROUP_NDX ];

		array_set($this->parameters, 'handle', $handle ?? $this->halt());
        array_set($this->parameters, 'area', $area);
        array_set($this->parameters, 'group', $group);
    }

    protected function getCommanderRecordFromExcel($needle)
    {     
        $array = excel_range_to_array(storage_path('app/public/spreadsheet.xlsx'), [
            self::ID_NDX, self::HANDLE_NDX, self::AREA_NDX, self::GROUP_NDX
        ]);
        $key = array_search($needle, array_column($array, self::ID_NDX));

        return ($key !== false) 
                    ? $array[$key] 
                    : [];
    }
}