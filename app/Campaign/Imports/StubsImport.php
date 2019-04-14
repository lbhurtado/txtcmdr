<?php

namespace App\Campaign\Imports;

use App\Campaign\Domain\Models\Stub;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StubsImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Stub([
            'code' => $row['code'],
            'extra_attributes' => [
                'area' => $row['area'],
                'group' => $row['group'],
            ],
        ]);
    }
}
