<?php

use Illuminate\Database\Seeder;
use App\Campaign\Domain\Models\Group;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Group::build('hq.personnel');
        Group::build('hq.intelligence');
        Group::build('hq.operations');
        Group::build('hq.logistics');
        Group::build('hq.liasons');
        Group::build('hq.comptroller');
        Group::build('hq.security');
        Group::build('hq.training');  
    }
}
