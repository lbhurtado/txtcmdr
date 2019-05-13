<?php

use Illuminate\Database\Seeder;

use App\Campaign\Imports\VolunteersImport;

class VolunteerSeeder extends Seeder
{
    protected $spreadsheet = 'spreadsheets/volunteers.xlsx';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Excel::import(new VolunteersImport, database_path($this->spreadsheet));
    }
}
