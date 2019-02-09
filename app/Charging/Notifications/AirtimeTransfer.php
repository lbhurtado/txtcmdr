<?php

namespace App\Charging\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\EngageSpark\Channels\{EngageSparkChannel, EngageSparkMessage};

class AirtimeTransfer extends Notification implements ShouldQueue
{
    use Queueable;

    protected $airtime;

    public function __construct($airtime)
    {
        $this->$airtime = $airtime;
    }

    public function via($notifiable)
    {
        return ['database', EngageSparkChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'mobile' => $notifiable->mobile,
        ];
    }

    public function toEngageSpark($notifiable)
    {
        return (new EngageSparkMessage())
            ->mode('topup')
            ->transfer($this->airtime)
            ;
    }
}
