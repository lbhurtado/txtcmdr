<?php

namespace App\App\Stages;

use App\Campaign\Jobs\UpdateContactArea;
use App\Campaign\Domain\Repositories\{AreaRepository, GroupRepository};

class SanitizeContextStage extends BaseStage
{
    public function execute()
    {
		$context = array_get($this->getParameters(), 'context');

		$sanitized_context = $this->getSanitizedContext($context) ?? 'DEFAULT';

		array_set($this->parameters, 'context', $sanitized_context ?? $this->halt());
    }

    protected function getSanitizedContext($input)
    {
		$area =  app(AreaRepository::class)
				->pluck('name', 'id')
				->first(function($value, $key) use ($input) {
					//there's no easy way to search case-insensitive in database
					//better in the collection
					return strtoupper($value) == strtoupper($input);
				})
				;


		$group = app(GroupRepository::class)
				->pluck('name', 'id')
				->first(function($value, $key) use ($input) {
					//there's no easy way to search case-insensitive in database
					//better in the collection
					return strtoupper($value) == strtoupper($input);
				})
				;

		return $area ?? $group;
    }
}