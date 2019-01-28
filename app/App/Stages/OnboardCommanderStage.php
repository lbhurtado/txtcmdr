<?php

namespace App\App\Stages;

use Globe\Connect\Oauth;
use Globe\Connect\Sms;

class OnboardCommanderStage  extends BaseStage
{
    public function execute()
    {
    	\Log::info('OnboardCommanderStage::execute');
    	$globe = '21582402';
    	$smart = '29290582402';

    	$app_id = 'jXeXUqMxGEu67Te958ixxzu8oX5KU4ad';
    	$app_secret = '37632fe0b295486ed8c8efca6';

    	$oauth = new Oauth($app_id, $app_secret);

    	// \Log::info('start');
    	// \Log::info($oauth->getRedirectUrl());
    	// \Log::info('end');

    	//LBH
    	//9173011987
    	//HjvtzaRUyDDUANLR3bvcpqLeWQG_WpXsq7PJaxArctI
    	//CIS
    	//9166033598
    	//wYe8ubCzFWZWKEZOXQ6rozwV9h8h_Hj47v3D4fOezKg

    	// $oauth->setCode("[code]");
    	// \Log::info($oauth->getAccessToken());
    	
		$sms = new Sms("21582402", "HjvtzaRUyDDUANLR3bvcpqLeWQG_WpXsq7PJaxArctI");

		$sms->setReceiverAddress("9173011987");
		$sms->setMessage("test");
		// $sms->setClientCorrelator("[correlator]");
		echo $sms->sendMessage();

    }
}