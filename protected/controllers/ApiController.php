<?php

class ApiController extends Controller
{
	public function actionRequestToken()
	{
		$result = new Returner;
		$keyToken = Helper::getInstance()->hashSha256("token");
		if (empty(Helper::getInstance()->getState($keyToken))) {
			//call token
			$token = ApiHelper::getInstance()->callUrl([
				'url' => 'api/v1/kiosk/token',
				'parameter' => [
					'method' => 'POST',
					'postfields' => [
						'username' => 'kiosk',
						'password' => 'kioskEfisiens1'
					]
				]
			]);
			if (!isset($token['data']['access_token'], $token['data']['token_type'])){
				$res = $result->dump("Invalid Token :: " . (isset($token['message']) ? $token['message'] : '-'));
				doPrintResult($res);
			}
			//set state
			Helper::getInstance()->setState($keyToken, $token['data']['token_type'] . " " . $token['data']['access_token']);
			$res = $result->successV2("success");
			doPrintResult($res);
		}
		
		$res = $result->successV2("success");
		doPrintResult($res);
	}

	public function actionSetTitikId()
	{
		$res = ApiHelper::getInstance()->setTitikId($_POST);
		doPrintResult($res);
	}
}