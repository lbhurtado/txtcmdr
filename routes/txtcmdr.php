<?php

use League\Pipeline\Pipeline;
use App\App\Stages\NotifyHQStage;
use App\App\Stages\NotifyUplineStage;
use App\App\Stages\UpdateContactStage;
use App\App\Stages\NotifyCommanderStage;
use App\App\Stages\OnboardCommanderStage;
use App\App\Stages\GuessContextAreaStage;
use App\App\Stages\GuessContextGroupStage;
use App\App\Stages\NotifyContextAreaStage;
use App\App\Stages\UpdateContactAreaStage;
use App\App\Stages\UpdateContactGroupStage;
use App\App\Stages\NotifyContextGroupStage;
use App\App\Stages\UpdateCommanderTagStage;
use App\App\Stages\UpdateCommanderCampaignStage;
use App\App\Stages\SanitizeAreaStage;
use App\Campaign\Domain\Repositories\AreaRepository;
use App\Campaign\Domain\Repositories\GroupRepository;
use Symfony\Component\Process\Exception\LogicException;
use Opis\String\UnicodeString as wstring;

$txtcmdr = resolve('txtcmdr');

$txtcmdr->register("{command=optin}", function (string $path, array $parameters) {
	(new Pipeline)
	    ->pipe(new OnboardCommanderStage)
	    ->process($parameters)
	    ;
});

$campaigns = optional(true, function (){
	return "regular|special";
});

$txtcmdr->register("{context?}{command=>}{message}", function (string $path, array $parameters) {
	(new Pipeline)
	    ->pipe(new GuessContextAreaStage)
	    ->pipe(new NotifyContextAreaStage)
	    ->pipe(new GuessContextGroupStage)
	    ->pipe(new NotifyContextGroupStage)
	    ->pipe(new NotifyCommanderStage)
	    ->process($parameters)
	    ;
});

$txtcmdr->register("{campaign?={$campaigns}}{command=#}{tag?}", function (string $path, array $parameters) {
	(new Pipeline)
	    ->pipe(new UpdateCommanderTagStage)
	    ->pipe(new UpdateCommanderCampaignStage)
	    ->pipe(new NotifyCommanderStage)
	    ->process($parameters)
	    ;
});

$groups = optional(app(GroupRepository::class), function ($groups) {
	return implode($groups->pluck('name')->toArray(), '|');
});

$txtcmdr->register("{message?}{command=&}{group?={$groups}}", function (string $path, array $parameters) {
	(new Pipeline)
	    ->pipe(new UpdateContactGroupStage) //done
	    ->pipe(new NotifyCommanderStage)  //done
	    ->pipe(new NotifyUplineStage)
	    ->process($parameters)
	    ;
});

$areas = optional(app(AreaRepository::class), function ($areas) {
	$names = implode($areas->pluck('name')->toArray(), '|');
	$ids = implode($areas->pluck('id')->toArray(), '|'); 

	return wstring::from($names)->append('||')->append($ids);
});

$txtcmdr->register("{message?}{command=@}{area?={$areas}}", function (string $path, array $parameters) {
	DB::beginTransaction();
	try 
	{
		(new Pipeline)
		    ->pipe(new SanitizeAreaStage) //done 
		    ->pipe(new UpdateContactAreaStage) //done
		    ->pipe(new NotifyCommanderStage) //done
		    ->pipe(new NotifyUplineStage)
		    ->process($parameters)
		    ;
	} 
	catch (LogicException $e) {
		DB::rollBack();
    	\Log::error('Error::LogicException');
	};
	DB::commit();
});

$keywords = optional(true, function (){
	return "bonggo|bonggo123";
});

$txtcmdr->register("{tag={$keywords}} {name}", function (string $path, array $parameters) {
	$parameters['command'] = 'register';
	(new Pipeline)
	    ->pipe(new UpdateContactStage)
	    ->pipe(new GuessContextAreaStage)
	    ->pipe(new GuessContextGroupStage)
	    ->pipe(new NotifyCommanderStage)
	    ->process($parameters)
	    ;
});

$txtcmdr->register("{command=broadcast} {pin?=[\d]+} {message}", function (string $path, array $parameters) {
	(new Pipeline)
	    ->pipe(new GuessContextAreaStage)
	    ->pipe(new NotifyContextAreaStage)
	    ->pipe(new NotifyCommanderStage)
	    ->process($parameters)
	    ;
});