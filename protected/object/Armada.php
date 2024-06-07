<?php

class Armada
{
	public $startdate, $enddate, $filter = null, $get = null;
	public $id_trip,$group,$kelas,$groupId,$armadaId;
    public $source_id = null, $destination_id = null;

    public function searchListBus()
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
		$res = ApiHelper::getInstance()->callUrl([
            'url' => 'apiMobile/listBusV2',
            'parameter' => [
                'method' => 'POST',
                'postfields' => [
					'startdate' => $this->startdate,
					'source_id' => $this->source_id,
					'destination_id' => $this->destination_id,
					'filter' => $this->filter
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
        // Helper::getInstance()->dump($res);
        $data = $res['data'];
		return new CArrayDataProvider($data, array(
			'keyField' => 'id',
			'pagination' => array(
				'pageSize' => count($data),
				),
			));	
    }

	public function getKelasArmada()
	{
		$result = [];
		$res = ApiHelper::getInstance()->callUrl([
            'url' => 'apiMobile/getKelasArmada?1=1',
            'parameter' => [
                'method' => 'GET'
            ]
        ]);
        if (isset($res['data'])) {
            $result = $res['data'];
            if (isset($result['3']))
                unset($result['3']);
        }

		return $result;
	}

	public function getGroupTrip()
	{
		$result = [];
		$res = ApiHelper::getInstance()->callUrl([
            'url' => 'apiMobile/getGroupTrip?1=1',
            'parameter' => [
                'method' => 'GET'
            ]
        ]);
        if (isset($res['data'])) {
            $result = $res['data'];
        }
		return $result;
	}

    public function getOptionsArmada()
    {
        $result = [];
		$res = ApiHelper::getInstance()->callUrl([
            'url' => 'apiMobile/getOptionsArmada?1=1',
            'parameter' => [
                'method' => 'GET'
            ]
        ]);
        if (isset($res['data'])) {
            $result = $res['data'];
        }
		return $result;
    }

    public function getAsalKeberangkatan()
    {
        $result = [];
        $this->destination_id = isset(Yii::app()->user->destination_id) ? Yii::app()->user->destination_id : null;
		$res = ApiHelper::getInstance()->callUrl([
            'url' => 'apiMobile/getAsalKeberangkatan',
            'parameter' => [
                'method' => 'POST',
                'postfields' => [
					'destination_id' => $this->destination_id
                ]
            ]
        ]);
        if (isset($res['data'])) {
            $result = $res['data'];
        }
		return $result;
    }

    public function getTujuan($model)
    {
        $result = [];
        if (!isset($model->startdate, $model->latitude, $model->longitude, $model->rit)) {
            return $result;
        }

        // Helper::getInstance()->dump($model);
        $get = [
            'user_id' => Yii::app()->user->id,
            'role' => Yii::app()->user->role,
            'startdate' => $model->startdate,
            'rit' => $model->rit,
            'latitude' => $model->latitude,
            'longitude' => $model->longitude,
            'tujuan' => $model->tujuan,
            'penjadwalan_id' => $model->penjadwalan_id_fake
        ];
       
		$res = ApiHelper::getInstance()->callUrl([
            'url' => 'apiMobile/getTujuan',
            'parameter' => [
                'method' => 'POST',
                'postfields' => $get
            ]
        ]);
        // Helper::getInstance()->dump($res);
        if (isset($res['data'])) {
            $result = $res['data'];
        }
		return $result;
    }

    public function getTrip()
	{
		$result = [];
		$res = ApiHelper::getInstance()->callUrl([
            'url' => 'apiMobile/getTrip?1=1',
            'parameter' => [
                'method' => 'GET'
            ]
        ]);
        if (isset($res['data'])) {
            $result = $res['data'];
        }
		return $result;
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
