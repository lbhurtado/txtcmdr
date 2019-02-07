<?php

namespace App\App\Stages\Notify;

use App\Campaign\Domain\Classes\CommandKey;
use App\Campaign\Domain\Repositories\GroupRepository;
use App\Campaign\Notifications\CommanderTagUpdated;

class NotifyCommanderTagGroupStage extends NotifyContextStage
{
    protected $repository = GroupRepository::class;

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
