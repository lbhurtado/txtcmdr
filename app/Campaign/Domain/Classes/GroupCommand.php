<?php

namespace App\Campaign\Domain\Classes;

//use Opis\String\UnicodeString as wstring;
//use App\Campaign\Domain\Repositories\GroupRepository;

class GroupCommand extends Command
{
	const DEFAULT_CMD = '&';

//	protected $groups;
//
//	public function __construct(GroupRepository $groups)
//	{
//		$this->groups = $groups;
//	}

	protected function go()
	{
//		$names = implode($this->groups->pluck('name')->toArray(), '|');
//		$ids = implode($this->groups->pluck('id')->toArray(), '|');
//
//		$this->LST = wstring::from($names)->append('||')->append($ids);

		return $this;
	}
}