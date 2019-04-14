<?php

namespace App\App\Stages;

use Illuminate\Support\Arr;
use App\Campaign\Domain\Models\Stub;
use App\Campaign\Domain\Repositories\StubRepository;

class SanitizeCommanderStubStage extends BaseStage
{
    protected $stub;

    protected function enabled()
    {
        $input_code = trim(Arr::get($this->getParameters(), 'code'));
        $this->stub = $this->getSanitizedStub($input_code);

        return $this->stub ?? $this->halt();
    }

    public function execute()
    {
        $handle = trim(Arr::get($this->getParameters(), 'handle'));

        Arr::set($this->parameters, 'handle', $handle);
        Arr::set($this->parameters, 'area', $this->stub->area);
        Arr::set($this->parameters, 'group', $this->stub->group);
        Arr::set($this->parameters, 'model.stub', $this->stub);
    }

    protected function getSanitizedStub($input)
    {
//        return Stub::whereCode($input)->first();
        return app(StubRepository::class)->findByField('code', $input)->first();
    }
}
