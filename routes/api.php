<?php

use Illuminate\Http\Request;

Route::post('webhook/sms', App\Missive\Actions\CreateSMSAction::class);
Route::post('webhook/sms/globe', App\Missive\Actions\CreateGlobeSMSAction::class);