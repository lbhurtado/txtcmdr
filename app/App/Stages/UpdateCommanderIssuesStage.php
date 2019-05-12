<?php

namespace App\App\Stages;

use Illuminate\Support\Arr;
use App\Campaign\Jobs\UpdateCommanderIssues;

class UpdateCommanderIssuesStage extends BaseStage
{
    protected $poll_array;

    protected $poll_area;

    protected function enabled()
    {
        $this->poll_array = Arr::get($this->parameters, 'poll_array');
        $this->poll_area = Arr::get($this->parameters, 'models.poll_area');

        return $this->poll_array && $this->poll_area;
    }

    public function execute()
    {
        $this->dispatch(new UpdateCommanderIssues($this->getCommander(), $this->poll_array, $this->poll_area));
    }
}
