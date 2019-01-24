<?php

namespace App\App\Stages;

use App\Campaign\Jobs\UpdateContactArea;
use App\Campaign\Domain\Repositories\GroupRepository;

class SanitizeGroupStage extends BaseStage
{
    public function execute()
    {
		$input_group = $this->getParameters()['group'];

		$sanitized_group = $this->getSanitizedGroup($input_group);

		array_set($this->parameters, 'group', $sanitized_group ?? $this->halt());
    }

    protected function getSanitizedGroup($input):string
    {
		return app(GroupRepository::class)
				->pluck('name', 'id')
				->first(function($value, $key) use ($input) {
					//there's no easy way to search case-insensitive in database
					//better in the collection
					return strtoupper($value) == strtoupper($input) or $key == $input;
				});
    }
}