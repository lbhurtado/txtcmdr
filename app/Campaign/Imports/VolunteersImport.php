<?php

namespace App\Campaign\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Missive\Domain\Models\Contact;
use Illuminate\Support\Str;
use App\Campaign\Domain\Models\{Area, Group};

class VolunteersImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {

        $hq1 = Contact::where('mobile', '+639954705290')->first();
        $hq2 = Contact::where('mobile', '+639612526279')->first();

        foreach ($rows as $i=>$row) {
            $province = $citymun = $barangay = $precinct = $clustered_precinct = null;
            $name = $smv_position = $smv_id_no = $registered_phone_no = null;

            extract($row->toArray());

            $mobile = (int) filter_var($registered_phone_no, FILTER_SANITIZE_NUMBER_INT);
            if (strlen($mobile) < 12)
                continue;

            if (! substr($mobile, 0, 2) == '63')
                continue;

            $mobile = '+' . $mobile;
            if (strlen($mobile) == 0)
                continue;

            $handle = filter_var($name, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
            $handle = Str::title($handle);

            $group_name = "HQ.".filter_var($smv_position, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
            Group::build($group_name);
            $group = Group::dig($group_name);

            $area_name = "{$province}.{$citymun}.{$barangay}.{$this->getCode($citymun)}-{$this->getNumber($clustered_precinct)}";
            Area::build($area_name);
            $area = Area::dig($area_name);

            try {
                if ($group->name == 'CORE')
                    $contact = Contact::create(compact('mobile', 'handle'), $hq1);
                else
                    $contact = Contact::create(compact('mobile', 'handle'), $hq2);

                $contact->syncGroups($group);
                $contact->syncAreas($area);
                $contact->extra_attributes['precinct'] = $precinct;
                $contact->save();
            }
            catch (\Exception $e) {

                var_dump($row);
            }
        }
    }

    protected function getCode($name)
    {
        $retval = 'NA';

        switch ($name)
        {
            case 'CABUYAO CITY':
                $retval = 'CAB';
                break;
            case 'LOS BANOS':
                $retval = 'LB';
                break;
            case 'BAY':
                $retval = 'BAY';
                break;
        }

        return $retval;
    }

    protected function getNumber($name)
    {
        return (int) filter_var($name, FILTER_SANITIZE_NUMBER_INT);
    }
}
