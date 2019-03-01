<?php

use Maatwebsite\Excel\Facades\Excel;
use App\Campaign\Exports\AreaContactsExport;


Route::get('/', function () {
    return view('welcome');
});

Route::match(['get', 'post'], 'webhook/telerivet/airtime', 'TelerivetAirtimeController@handle');
Route::match(['get', 'post'], 'webhook/engagespark/sms', 'EngageSparkSMSController@handle');
Route::match(['get', 'post'], 'webhook/engagespark/airtime', 'EngageSparkAirtimeController@handle');

Route::get('/exports/area-contacts', function() {
    return Excel::download(new AreaContactsExport, 'area-contacts.xlsx');
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
            ->addSelect('precincts.name as precinct')
            ->addSelect('barangays.name as barangay')
            ->addSelect('towns.name as town')
            ->addSelect('districts.name as district')
            ->addSelect('categories.name as category')
            ->addSelect('issues.name as issue')
            ->addSelect('area_issue.qty as votes')
            ->join('issues', 'issues.id', '=', 'area_issue.issue_id')
            ->join('categories', 'categories.id', '=', 'issues.category_id')
            ->join('areas as precincts', 'precincts.id', '=', 'area_issue.area_id')
            ->join('areas as barangays', 'barangays.id', '=', 'precincts.parent_id')
            ->join('areas as towns', 'towns.id', '=', 'barangays.parent_id')
            ->join('areas as districts', 'districts.id', '=', 'towns.parent_id')
            ->orderBy('precinct')
            ->get();
});

Route::get('/poll4', function() {
    return
        DB::table('area_issue')
            ->addSelect('barangays.name as barangay')
//            ->addSelect('district.name as district')
            ->addSelect('categories.name as category')
            ->addSelect('issues.name as issue')
            ->selectRaw('sum(area_issue.qty) as votes')
            ->join('issues', 'issues.id', '=', 'area_issue.issue_id')
            ->join('categories', 'categories.id', '=', 'issues.category_id')
            ->join('areas as precincts', 'precincts.id', '=', 'area_issue.area_id')
            ->join('areas as barangays', 'barangays.id', '=', 'precincts.parent_id')
            ->join('areas as towns', 'towns.id', '=', 'barangays.parent_id')
            ->join('areas as districts', 'districts.id', '=', 'towns.parent_id')
            ->groupBy('barangay', 'category', 'issue')
            ->orderByRaw('barangays.id, categories.id, issue', 'qty desc')
            ->get();
});

