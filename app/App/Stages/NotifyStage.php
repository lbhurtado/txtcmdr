<?php

namespace App\App\Stages;

use Notification;
use App\Campaign\Notifications\BaseNotification;
use App\Campaign\Domain\Classes\{Command, CommandKey};

abstract class NotifyStage extends BaseStage
{
    public $params = ['downline' => null];

    protected $notifiable;

    protected $notifications = [];

    protected function enabled()
    {
        return $this->notifiable = $this->getNotifiable();
    }

    public function execute()
    {
        optional($this->getNotification(), function ($notification) {
            Notification::send($this->notifiable, app($notification, $this->params));
        });
    }

    public function setup($key){}

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
        $key = $this->getKey($cmd);
        $this->setup($key);

        return array_get($this->notifications, $key);
    }

    protected function getKey($cmd)
    {
        return array_first(Command::$mappings, function($v,$k) use ($cmd) {
            return strtoupper($k) == strtoupper($cmd);
        });
    }
} 
