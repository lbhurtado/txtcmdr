<?php

use Illuminate\Database\Seeder;
use App\Campaign\Imports\SMSsImport;

class SMSSeeder extends Seeder
{
    protected $spreadsheet = 'spreadsheets/s_m_s_s.xlsx';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Excel::import(new SMSsImport, database_path($this->spreadsheet));
    }
}
