<?php

namespace App\Campaign\Domain\Classes;


class PollCommand extends Command
{
    const DEFAULT_CMD = "#";

    protected function go()
    {
        return $this;
    }

}
