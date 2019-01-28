<?php

namespace App\Campaign\Domain\Classes;

class AlertCommand extends Command
{
	const DEFAULT_CMD = '!';

	protected function go()
	{
		return $this;
	}
}