<?php

namespace App\Campaign\Imports;

use App\Campaign\Domain\Models\Area;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class AreasImport implements ToCollection
{
    protected $last_attribs = [];

    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            $ar = [];
            $pointer = 0;

//            $columns_count = sizeOf($row);
            $columns_count = 5;

            for ($i = 0; $i <= $columns_count-1; $i++) {
                $ar[$i] = $row[$i] ?? null;
                $pointer = !empty($row[$i]) ? $i : $pointer;
            }

            array_splice($this->last_attribs, $pointer+1);

            for ($i = 0; $i <= sizeOf($this->last_attribs)-1; $i++) {
                $ar[$i] = $ar[$i] ?? $this->last_attribs[$i];
            }

            $node = $this->getNodeFromArray($ar);

            Area::build($node);

            $area = Area::dig($node);

            $area->extra_attributes['registered_voters'] = $row[$columns_count];
            $area->save();
            $area->parent->extra_attributes['polling_place'] = $row[$columns_count+1];
            $area->parent->extra_attributes['polling_address'] = $row[$columns_count+1+1];
            $area->parent->save();
//            dd($area);

            for ($i = 0; $i <= sizeOf($ar)-1; $i++) {
                optional($ar[$i], function ($value) use ($i) {
                    $this->last_attribs[$i] = $value;
                });
            }
        }
    }

    protected function getNodeFromArray($array)
    {
        return implode('.', array_filter($array));
    }
}
