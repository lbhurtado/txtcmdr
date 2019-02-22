<?php

namespace App\Campaign\Exports;

use App\User;
use App\Missive\Domain\Models\Contact;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ContactsExport implements FromCollection, Responsable, WithHeadings, ShouldAutoSize
{
    use Exportable;

    public $fileName = 'contacts.xlsx';

    public function collection()
    {
        return Contact::all([
            'mobile',
            'handle',
        ]);
    }

    public function headings(): array
    {
        return [
            'Mobile',
            'Handle',
        ];
    }
}
