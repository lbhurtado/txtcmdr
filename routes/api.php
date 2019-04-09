<?php

use Illuminate\Http\Request;

Route::post('webhook/sms', App\Missive\Actions\CreateSMSAction::class);

Route::match(['get', 'post'], 'webhook/redirect/globe', App\Missive\Actions\CreateGlobeRedirectAction::class);

Route::match(['get', 'post'], 'webhook/sms/globe', App\Missive\Actions\CreateGlobeSMSAction::class);

Route::match(['get', 'post'], 'webhook/sms/engagespark-relay', App\Missive\Actions\CreateEngageSparkRelaySMSAction::class);

Route::match(['get', 'post'], 'webhook/sms/telerivet-relay', App\Missive\Actions\CreateTelerivetRelaySMSAction::class);
