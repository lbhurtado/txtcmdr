<?php

namespace App\Campaign\Domain\Classes;

class HelpCommand extends Command
{
    const DEFAULT_CMD = 'help';

    protected function go()
    {
        return $this;
    }

}
