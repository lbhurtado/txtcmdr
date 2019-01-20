<?php

use Illuminate\Http\Request;

Route::post('webhook/sms', App\Missive\Actions\CreateSMSAction::class);
