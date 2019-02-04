<?php

namespace App\App\Stages;

use App\Campaign\Jobs\UpdateCommanderCheckin;

class UpdateCommanderCheckinStage extends BaseStage
{
    public function execute()
    {
        \Log::info('here here');

        $this->dispatch((new UpdateCommanderCheckin($this->getCommander())));
    }
}
