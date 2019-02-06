<?php

namespace App\App\Stages\Notify;

use App\Campaign\Domain\Classes\CommandKey;
use App\Campaign\Notifications\CommanderSendToArea;
use App\Campaign\Domain\Repositories\AreaRepository;

class NotifyAreaStage extends NotifyContextStage
{
    protected $repository = AreaRepository::class;

    protected $notifications = [
        CommandKey::SEND => CommanderSendToArea::class,
    ];

    protected function getRepository()
    {
        return $this->repository;
    }
}
