<?php

namespace App\App\Stages;

use App\Campaign\Jobs\UpdateCommanderCheckin;

class UpdateCommanderCheckinStage extends BaseStage
{
    public function execute()
    {
        $this->dispatch((new UpdateCommanderCheckin($this->getCommander())));
    }
}
