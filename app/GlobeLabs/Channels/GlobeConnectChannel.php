<?php

namespace App\GlobeLabs\Channels;

use App\GlobeLabs\Services\GlobeConnect;
use Illuminate\Notifications\Notification;

class GlobeConnectChannel
{
    /** @var string */
    private $mode;

    /** @var GlobeConnect */
    protected $smsc;

    public function __construct(GlobeConnect $smsc)
    {
        $this->smsc = $smsc;
    }

    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  Notification  $notification
     *
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->{'toGlobeConnect'}($notifiable);

        if (\is_string($message)) {
            $message = new GlobeConnectMessage($message);
        }

	    $params = [
	        'token'   => $notifiable->routeNotificationFor('globe_connect', $notification),
	        'address' => $notifiable->mobile,      
	        'message' => $message->content,  
	    ];

        $this->smsc->send($params);
    }

    protected function getSender(GlobeConnectMessage $message)
    {
        return $message->sender ?? $this->smsc->getSender();
    }
}