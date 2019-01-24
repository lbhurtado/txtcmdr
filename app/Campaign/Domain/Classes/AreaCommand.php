<?php

namespace App\Campaign\Domain\Classes;

use Opis\String\UnicodeString as wstring;
use App\Campaign\Domain\Repositories\AreaRepository;

class AreaCommand extends Command
{
	const DEFAULT_CMD = '@';

	protected $areas;

	public function __construct(AreaRepository $areas)
	{
		$this->areas = $areas;
	}

	protected function go()
	{
		$names = implode($this->areas->pluck('name')->toArray(), '|');
		$ids = implode($this->areas->pluck('id')->toArray(), '|');

		$this->LST = wstring::from($names)->append('||')->append($ids);

		return $this;
	}
}