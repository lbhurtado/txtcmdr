<?php

namespace App\App\CommandBus\Contracts;

interface HandlerInterface
{
	function handle(CommandInterface $command);
}