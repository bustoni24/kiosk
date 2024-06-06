<?php

class CronController extends Controller
{
	public function init() {
		function doPrintResult($result = [])
		{
			echo json_encode($result);
			Yii::app()->end();
		}
	}

	public function actionIndex()
	{
		$this->render('index');
	}
}