<?php

namespace App\GlobeLabs\Services;

use Globe\Connect\Sms;
use Globe\Connect\Oauth;
use Globe\Connect\Location;

class GlobeConnect
{
    protected $oauth;
    
    protected $sender;

    public function __construct()
    {
        $config = config('broadcasting.connections.globeconnect');

        $this
            ->setOAuth(array_get($config, 'app_id'), array_get($config, 'app_secret'))
            ->setSender(array_get($config, 'sender'));
    }

    public function send($params, $mode = 'sms')
    {
        $base = [

        ];

        $params = \array_merge($base, \array_filter($params));
        
        try {

            $sms = new Sms($this->getSender(), array_get($params, 'token'));

            $sms->setReceiverAddress(array_get($params, 'address'));
            $sms->setMessage(array_get($params, 'message'));
            // $sms->setClientCorrelator(array_get($params, 'correlator'));

            $response = $sms->sendMessage();
            // $response = \json_decode((string) $response->getBody(), true);

            // if (isset($response['error'])) {
            //     throw new \DomainException($response['error'], $response['error_code']);
            // }

            return $response;
        // } catch (\DomainException $exception) {
        //     throw CouldNotSendNotification::smscRespondedWithAnError($exception);
        } catch (\Exception $exception) {
            // throw CouldNotSendNotification::couldNotCommunicateWithSmsc($exception);
            throw $exception;
        }
    }

    public function locate($params)
    {
        $base = [

        ];

        $params = \array_merge($base, \array_filter($params));

        $location = new Location(array_get($params, 'token'));
        $location->setAddress(array_get($params, 'address'));
        $location->setRequestedAccuracy(array_get($params, 'requested_accuracy'));

        $response = $location->getLocation();

        return $response;
    }

    public function getSender()
    {
        return $this->sender;
    }

    public function setOAuth($app_id, $app_secret)
    {
        $this->oauth = new Oauth($app_id, $app_secret);

        return $this;
    }

    public function setSender($sender)
    {
        $this->sender = $sender;

        return $this;
    }
}