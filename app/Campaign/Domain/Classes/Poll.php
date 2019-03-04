<?php

namespace App\Campaign\Domain\Classes;

use DB;

class Poll
{
    public static function report_precinct()
    {
        return DB::table('area_issue')
            ->selectRaw("concat_ws(', ', `precincts`.`name`, `towns`.`name`, `districts`.`name`) as precinct")
            ->addSelect('categories.name as position')
            ->addSelect('issues.code as candidate')
            ->selectRaw('sum(`area_issue`.`qty`) as `votes`')
            ->join('issues', 'issues.id', '=', 'area_issue.issue_id')
            ->join('categories', 'categories.id', '=', 'issues.category_id')
            ->join('areas as precincts', 'precincts.id', '=', 'area_issue.area_id')
            ->join('areas as barangays', 'barangays.id', '=', 'precincts.parent_id')
            ->join('areas as towns', 'towns.id', '=', 'barangays.parent_id')
            ->join('areas as districts', 'districts.id', '=', 'towns.parent_id')
            ->whereIn('categories.id', [1, 2, 3])
            ->groupBy('precinct', 'position', 'candidate')
            ->orderByRaw('`precinct`, `categories`.`id`, `votes` desc')
            ->get();
    }

    public static function report_barangay()
    {
        return DB::table('area_issue')
            ->selectRaw("concat_ws(', ', `barangays`.`name`, `towns`.`name`, `districts`.`name`) as barangay")
            ->addSelect('categories.name as position')
            ->addSelect('issues.code as candidate')
            ->selectRaw('sum(`area_issue`.`qty`) as `votes`')
            ->join('issues', 'issues.id', '=', 'area_issue.issue_id')
            ->join('categories', 'categories.id', '=', 'issues.category_id')
            ->join('areas as precincts', 'precincts.id', '=', 'area_issue.area_id')
            ->join('areas as barangays', 'barangays.id', '=', 'precincts.parent_id')
            ->join('areas as towns', 'towns.id', '=', 'barangays.parent_id')
            ->join('areas as districts', 'districts.id', '=', 'towns.parent_id')
            ->whereIn('categories.id', [1, 2, 3])
            ->groupBy('barangay', 'position', 'candidate')
            ->orderByRaw('`barangay`, `categories`.`id`, `votes` desc')
            ->get();
    }

    public static function report_town()
    {
        return DB::table('area_issue')
            ->selectRaw("concat_ws(', ', `towns`.`name`, `districts`.`name`) as town")
            ->addSelect('categories.name as position')
            ->addSelect('issues.code as candidate')
            ->selectRaw('sum(`area_issue`.`qty`) as `votes`')
            ->join('issues', 'issues.id', '=', 'area_issue.issue_id')
            ->join('categories', 'categories.id', '=', 'issues.category_id')
            ->join('areas as precincts', 'precincts.id', '=', 'area_issue.area_id')
            ->join('areas as barangays', 'barangays.id', '=', 'precincts.parent_id')
            ->join('areas as towns', 'towns.id', '=', 'barangays.parent_id')
            ->join('areas as districts', 'districts.id', '=', 'towns.parent_id')
            ->whereIn('categories.id', [1, 2, 3])
            ->groupBy('town', 'position', 'candidate')
            ->orderByRaw('`town`, `categories`.`id`, `votes` desc')
            ->get();
    }

    public static function report_district()
    {
        return
            DB::table('area_issue')
                ->selectRaw("concat_ws(', ', `districts`.`name`) as district")
                ->addSelect('categories.name as position')
                ->addSelect('issues.code as candidate')
                ->selectRaw('sum(`area_issue`.`qty`) as `votes`')
                ->join('issues', 'issues.id', '=', 'area_issue.issue_id')
                ->join('categories', 'categories.id', '=', 'issues.category_id')
                ->join('areas as precincts', 'precincts.id', '=', 'area_issue.area_id')
                ->join('areas as barangays', 'barangays.id', '=', 'precincts.parent_id')
                ->join('areas as towns', 'towns.id', '=', 'barangays.parent_id')
                ->join('areas as districts', 'districts.id', '=', 'towns.parent_id')
                ->whereIn('categories.id', [1])
                ->groupBy('district', 'position', 'candidate')
                ->orderByRaw('`district`, `categories`.`id`, `votes` desc')
                ->get();
    }
}
