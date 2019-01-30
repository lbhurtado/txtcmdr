<?php

namespace App\Missive\Domain\Services\Commands;

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
        $address = $data['senderAddress'];
        $mobile = str_ireplace('tel:', '', $address);

        return PhoneNumber::make($mobile)->ofCountry('PH')->formatE164();
    }

    protected function getDestination($data)
    {
        $address = $data['destinationAddress'];

        return str_ireplace('tel:', '', $address);
    }

    protected function getMessage($data)
    {
        return $data['message'];
    }
}
