<?php

namespace App\App\Stages;

use Illuminate\Support\Arr;
use App\Campaign\Jobs\UpdateCommanderStub;

class UpdateCommanderStubStage extends BaseStage
{
    protected $stub;

    protected function enabled()
    {
        return $this->stub = Arr::get($this->parameters, 'model.stub');
    }

    public function execute()
    {
        $this->dispatch(new UpdateCommanderStub($this->stub));
    }
}
