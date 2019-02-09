<?php

namespace App\TwoFactor\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\EngageSpark\Channels\{EngageSparkChannel, EngageSparkMessage};

class PhoneVerification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $otp;

    protected $content;

    public function __construct($otp)
    {
        $this->otp = $otp;
    }

    public function via($notifiable)
    {
        return ['database', EngageSparkChannel::class];
    }

    public function toArray($notifiable)
    {
        return [
            'mobile' => $notifiable->mobile,
            'otp' => $this->otp,
            'message' => $this->getContent(),
        ];
    }

    public function toEngageSpark($notifiable)
    {
        return (new EngageSparkMessage())
            ->content($this->getContent())
            ;
    }

    protected function getContent()
    {
        return once(function () {
            return "OTP: ".$this->otp;
        });
    }
}
