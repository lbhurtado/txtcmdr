<?php

use Illuminate\Database\Seeder;
use App\Campaign\Imports\StubsImport;

class StubSeeder extends Seeder
{
    protected $spreadsheet = 'spreadsheets/stubs.xlsx';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Excel::import(new StubsImport, database_path($this->spreadsheet));
    }
}
