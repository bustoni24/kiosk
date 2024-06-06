<?php
class HomeController extends Controller
{
	public $layout='//layouts/column_mobile';

	public function init() {
		if (isset(Yii::app()->user->id, Yii::app()->user->role)){

		} else {
			$this->redirect(Constant::baseLogin());
		}
	}

    public function actionIndex()
	{
		$post = [];
		$this->render('index', ['post'=>$post]);
	}
}