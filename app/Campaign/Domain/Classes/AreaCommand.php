<?php

namespace App\Campaign\Domain\Classes;

class AreaCommand extends Command
{
	const DEFAULT_CMD = '@';

	protected function go()
	{
	    return $this;
	}
}