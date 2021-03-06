<?php

use Maatwebsite\Excel\Facades\Excel;
use App\Campaign\Exports\{AreasExport, AreaContactsExport};
use App\Exports\WatchersReportExport;

Route::get('/', function () {
    return view('welcome');
});

Route::match(['get', 'post'], 'webhook/telerivet/airtime', 'TelerivetAirtimeController@handle');
Route::match(['get', 'post'], 'webhook/engagespark/sms', 'EngageSparkSMSController@handle');
Route::match(['get', 'post'], 'webhook/engagespark/airtime', 'EngageSparkAirtimeController@handle');

Route::get('/exports/area-contacts', function() {
    return Excel::download(new AreaContactsExport, 'area-contacts.xlsx');
});

Route::get('/exports/areas', function() {
    return Excel::download(new AreasExport, 'areas.xlsx');
});

Route::get('/poll', function() {
    return \App\Campaign\Domain\Models\AreaIssue::all()->groupBy('issue_id')->map(function ($item) {
        return $item->sum('qty');
    });
});

Route::get('/poll2', function() {
    return \App\Campaign\Domain\Models\AreaIssue::with(['issue','area'])->get()->groupBy(['issue.name', 'area.name'])->map(function ($item) {
        return $item->select('area');
    });
});

Route::get('/poll3', function() {
    return
        DB::table('area_issue')
            ->selectRaw("concat_ws(', ', `precincts`.`name`, `barangays`.`name`, `towns`.`name`, `districts`.`name`) as precinct")
            ->addSelect('categories.name as position')
            ->addSelect('issues.name as candidate')
            ->addSelect('area_issue.qty as votes')
            ->join('issues', 'issues.id', '=', 'area_issue.issue_id')
            ->join('categories', 'categories.id', '=', 'issues.category_id')
            ->join('areas as precincts', 'precincts.id', '=', 'area_issue.area_id')
            ->join('areas as barangays', 'barangays.id', '=', 'precincts.parent_id')
            ->join('areas as towns', 'towns.id', '=', 'barangays.parent_id')
            ->join('areas as districts', 'districts.id', '=', 'towns.parent_id')
            ->whereIn('categories.id', [1, 2, 3])
            ->orderBy('precincts.id')
            ->get();
});

Route::get('/poll4', function() {
    return
        DB::table('area_issue')
            ->selectRaw("concat_ws(', ', `barangays`.`name`, `towns`.`name`, `districts`.`name`) as barangay")
            ->addSelect('categories.name as position')
            ->addSelect('issues.name as candidate')
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
});

Route::get('/report/{area}', 'PollController@poll_area');

Route::get('/export/watchers', function() {
    return Excel::download(new WatchersReportExport, 'watchers.xlsx');
});
