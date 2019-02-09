<?php

use App\Campaign\Domain\Classes\InfoKey;
use App\Charging\Domain\Classes\AirtimeKey;
use App\Campaign\Domain\Classes\CommandKey;
use App\GlobeLabs\Channels\GlobeConnectChannel;
use App\EngageSpark\Channels\EngageSparkChannel;

return [
	'airtime' => [
		'availments' => [
			AirtimeKey::SMS 	 => App\Charging\Domain\Classes\Availments\AvailSMS::class,
            AirtimeKey::LBS      => App\Charging\Domain\Classes\Availments\AvailLBS::class,
            AirtimeKey::LOAD10   => App\Charging\Domain\Classes\Availments\AvailLoad10::class,
			AirtimeKey::LOAD25   => App\Charging\Domain\Classes\Availments\AvailLoad25::class,
			AirtimeKey::LOAD50   => App\Charging\Domain\Classes\Availments\AvailLoad50::class,
			AirtimeKey::LOAD100  => App\Charging\Domain\Classes\Availments\AvailLoad100::class,
			AirtimeKey::LOAD500  => App\Charging\Domain\Classes\Availments\AvailLoad500::class,
			AirtimeKey::LOAD1000 => App\Charging\Domain\Classes\Availments\AvailLoad1000::class,
		],
        'transfers' => [
            'default' => env('DEFAULT_AIRTIME_TRANSFER',AirtimeKey::LOAD10),
            'telerivet' => [
                'services' => [
                    AirtimeKey::LOAD10 => env('TELERIVET_LOAD10', 'SV955ec4a037c1d523'),
                    AirtimeKey::LOAD25 => env('TELERIVET_LOAD25', 'SV642b894189df344f'),
                ],
            ],
        ],
	],
    'notification' => [
        'channels' => array_merge(['database'], env('SEND_NOTIFICATION', false)
                                             ? [env('NOTIFICATION_CLASS', GlobeConnectChannel::class)] 
                                             : []),
        'signature' => env('TXTCMDR_SIGNATURE', 'HQ'),
    ],
    'commands' => [

    	CommandKey::TAG => [
    		'cmd' => env('TAG_COMMAND'),
    		'class' => App\Campaign\Domain\Classes\TagCommand::class,
    	],
    	CommandKey::AREA => [
    		'cmd' => env('AREA_COMMAND'),
    		'class' => App\Campaign\Domain\Classes\AreaCommand::class,	
    	],
        CommandKey::SEND => [
            'cmd' => env('SEND_COMMAND'),
            'class' => App\Campaign\Domain\Classes\SendCommand::class,
        ],
        CommandKey::INFO => [
            'cmd' => env('INFO_COMMAND'),
            'class' => App\Campaign\Domain\Classes\InfoCommand::class,
        ],
        CommandKey::TEST => [
            'cmd' => env('TEST_COMMAND'),
            'class' => App\Campaign\Domain\Classes\TestCommand::class,
        ],
        CommandKey::HELP => [
            'cmd' => env('HELP_COMMAND'),
            'class' => App\Campaign\Domain\Classes\HelpCommand::class,
        ],
    	CommandKey::GROUP => [
    		'cmd' => env('GROUP_COMMAND'),
    		'class' => App\Campaign\Domain\Classes\GroupCommand::class,	
    	],
        CommandKey::ALERT => [
            'cmd' => env('ALERT_COMMAND'),
            'class' => App\Campaign\Domain\Classes\AlertCommand::class,
        ],
        CommandKey::OPTIN => [
            'cmd' => env('OPTIN_COMMAND'),
            'class' => App\Campaign\Domain\Classes\OptinCommand::class,
        ],
        CommandKey::REPORT => [
            'cmd' => env('REPORT_COMMAND'),
            'class' => App\Campaign\Domain\Classes\ReportCommand::class,
        ],
        CommandKey::STATUS => [
            'cmd' => env('STATUS_COMMAND'),
            'class' => App\Campaign\Domain\Classes\StatusCommand::class,
        ],
        CommandKey::CHECKIN => [
            'cmd' => env('CHECKIN_COMMAND'),
            'class' => App\Campaign\Domain\Classes\CheckinCommand::class,
        ],
        CommandKey::ANNOUNCE => [
            'cmd' => env('ANNOUNCE_COMMAND'),
            'class' => App\Campaign\Domain\Classes\AnnounceCommand::class,
        ],
    	CommandKey::REGISTER => [
    		'cmd' => env('REGISTER_COMMAND'),
    		'class' => App\Campaign\Domain\Classes\RegisterCommand::class,
    	],
    	CommandKey::BROADCAST => [
    		'cmd' => env('BROADCAST_COMMAND'),
    		'class' => App\Campaign\Domain\Classes\BroadcastCommand::class,
    	],
        CommandKey::ATTRIBUTE => [
            'cmd' => env('ATTRIBUTE_COMMAND'),
            'class' => App\Campaign\Domain\Classes\AttributeCommand::class,
        ],
    ],
    'infokeys' => [
        InfoKey::TAG => env('INFO_KEYWORD_AREA', 'TAG'),
        InfoKey::AREA => env('INFO_KEYWORD_AREA', 'AREA'),
        InfoKey::GROUP => env('INFO_KEYWORD_GROUP', 'GROUP'),
        InfoKey::ALERT => env('INFO_KEYWORD_GROUP', 'ALERT'),
        InfoKey::STATUS => env('INFO_KEYWORD_STATUS', 'STATUS'),
    ],
    'tag'  => env('TAG', 'JOIN'),
];
