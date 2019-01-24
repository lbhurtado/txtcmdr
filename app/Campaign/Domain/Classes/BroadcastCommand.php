<?php

namespace App\Campaign\Domain\Classes;

class BroadcastCommand extends Command
{
	const DEFAULT_CMD = 'broadcast';

	protected function go()
	{
		return $this;
	}
}