<?php

namespace App\Campaign\Domain\Classes;

class TestCommand extends Command
{
    const DEFAULT_CMD = 'ping';

    protected function go()
    {
        return $this;
    }
}