<?php

namespace App\Campaign\Domain\Classes;

use Opis\String\UnicodeString as wstring;
use App\Campaign\Domain\Repositories\{AreaRepository, GroupRepository};

class SendCommand extends Command
{
	const DEFAULT_CMD = ':';
	
	protected $areas;

	protected $groups;	

	public function __construct(AreaRepository $areas, GroupRepository $groups)
	{
		$this->areas = $areas;
		$this->groups = $groups;
	}

	protected function go()
	{
		$areas = implode($this->areas->pluck('name')->toArray(), '|');
		$groups = implode($this->groups->pluck('name')->toArray(), '|');

		$this->LST = wstring::from($areas)->append('|')->append($groups);

		return $this;
	}
}