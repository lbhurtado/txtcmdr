<?php

namespace App\App\Stages;

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
            $this->notifiable->notify(app($notification));
        });
    }

    abstract protected function getNotifiable();

    protected function getNotification()
    {
        $cmd = array_get($this->getParameters(), 'command');
        $key = array_get(Command::$mappings, $cmd);

        return array_get($this->notifications, $key);
    }
}