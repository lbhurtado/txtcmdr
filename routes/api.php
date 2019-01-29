<?php

use Illuminate\Http\Request;

Route::post('webhook/sms', App\Missive\Actions\CreateSMSAction::class);

Route::match(['get', 'post'], 'webhook/redirect/globe', App\Missive\Actions\CreateGlobeRedirectAction::class);

Route::post('webhook/sms/globe', App\Missive\Actions\CreateGlobeSMSAction::class);