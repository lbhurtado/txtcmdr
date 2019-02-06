<?php

namespace App\App\Stages\Notify;

use App\Campaign\Domain\Classes\CommandKey;
use App\Campaign\Notifications\CommanderSendToGroup;
use App\Campaign\Domain\Repositories\GroupRepository;

class NotifyGroupStage extends NotifyContextStage
{
    protected $repository = GroupRepository::class;

    protected $notifications = [
        CommandKey::SEND => CommanderSendToGroup::class,
    ];

    protected function getRepository()
    {
        return $this->repository;
    }
}