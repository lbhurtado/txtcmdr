<?php

namespace App\Campaign\Imports;

use App\App\Facades\TxtCmdr;
use App\Missive\Domain\Models\SMS;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use App\Missive\Jobs\CreateContact;
use App\App\Jobs\ProcessCommand;
use App\Charging\Jobs\ChargeAirtime;


class SMSsImport implements ToCollection, WithHeadingRow
{
    use DispatchesJobs;

    public function collection(Collection $rows)
    {
        foreach ($rows as $i=>$row) {
            $from = $to = $message = null;
            extract($row->toArray());
            $from = (int) filter_var($from, FILTER_SANITIZE_NUMBER_INT);

            if (strlen($from) < 12)
                continue;

            if (! substr($from, 0, 2) == '63')
                continue;

            if (strlen($message) == 0)
                continue;

            try {
                tap(SMS::create(compact('from', 'to', 'message')), function ($sms) {

                    TxtCmdr::setSMS($sms);

                    $this->dispatchNow(new CreateContact($sms));
                    $this->dispatchNow(new ProcessCommand());
//                    $this->dispatch(new ChargeAirtime($sms));
                });
            }
            catch (\Exception $e) {

                var_dump($row);
            }
        }
    }
}
