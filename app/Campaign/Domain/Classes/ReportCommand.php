<?php

namespace App\Campaign\Domain\Classes;

class ReportCommand extends Command
{
	const DEFAULT_CMD = '#';

	protected function go()
	{
		return $this;
	}
}