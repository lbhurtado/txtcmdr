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
        
 		$this->from = $this->getOrigin($data);
 		$this->to = $this->getDestination($data);
 		$this->message = $this->getMessage($data);
    }

    public function getProperties():array
    {
    	return [
    		'from' => $this->from,
    		'to' => $this->to,
    		'message' => $this->message,
    	];
    }

    protected function getOrigin($data)
    {
        $senderAddress = wstring::from($data['senderAddress'])->replace('tel:', '');

        return PhoneNumber::make($senderAddress)->ofCountry('PH')->formatE164();
    }

    protected function getDestination($data)
    {
        return wstring::from($data['destinationAddress'])->replace('tel:', '');
    }

    protected function getMessage($data)
    {
        return $data['message'];
    }
}
