<?php

Route::get('/', function () {
    return view('welcome');
});

Route::match(['get', 'post'], 'webhook/telerivet/airtime', 'TelerivetAirtimeController@handle');
Route::match(['get', 'post'], 'webhook/engagespark/sms', 'EngageSparkSMSController@handle');
Route::match(['get', 'post'], 'webhook/engagespark/airtime', 'EngageSparkAirtimeController@handle');
