<?php
class BookingHelper{

    private function clientSecret()
    {
        if (SERVER_TYPE == "PROD") {
            return "xnd_production_cwuvhAOrVg3m0ujKkvTEQOI2mb3Hfx7t2s9ecCgG9pGPcrXRFBCz1c36yhLpM7n";
        } else if (SERVER_TYPE == "STG") {
            return "xnd_development_5JtI1p6W1AgJm2vVuJ3lbv1TrzXJPoraOaGvL472qGYTQ1N7qVk7Tw5Q9MhUlH";
        } else {
            return "xnd_development_5JtI1p6W1AgJm2vVuJ3lbv1TrzXJPoraOaGvL472qGYTQ1N7qVk7Tw5Q9MhUlH";
        }
    }
    public function createInvoice($post = [])
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.xendit.co/v2/invoices',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>json_encode($post),
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Basic ' . base64_encode($this->clientSecret().':')
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode($response, true);
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