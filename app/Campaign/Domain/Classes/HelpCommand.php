<?php

namespace App\Campaign\Domain\Classes;

class HelpCommand extends Command
{
    const DEFAULT_CMD = '.';

    protected function go()
    {
        return $this;
    }

}
