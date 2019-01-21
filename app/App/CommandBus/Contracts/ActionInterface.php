<?php

namespace App\App\CommandBus\Contracts;

use App\App\Services\TextCommander;
use Joselfonseca\LaravelTactician\CommandBusInterface;

interface ActionInterface
{
	function getBus():CommandBusInterface;

	function getCommand():string;

	function getHandler():string;

	function getMiddlewares():array;

	function getData():array;

	function getService(): TextCommander;
}