<?php
/**
 * Created by PhpStorm.
 * User: aph
 * Date: 2019-02-09
 * Time: 17:53
 */

namespace App\Missive\Domain\Services\Commands;

use Propaganistas\LaravelPhone\PhoneNumber;
use App\App\CommandBus\Contracts\CommandInterface;

class CreateEngageSparkSMSCommand implements CommandInterface
{
//    public $secret;

    public $from;

    public $to;

    public $message;

    public function __construct($from, $to, $message)
    {
//        $this->secret = $secret;
        $this->from = $this->getOrigin($from);
        $this->to = $to;
        $this->message = $message;
    }

    public function getProperties():array
    {
        return [
            'from' => $this->from,
            'to' => $this->to,
            'message' => $this->message,
        ];
    }

    protected function getOrigin($mobile)
    {
        return PhoneNumber::make($mobile)->ofCountry('PH')->formatE164();
    }
}
