<?php

namespace App\Campaign\Domain\Classes;

class CheckinCommand extends Command
{
    const DEFAULT_CMD = "CHECKIN";

    protected function go()
    {
        return $this;
    }

}
