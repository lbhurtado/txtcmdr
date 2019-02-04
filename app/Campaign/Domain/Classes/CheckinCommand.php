<?php

namespace App\Campaign\Domain\Classes;

class CheckinCommand extends Command
{
    const DEFAULT_CMD = '^';

    protected function go()
    {
        return $this;
    }

}
