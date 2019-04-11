<?php

namespace App\Campaign\Imports;

use App\Campaign\Domain\Models\Lead;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class LeadsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Lead([
            'name' => $row['name'],
            'code' => $row['id'],
            'extra_attributes' => [
                'area' => $row['area'],
                'group' => $row['group'],
                'id' => $row['id'],
            ],
        ]);
    }
}
