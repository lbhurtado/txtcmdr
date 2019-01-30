<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    function getJsonData($message, $from, $to, $service = 'globe')
    {
        $data = [
            'globe' => [
                'inboundSMSMessageList' => [
                    'inboundSMSMessage' => [
                        [
                            'senderAddress' => $from,
                            'destinationAddress' => $to,
                            'message' => $message,
                        ],
                    ],
                ],
            ],
        ];

        return $data[$service];
    }

    function getEndpoint($action = 'sms', $service = 'globe')
    {
        $array = [
            'globe' => [
                'redirect' => 'api/webhook/redirect/globe',
                'sms' => 'api/webhook/sms/globe', 
            ],
        ];

        return $array[$service][$action];
    }

    function generateMobile($provider = 'globe')
    {
        $array = [
            'globe' => '+63917' . rand(1000000,9999999),
            'smart' => '+63918' . rand(1000000,9999999),
        ];

        return $array[$provider];
    }
}
