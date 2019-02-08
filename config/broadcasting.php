<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Broadcaster
    |--------------------------------------------------------------------------
    |
    | This option controls the default broadcaster that will be used by the
    | framework when an event needs to be broadcast. You may set this to
    | any of the connections defined in the "connections" array below.
    |
    | Supported: "pusher", "redis", "log", "null"
    |
    */

    'default' => env('BROADCAST_DRIVER', 'null'),

    /*
    |--------------------------------------------------------------------------
    | Broadcast Connections
    |--------------------------------------------------------------------------
    |
    | Here you may define all of the broadcast connections that will be used
    | to broadcast events to other systems or over websockets. Samples of
    | each available type of connection are provided inside this array.
    |
    */

    'connections' => [

        'pusher' => [
            'driver' => 'pusher',
            'key' => env('PUSHER_APP_KEY'),
            'secret' => env('PUSHER_APP_SECRET'),
            'app_id' => env('PUSHER_APP_ID'),
            'options' => [
                'cluster' => env('PUSHER_APP_CLUSTER'),
                'encrypted' => true,
            ],
        ],

        'redis' => [
            'driver' => 'redis',
            'connection' => 'default',
        ],

        'log' => [
            'driver' => 'log',
        ],

        'null' => [
            'driver' => 'null',
        ],

        'telerivet' => [
            'driver' => 'telerivet',
            'api_key' => env('TELERIVET_API_KEY'),
            'project_id' => env('TELERIVET_PROJECT_ID'),
            'service_id' => env('TELERIVET_SERVICE_ID'),
        ],

        'globeconnect' => [
            'app_id' => env('GLOBECONNECT_APP_ID', 'jXeXUqMxGEu67Te958ixxzu8oX5KU4ad'),
            'app_secret' => env('GLOBECONNECT_APP_SECRET', '37632fe0b295486ed8c8efca6'),
            'sender' => env('GLOBECONNECT_SENDER', '21582402'),
        ],

        'telerivet' => [
            'driver' => 'telerivet',
            'api_key' => env('TELERIVET_API_KEY'),
            'project_id' => env('TELERIVET_PROJECT_ID'),
            'service_id' => env('TELERIVET_SERVICE_ID'),
        ],
    ],

];
