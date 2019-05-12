<?php

namespace App\Campaign\Domain\Classes\Collections;

use DB;
use Illuminate\Support\Arr;
use App\Campaign\Domain\Contracts\PollCollection;

abstract class PollArea implements PollCollection
{
    /**
     * @param $area
     * values in [precinct, cluster, barangay, town, district]
     *
     * @return mixed
     */
    public static function by($area)
    {
        return static:: getPollAreaClass($area)->getCollection();
    }

    protected static function getPollAreaClass($area): PollArea
    {
        return app(Arr::get(config('txtcmdr.collections.poll'), $area));
    }

    protected function getCollection()
    {
        return DB::table('area_issue')
            ->selectRaw($this->getSelectField1())
            ->addSelect('categories.name as position')
            ->addSelect('issues.code as candidate')
            ->selectRaw('sum(area_issue.qty) as votes')
            ->join('issues', 'issues.id', '=', 'area_issue.issue_id')
            ->join('categories', 'categories.id', '=', 'issues.category_id')
//            ->join('areas as precincts', 'precincts.id', '=', 'area_issue.area_id')
//            ->join('areas as clusters', 'clusters.id', '=', 'precincts.parent_id')
            ->join('areas as clusters', 'clusters.id', '=', 'area_issue.area_id')
            ->join('areas as barangays', 'barangays.id', '=', 'clusters.parent_id')
            ->join('areas as towns', 'towns.id', '=', 'barangays.parent_id')
            ->join('areas as districts', 'districts.id', '=', 'towns.parent_id')
            ->whereIn('categories.id', $this->getCategoryIds())
            ->groupBy($this->getGroupByField1(), 'categories.id', 'issues.id')
            ->orderByRaw($this->getOrderByField1() . ', categories.id, votes desc')
            ->get();
    }
}
