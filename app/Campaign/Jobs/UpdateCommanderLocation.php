<?php

namespace App\Campaign\Jobs;

use App\GlobeLabs\Services\GlobeConnect;
use Illuminate\Bus\Queueable;
use App\Missive\Domain\Models\Contact;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateCommanderLocation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $service;

    protected $commander;

    public function __construct(Contact $commander)
    {
        $this->commander = $commander;
    }

    public function handle(GlobeConnect $service)
    {
        $params = [
            'token'   => $this->commander->token,
            'address' => $this->commander->mobile,
            'requested_accuracy' => 100,
        ];

        $json = json_decode($service->locate($params), true);

        \Log::info('here');

        optional($json['terminalLocationList']['terminalLocation']['currentLocation'], function ($location) {
            \Log::info($location);
            $longitude = array_get($location, 'longitude');
            $latitude = array_get($location, 'latitude');

           tap($this->commander->checkin($longitude, $latitude), function ($checkin) use ($location) {
               $map_url = array_get($location, 'map_url');
               $timestamp = array_get($location, 'timestamp');
               $checkin->mapUrl = $map_url;
               $checkin->extra_attributes['timestamp'] = $timestamp;
           })->save();
        });
    }
}
