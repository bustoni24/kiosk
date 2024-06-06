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
		
		$listTujuan = ApiHelper::getInstance()->callUrl([
			'url' => 'api/v1/kiosk/listCitySource',
			'parameter' => [
				'method' => 'GET'
			]
		]);

		Helper::getInstance()->dump($listTujuan);

		$this->render('index', [
			
		]);
	}

	public function actionHomePage()
	{
		$this->render('homepage', [
			
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