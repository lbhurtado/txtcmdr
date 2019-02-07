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
        DB::table('airtimes')->delete();
        AirTime::create([ 'key' => 'sms',      'credits' =>    1 ]);
        AirTime::create([ 'key' => 'lbs',      'credits' =>  2.5 ]);
        AirTime::create([ 'key' => 'load-10',  'credits' =>   10 ]);
        AirTime::create([ 'key' => 'load-20',  'credits' =>   20 ]);
        AirTime::create([ 'key' => 'load-50',  'credits' =>   50 ]);
        AirTime::create([ 'key' => 'load-100', 'credits' =>  100 ]);
        AirTime::create([ 'key' => 'load-500', 'credits' =>  500 ]);
        AirTime::create([ 'key' => 'load-1000','credits' => 1000 ]);
    }
}
