<?php

return [
	'commander' => [
		'optin' 	        => "You have opted in using :mobile. \n-:signature",
		'area'  	        => "You are now operating in :area. \n-:signature",
		'group'  	        => "You joined :group. \n-:signature",
		'tag'   	        => "You have a new keyword :code. \n-:signature",
		'registration'      => ":handle, you have registered. \n-:signature",
		'alert'		        => "You sent a :alert alert. \n-:signature",
		'attribute'	        => "You changed a :attribute attribute. \n-:signature",
		'status'	        => "Your status changed: :status. \n-:signature",
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
        'status'	   => "Downline status changed: :status. \n\n-:signature",
    ],
];