<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EngageSparkAirtimeController extends Controller
{
    //need to check if csrf is disabled in this route
    public function handle(Request $request)
    {
        \Log::info($request);

        return response(env('APP_NAME'), 200);
    }
}
