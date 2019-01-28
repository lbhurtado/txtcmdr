<?php

namespace App\Missive\Domain\Services\Commands;

use Opis\String\UnicodeString as wstring;
use Propaganistas\LaravelPhone\PhoneNumber;
use App\App\CommandBus\Contracts\CommandInterface;

class CreateGlobeSMSCommand implements CommandInterface
{
	public $from;

	public $to;

	public $message;

    public function __construct($inboundSMSMessageList)
    {
        $data = $inboundSMSMessageList['inboundSMSMessage'][0];
 		$this->from = PhoneNumber::make(wstring::from($data['senderAddress'])->replace('tel:', ''))->ofCountry('PH')->formatE164();
 		$this->to = wstring::from($data['destinationAddress'])->replace('tel:', '');
 		$this->message = $data['message'];
    }

    public function getProperties():array
    {
    	return [
    		'from' => $this->from,
    		'to' => $this->to,
    		'message' => $this->message,
    	];
    }
}
