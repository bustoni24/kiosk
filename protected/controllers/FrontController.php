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
			'listTujuan' => isset($listTujuan['data']) ? $listTujuan['data'] : [],
			'arrTujuan' => $arrTujuan,
			'model' => $model
		]);
	}

	public function actionHomePage()
	{
		/* $ip = "27.124.95.50";
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

		$listTujuan = ApiHelper::getInstance()->callUrl([
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

		$this->render('homepage', [
			'listTujuan' => isset($listTujuan['data']) ? $listTujuan['data'] : [],
			'arrTujuan' => $arrTujuan,
			'model' => $model
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