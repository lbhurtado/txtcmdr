<?php

namespace App\Telerivet\Services;

use Telerivet_API;

class Telerivet
{
    private $api;

    private $project;

    private $service;

    public function __construct(Telerivet_API $api)
    {
        $this->api = $api;
    }

    public function setProject($project_id)
    {
        $this->project = $this->api->initProjectById($project_id);
    }

    public function getProject()
    {
        return $this->project;
    }

    public function setService($service_id)
    {
        $this->service = $this->getProject()->initServiceById($service_id);

        return $this;
    }

    public function getService()
    {
        return $this->service;
    }
}