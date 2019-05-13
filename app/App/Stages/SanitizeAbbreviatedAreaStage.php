<?php

namespace App\App\Stages;

use Illuminate\Support\Arr;
use App\Campaign\Domain\Models\Area;
use App\Campaign\Domain\Repositories\AreaRepository;

class SanitizeAbbreviatedAreaStage extends BaseStage
{
    protected $input_abbr;

    protected function enabled()
    {
        return $this->input_abbr = trim(Arr::get($this->getParameters(), 'abbr'));
    }

    public function execute()
    {
        $area = $this->getAreaFromAbbreviation() ?? $this->halt();
        $sanitized_area = $area->name;

        //TODO: combine the next 3 lines to something like the 4th line
        Arr::set($this->parameters, 'area', $sanitized_area);
        Arr::set($this->parameters, 'context', $sanitized_area);
        Arr::set($this->parameters, 'field', 'area');

        Arr::set($this->parameters, 'models.area', $area);
    }

    protected function getAreaFromAbbreviation()
    {
        switch ($this->input_abbr[0])
        {
            case 'L':
                $area = Area::where('name', 'Los Banos')->first();
                break;

            case 'B':
                $area = Area::where('name', 'Bay')->first();
                break;

            case 'C':
                $area = Area::where('name', 'Cabuyao')->first();
                break;
        }

        return $area;

//        return Area::descendantsOf($lgu)->where('name','CP'.$cp)->first();
    }
}
