<?php

namespace App\App\CommandBus\Contracts;

interface CommandInterface
{
	function getProperties():array;
}