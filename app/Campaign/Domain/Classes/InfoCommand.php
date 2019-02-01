<?php

namespace App\Campaign\Domain\Classes;

use App\Campaign\Domain\Classes\InfoKey;

class InfoCommand extends Command
{
	const DEFAULT_CMD = '\\\?';

	protected function go()
	{
		$this->LST = implode(InfoKey::getKeys(), '|');

		return $this;
	}
}