<?php

class Booking
{
    public $doj, $startdate, $enddate;
	public $trip_id, $penjadwalan_id;
	public $source_name;
	public $destination_name;
    public $route_id = null;
    public $armada_ke = null;
    public $sdm_id, $type_date;
    public $is_export = false;
    public $source_id = null, $destination_id = null;
    public $search_type;
    public $arrTujuan = [];

    public function seatmap()
    {
        $data = [];
        if (!isset($this->doj, $this->route_id, $this->armada_ke)){
			return $data;
		}

        $res = ApiHelper::getInstance()->callUrl([
            'url' => 'api/v1/kiosk/seatmap',
            'parameter' => [
                'method' => 'POST',
                'postfields' => [
					'route_id' => $this->route_id,
					'trip_id' => $this->trip_id,
                    'armada_ke' => $this->armada_ke,
                    'startdate' => $this->doj,
                    'penjadwalan_id' => $this->penjadwalan_id,
                    'search_type' => $this->search_type,
                    'source_name' => $this->source_name,
                    'destination_name' => $this->destination_name
					]
            ]
        ]);

        // Helper::getInstance()->dump($res);
        return $res;
    }

    private static $instance;

    public static function object()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

}
