<?php

Route::get('/', function () {
    return view('welcome');
});

Route::match(['get', 'post'], 'webhook/telerivet/airtime', 'TelerivetAirtimeController@handle');
