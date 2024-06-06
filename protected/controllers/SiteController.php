<?php
class SiteController extends Controller
{

	public function init() {
		$police = Police::getInstance()->filtering($_POST, $_GET);
		if (!isset($police['success']) || !$police['success']) {
			echo json_encode(is_array($police) ? $police : (['success' => 0, 'message' => (isset($police['message']) ? $police['message'] : 'Oops something wrong...' ), 'code' => '403']));
			exit;
		}
	}
	
	public function actionIndex()
	{
		header("Location: ".Yii::app()->request->baseUrl."/login");
		die();
		
	}
	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		Yii::app()->theme = 'gentelella';
		$this->layout = '//layouts/column_error';
		if($error=Yii::app()->errorHandler->error)
		{
			if (isset($error['traces'][0]['args'][0]) && is_string($error['traces'][0]['args'][0]) && strpos($error['traces'][0]['args'][0], 'Tidak bisa mengurai request ') !== false && !in_array($error['traces'][0]['args'][0], ['Tidak bisa mengurai request "assets/img/apple-touch-icon.png"','Tidak bisa mengurai request "favicon.ico"','Tidak bisa mengurai request "images/icon.png"']) && strpos($error['traces'][0]['args'][0], '{"ajax"') === false && strpos($error['traces'][0]['args'][0], 'Tidak bisa mengurai request "assets/') === false ) {
				$argsArr = explode('/',$error['traces'][0]['args'][0]);
				if (!empty($argsArr)) {
					Police::getInstance()->insertLogPolice(['keterangan' => $error['traces'][0]['args'][0]]);
				}
			} else if (isset($error['message']) && strpos($error['message'], 'Tidak bisa mengurai request ') !== false && !in_array($error['message'], ['Tidak bisa mengurai request "assets/img/apple-touch-icon.png"','Tidak bisa mengurai request "favicon.ico"','Tidak bisa mengurai request "images/icon.png"']) && strpos($error['message'], '{"ajax"') === false) {
				$args = $error['message'];
				$args = str_replace('Tidak bisa mengurai request ','',$args);
				$argsArr = explode('/',$args);
				if (!empty($argsArr)) {
					Police::getInstance()->insertLogPolice(['keterangan' => $error['message']]);
				}
			}

			if(Yii::app()->request->isAjaxRequest){
				echo $error['message'];
			}
			 $this->render('error', $error);
		}
	}

	public function actionLoginAdmin()
	{
		if (isset(Yii::app()->user->id, Yii::app()->user->role)){      	
			$this->redirect(Constant::baseUrl()."/home/index");
		}

		$this->layout = 'login_admin';
		
  		$model=new LoginFormAdmin();
  		// if it is ajax validation request
  		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
  		{
  			echo CActiveForm::validate($model);
  			Yii::app()->end();
  		}
  
  		// collect user input data
  		if(isset($_POST['LoginFormAdmin']))
  		{
			$username = $_POST['LoginFormAdmin']['username'];
  			$model->attributes=$_POST['LoginFormAdmin'];
  			if($model->validate() && $model->login()) {
				$this->redirect(Constant::baseUrl()."/");
			  }
  		}

  		// display the login form
  		$this->render('loginAdmin',array('model'=>$model));	
	}

	public function actionTestQr()
	{
		$this->layout = 'login_admin';
		return $this->render('testQr');
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		if (isset(Yii::app()->user->id, Yii::app()->user->role)){
			return $this->redirect(Constant::baseUrl()."/home/index");
		}

		$this->layout = 'loginv2';
  		$model=new LoginForm;
  
  		// if it is ajax validation request
  		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
  		{
  			echo CActiveForm::validate($model);
  			Yii::app()->end();
  		}
  
  		// collect user input data
  		if(isset($_POST['LoginForm']))
  		{
  			$model->attributes=$_POST['LoginForm'];
  			if($model->validate() && $model->login()) {
				$this->redirect(Constant::baseUrl()."/");
			  }
  		}

  		// display the login form
  		$this->render('loginMember',array(
			  'model'=>$model
			));	
	}

	public function actionRegister()
	{
		if (isset(Yii::app()->user->id, Yii::app()->user->role)){      	
			$this->redirect(Constant::baseUrl()."/home/index");
		}
		$this->layout = 'loginV2';

		$post = [];
		if(isset($_POST['User']))
		{
			$post = $_POST;
			if (!isset($post['User']['passconf']) || empty($post['User']['passconf']))
				throw new CHttpException(400,'Password tidak boleh kosong');
			if ($post['User']['passconf'] != $post['User']['password'])
				throw new CHttpException(400,'Password tidak cocok, mohon ulangi kembai');

			$register = ApiHelper::getInstance()->callUrl([
				'url' => 'apiMobile/register',
				'parameter' => [
					'method' => 'POST',
					'postfields' => $post
				]
			]);

			if (!$register['success'])
				throw new CHttpException(401,$register['message']);

			Yii::app()->user->setFlash('success', 'Registrasi member baru berhasil. Silahkan login untuk masuk dashboard');
			$this->redirect(Constant::baseUrl() . '/login');
		}

		$this->render('registerAccount', [
			'post' => $post
		]);
	}

	public function actionForgotPassword()
	{
		$this->login_user =  User::model()->findByPk(Yii::app()->user->id);
		if (!isset($this->login_user))
			$this->login_user = Sdm::model()->findByPk(Yii::app()->user->id);
		if (isset($this->login_user->username)){         	
			$this->redirect(array('home/index'));
		}
		$this->layout = 'loginv2';
		$model = new User;
		// $model->role = 'forgotPassword';
		$message = ['status' => '', 'message' => ''];
		if (isset($_POST['User'])){
		/* 	$post = $_POST['User'];
			if(!User::model()->exists("username='".$post['username']."'")){
				$message = [
					'status' => 'error',
					'message' => "Email / Username tidak terdaftar. Mohon koreksi kembali",
				];
			} else {
				$digits = 7;
				$kode_verifikasi = rand(pow(10, $digits-1), pow(10, $digits)-1);
				$modelUserExisting = User::model()->findByAttributes(['username' => $post['username']]);
				$modelUserExisting->kode_verifikasi = $kode_verifikasi;
				if ($modelUserExisting->save()){
					//send email
					SendEmail::getInstance()->sendForgotPassword(['email' => $modelUserExisting->username, 'nama' => $modelUserExisting->nama, 'prefix' => $modelUserExisting->prefix, 'kode_verifikasi' => $modelUserExisting->kode_verifikasi]);
					
					$message = [
						'status' => 'success',
						'message' => "Pengiriman berhasil! Silakan cek email Anda dan lakukan perubahan password melalui email",
					];

					$this->redirect(SERVER.'/site/verifikasi/'.base64_encode($modelUserExisting->username.'-'.$modelUserExisting->kode_verifikasi));
				} else {
					$message = [
						'status' => 'error',
						'message' => "Kirim email gagal. Mohon koreksi kembali",
					];
				}
			} */
		}

		$this->render('forgotPassword', array('model'=>$model, 'message' => $message));
	}

	public function actionSuccessRegister()
	{
		$this->layout = '//layouts/column_landing';
		$name = "";
		if (isset(Yii::app()->session['userRegister'])){
			$name = Yii::app()->session['userRegister'];

			unset(Yii::app()->session['userRegister']);
		}
		$this->render('successRegister', ['name' => $name]);
	}
	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{

		if (isset(Yii::app()->session)){
			Yii::app()->session->clear();
            Yii::app()->session->destroy();
		}
		Yii::app()->user->logout();
		
		$this->redirect(Constant::baseUrl().'/');
	}

	public function actionLogoutAdmin()
	{

		if (isset(Yii::app()->session)){
			Yii::app()->session->clear();
            Yii::app()->session->destroy();
		}
		Yii::app()->user->logout();
		
		$this->redirect(Constant::baseUrl().'/loginadmin');
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && ($_POST['ajax']==='login-form' || $_POST['ajax']==='register'))
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
