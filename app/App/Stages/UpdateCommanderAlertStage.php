<?php

namespace App\App\Stages;


use App\Campaign\Jobs\UpdateCommanderAlert;
use App\Campaign\Domain\Repositories\AlertRepository;

class UpdateCommanderAlertStage extends BaseStage
{
    protected $alert;

    protected function enabled()
    {
        return $this->alert = app(AlertRepository::class)->findByField('name', $this->parameters['alert'])->first();
    }

    public function execute()
    {
        $this->dispatch(new UpdateCommanderAlert($this->getCommander(), $this->alert));
    }
}
