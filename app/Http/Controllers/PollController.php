<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Response;
use App\Campaign\Domain\Classes\Collections\PollArea;

class PollController extends Controller
{
    public function poll_area($area)
    {
        $report = PollArea::by($area)->groupBy(['area', 'position']);

        return Response::view('txtcmdr.poll.test', ['areas' => $report])->header('Content-Type', 'text/plain');
    }
}
