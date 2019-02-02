<?php

return [
	'commander' => [
		'optin' 	        => "You have opted in using :mobile. \n\n-:signature",
		'area'  	        => "You are now operating in :area. \n\n-:signature",
		'group'  	        => "You are now attached to :group. \n\n-:signature",
		'tag'   	        => "You have a new keyword: :code*\n\n*:next [name]\n\n-:signature",
		'registration'      => ":handle, you have registered. \n\n-:signature",
		'alert'		        => "You sent a :alert alert. \n\n-:signature",
		'attribute'	        => "You changed a :attribute attribute. \n\n-:signature",
		'status'	        => "Your status changed to: :status*\n\n*:reason\n\n-:signature",
        'test'	            => "PONG",
        'info'		        => [
            'tag' 	        => "Tag:\n:data\n\n-:signature",
        	'area' 	        => "Area:\n:data\n\n-:signature",
            'group'         => "Group:\n:data\n\n-:signature",
            'alert'         => "Alert:\n:data\n\n-:signature",
            'signal'        => "Signal:\n:data\n\n-:signature",
            'status'        => "Status:\n:data\n\n-:signature",
            'upline'        => "Upline:\n:data\n\n-:signature",
            'downline'      => "Downline:\n:data\n\n-:signature",
            'attribute'     => "Attribute:\n:data\n\n-:signature",
            'descendants'   => "Descendants:\n:data\n\n-:signature",
        ],
	],
    'upline' => [
        'tag'               => "Your downline :handle [:mobile] has a new keyword:\n\n:code\n\n-:signature",
        'group'             => "Your downline :handle [:mobile] is now attached to :group.\n\n-:signature",
        'area'              => "Your downline :handle [:mobile] is now operating in :area.\n\n-:signature",
        'status'	        => "Your downline :handle [:mobile] has a new status: :status*\n\n*:reason\n\n-:signature",
    ],
];