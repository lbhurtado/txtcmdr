<?php

namespace App\Campaign\Domain\Classes;

abstract class Command
{
	const DEFAULT_CMD = null;

	public $CMD;

	public $LST;

	public static function using($key)
	{
		$cmd = config("txtcmdr.commands.{$key}");

		return app($cmd['class'])->setCMD(optional($cmd)['cmd'])->go();
	}

	protected function setCMD($cmd = null)
	{
		$this->CMD = $cmd ?? static::DEFAULT_CMD;
		return $this;
	}

	abstract protected function go();
}
