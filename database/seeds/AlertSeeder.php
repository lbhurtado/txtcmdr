<?php

use Illuminate\Database\Seeder;
use App\Campaign\Domain\Models\Alert;

class AlertSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Alert::create(['name' => 'green']);
        Alert::create(['name' => 'yellow']);
        Alert::create(['name' => 'red']);
    }
}
