<?php

namespace App\App\Stages;

use App\Campaign\Domain\Classes\CommandKey;
use App\Campaign\Notifications\CommanderSendToArea;
use App\Campaign\Domain\Repositories\AreaRepository;

class NotifyAreaStage extends NotifyStage
{
    protected $area;

    protected $notifications = [
        CommandKey::SEND => CommanderSendToArea::class,
    ];

    protected function getNotifiable()
    {
        return $this->getArea()->contacts()->where('id', '!=', $this->getCommander()->id)->get();
    }

    protected function getArea()
    {
        $name = array_get($this->parameters, 'area');

        return once(function () use ($name) {
            return app(AreaRepository::class)->findByField('name', $name)->first();
        });


    }

    public function setup($key)
    {
        $this->params = [
            'message' => array_get($this->getParameters(), 'message'),
            'area' => $this->getArea(),
        ];

        array_set($this->parameters, 'args', [
            'message' => array_get($this->getParameters(), 'message'),
            'area' => $this->getArea(),
            'count' => $this->getNotifiable()->count(),
        ]);
    }
}
