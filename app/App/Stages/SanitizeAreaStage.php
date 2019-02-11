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
        array_set($this->parameters, 'field', 'area');
    }

    //TODO get alias or note, sleep now

    protected function getSanitizedArea($input):string
    {
		return
            app(AreaRepository::class)->all()->sortByDesc('name')
				->pluck('name')
				->first(function($value) use ($input) {
					//there's no easy way to search case-insensitive in database
					//better in the collection
					return strtoupper($value) == strtoupper($input) ;
				})
            ??
            app(AreaRepository::class)->all()->sortByDesc('alias')
                ->pluck('name' ,'alias')
                ->first(function($value, $alias) use ($input) {
                    //there's no easy way to search case-insensitive in database
                    //better in the collection
                    return strtoupper($alias) == strtoupper($input) ;
                })
            ;
    }
}
