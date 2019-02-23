<?php

use Illuminate\Database\Seeder;
use App\Campaign\Domain\Models\Issue;

class IssueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Issue::create([ 'code' => 'LEVI', 'name' => 'Levi Baligod']);
        Issue::create([ 'code' => 'BOYING', 'name' => 'Boying Cari']);
    }
}
