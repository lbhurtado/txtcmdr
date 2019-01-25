<?php

use League\Pipeline\Pipeline;
use App\App\Stages\NotifyHQStage;
use App\App\Stages\SanitizeAreaStage;
use App\App\Stages\NotifyUplineStage;
use App\App\Stages\SanitizeGroupStage;
use App\App\Stages\UpdateCommanderStage;
use App\App\Stages\NotifyCommanderStage;
use App\App\Stages\OnboardCommanderStage;
use App\App\Stages\GuessContextAreaStage;
use App\App\Stages\GuessContextGroupStage;
use App\App\Stages\NotifyContextAreaStage;
use App\App\Stages\NotifyContextGroupStage;
use App\App\Stages\UpdateCommanderTagStage;
use App\App\Stages\UpdateCommanderAreaStage;
use App\App\Stages\UpdateCommanderGroupStage;
use App\App\Stages\UpdateCommanderUplineStage;
use App\App\Stages\UpdateCommanderTagAreaStage;
use App\App\Stages\UpdateCommanderTagCampaignStage;
use App\Campaign\Domain\Classes\{Command, CommandKey};

$txtcmdr = resolve('txtcmdr');

tap(Command::using(CommandKey::OPTIN), function ($cmd) use ($txtcmdr) {
	$txtcmdr->register("{command={$cmd->CMD}}", function (string $path, array $parameters) {
		(new Pipeline)
		    ->pipe(new OnboardCommanderStage)
		    ->process($parameters)
		    ;
	});	
});

tap(Command::using(CommandKey::SEND), function ($cmd) use ($txtcmdr) {
	$txtcmdr->register("{context?}{command={$cmd->CMD}}{message}", function (string $path, array $parameters) {
		(new Pipeline)
		    ->pipe(new GuessContextAreaStage)
		    ->pipe(new NotifyContextAreaStage)
		    ->pipe(new GuessContextGroupStage)
		    ->pipe(new NotifyContextGroupStage)
		    ->pipe(new NotifyCommanderStage)
		    ->process($parameters)
		    ;
	});	
});

tap(Command::using(CommandKey::TAG), function ($cmd) use ($txtcmdr) {
	$txtcmdr->register("{campaign?={$cmd->LST}}{command={$cmd->CMD}}{tag?}", function (string $path, array $parameters) {
		(new Pipeline)
		    ->pipe(new UpdateCommanderTagStage) //done
		    ->pipe(new UpdateCommanderTagCampaignStage) //done
		    ->pipe(new NotifyCommanderStage) //done
		    ->process($parameters)
		    ;
	});
});

tap(Command::using(CommandKey::GROUP), function ($cmd) use ($txtcmdr) {
	$txtcmdr->register("{message?}{command={$cmd->CMD}}{group?={$cmd->LST}}", function (string $path, array $parameters) {
		(new Pipeline)
			->pipe(new SanitizeGroupStage) //done 
		    ->pipe(new UpdateCommanderGroupStage) //done
		    ->pipe(new NotifyCommanderStage)  //done
		    ->pipe(new NotifyUplineStage)
		    ->process($parameters)
		    ;
	});
});

tap(Command::using(CommandKey::AREA), function ($cmd) use ($txtcmdr) {
	$txtcmdr->register("{message?}{command={$cmd->CMD}}{area?={$cmd->LST}}", function (string $path, array $parameters) {
			(new Pipeline)
			    ->pipe(new SanitizeAreaStage) //done 
			    ->pipe(new UpdateCommanderAreaStage) //done
			    ->pipe(new UpdateCommanderTagAreaStage)
			    ->pipe(new NotifyCommanderStage) //done
			    ->pipe(new NotifyUplineStage)
			    ->process($parameters)
			    ;
	});
});

tap(Command::using(CommandKey::REGISTER), function ($cmd) use ($txtcmdr) {
	$txtcmdr->register("{tag={$cmd->LST}} {name}", function (string $path, array $parameters) use ($cmd) {
		$parameters['command'] = $cmd->CMD;
		(new Pipeline)
		    ->pipe(new UpdateCommanderStage) //done
		    ->pipe(new UpdateCommanderUplineStage) //done
		    ->pipe(new GuessContextAreaStage)
		    ->pipe(new GuessContextGroupStage)
		    ->pipe(new NotifyCommanderStage)
		    ->process($parameters)
		    ;
	});
});

tap(Command::using(CommandKey::BROADCAST), function ($cmd) use ($txtcmdr) {
	$txtcmdr->register("{command={$cmd->CMD}} {pin?=[\d]+} {message}", function (string $path, array $parameters) {
		(new Pipeline)
		    ->pipe(new GuessContextAreaStage)
		    ->pipe(new NotifyContextAreaStage)
		    ->pipe(new NotifyCommanderStage)
		    ->process($parameters)
		    ;
	});	
});
