<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Campaign\Domain\Models\Tag;
use App\Campaign\Domain\Models\Area;
use App\Campaign\Domain\Models\Group;
use App\Campaign\Domain\Models\Campaign;
use App\Missive\Domain\Models\Contact;
// use Tests\TextCommanderCase as TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

use Illuminate\Support\Arr;
use App\Campaign\Jobs\CreateCommanderGroupArea;
use App\Missive\Jobs\UpdateContact;

class HernandezSimulationTest extends TestCase
{
    function setup(): void
    {
        parent::setUp();

        // Area::build('2nd District of Laguna.Bay.San Agustin.CP1.0001A');
        // Area::build('2nd District of Laguna.Bay.San Agustin.CP1.0001B');
        // Area::build('2nd District of Laguna.Bay.San Agustin.CP1.0002A');
        // Area::build('2nd District of Laguna.Bay.San Agustin.CP1.0002B');
        // Area::build('2nd District of Laguna.Bay.San Agustin.CP2.0003A');
        // Area::build('2nd District of Laguna.Bay.San Agustin.CP2.0003B');
        // Area::build('2nd District of Laguna.Bay.San Agustin.CP2.0004A');
        // Area::build('2nd District of Laguna.Bay.San Agustin.CP2.0004B');

        // Group::build('HQ.Core');
        // Group::build('HQ.Volunteers');
        // Group::build('HQ.Recruits');

        Contact::create(['mobile' => '+639179205299', 'handle' => 'Edward Inzon']);

        // Campaign::create(['name' => 'registration', 'message' => 'Welcome! - Ruth Hernandez']);
        
    }

    /** @test */
    function commander_can_register_using_id()
    {
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load("volunteers.xlsx");
        
        $worksheet = $spreadsheet->getActiveSheet();
        $highestRow = $worksheet->getHighestRow();
        $highestColumn = $worksheet->getHighestColumn();
        $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn); // e.g. 5

        $array = $worksheet->rangeToArray("A2:{$highestColumn}{$highestColumnIndex}");
        $needle = '111111';
        $key = array_search($needle, array_column($array, 0));

        $record = $key !== false ? $array[$key] : [];

        var_dump($record);
                
        $mobile = $this->faker->mobileNumber;
        $handle = $record[1];

        var_dump($mobile);
        var_dump($handle);
        // (new CreateCommanderGroupArea($mobile, $handle))->handle(app(\App\Missive\Domain\Repositories\ContactRepository::class));
        // (new UpdateContact($this->commander, $handle))->handle();

// echo '<table>' . "\n";
// for ($row = 1; $row <= $highestRow; ++$row) {
//     echo '<tr>' . PHP_EOL;
//     for ($col = 1; $col <= $highestColumnIndex; ++$col) {
//         $value = $worksheet->getCellByColumnAndRow($col, $row)->getValue();
//         echo '<td>' . $value . '</td>' . PHP_EOL;
//     }
//     echo '</tr>' . PHP_EOL;
// }
// echo '</table>' . PHP_EOL;

        $this->assertEquals($spreadsheet->getActiveSheet()->getCellByColumnAndRow(1, 1)->getValue(), 'ID');
        $this->assertEquals($spreadsheet->getActiveSheet()->getCell('B1'), 'NAME');

        // $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Xlsx");
        // $writer->save("05featuredemo.xlsx");

        // $spreadsheet = new Spreadsheet();
        // $sheet = $spreadsheet->getActiveSheet();
        // $sheet->setCellValue('A1', 'Id');
        // $sheet->setCellValue('B1', 'Name');
        // $sheet->setCellValue('C1', 'Age');
        // $sheet->setCellValue('D1', 'Skills');
        // $sheet->setCellValue('E1', 'Address');
        // $sheet->setCellValue('F1', 'Designation');

        // $writer = new Xlsx($spreadsheet);
        // $writer->save("testxxx");
        // $tag = Tag::create(['code' => 'RUTH 123']);
    }

}
