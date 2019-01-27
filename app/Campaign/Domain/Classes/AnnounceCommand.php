<?php

namespace App\Campaign\Domain\Classes;

class AnnounceCommand extends Command
{
	const DEFAULT_CMD = '>';

	protected function go()
	{
		return $this;
	}
}