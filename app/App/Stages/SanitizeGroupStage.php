<?php

namespace App\App\Stages;

use App\Campaign\Jobs\UpdateContactArea;
use App\Campaign\Domain\Repositories\GroupRepository;

class SanitizeGroupStage extends BaseStage
{
    protected $input_group;

    protected function enabled()
    {
        return $this->input_group = trim(array_get($this->getParameters(), 'group'));
    }

    public function execute()
    {
		$sanitized_group = $this->getSanitizedGroup($this->input_group);

		array_set($this->parameters, 'group', $sanitized_group ?? $this->halt());
        array_set($this->parameters, 'context', $sanitized_group);
    }

    protected function getSanitizedGroup($input):string
    {
		return app(GroupRepository::class)
				->pluck('name', 'id')
				->first(function($value, $key) use ($input) {
					//there's no easy way to search case-insensitive in database
					//better in the collection
//					return strtoupper($value) == strtoupper($input) or $key == $input;
                    return strtoupper($value) == strtoupper($input);
				});
    }
}
