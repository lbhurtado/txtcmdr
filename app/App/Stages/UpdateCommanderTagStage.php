<?php

namespace App\App\Stages;

use Illuminate\Support\Arr;
use App\Campaign\Jobs\UpdateCommanderTag;

class UpdateCommanderTagStage extends BaseStage
{
    public function execute()
    {
        $this->dispatch(new UpdateCommanderTag($this->getCommander(), $this->getCode()));
    }

    protected function getCode()
    {
        $space = " ";
        
        return string($this->tag())->concat($space)->concat($this->context())->toUpper();
    }

    protected function tag()
    {
        //TODO Confirm Code
        return Arr::get($this->getParameters(), 'tag') ?? config('txtcmdr.tag');
    }

    protected function context()
    {
        $field = Arr::get($this->getParameters(), 'field', 'area');
        $model = Arr::get($this->parameters, 'models')[$field];

        return $model->alias ?? $model->name;
    }
}
