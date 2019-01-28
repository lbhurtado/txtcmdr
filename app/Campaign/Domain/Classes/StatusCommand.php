<?php

namespace App\Campaign\Domain\Classes;

class StatusCommand extends Command
{
	const DEFAULT_CMD = '=';

	protected function go()
	{
		return $this;
	}
}