<?php

namespace App\App\Stages;

use App\Campaign\Jobs\UpdateContactArea;
use App\Campaign\Domain\Repositories\AreaRepository;


class SanitizeAreaStage extends BaseStage
{
    public function execute()
    {
		$input_area = $this->getParameters()['area'];

		$sanitized_area = $this->getSanitizedArea($input_area);

		array_set($this->parameters, 'area', $sanitized_area ?? $this->halt());
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