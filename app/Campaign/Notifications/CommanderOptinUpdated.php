<?php

namespace App\Campaign\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\GlobeLabs\Channels\{GlobeConnectMessage, GlobeConnectChannel};

class CommanderOptinUpdated extends Notification implements ShouldQueue
{
    use Queueable;

    protected $content;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
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
        ];
    }

    public function toGlobeConnect($notifiable)
    {
        return (new GlobeConnectMessage())
            ->content($this->getContent($notifiable))
            ;
    }

    protected function getContent($notifiable)
    {
        $mobile = $notifiable->mobile;
        $signature = config('txtcmdr.notification.signature');

        return trans('txtcmdr.commander.optin', compact('mobile', 'signature'));
    }
}
