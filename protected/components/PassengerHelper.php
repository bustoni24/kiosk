<?php
class PassengerHelper {

    public function listSeatLayout($post = [])
    {
        $result = new Returner;
        $result->put('log', 'INIT booking');
        $data = [];
        if (!isset($post['startdate'], $post['user_id'], $post['role'])){
            $result->put('errorMessage', 'Silahkan pilih Tujuan Anda dengan tepat');
            $result->putAdd('log', $result->get('errorMessage'));
            return $result->dumpV2($result->get('errorMessage'), null, 400);
        }
        if ($post['startdate'] <= '2024-04-16' && $post['startdate'] >= '2024-04-04' && (int)Setting::getValue("SETTING_HARGA_LEBARAN", 1) == 1) {
            $result->put('errorMessage', 'Mohon maaf pembelian tiket untuk Lebaran belum tersedia');
            $result->putAdd('log', $result->get('errorMessage'));
            return $result->dumpV2($result->get('errorMessage'), null, 400);
		}
        if (!isset($post['route_id'], $post['armada_ke'], $post['startdate'])) {
            $result->put('errorMessage', 'parameter route_id dan armada_ke tidak valid');
            $result->putAdd('log', $result->get('errorMessage'));
            return $result->dumpV2($result->get('errorMessage'), null, 400);
        }
        if (isset($post['penjadwalan_id'])) {
            $modelPenjadwalan = PenjadwalanJalurBus::model()->findByAttributes([
                'id' => $post['penjadwalan_id']
            ]);
        }
        
        return BookingHelper::getInstance()->tripActive([
            'route_id' => $post['route_id'],
            'armada_ke' => $post['armada_ke'],
            'startdate' => $post['startdate'],
            'tujuan_id' => isset($post['tujuan']) ? $post['tujuan'] : null,
            'kode_booking' => isset($post['kode_booking']) ? $post['kode_booking'] : null,
            'penjadwalan_id' => isset($post['penjadwalan_id']) ? $post['penjadwalan_id'] : null,
            'nomor_lambung' => isset($modelPenjadwalan->no_lambung) ? $modelPenjadwalan->no_lambung : null,
            'trip_label' => isset($post['label_trip']) ? $post['label_trip'] : null,
            'agen_id_asal' => isset($post['agen_id_asal']) ? $post['agen_id_asal'] : null,
            'agen_id_tujuan' => isset($post['agen_id_tujuan']) ? $post['agen_id_tujuan'] : null,
            'data_transit' => isset($post['data_transit']) ? $post['data_transit'] : null,
        ]);
    }

    public function checkUser($post)
    {
        $result = new Returner;
        if (!isset($post['nama'], $post['email'], $post['hp'])) 
            return $result->dumpV2("Invalid parameter", null, 400);

        if (!isset($post['nik']) || empty($post['nik'])) {
            $post['nik'] = 0;
        }

        $checkUser = ApiHelper::getInstance()->callUrl([
            'url' => 'api/v1/kiosk/checkUser',
            'parameter' => [
                'method' => 'POST',
                'postfields' => [
                    'username' => $post['email'],
                    'password' => Helper::getInstance()->hashPassword('password54321'),
                    'password_temp' => 'password54321',
                    'no_hp' => $post['hp'],
                    'instagram' => isset($post['instagram']) ? $post['instagram'] : null,
                    'created_date' => date('Y-m-d H:i:s'),
                    'name' => $post['nama'],
                    'nik' => $post['nik']
                ]
            ]
        ]);
        
        if (!isset($checkUser['data']) || !$checkUser['success']) {
            return $result->dumpV2("Error: " . $checkUser['message'], null, 400);
        }

        $model = (object)$checkUser['data'];

        //proses login
        $login = new LoginFormSystem;
        $login->username = $model->username;
        $login->password = $model->password;
        $login->login();

        $result->put('model', $model);
        return $result->successV2("success");
    }

    private static $instance;

    private function __construct()
    {
        
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}