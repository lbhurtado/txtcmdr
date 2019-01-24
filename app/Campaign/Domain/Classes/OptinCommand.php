<?php

namespace App\Campaign\Domain\Classes;

class OptinCommand extends Command
{
	const DEFAULT_CMD = 'optin';

	protected function go()
	{
		return $this;
	}
}