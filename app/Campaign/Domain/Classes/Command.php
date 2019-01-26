<?php

namespace App\Campaign\Domain\Classes;

abstract class Command
{
	public static $mappings = [];

	const DEFAULT_CMD = null;

	protected $key;

	public $CMD;

	public $LST;

	public static function using($key)
	{
		$cmd = config("txtcmdr.commands.{$key}");

		return app($cmd['class'])->setKey($key)->setCMD(optional($cmd)['cmd'])->go();
	}

	protected function setKey($key)
	{
		$this->key = $key;

		return $this;
	}

	protected function setCMD($cmd = null)
	{
		$this->CMD = $cmd ?? static::DEFAULT_CMD;

		self::$mappings[$this->CMD] = $this->key;

		return $this;
	}

	abstract protected function go();
}
