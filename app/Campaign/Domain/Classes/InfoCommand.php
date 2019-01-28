<?php

namespace App\Campaign\Domain\Classes;

class InfoCommand extends Command
{
	const DEFAULT_CMD = '\\\?';

	protected function go()
	{
		return $this;
	}
}