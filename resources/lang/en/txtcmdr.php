<?php

return [
	'commander' => [
		'optin' 	        => "You have opted in using :mobile. \n\n-:signature",
		'area'  	        => "You are now operating in :area. \n\n-:signature",
        'confirm'           => "Salamat sa pagsali. Masigasig po tayong mangumbinsi para sa tagumpay ng ating laban. Ang panalo ko, ay panalo niyo! Nagmamahal,\n\n- Cong Ruth Hernandez",
		'group'  	        => "You are now attached to :group. \n\n-:signature",
		'tag'   	        => "Registration procedure for :context:\n\nsend :code [first name] [last name] to :numbers\n\n-:signature",
		'registration'      => "Akong higala :handle, ako si Atty. Levi Baligod, nagpasalamat kanimo sa imong kinasing-kasing nga pagsuporta alang sa Kausaban sa Baybay.  Magtinabangay ta arun masulusyonan ang mga problema sa atong lungsod, hilabi na ang kawad-on ug ang pagbatuk sa korapsyon ug sa ginadili na droga",
		'alert'		        => ":alert alert was issued to:\n:handle\n:groups \n\n-:signature",
		'attribute'	        => "You changed a :attribute attribute. \n\n-:signature",
		'status'	        => "Your status changed to: :status*\n\n*:reason\n\n-:signature",
        'test'	            => "PONG",
        'help'              => "Commands:\n\n:commands\n\n-:signature",
        'checkin'	        => "You checked in: [:id] :location. \n\n-:signature",
        'announce'          => "Your announcement ':tease' was sent to :count downlines.\n\n-:signature",
        'report'            => "Your report ':tease' was sent to :upline.\n\n-:signature",
        'broadcast'         => "Your broadcast ':tease' was sent to :count descendants.\n\n-:signature",
        'info'		        => [
            'tag' 	        => "Tag:\n:data\n\n-:signature",
        	'area' 	        => "Area:\n:data\n\n-:signature",
            'group'         => "Group:\n:data\n\n-:signature",
            'alert'         => "Alert:\n:data\n\n-:signature",
            'signal'        => "Signal:\n:data\n\n-:signature",
            'status'        => "Status:\n:data\n\n-:signature",
            'upline'        => "Upline:\n:data\n\n-:signature",
            'downlines'     => "Downlines (:context):\n:data pax\n\n-:signature",
            'attribute'     => "Attribute:\n:data\n\n-:signature",
            'descendants'   => "Descendants:\n:data pax\n\n-:signature",
        ],
        'send'              => [
            'area'          => "Send:\n:message\n\ncc: :area\n\n-:signature",
            'group'         => "Send:\n:message\ncc::group\n\n-:signature",
            'feedback'      => "Your message ':tease' was sent to :count recipients in :context.\n\n-:signature",
        ],
        'errors'            => [
            'registration'  => "You have already registered.",
        ],
	],
    'upline' => [
        'tag'               => "Your downline :handle [:mobile] has a new keyword:\n\n:code\n\n-:signature",
        'registration'	    => "Your downline :handle [:mobile] registered in: :area. \n\n-:signature",
        'group'             => "Your downline :handle [:mobile] is now attached to :group.\n\n-:signature",
        'area'              => "Your downline :handle [:mobile] is now operating in :area.\n\n-:signature",
        'alert'	            => "Your downline :handle [:mobile] issued an alert: :alert*\n\n*:area\n\n-:signature",
        'status'	        => "Your downline :handle [:mobile] has a new status: :status*\n\n*:reason\n\n-:signature",
        'checkin'	        => "Your downline :handle [:mobile] checked in: [:id] :location. \n\n-:signature",
        'report'            => "Report:\n:message\n\n:downline",
    ],
    'downline' => [
        'announce'          => "Announcement:\n:message\n\n:upline",
    ],
    'descendants' => [
        'broadcast'         => "Broadcast:\n:message\n\n:origin",
    ],
    'group' => [
        'alert'	            => ":handle [:mobile] issued an alert: :alert*\n\n*:area\n\n-:signature",
    ],
    'seeds' => [
        'campaigns' => [
            'default'       => env('CAMPAIGN_DEFAULT', "default message"),
            'training'      => env('CAMPAIGN_TRAINING', "training message"),
            'testing'       => env('CAMPAIGN_TESTING', "testing message"),
            'deployment'    => env('CAMPAIGN_DEPLOYMENT', "testing message"),
        ],
    ],
    'sms' => [
        'telcos' => [
            'globe' =>  env('GLOBE', '21582402'),
            'smart' =>  env('SMART', '29290582402'),
        ],
    ],
];
