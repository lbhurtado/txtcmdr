<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Campaign\Domain\Classes\Poll;
use Illuminate\Support\Facades\Response;

class PollController extends Controller
{
    public function poll_precinct()
    {
        $report = Poll::report_precinct()->groupBy(['precinct', 'position']);

        return Response::view('txtcmdr.poll.test', ['areas' => $report])->header('Content-Type', 'text/plain');
    }

    public function poll_barangay()
    {
        $report = Poll::report_barangay()->groupBy(['barangay', 'position']);

        return Response::view('txtcmdr.poll.test', ['areas' => $report])->header('Content-Type', 'text/plain');
    }

    public function poll_town()
    {
        $report = Poll::report_town()->groupBy(['town', 'position']);

        return Response::view('txtcmdr.poll.test', ['areas' => $report])->header('Content-Type', 'text/plain');
    }

    public function poll_district()
    {
        $report = Poll::report_district()->groupBy(['district', 'position']);

        return Response::view('txtcmdr.poll.test', ['areas' => $report])->header('Content-Type', 'text/plain');
    }
}
