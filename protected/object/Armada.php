<?php

class Armada
{
	public $startdate, $enddate, $filter = null, $get = null;
	public $id_trip,$group,$kelas,$groupId,$armadaId;
    public $source_id = null, $destination_id = null;
    public $source_name,$destination_name,$search_type;
    public $return = 0;

    public function searchListBus($search_type = Constant::SEARCH_BOARDING)
    {
        $data = [];
        if (!isset($this->startdate) || empty($this->startdate)){
			return new CArrayDataProvider($data, array(
				'keyField' => 'id',
				'pagination' => array(
					'pageSize' => count($data),
					),
				));	
		}
        $startdate = $this->startdate;
        $enddate = $this->enddate;
        $source_id_ori = $this->source_id;
        $destination_id_ori = $this->destination_id;
        switch ($search_type) {
            case Constant::SEARCH_DROP_OFF:
                $this->startdate = $enddate;
                $this->source_id = $destination_id_ori;
                $this->destination_id = $source_id_ori;
                $boarding_name = $this->source_name;
                $drop_off_name = $this->destination_name;
                $this->source_name = $drop_off_name;
                $this->destination_name = $boarding_name;
                break;
            
            default:
                $this->startdate = $startdate;
                break;
        }
        $this->search_type = $search_type;

		$res = ApiHelper::getInstance()->callUrl([
            'url' => 'api/v1/kiosk/searchTrip',
            'parameter' => [
                'method' => 'POST',
                'postfields' => [
					'startdate' => $this->startdate,
                    'source_id' => $this->source_id,
                    'destination_id' => $this->destination_id,
                    'source_name' => $this->source_name,
                    'destination_name' => $this->destination_name,
                    'search_type' => $this->search_type
					]
            ]
        ]);
        if (!isset($res['data'])) {
            $data = [
                [
                    'id' => 1,
                    'message' => isset($res['message']) ? $res['message'] : 'Tidak tersedia'
                ]
            ];

            return new CArrayDataProvider($data, array(
                'keyField' => 'id',
                'pagination' => array(
                    'pageSize' => count($data),
                    ),
            ));
        }

        $data = $res['data'];
		return new CArrayDataProvider($data, array(
			'keyField' => 'id',
			'pagination' => array(
				'pageSize' => count($data),
				),
			));	
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
