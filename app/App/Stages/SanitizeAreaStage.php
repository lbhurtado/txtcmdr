<?php

namespace App\App\Stages;

use App\Campaign\Jobs\UpdateContactArea;
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
		$sanitized_area = $this->getSanitizedArea($this->input_area);

		array_set($this->parameters, 'area', $sanitized_area ?? $this->halt());
        array_set($this->parameters, 'context', $sanitized_area);
    }

    protected function getSanitizedArea($input):string
    {
		return app(AreaRepository::class)
				->pluck('name', 'id')
				->first(function($value, $key) use ($input) {
					//there's no easy way to search case-insensitive in database
					//better in the collection
					return strtoupper($value) == strtoupper($input) or $key == $input;
				});
    }
}
