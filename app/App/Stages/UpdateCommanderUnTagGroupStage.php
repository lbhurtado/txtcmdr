<?php

namespace App\App\Stages;

use App\Campaign\Jobs\UpdateCommanderUnTagGroup;

class UpdateCommanderUnTagGroupStage extends BaseStage
{
    public function execute()
    {
        $this->dispatch(new UpdateCommanderUnTagGroup($this->getCommander()));
    }
}
