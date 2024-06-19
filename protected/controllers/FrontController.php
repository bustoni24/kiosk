<?php

class FrontController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	/**
	 * @return array action filters
	 */
	public function filters()
    {
        return array(
            'accessControl', // tambahkan filter akses
			'postOnly + delete', // we only allow deletion via POST request
            array('application.components.CsrfFilter'), // tambahkan filter csrf untuk semua action
        );
    }

	public function actionIndex()
	{		
		$this->layout = "//layouts/column_front";

		$model = new Armada('searchListBus');
		if (isset($_GET['source'])) {
			$model->source_id = $_GET['source'];
		}
		if (isset($_GET['destination'])){
			$model->destination_id = $_GET['destination'];
		}		

		$listTujuan = ApiHelper::getInstance()->callUrl([
			'url' => 'api/v1/kiosk/listCitySource',
			'parameter' => [
				'method' => 'GET'
			]
		]);
		$listTujuan = isset($listTujuan['data']) ? $listTujuan['data'] : [];

		$arrTujuan = [];
		if (isset($model->source_id)) {
			$option = ApiHelper::getInstance()->callUrl([
				'url' => 'api/v1/kiosk/listCityDestination',
				'parameter' => [
					'method' => 'POST',
					'postfields' => [
						'titik_id' => $model->source_id
					]
				]
			]);

			if (isset($option['data']))
				$arrTujuan = $option['data'];
		}

		$this->render('index', [
			'listTujuan' => $listTujuan,
			'arrTujuan' => $arrTujuan,
			'model' => $model
		]);
	}

	public function actionHomePage()
	{
		/* $ip = "34.172.237.230";
		$test = ApiHelper::getInstance()->get_geolocation(ApiHelper::getInstance()->apiKeyGeoLoc(), $ip);
		Helper::getInstance()->dump(json_decode($test, true)); */
		if (!isset($_POST['startdate'], $_POST['source'], $_POST['destination'])) {
			throw new CHttpException(404,'Halaman yang diminta tidak valid. Pastikan Anda telah benar dalam memilih titik keberangkatan, tujuan dan tanggal!');
		}
		$model = new Armada('searchListBus');
		$model->startdate = $_POST['startdate'];
		$model->enddate = isset($_POST['enddate']) && !empty($_POST['enddate']) ? $_POST['enddate'] : null;
		$model->source_id = $_POST['source'];
		$model->destination_id = $_POST['destination'];

		$listSource = ApiHelper::getInstance()->callUrl([
			'url' => 'api/v1/kiosk/listCitySource',
			'parameter' => [
				'method' => 'GET'
			]
		]);
		$arrTujuan = [];
		if (isset($model->source_id)) {
			$option = ApiHelper::getInstance()->callUrl([
				'url' => 'api/v1/kiosk/listCityDestination',
				'parameter' => [
					'method' => 'POST',
					'postfields' => [
						'titik_id' => $model->source_id
					]
				]
			]);

			if (isset($option['data']))
				$arrTujuan = $option['data'];
		}

		$arrSource = isset($listSource['data']) ? $listSource['data'] : [];
		if (isset($arrSource[$model->source_id])) {
			$model->source_name = $arrSource[$model->source_id];
		}
		if (isset($arrTujuan[$model->destination_id])) {
			$model->destination_name = $arrTujuan[$model->destination_id];
		}
		$this->render('homepage', [
			'listTujuan' => $arrSource,
			'arrTujuan' => $arrTujuan,
			'model' => $model
		]);
	}

	public function actionSeatmap($id)
	{
		$model = new Booking('seatmap');
		$post = $_POST;
        if (isset($_POST['FormSeat'], $_POST['FormBooking'][Constant::SEARCH_BOARDING])) {
            $post = $_POST['FormBooking'][Constant::SEARCH_BOARDING];
            //proses simpan post array untuk boarding
            if (!isset($post['tipe'], $_POST['proses'])) {
                throw new CHttpException(500,'Parameter tipe tidak valid');
            }

            //set paramPost untuk boarding
            Helper::getInstance()->setState(Constant::TEMP_POST, [
                'FormSeat' => $_POST['FormSeat'],
                'FormBooking' => $_POST['FormBooking'],
            ]);
            if ($_POST['proses'] == 'PILIH KURSI KEPULANGAN') {
                //redirect ke pilih kursi untuk kepulangan
                return $this->redirect(Constant::baseUrl().'/front/cariBus?asal=' . $post['boarding_name'] . '&tujuan=' . $post['drop_off_name'] . '&boarding_date=' . $post['startdate'] . '&return_boarding_date=' . $post['enddate'] . '&boarding_id=' . $post['titik_id'] . '&destination_id=' . (isset($post['destination_id']) ? $post['destination_id'] : '') .'&tipe=' . $post['tipe'] . '&return=1');
            }

            //jika sampai sini redirect ke isi identitas
            return $this->redirect(Constant::baseUrl().'/front/isiForm');
        } else if (isset($_POST['FormSeat'], $_POST['FormBooking'][Constant::SEARCH_DROP_OFF])) {
            $post = $_POST['FormBooking'][Constant::SEARCH_DROP_OFF];
            //proses simpan post array untuk drop off
            $this->paramPost = Helper::getInstance()->getState(Constant::TEMP_POST);
            if (isset($this->paramPost['FormSeat'])) {
                $this->paramPost['FormSeat'][Constant::SEARCH_DROP_OFF] = $_POST['FormSeat'][Constant::SEARCH_DROP_OFF];

                $countSeatBoarding = 0;
                if (isset($this->paramPost['FormSeat'][Constant::SEARCH_BOARDING]['kursi']))
                    $countSeatBoarding = count($this->paramPost['FormSeat'][Constant::SEARCH_BOARDING]['kursi']);

                $countSeatDropOff = count($_POST['FormSeat'][Constant::SEARCH_DROP_OFF]['kursi']);
                if ($countSeatBoarding != $countSeatDropOff) {
                    throw new CHttpException(500,'Jumlah kursi Kepulangan harus sama dengan Jumlah kursi Keberangkatan');
                }
            }
            if (isset($this->paramPost['FormBooking'])) {
                $this->paramPost['FormBooking'][Constant::SEARCH_DROP_OFF] = $_POST['FormBooking'][Constant::SEARCH_DROP_OFF];
            }
            Helper::getInstance()->setState(Constant::TEMP_POST, $this->paramPost);

            //redirect ke isi identitas
            return $this->redirect(Constant::baseUrl().'/front/isiForm');
        }

		if (!isset($post['route_id'], $post['armada_ke'], $post['doj'], $post['startdate'], $post['source_name'], $post['destination_name'], $post['source_id'], $post['destination_id']))
			throw new CHttpException(500,'Invalid Parameter RouteID');

		// Helper::getInstance()->dump($post);
		$routeID = $post['route_id'];
        $data_transit = isset($post['data_transit']) && !empty($post['data_transit']) ? $post['data_transit'] : null;
        $search_type = isset($post['search_type']) ? $post['search_type'] : Constant::SEARCH_BOARDING;
        $model->doj = $post['doj'];
        $model->startdate = $post['startdate'];
        $model->enddate = isset($post['enddate']) ? $post['enddate'] : null;
		$model->route_id = $routeID;
		$model->trip_id = $post['trip_id'];
        $model->armada_ke = $post['armada_ke'];
        $model->source_name = $post['source_name'];
        $model->destination_name = $post['destination_name'];
        $model->source_id = $post['source_id'];
        $model->destination_id = $post['destination_id'];
        $model->search_type = $search_type;

        $listSeat = $model->seatmap();
		if (!isset($listSeat['data']['route'], $listSeat['data']['route']))
			throw new CHttpException(500,'Invalid Result Data :: ' . json_encode($listSeat),1);

        $data = isset($listSeat['data']['route']) ? $listSeat['data']['route'] : [];
		// Helper::getInstance()->dump($data);
        if ($model->search_type == Constant::SEARCH_BOARDING && isset($model->enddate))
				$button_text = "PILIH KURSI KEPULANGAN";
			else 
				$button_text = "LANJUTKAN";

        $data['btn_text'] = $button_text;

		$listSource = ApiHelper::getInstance()->callUrl([
			'url' => 'api/v1/kiosk/listCitySource',
			'parameter' => [
				'method' => 'GET'
			]
		]);
		$arrTujuan = [];
		if (isset($model->source_id)) {
			$option = ApiHelper::getInstance()->callUrl([
				'url' => 'api/v1/kiosk/listCityDestination',
				'parameter' => [
					'method' => 'POST',
					'postfields' => [
						'titik_id' => $model->source_id
					]
				]
			]);

			if (isset($option['data']))
				$arrTujuan = $option['data'];
		}

		$arrSource = isset($listSource['data']) ? $listSource['data'] : [];
		if (isset($arrSource[$model->source_id])) {
			$model->source_name = $arrSource[$model->source_id];
		}
		if (isset($arrTujuan[$model->destination_id])) {
			$model->destination_name = $arrTujuan[$model->destination_id];
		}
		$this->render('seatmap', [
            'model' => $model,
            'seatmap' => $listSeat['data']['seatmap'],
            'data' => $data,
			'listTujuan' => $arrSource,
			'arrTujuan' => $arrTujuan
        ]);
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && ($_POST['ajax']==='register-form' || $_POST['ajax'] === 'register-checkpoint'))
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}