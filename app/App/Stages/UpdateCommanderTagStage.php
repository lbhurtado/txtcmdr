<?php

namespace App\App\Stages;

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
        return array_get($this->getParameters(), 'tag') ?? config('txtcmdr.tag');
    }

    protected function context()
    {
        $field = array_get($this->getParameters(), 'field', 'area');
        $model = array_get($this->parameters, 'models')[$field];

        return $model->alias ?? $model->name;
    }
}
