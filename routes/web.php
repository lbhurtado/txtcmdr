<?php

use Maatwebsite\Excel\Facades\Excel;
use App\Campaign\Exports\ContactsExport;


Route::get('/', function () {
    return view('welcome');
});

Route::match(['get', 'post'], 'webhook/telerivet/airtime', 'TelerivetAirtimeController@handle');
Route::match(['get', 'post'], 'webhook/engagespark/sms', 'EngageSparkSMSController@handle');
Route::match(['get', 'post'], 'webhook/engagespark/airtime', 'EngageSparkAirtimeController@handle');

Route::get('/exports/contacts', function() {
    return Excel::download(new ContactsExport, 'contacts.xlsx');
});
