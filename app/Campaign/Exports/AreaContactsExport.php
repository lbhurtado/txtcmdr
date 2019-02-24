<?php

namespace App\Campaign\Exports;

use App\Missive\Domain\Models\Contact;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use App\Campaign\Domain\Models\Area;
use App\Campaign\Domain\Models\Issue;

class AreaContactsExport implements FromCollection, Responsable, WithHeadings, ShouldAutoSize
{
    use Exportable;

    protected $data;

    protected $basic_headings = [
        'District',
        'Municipality',
        'Barangay',
        'Precinct',
        'Upline',
        'Member',
        'Status',
    ];


    public $fileName = 'area-contacts.xlsx';

    public function collection()
    {
        $array = [
            [
                'name' => 'Lester'
            ],
            [
                'name' => 'Dene'
            ],
        ];
//        dd(collect($array));

//        $collection = Area::defaultOrder()->get()->toTree();
//
//        $xx = $collection->map(function ($item, $key) {
//            return ['district' => $item->name];
//        });


//        dd($xx);

        $this->process();
        return $this->data;
    }

    public function headings(): array
    {
//        return [
//            'District',
//            'Municipality',
//            'Barangay',
//            'Precinct',
//            'Upline',
//            'Member',
//            'Status',
//        ];

        $issue_headings = [];

        Issue::get()->each(function ($issue) use (&$issue_headings) {
            $issue_headings[] = $issue->code;
        });

        return array_merge($this->basic_headings, $issue_headings);
    }

    protected function process()
    {
        $array = [];

        $level = [
            '-' => 'District',
            '--' => 'Municipality',
            '---' => 'Barangay',
            '----' => 'Precinct',
        ];

        $nodes = Area::get()->toTree();

        $traverse = function ($areas, $prefix = '-') use (&$traverse, &$array, $level) {
            foreach ($areas as $area) {
//                echo PHP_EOL.$prefix.' '.$area->name;

                $ar = [
                    'District' => '',
                    'Municipality' => '',
                    'Barangay' => '',
                    'Precinct' => '',
                    'Upline' => '',
                    'Member' => '',
                    'Status' => '',
                ];

                $ar[$level[$prefix]] = $area->name;

                $array[] = $ar;

                $area->contacts->each(function ($contact) use (&$array) {
                    $ar = [
                        'District' => '',
                        'Municipality' => '',
                        'Barangay' => '',
                        'Precinct' => '',
                        'Upline' => optional($contact->parent)->mobileHandle ?? '',
                        'Member' => $contact->mobileHandle,
                        'Status' => $contact->status(),
                    ];

                    $ir = [];

                    $contact->issues()->get()->each(function ($issue) use (&$ir) {
                        $ir[$issue->code] = $issue->pivot->qty;
                    });


                    $array [] = array_merge($ar, $ir);
                });


                $traverse($area->children, $prefix.'-');
            }
        };

        $traverse($nodes);

//        dd($array);
        $this->data = collect($array);
    }
}
