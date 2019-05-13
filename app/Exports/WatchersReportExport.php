<?php

namespace App\Exports;

use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class WatchersReportExport implements FromCollection, Responsable, WithHeadings, ShouldAutoSize, WithMapping
{
    use Exportable;

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return
            DB::table('area_issue')
            ->selectRaw('towns.name as town')
            ->selectRaw('barangays.name as barangay')
            ->selectRaw('precincts.name as cluster')
            ->addSelect('issues.code as candidate')
            ->addSelect('area_issue.qty as votes')
            ->addSelect('contacts.handle as watcher')
            ->addSelect('contacts.mobile as mobile')
            ->addSelect('area_issue.updated_at as datetime')
            ->join('contacts', 'contacts.id', '=', 'area_issue.contact_id')
            ->join('issues', 'issues.id', '=', 'area_issue.issue_id')
            ->join('categories', 'categories.id', '=', 'issues.category_id')
            ->join('areas as precincts', 'precincts.id', '=', 'area_issue.area_id')
            ->join('areas as barangays', 'barangays.id', '=', 'precincts.parent_id')
            ->join('areas as towns', 'towns.id', '=', 'barangays.parent_id')
            ->join('areas as districts', 'districts.id', '=', 'towns.parent_id')
            ->orderByRaw('precincts.id, categories.id, issues.id')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Town',
            'Barangay',
            'Cluster',
            'Candidate',
            'Votes',
            'Watcher',
            'Mobile',
            'Date Time'
        ];
    }

    public function map($area_issue): array
    {
        return [
            $area_issue->town,
            $area_issue->barangay,
            preg_replace('/[^\d]/i', '', $area_issue->cluster),
            $area_issue->candidate,
            $area_issue->votes,
            $area_issue->watcher,
            $area_issue->mobile,
            $area_issue->datetime
        ];
    }
}
