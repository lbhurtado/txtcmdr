<?php

namespace App\Campaign\Domain\Classes;

class BroadcastCommand extends Command
{
	const DEFAULT_CMD = '>>';

	protected function go()
	{
		return $this;
	}
}
