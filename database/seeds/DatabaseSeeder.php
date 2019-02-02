<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ContactSeeder::class);
        $this->call(AirtimeSeeder::class);
        $this->call(GroupSeeder::class);
        $this->call(AreaSeeder::class);
        $this->call(CampaignSeeder::class);
        $this->call(AlertSeeder::class);
    }
}
