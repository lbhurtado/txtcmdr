<?php

namespace App\App\Stages;

use Illuminate\Support\Arr;
use App\Campaign\Jobs\UpdateCommanderIssues;

class UpdateCommanderIssuesStage extends BaseStage
{
    protected $poll_array;

    protected function enabled()
    {
        return $this->poll_array = Arr::get($this->parameters, 'poll_array');
    }

    public function execute()
    {
        $this->dispatch(new UpdateCommanderIssues($this->getCommander(), $this->poll_array));
        $area = Arr::get($this->parameters, 'models.old_area');
        Arr::set($this->parameters, 'models.area', $area);
    }
}
