<?php

namespace App\Campaign\Domain\Classes;

class SendCommand extends Command
{
	const DEFAULT_CMD = '>';
	
	protected function go()
	{
		return $this;
	}
}