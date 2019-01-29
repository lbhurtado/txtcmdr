<?php

namespace App\Missive\Domain\Services\Commands;

use Opis\String\UnicodeString as wstring;
use Propaganistas\LaravelPhone\PhoneNumber;
use App\App\CommandBus\Contracts\CommandInterface;

class CreateContactFromGlobeRedirectCommand implements CommandInterface
{
	public $subscriber_number;

	public $access_token;

    public function __construct($access_token, $subscriber_number)
    {
        $this->access_token = $access_token;
 		$this->subscriber_number = $this->getSubscriberNumber($subscriber_number);
    }

    public function getProperties():array
    {
    	return [
            'access_token' => $this->access_token,
    		'subscriber_number' => $this->subscriber_number,
    	];
    }

    protected function getSubscriberNumber($data)
    {
        $cleanData = wstring::from($data)->replace('tel:', '');

        return PhoneNumber::make($cleanData)->ofCountry('PH')->formatE164();
    }
}
