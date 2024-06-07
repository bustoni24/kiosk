<?php

class ApiHelper {

    public function getUrl()
    {
        if (SERVER_TYPE == "PROD") {
            return "https://efisiensi.id/";
        } else if (SERVER_TYPE == "STG") {
            return "https://efisiensi.web.id/staging/";
        } else {
            return "http://localhost/efisiensi/";
        }
    }

    public function apiKeyGeoLoc()
    {
        return "ef2f7bdbd30e49a4875221a03c487cda";
    }

    public function apiCall($data){
        $result = array('success' => 0);
        if(!isset($data['url'], $data['parameter']['method']))
            return $result;

        $token = "";
        $keyToken = Helper::getInstance()->hashSha256("token");
		$dataToken = Helper::getInstance()->getState($keyToken);
        if (isset($dataToken['token']))
            $token = $dataToken['token'];
            
        if(isset($data['parameter']['postfields']) && $data['parameter']['method'] == "POST"){
            $headers = [
                'Content-Type: application/json',
                'Authorization: ' . $token,
                'cache-control: no-cache',
            ];

            if (SERVER_TYPE == "LOCAL") {
                $headers = [
                    'Content-Type: application/json',
                    'Auth: ' . $token,
                    'cache-control: no-cache',
                ];
            }

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL =>  $this->getUrl() . $data['url'],
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode($data['parameter']['postfields']),
                CURLOPT_HTTPHEADER => $headers,
            ));

            $result = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);

        }else if($data['parameter']['method'] == "GET"){
            $headers = [
                'Authorization: ' . $token,
                'cache-control: no-cache',
            ];

            if (SERVER_TYPE == "LOCAL") {
                $headers = [
                    'Auth: ' . $token,
                    'cache-control: no-cache',
                ];
            }

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL =>$this->getUrl() . $data['url'],
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => $headers,
            ));

            $result = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
        }
        
        if($err)
            return "cURL Error #:" . $err;

        return $result;
    }

    public function callUrl($data) {

        $result = self::apiCall($data);
        if (!isset($result)){
            $result = self::apiCall($data);

            if (!isset($result))
                return null;
        }

        return json_decode($result, true);
    }

    function get_geolocation($apiKey, $ip, $lang = "en", $fields = "*", $excludes = "") {
        $url = "https://api.ipgeolocation.io/ipgeo?apiKey=".$apiKey."&ip=".$ip."&lang=".$lang."&fields=".$fields."&excludes=".$excludes;
        $cURL = curl_init();

        curl_setopt($cURL, CURLOPT_URL, $url);
        curl_setopt($cURL, CURLOPT_HTTPGET, true);
        curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($cURL, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Accept: application/json',
            'User-Agent: '.$_SERVER['HTTP_USER_AGENT']
        ));

        $result = curl_exec($cURL);
        $err = curl_error($cURL);
        curl_close($cURL);

        if($err)
            return "cURL Error #:" . $err;

        return $result;
    }

    public function setTitikId($post)
    {
        return ApiHelper::getInstance()->callUrl([
			'url' => 'api/v1/kiosk/nearestPoint',
			'parameter' => [
				'method' => 'POST',
                'postfields' => $post
			]
		]);
    }

    private static $instance;

    private function __construct()
    {
        // Hide the constructor
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}