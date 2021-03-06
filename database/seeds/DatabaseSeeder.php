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
        $this->call(AirtimeSeeder::class);
         $this->call(ContactSeeder::class);
         $this->call(LagunaSeeder::class);
//         $this->call(GroupSeeder::class);
        // $this->call(AreaSeeder::class);
//         $this->call(CampaignSeeder::class);
//        $this->call(AlertSeeder::class);
//        $this->call(CategorySeeder::class);
//        $this->call(IssueSeeder::class);

//        $this->call(LeadSeeder::class);
//        $this->call(StubSeeder::class);
//        $this->call(CabuyaoSeeder::class);
        $this->call(VolunteerSeeder::class);
    }
}
