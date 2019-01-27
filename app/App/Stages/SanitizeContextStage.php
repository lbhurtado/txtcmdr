<?php

namespace App\App\Stages;

use App\Campaign\Jobs\UpdateContactArea;
use App\Campaign\Domain\Repositories\AreaRepository;

class SanitizeContextStage extends BaseStage
{
    public function execute()
    {
		$input_area = array_get($this->getParameters(), 'context');

		$sanitized_area = $this->getSanitizedArea($input_area);

		array_set($this->parameters, 'context', $sanitized_area ?? $this->halt());

		//you are here
		//apply to groups
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