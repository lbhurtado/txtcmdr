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

//        dd($this->context());
//        return $this->tag();
        return trim(string($this->tag())->concat($space)->concat($this->context())->toUpper());
    }

    protected function tag()
    {
        //TODO Confirm Code
        return Arr::get($this->getParameters(), 'tag') ?? config('txtcmdr.tag');
    }

    protected function context()
    {
        return '';

        $field = Arr::get($this->getParameters(), 'field', 'area');
//        $model = Arr::get($this->parameters, 'models')[$field];

        return optional(Arr::get($this->parameters, 'models')[$field], function ($model) {
            return $model->alias ?? $model->name;
        }) ?? 'xxx';
//        return optional($model)->alias ?? optional($model)->name;
    }
}
