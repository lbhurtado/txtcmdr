<?php

use League\Pipeline\Pipeline;
use App\App\Stages\SanitizeAreaStage;
use App\App\Stages\NotifyUplineStage;
use App\App\Stages\SanitizeGroupStage;
use Illuminate\Support\Facades\Schema;
use App\App\Stages\NotifyDownlineStage;
use App\App\Stages\SanitizeContextStage;
use App\App\Stages\UpdateCommanderStage;
use App\App\Stages\NotifyCommanderStage;
use App\App\Stages\NotifyGroupAlertStage;
use App\App\Stages\OnboardCommanderStage;
use App\App\Stages\NotifyDescendantsStage;
use App\App\Stages\NotifyContextAreaStage;
use App\App\Stages\NotifyContextGroupStage;
use App\App\Stages\UpdateCommanderTagStage;
use App\App\Stages\UpdateCommanderAreaStage;
use App\App\Stages\NotifyCommanderInfoStage;
use App\App\Stages\UpdateCommanderAlertStage;
use App\App\Stages\UpdateCommanderGroupStage;
use App\App\Stages\UpdateCommanderUplineStage;
use App\App\Stages\UpdateCommanderStatusStage;
use App\App\Stages\UpdateCommanderTagAreaStage;
use App\App\Stages\UpdateCommanderTagGroupStage;
use App\App\Stages\UpdateCommanderAttributeStage;
use App\App\Stages\UpdateCommanderTagCampaignStage;
use App\Campaign\Domain\Classes\{Command, CommandKey};
use App\App\Stages\UpdateCommanderCampaignParametersStage;
use App\App\Stages\UpdateCommanderAreaFromUplineTagAreaStage;
use App\App\Stages\UpdateCommanderGroupFromUplineTagGroupStage;
use App\App\Stages\UpdateCommanderCheckinStage;
use App\App\Stages\Notify\NotifyAreaStage;
use App\App\Stages\Notify\NotifyGroupStage;
use App\App\Stages\UpdateCommanderUnTagAreaStage;
use App\App\Stages\UpdateCommanderUnTagGroupStage;
use App\App\Stages\Notify\NotifyCommanderTagAreaStage;
use App\App\Stages\Notify\NotifyCommanderTagGroupStage;
use App\App\Stages\Charge\ChargeCommanderLBSStage;
use App\App\Stages\Charge\RegisterAirtimeTransferServiceStage;
use App\App\Stages\Charge\TransferCommanderAirtimeStage;
use App\App\Stages\Charge\ChargeCommanderAirtimeTransferStage;

use Opis\Events\EventDispatcher;
use App\Missive\Domain\Events\{ContactEvent, ContactEvents};
use App\Campaign\Domain\Events\{CheckinEvent, CheckinEvents};

use App\App\Stages\Charge\ChargeCommanderOutgoingSMSStage;
use App\App\Stages\SanitizeTagStage;


if (! Schema::hasTable('taggables')) return; //find other ways to make this elegant
if (! Schema::hasTable('alerts')) return; //find other ways to make this elegant

$txtcmdr = resolve('txtcmdr');

//tap(Command::using(CommandKey::OPTIN), function ($cmd) use ($txtcmdr) {
//	$txtcmdr->register("{command={$cmd->CMD}}", function (string $path, array $parameters) {
//		(new Pipeline)
//		    // ->pipe(new OnboardCommanderStage)
//		    ->pipe(new NotifyCommanderStage) //done
//		    ->process($parameters)
//		    ;
//	});
//});

// TODO add upline notification
tap(Command::using(CommandKey::REGISTER), function ($cmd) use ($txtcmdr) {
    $txtcmdr->register("{code={$cmd->LST}} {handle}", function (string $path, array $parameters) use ($cmd) {
//    $txtcmdr->register("{code}", function (string $path, array $parameters) use ($cmd) {
        $parameters['command'] = $cmd->CMD;
        (new Pipeline)
            ->pipe(new SanitizeTagStage)
            ->pipe(new UpdateCommanderStage) //tested
            ->pipe(new UpdateCommanderUplineStage) //tested
            ->pipe(new UpdateCommanderAreaFromUplineTagAreaStage) //tested
            ->pipe(new UpdateCommanderGroupFromUplineTagGroupStage) //tested
//            ->pipe(new UpdateCommanderTagStage) //tested
//            ->pipe(new UpdateCommanderCampaignParametersStage) //done
//            ->pipe(new UpdateCommanderTagCampaignStage) //tested
//            ->pipe(new UpdateCommanderTagAreaStage) //tested
//            ->pipe(new UpdateCommanderTagGroupStage) //tested
            ->pipe(new NotifyCommanderStage) //tested
            ->pipe(new NotifyUplineStage) //tested
            ->pipe(new ChargeCommanderOutgoingSMSStage)
            ->process($parameters)
        ;
    });
});

tap(Command::using(CommandKey::INFO), function ($cmd) use ($txtcmdr) {
	$txtcmdr->register("{command={$cmd->CMD}}{keyword?={$cmd->LST}}", function (string $path, array $parameters) {
		(new Pipeline)
		    ->pipe(new NotifyCommanderInfoStage)
            ->pipe(new ChargeCommanderOutgoingSMSStage)
		    ->process($parameters)
		    ;
	});
});

//tap(Command::using(CommandKey::TAG), function ($cmd) use ($txtcmdr) {
//    $txtcmdr->register("{campaign?={$cmd->LST}}{command={$cmd->CMD}}{tag?}", function (string $path, array $parameters) {
//        (new Pipeline)
//            ->pipe(new UpdateCommanderTagStage) //tested
//            ->pipe(new UpdateCommanderTagCampaignStage) //tested
//            ->pipe(new UpdateCommanderTagGroupStage) //tested
//            ->pipe(new UpdateCommanderTagAreaStage) //tested
//            ->pipe(new NotifyCommanderStage) //test
//            ->pipe(new NotifyUplineStage) //tested
//            ->process($parameters)
//        ;
//    });
//
//    return true;
//});

tap(Command::using(CommandKey::ALERT), function ($cmd) use ($txtcmdr) {
    $txtcmdr->register("{command={$cmd->CMD}}{alert={$cmd->LST}}", function (string $path, array $parameters) {
        (new Pipeline)
            ->pipe(new UpdateCommanderAlertStage)
            ->pipe(new NotifyUplineStage) //tested
            ->pipe(new NotifyCommanderStage) //tested
            ->pipe(new NotifyGroupAlertStage) //tested
            ->pipe(new ChargeCommanderOutgoingSMSStage)
            ->process($parameters)
        ;

        return true;
    });
});

tap(Command::using(CommandKey::REPORT), function ($cmd) use ($txtcmdr) {
    $txtcmdr->register("{command={$cmd->CMD}}{message}", function (string $path, array $parameters) {
        (new Pipeline)
            ->pipe(new NotifyUplineStage) //tested
            ->pipe(new NotifyCommanderStage) //tested
            ->pipe(new ChargeCommanderOutgoingSMSStage)
            ->process($parameters)
        ;

        return true;
    });
});

tap(Command::using(CommandKey::ANNOUNCE), function ($cmd) use ($txtcmdr) {
    $txtcmdr->register("{command={$cmd->CMD}}{message}", function (string $path, array $parameters) {
        (new Pipeline)
            ->pipe(new NotifyDownlineStage) //tested
            ->pipe(new NotifyCommanderStage) //tested
            ->pipe(new ChargeCommanderOutgoingSMSStage)
            ->process($parameters)
        ;

        return true;
    });
});

tap(Command::using(CommandKey::BROADCAST), function ($cmd) use ($txtcmdr) {
    $txtcmdr->register("{command={$cmd->CMD}}{message}", function (string $path, array $parameters) {
        (new Pipeline)
            ->pipe(new NotifyDescendantsStage) //tested
            ->pipe(new NotifyCommanderStage) //tested
            ->pipe(new ChargeCommanderOutgoingSMSStage)
            ->process($parameters)
        ;

        return true;
    });
});

tap(Command::using(CommandKey::STATUS), function ($cmd) use ($txtcmdr) {
    $txtcmdr->register("{percent?}{command={$cmd->CMD}}{status}/{reason?}", function (string $path, array $parameters) {
        (new Pipeline)
            ->pipe(new UpdateCommanderStatusStage) //tested
            ->pipe(new NotifyCommanderStage) //tested
            ->pipe(new NotifyUplineStage) //tested
            ->pipe(new ChargeCommanderOutgoingSMSStage)
            ->process($parameters)
        ;

        return true;
    });
});

tap(Command::using(CommandKey::ATTRIBUTE), function ($cmd) use ($txtcmdr) {
    $txtcmdr->register("{key}{command={$cmd->CMD}}{value?}", function (string $path, array $parameters) {
        (new Pipeline)
            ->pipe(new UpdateCommanderAttributeStage) //tested
            ->pipe(new NotifyCommanderStage) //tested
            ->pipe(new ChargeCommanderOutgoingSMSStage)
            ->process($parameters)
        ;

        return true;
    });
});

// TODO create a control for changing areas
tap(Command::using(CommandKey::AREA), function ($cmd) use ($txtcmdr) {
    $txtcmdr->register("{command={$cmd->CMD}}{area}", function (string $path, array $parameters) {
        (new Pipeline)
            ->pipe(new SanitizeAreaStage) //tested
            ->pipe(new UpdateCommanderAreaStage) //tested
//            ->pipe(new UpdateCommanderTagAreaStage) //tested, working but should not be
            ->pipe(new NotifyCommanderStage) //tested
            ->pipe(new NotifyUplineStage) //tested
            ->pipe(new ChargeCommanderOutgoingSMSStage) //tested
            ->process($parameters)
        ;
    });
});

// TODO create a control for changing groups
tap(Command::using(CommandKey::GROUP), function ($cmd) use ($txtcmdr) {
    $txtcmdr->register("{command={$cmd->CMD}}{group}", function (string $path, array $parameters) {
        (new Pipeline)
            ->pipe(new SanitizeGroupStage) //tested
            ->pipe(new UpdateCommanderGroupStage) //tested
//            ->pipe(new UpdateCommanderTagGroupStage) //tested, working but should not be
            ->pipe(new NotifyCommanderStage)  //tested
            ->pipe(new NotifyUplineStage) //tested
            ->pipe(new ChargeCommanderOutgoingSMSStage)
            ->process($parameters)
        ;

        return true;
    });
});

//tap(Command::using(CommandKey::SEND), function ($cmd) use ($txtcmdr) {
//    $txtcmdr->register("{context={$cmd->LST}}{command={$cmd->CMD}}{message}", function (string $path, array $parameters) {
//        (new Pipeline)
//            ->pipe(new SanitizeContextStage) //tested
//            ->pipe(new NotifyContextAreaStage) //tested
//            ->pipe(new NotifyContextGroupStage) //tested
//            ->pipe(new NotifyCommanderStage) //tested
//            ->process($parameters)
//
//
//        return true;
//    });
//});

tap(Command::using(CommandKey::SEND), function ($cmd) use ($txtcmdr) {
//    $txtcmdr->register("&{group={$cmd->GROUPS}}{command={$cmd->CMD}}{message}", function (string $path, array $parameters) {
    $txtcmdr->register("&{group}{command={$cmd->CMD}}{message}", function (string $path, array $parameters) {
        (new Pipeline)
            ->pipe(new SanitizeGroupStage)
            ->pipe(new NotifyGroupStage)
            ->pipe(new NotifyCommanderStage)
            ->pipe(new ChargeCommanderOutgoingSMSStage)
            ->process($parameters)
        ;

        return true;
    });
});

tap(Command::using(CommandKey::SEND), function ($cmd) use ($txtcmdr) {
//    $txtcmdr->register("@{area={$cmd->AREAS}}{command={$cmd->CMD}}{message}", function (string $path, array $parameters) {
    $txtcmdr->register("@{area}{command={$cmd->CMD}}{message}", function (string $path, array $parameters) {
        (new Pipeline)
            ->pipe(new SanitizeAreaStage) //tested
            ->pipe(new NotifyAreaStage)
            ->pipe(new NotifyCommanderStage)
            ->pipe(new ChargeCommanderOutgoingSMSStage)
            ->process($parameters)
        ;

        return true;
    });
});

tap(Command::using(CommandKey::TAG), function ($cmd) use ($txtcmdr) {
    $txtcmdr->register("{command={$cmd->CMD}} &{group}", function (string $path, array $parameters) {
        (new Pipeline)
            ->pipe(new SanitizeGroupStage) //tested
            ->pipe(new UpdateCommanderTagStage) //tested
            ->pipe(new UpdateCommanderGroupStage) //tested
            ->pipe(new UpdateCommanderTagGroupStage) //tested
            ->pipe(new UpdateCommanderUnTagAreaStage)
            ->pipe(new NotifyCommanderTagGroupStage)
            ->pipe(new ChargeCommanderOutgoingSMSStage)
            ->process($parameters)
        ;

        return true;
    });
});

tap(Command::using(CommandKey::TAG), function ($cmd) use ($txtcmdr) {
    $txtcmdr->register("{command={$cmd->CMD}} &{group} {campaign={$cmd->LST}}", function (string $path, array $parameters) {
        (new Pipeline)
            ->pipe(new SanitizeGroupStage) //tested
            ->pipe(new UpdateCommanderTagStage) //tested
            ->pipe(new UpdateCommanderTagCampaignStage) //tested
            ->pipe(new UpdateCommanderGroupStage) //tested
            ->pipe(new UpdateCommanderTagGroupStage) //tested
            ->pipe(new UpdateCommanderUnTagAreaStage)
            ->pipe(new NotifyCommanderTagGroupStage)
            ->pipe(new ChargeCommanderOutgoingSMSStage)
            ->process($parameters)
        ;

        return true;
    });
});

//TODO if alias is used in tagging, make sure the tag is the alias
tap(Command::using(CommandKey::TAG), function ($cmd) use ($txtcmdr) {
    $txtcmdr->register("{command={$cmd->CMD}} @{area}", function (string $path, array $parameters) {
        (new Pipeline)
            ->pipe(new SanitizeAreaStage) //tested
            ->pipe(new UpdateCommanderTagStage) //tested
            ->pipe(new UpdateCommanderAreaStage) //tested
            ->pipe(new UpdateCommanderTagAreaStage) //tested
//            ->pipe(new UpdateCommanderUnTagGroupStage)
            ->pipe(new NotifyCommanderTagAreaStage)
            ->pipe(new ChargeCommanderOutgoingSMSStage)
            ->process($parameters)
        ;

        return true;
    });
});

tap(Command::using(CommandKey::TAG), function ($cmd) use ($txtcmdr) {
    $txtcmdr->register("{command={$cmd->CMD}} @{area} {campaign={$cmd->LST}}", function (string $path, array $parameters) {
        (new Pipeline)
            ->pipe(new SanitizeAreaStage) //tested
            ->pipe(new UpdateCommanderTagStage) //tested
            ->pipe(new UpdateCommanderTagCampaignStage) //tested
            ->pipe(new UpdateCommanderAreaStage) //tested
            ->pipe(new UpdateCommanderTagAreaStage) //tested
            ->pipe(new UpdateCommanderUnTagGroupStage)
            ->pipe(new NotifyCommanderTagAreaStage)
            ->pipe(new ChargeCommanderOutgoingSMSStage)
            ->process($parameters)
        ;

        return true;
    });
});

tap(Command::using(CommandKey::CHECKIN), function ($cmd) use ($txtcmdr) {
    $txtcmdr->register("{command={$cmd->CMD}}", function (string $path, array $parameters) use ($cmd) {
        (new Pipeline)
            ->pipe(new UpdateCommanderCheckinStage) //tested
            ->pipe(new NotifyCommanderStage) //tested
            ->pipe(new NotifyUplineStage) //tested
            ->pipe(new RegisterAirtimeTransferServiceStage)
//            ->pipe(new AirtimeTransferStage)
            ->pipe(new ChargeCommanderLBSStage)
            ->pipe(new ChargeCommanderOutgoingSMSStage)
            ->process($parameters)
        ;

        return true;
    });
});

tap(Command::using(CommandKey::TEST), function ($cmd) use ($txtcmdr) {
    $txtcmdr->register("{command=ping}", function (string $path, array $parameters) use ($cmd) {
        $parameters['command'] = $cmd->CMD;
        (new Pipeline)
            ->pipe(new NotifyCommanderStage) //tested
//            ->pipe(new RegisterAirtimeTransferServiceStage) //working, here just for testing
//            ->pipe(new TransferCommanderAirtimeStage) //working, here just for testing
//            ->pipe(new ChargeCommanderAirtimeTransferStage) //working, here just for testing
            ->pipe(new ChargeCommanderOutgoingSMSStage)
            ->process($parameters)
        ;

        return true;
    });
});

tap(Command::using(CommandKey::HELP), function ($cmd) use ($txtcmdr) {
    $txtcmdr->register("{command={$cmd->CMD}}", function (string $path, array $parameters) use ($cmd) {
        (new Pipeline)
            ->pipe(new NotifyCommanderStage)
            ->pipe(new ChargeCommanderOutgoingSMSStage)
            ->process($parameters)
        ;

        return true;
    });
});

tap(app(EventDispatcher::class), function ($dispatcher) {
    $dispatcher->handle(ContactEvents::ADOPTED, function (ContactEvent $event) {
        \Log::info('aaaaaaaaaaaaaa');
    });
});

tap(app(EventDispatcher::class), function ($dispatcher) {
    $dispatcher->handle(CheckinEvents::CREATED, function (CheckinEvent $event) {
        \Log::info('kkkkkkkkkkkkk');
    });
});
