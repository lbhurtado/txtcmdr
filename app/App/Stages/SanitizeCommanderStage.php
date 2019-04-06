<?php

namespace App\App\Stages;

use Illuminate\Support\Arr;
use App\Missive\Domain\Repositories\ContactRepository;

class SanitizeCommanderStage extends BaseStage
{
    const HANDLE_NDX    = 1;
    const AREA_NDX      = 2;
    const GROUP_NDX     = 3;

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
        $group    = Arr::get($array_record, self::GROUP_NDX, 'HQ');
        $group    = 'HQ';

        //TODO: combine the next 3 lines to something like the 4th line
		array_set($this->parameters, 'handle', $handle ?? $this->halt());
        array_set($this->parameters, 'area', $area);
        array_set($this->parameters, 'group', $group);
    }

    protected function getCommanderRecordFromExcel($needle)
    {     
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load("volunteers.xlsx");
        
        $worksheet = $spreadsheet->getActiveSheet();
        $highestRow = $worksheet->getHighestRow();
        $highestColumn = $worksheet->getHighestColumn();
        $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn); // e.g. 5

        $array = $worksheet->rangeToArray("A2:{$highestColumn}{$highestColumnIndex}");

        $key = array_search($needle, array_column($array, 0));

        return ($key !== false) 
                    ? $array[$key] 
                    : [];
    }
}