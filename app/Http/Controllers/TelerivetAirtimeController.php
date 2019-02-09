<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TelerivetAirtimeController extends Controller
{
    public function handle(Request $request)
    {
        \Log::info($request);

        return response(env('APP_NAME'), 200);

        //need to check if csrf is disabled in this route
        if ($request->secret == env('TELERIVET_WEBHOOK_SECRET')) {
            switch ($request->event) {
                case 'default':
                    $this->persistAirTimeTransfer($request);

                    return response(env('APP_NAME'), 200);
                default:
                    # code...
                    break;
            }
        }

        return response(env('APP_NAME'), 401);
    }
}
