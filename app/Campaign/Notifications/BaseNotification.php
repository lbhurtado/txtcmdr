<?php

namespace App\Campaign\Notifications;

use Illuminate\Bus\Queueable;
use App\Missive\Domain\Models\Contact;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\GlobeLabs\Channels\{GlobeConnectChannel, GlobeConnectMessage};
use App\EngageSpark\Channels\{EngageSparkChannel, EngageSparkMessage};

abstract class BaseNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $template;

    abstract function params(Contact $notifiable);

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
//        return ['database', EngageSparkChannel::class];
        return config('txtcmdr.notification.channels');
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
            'message' => $this->getContent($notifiable),
        ];
    }

    public function toGlobeConnect($notifiable)
    {
        return (new GlobeConnectMessage())
            ->content($this->getContent($notifiable))
            ;
    }

    public function toEngageSpark($notifiable)
    {
        return (new EngageSparkMessage())
            ->content($this->getContent($notifiable))
            ;
    }

    protected function getContent($notifiable)
    {
        $signature = [
            'signature' => config('txtcmdr.notification.signature'),
        ];
    
        return once(function () use ($notifiable, $signature) {
            return trans($this->template, \array_merge($signature, \array_filter($this->params($notifiable))));
        });
    }
}
