<?php

use League\Pipeline\Pipeline;
use App\App\Stages\NotifyHQStage;
use App\App\Stages\SanitizeAreaStage;
use App\App\Stages\NotifyUplineStage;
use App\App\Stages\SanitizeGroupStage;
use Illuminate\Support\Facades\Schema;
use App\App\Stages\NotifyDownlineStage;
use App\App\Stages\SanitizeContextStage;
use App\App\Stages\UpdateCommanderStage;
use App\App\Stages\NotifyCommanderStage;
use App\App\Stages\OnboardCommanderStage;
use App\App\Stages\NotifyDescendantsStage;
use App\App\Stages\NotifyContextAreaStage;
use App\App\Stages\NotifyContextGroupStage;
use App\App\Stages\UpdateCommanderTagStage;
use App\App\Stages\UpdateCommanderAreaStage;
use App\App\Stages\UpdateCommanderGroupStage;
use App\App\Stages\UpdateCommanderUplineStage;
use App\App\Stages\UpdateCommanderStatusStage;
use App\App\Stages\UpdateCommanderTagAreaStage;
use App\App\Stages\UpdateCommanderTagGroupStage;
use App\App\Stages\UpdateCommanderAttributeStage;
use App\App\Stages\UpdateCommanderTagCampaignStage;
use App\Campaign\Domain\Classes\{Command, CommandKey};
use App\App\Stages\UpdateCommanderAreaFromUplineTagAreaStage;
use App\App\Stages\UpdateCommanderGroupFromUplineTagGroupStage;

use App\App\Stages\UpdateCommanderCampaignParametersStage;

if (! Schema::hasTable('taggables')) return; //find other ways to make this elegant

$txtcmdr = resolve('txtcmdr');

tap(Command::using(CommandKey::OPTIN), function ($cmd) use ($txtcmdr) {
	$txtcmdr->register("{command={$cmd->CMD}}", function (string $path, array $parameters) {
		(new Pipeline)
		    // ->pipe(new OnboardCommanderStage)
		    ->pipe(new NotifyCommanderStage) //done
		    ->process($parameters)
		    ;
	});	
});

tap(Command::using(CommandKey::REPORT), function ($cmd) use ($txtcmdr) {
	$txtcmdr->register("{command={$cmd->CMD}}{message}", function (string $path, array $parameters) {
		(new Pipeline)
		    ->pipe(new NotifyUplineStage)
		    ->pipe(new NotifyCommanderStage)
		    ->process($parameters)
		    ;
	});	
});

tap(Command::using(CommandKey::ALERT), function ($cmd) use ($txtcmdr) {
	$txtcmdr->register("{command={$cmd->CMD}}{keyword?}", function (string $path, array $parameters) {
		(new Pipeline)
			->pipe(new NotifyUplineStage)
		    ->pipe(new NotifyCommanderStage)
		    ->process($parameters)
		    ;
	});	
});

tap(Command::using(CommandKey::INFO), function ($cmd) use ($txtcmdr) {
	$txtcmdr->register("{command={$cmd->CMD}}{keyword?}", function (string $path, array $parameters) {
		(new Pipeline)
		    ->pipe(new NotifyCommanderStage)
		    ->process($parameters)
		    ;
	});	
});

tap(Command::using(CommandKey::SEND), function ($cmd) use ($txtcmdr) {
    $txtcmdr->register("{context={$cmd->LST}}{command={$cmd->CMD}}{message}", function (string $path, array $parameters) {
        (new Pipeline)
            ->pipe(new SanitizeContextStage) //tested
            ->pipe(new NotifyContextAreaStage) //tested
            ->pipe(new NotifyContextGroupStage) //tested
            ->pipe(new NotifyCommanderStage) //tested
            ->process($parameters)
        ;
    });
});

tap(Command::using(CommandKey::ANNOUNCE), function ($cmd) use ($txtcmdr) {
    $txtcmdr->register("{command={$cmd->CMD}}{message}", function (string $path, array $parameters) {
        (new Pipeline)
            ->pipe(new NotifyDownlineStage) //tested
            ->pipe(new NotifyCommanderStage) //tested
            ->process($parameters)
        ;
    });
});

tap(Command::using(CommandKey::BROADCAST), function ($cmd) use ($txtcmdr) {
    $txtcmdr->register("{command={$cmd->CMD}}{message}", function (string $path, array $parameters) {
        (new Pipeline)
            ->pipe(new NotifyDescendantsStage) //tested
            ->pipe(new NotifyCommanderStage) //tested
            ->process($parameters)
        ;
    });
});

tap(Command::using(CommandKey::REGISTER), function ($cmd) use ($txtcmdr) {
    $txtcmdr->register("{tag={$cmd->LST}} {handle}", function (string $path, array $parameters) use ($cmd) {
        $parameters['command'] = $cmd->CMD;
        (new Pipeline)
            ->pipe(new UpdateCommanderStage) //tested
            ->pipe(new UpdateCommanderUplineStage) //tested
            ->pipe(new UpdateCommanderAreaFromUplineTagAreaStage) //tested
            ->pipe(new UpdateCommanderGroupFromUplineTagGroupStage) //tested
            ->pipe(new UpdateCommanderTagStage) //tested
            ->pipe(new UpdateCommanderCampaignParametersStage) //done
            ->pipe(new UpdateCommanderTagCampaignStage) //tested
            ->pipe(new UpdateCommanderTagAreaStage) //tested
            ->pipe(new UpdateCommanderTagGroupStage) //tested
            ->pipe(new NotifyCommanderStage) //tested
            ->process($parameters)
        ;
    });
});

tap(Command::using(CommandKey::TAG), function ($cmd) use ($txtcmdr) {
    $txtcmdr->register("{campaign?={$cmd->LST}}{command={$cmd->CMD}}{tag?}", function (string $path, array $parameters) {
        (new Pipeline)
            ->pipe(new UpdateCommanderTagStage) //tested
            ->pipe(new UpdateCommanderTagCampaignStage) //tested
            ->pipe(new UpdateCommanderTagGroupStage) //tested
            ->pipe(new UpdateCommanderTagAreaStage) //tested
            ->pipe(new NotifyCommanderStage) //test
            ->process($parameters)
        ;
    });
});

tap(Command::using(CommandKey::STATUS), function ($cmd) use ($txtcmdr) {
    $txtcmdr->register("{percent?}{command={$cmd->CMD}}{status}/{reason?}", function (string $path, array $parameters) {
        (new Pipeline)
            ->pipe(new UpdateCommanderStatusStage) //tested
            ->pipe(new NotifyCommanderStage) //tested
            ->pipe(new NotifyUplineStage) //tested
            ->process($parameters)
        ;
    });
});

tap(Command::using(CommandKey::ATTRIBUTE), function ($cmd) use ($txtcmdr) {
    $txtcmdr->register("{key}{command={$cmd->CMD}}{value?}", function (string $path, array $parameters) {
        (new Pipeline)
            ->pipe(new UpdateCommanderAttributeStage) //tested
            ->pipe(new NotifyCommanderStage) //tested
            ->process($parameters)
        ;
    });
});

tap(Command::using(CommandKey::AREA), function ($cmd) use ($txtcmdr) {
    $txtcmdr->register("{message?}{command={$cmd->CMD}}{area?={$cmd->LST}}", function (string $path, array $parameters) {
        (new Pipeline)
            ->pipe(new SanitizeAreaStage) //tested
            ->pipe(new UpdateCommanderAreaStage) //tested
            ->pipe(new UpdateCommanderTagAreaStage) //tested
            ->pipe(new NotifyCommanderStage) //tested
            ->pipe(new NotifyUplineStage) //tested
            ->process($parameters)
        ;
    });
});

tap(Command::using(CommandKey::GROUP), function ($cmd) use ($txtcmdr) {
    $txtcmdr->register("{message?}{command={$cmd->CMD}}{group?={$cmd->LST}}", function (string $path, array $parameters) {
        (new Pipeline)
            ->pipe(new SanitizeGroupStage) //tested
            ->pipe(new UpdateCommanderGroupStage) //tested
            ->pipe(new UpdateCommanderTagGroupStage) //tested
            ->pipe(new NotifyCommanderStage)  //tested
            ->pipe(new NotifyUplineStage) //tested
            ->process($parameters)
        ;
    });
});

tap(Command::using(CommandKey::TEST), function ($cmd) use ($txtcmdr) {
    $txtcmdr->register("{command=ping}", function (string $path, array $parameters) use ($cmd) {
        $parameters['command'] = $cmd->CMD;
        (new Pipeline)
            ->pipe(new NotifyCommanderStage) //tested
            ->process($parameters)
        ;
    });
});