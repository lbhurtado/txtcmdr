<?php

use Illuminate\Database\Seeder;
use App\Charging\Domain\Models\Airtime;

class AirtimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        DB::table('airtimes')->delete();
        AirTime::create([ 'key' => 'incoming-sms',  'credits' =>    0.005   ]);
        AirTime::create([ 'key' => 'outgoing-sms',  'credits' =>    0.02    ]);
        AirTime::create([ 'key' => 'lbs',           'credits' =>    0.05    ]);
        AirTime::create([ 'key' => 'load-10',       'credits' =>    0.27    ]);
        AirTime::create([ 'key' => 'load-25',       'credits' =>    0.61    ]);
    }
}
