<?php

namespace App\Campaign\Domain\Classes;

use App\Campaign\Domain\Repositories\TagRepository;

class RegisterCommand extends Command
{
	const DEFAULT_CMD = 'register';

	protected $tags;

	public function __construct(TagRepository $tags)
	{
		$this->tags = $tags;
	}

	protected function go()
	{
		$this->LST = implode($this->tags->pluck('code')->toArray(), '|');

		return $this;
	}
}