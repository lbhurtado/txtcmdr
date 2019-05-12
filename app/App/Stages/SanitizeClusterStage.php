<?php

namespace App\App\Stages;

use Illuminate\Support\Arr;
use App\Campaign\Domain\Repositories\AreaRepository;

class SanitizeClusterStage extends BaseStage
{
    protected $cluster;

    protected function enabled()
    {
        return $this->cluster = trim(Arr::get($this->getParameters(), 'cluster'));
    }

    public function execute()
    {
        Arr::set($this->parameters, 'models.poll_area', $this->getSanitizedClusteredPrecinct());
    }

    protected function getSanitizedClusteredPrecinct()
    {
        $clusterCode = $this->getClusteredPrecinctCode();

        return app(AreaRepository::class)->getSanitizedModel($clusterCode);
    }

    protected function getClusteredPrecinctCode()
    {
        $code = $this->getCode($this->getCommander()->area->name) ?? $this->halt();

        return $code.'-'.$this->cluster;
    }

    protected function getCode($name)
    {
        $retval = null;

        switch ($name)
        {
            case 'CABUYAO CITY':
                $retval = 'CAB';
                break;
            case 'LOS BANOS':
                $retval = 'LB';
                break;
            case 'BAY':
                $retval = 'BAY';
                break;
        }

        return $retval;
    }
}
