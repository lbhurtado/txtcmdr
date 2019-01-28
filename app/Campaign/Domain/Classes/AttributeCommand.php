<?php

namespace App\Campaign\Domain\Classes;

class AttributeCommand extends Command
{
	const DEFAULT_CMD = '=';

	protected function go()
	{
		return $this;
	}
}