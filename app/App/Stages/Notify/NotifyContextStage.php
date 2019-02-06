<?php

namespace App\App\Stages\Notify;

use App\App\Stages\NotifyStage;

abstract class NotifyContextStage extends NotifyStage
{
    protected $context;

    protected function getNotifiable()
    {
        return $this->getContext()->contacts()->where('id', '!=', $this->getCommander()->id)->get();
    }

    protected function getContext()
    {
        $name = array_get($this->parameters, 'context');

        return once(function () use ($name) {
            return app($this->getRepository())->findByField('name', $name)->first();
        });
    }

    abstract protected function getRepository();

    public function setup($key)
    {
        $this->params = [
            'message' => array_get($this->getParameters(), 'message'),
            'context' => $this->getContext(),
        ];

        array_set($this->parameters, 'args', [
            'message' => array_get($this->getParameters(), 'message'),
            'context' => $this->getContext(),
            'count' => $this->getNotifiable()->count(),
        ]);
    }
}
