<?php

namespace App\App\Stages\Notify;

use App\Campaign\Domain\Classes\CommandKey;
use App\Campaign\Domain\Repositories\AreaRepository;
use App\Campaign\Notifications\CommanderTagUpdated;

class NotifyCommanderTagAreaStage extends NotifyContextStage
{
    protected $repository = AreaRepository::class;

    protected $notifications = [
        CommandKey::TAG => CommanderTagUpdated::class,
    ];

    protected function getRepository()
    {
        return $this->repository;
    }

    protected function getNotifiable()
    {
        return $this->getCommander();
    }
}
