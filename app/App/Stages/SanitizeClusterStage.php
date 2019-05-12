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
        Arr::set($this->parameters, 'models.old_area', $this->getCommander()->area);
        Arr::set($this->parameters, 'models.area', $this->getSanitizedClusteredPrecinct());
    }

    protected function getSanitizedClusteredPrecinct()
    {
        $clusterCode = $this->getClusteredPrecinctCode();

        return app(AreaRepository::class)->getSanitizedModel($clusterCode);
    }

    protected function getClusteredPrecinctCode()
    {
        $code = $this->getCode($this->getCommander()->area->name);

        return $code.'-'.$this->cluster;
    }

    protected function getCode($name)
    {
        $retval = 'NA';

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
