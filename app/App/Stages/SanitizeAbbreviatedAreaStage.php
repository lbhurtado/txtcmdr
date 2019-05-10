<?php

namespace App\App\Stages;

use Illuminate\Support\Arr;
use App\Campaign\Domain\Models\Area;
use App\Campaign\Domain\Repositories\AreaRepository;

class SanitizeClusteredPrecinctStage extends BaseStage
{
    protected $input_lgu;

    protected $input_clustered_precinct;

    protected function enabled()
    {
        $this->input_lgu = trim(Arr::get($this->getParameters(), 'lgu'));
        $this->input_clustered_precinct = trim(Arr::get($this->getParameters(), 'cp'));

        return $this->input_lgu && $this->input_clustered_precinct;
    }

    public function execute()
    {
        dd($this->getClusteredPrecinct());
        $area = $this->getClusteredPrecinct() ?? $this->halt();
        $sanitized_area = $area->name;

        //TODO: combine the next 3 lines to something like the 4th line
        Arr::set($this->parameters, 'area', $sanitized_area);
        Arr::set($this->parameters, 'context', $sanitized_area);
        Arr::set($this->parameters, 'field', 'area');

        Arr::set($this->parameters, 'models.area', $area);
    }

    protected function getClusteredPrecinct()
    {
        switch ($this->input_lgu)
        {
            case 'L':
                $lgu = Area::where('name', 'Los Banos')->first();
                break;

            case 'B':
                $lgu = Area::where('name', 'Bay')->first();
                break;

            case 'C':
                $lgu = Area::where('name', 'Cabuyao City')->first();
                break;
        }

        $cp = (int) $this->input_clustered_precinct;

        return Area::descendantsOf($lgu)->where('name','CP'.$cp)->first();
    }
}
