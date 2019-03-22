<?php

namespace App\App\Stages;

use App\Campaign\Domain\Repositories\AreaRepository;

class SanitizeAreaStage extends BaseStage
{
    protected $input_area;

    protected function enabled()
    {
        return $this->input_area = trim(array_get($this->getParameters(), 'area'));
    }

    public function execute()
    {
        $area = $this->getSanitizedArea($this->input_area) ?? $this->halt();
		$sanitized_area = $area->name;

		//TODO: combine the next 3 lines to something like the 4th line
		array_set($this->parameters, 'area', $sanitized_area);
        array_set($this->parameters, 'context', $sanitized_area);
        array_set($this->parameters, 'field', 'area');

        array_set($this->parameters, 'models.area', $area);
    }

    protected function getSanitizedArea($input)
    {
        return app(AreaRepository::class)->getSanitizedModel($input);
    }
}
