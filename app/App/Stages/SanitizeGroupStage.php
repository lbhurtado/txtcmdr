<?php

namespace App\App\Stages;

use Illuminate\Support\Arr;
use App\Campaign\Domain\Repositories\GroupRepository;

class SanitizeGroupStage extends BaseStage
{
    protected $input_group;

    protected function enabled()
    {
        return $this->input_group = trim(Arr::get($this->getParameters(), 'group', config('txtcmdr.default.group')));
    }

    public function execute()
    {
        $group = $this->getSanitizedGroup($this->input_group) ?? $this->halt();
        $sanitized_group = $group->name;

        //TODO: combine the next 3 lines to something like the 4th line
		Arr::set($this->parameters, 'group', $sanitized_group ?? $this->halt());
        Arr::set($this->parameters, 'context', $sanitized_group);
        Arr::set($this->parameters, 'field', 'group');

        Arr::set($this->parameters, 'models.group', $group);
    }

    protected function getSanitizedGroup($input)
    {
        return app(GroupRepository::class)->getSanitizedModel($input);
    }
}
