<?php

namespace App\App\Stages;

use Notification;
use App\Campaign\Domain\Classes\{Command, CommandKey};

abstract class NotifyStage extends BaseStage
{
    protected $notifiable;

    protected $notifications = [];

    protected function enabled()
    {
        return $this->notifiable = $this->getNotifiable();
    }

    public function execute()
    {
        optional($this->getNotification(), function ($notification) {
            Notification::send($this->notifiable, app($notification));
        });
    }

    abstract protected function getNotifiable();

    protected function getNotification()
    {
        $cmd = array_get($this->getParameters(), 'command');
        switch ($cmd) {
         case '?':
             $cmd = '\?';
             break;
         default:
             # code...
             break;
        }
        $key = array_get(Command::$mappings, $cmd);

        return array_get($this->notifications, $key);
    }
} 