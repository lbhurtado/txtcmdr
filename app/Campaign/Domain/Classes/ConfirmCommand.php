<?php

namespace App\Campaign\Domain\Classes;

class ConfirmCommand extends Command
{
	const DEFAULT_CMD = 'confirm';

    protected function go()
    {
        return $this;
    }
}