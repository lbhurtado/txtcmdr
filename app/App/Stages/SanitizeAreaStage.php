<?php

namespace App\App\Stages;

use Illuminate\Support\Arr;
use App\Campaign\Domain\Repositories\AreaRepository;

class SanitizeAreaStage extends BaseStage
{
    protected $input_area;

    protected function enabled()
    {
        return $this->input_area = trim(Arr::get($this->getParameters(), 'area'));
    }

    public function execute()
    {
        $area = $this->getSanitizedArea($this->input_area) ?? $this->halt();
		$sanitized_area = $area->name;

		//TODO: combine the next 3 lines to something like the 4th line
		Arr::set($this->parameters, 'area', $sanitized_area);
        Arr::set($this->parameters, 'context', $sanitized_area);
        Arr::set($this->parameters, 'field', 'area');

        Arr::set($this->parameters, 'models.area', $area);
    }

    protected function getSanitizedArea($input)
    {
        return app(AreaRepository::class)->getSanitizedModel($input);
    }
}
