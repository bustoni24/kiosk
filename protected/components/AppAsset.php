<?php
class AppAsset
{
	private static $css = [
		'plugins/fontawesome-free/css/all.min.css',
		'plugins/overlayScrollbars/css/OverlayScrollbars.min.css',
		'plugins/select2/css/select2.min.css',
		'plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css',
		'dist/css/adminlte.min.css',
		'dist/css/loader.css',
		// 'plugins/daterangepicker/daterangepicker.css',
		// 'plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css',
	];
	private static $cssLogin = [
		'vendor/bootstrap/css/bootstrap.min.css',
	];
	private static $cssLanding = [
		'css/styles.css',
		'css/custom.css',
	];
	private static $js = [
		'plugins/jquery/jquery.min.js',
		'plugins/bootstrap/js/bootstrap.bundle.min.js',
		'plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js',
		// 'plugins/daterangepicker/daterangepicker.js',
		'plugins/moment/moment.min.js',
		// 'plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js',
		'plugins/select2/js/select2.full.min.js',
		'dist/js/adminlte.min.js',
		'js/sweetalert2.min.js',
		'js/accounting.min.js'
	];
	private static $jsLogin = [
		'plugins/jquery/jquery.min.js',
	];
	private static $jsLanding = [
		'js/jquery.js',
	];

	public static function registerCss($params = ''){
		$cssPrint = "";
		switch ($params) {
			
			default:
				foreach (self::$css as $asset) {
					$cssPrint .= "<link type=\"text/css\" href='" . Constant::assetsUrl() . "/". $asset ."' rel='stylesheet'> ";
				}
				break;
		}

		return $cssPrint;
	}

	public static function registerJs($params = ''){
		$jsPrint = "";
		switch ($params) {
			
			default:
				foreach (self::$js as $asset) {
					if (in_array(Yii::app()->controller->action->Id, ['admin'
					]) && in_array($asset, ['plugins/jquery/jquery.min.js']) || 
					(!in_array(Yii::app()->controller->action->Id, ['test']) && in_array($asset, ['js/tags/jquery.tagsinput.js'])))
						continue;

					$jsPrint .= "<script type='text/javascript' src='" . Constant::assetsUrl() . "/" . $asset . "'></script>";
				}

				break;
		}
	
		return $jsPrint;
	}

	public static function registerCssLogin($params = ''){
		$cssPrint = "";
		switch ($params) {
			case 'landing':
				foreach (self::$cssLanding as $asset) {
					$cssPrint .= "<link type=\"text/css\" href='" . Constant::frontAssetUrl() . "/assets/". $asset ."' rel='stylesheet'> ";
				}
				break;
			
			default:
				foreach (self::$cssLogin as $asset) {
					$cssPrint .= "<link type=\"text/css\" href='" . Constant::frontAssetUrl() . "/assets/". $asset ."' rel='stylesheet'> ";
				}
				break;
		}

		return $cssPrint;
	}

	public static function registerJsLogin($params = ''){
		$jsPrint = "";
		switch ($params) {
			case 'landing':
				foreach (self::$jsLanding as $asset) {
					$jsPrint .= "<script type='text/javascript' src='" . Constant::frontAssetUrl() . "/" . $asset . "'></script>";
				}

				break;
			
			default:
				foreach (self::$jsLogin as $asset) {
					if (in_array(Yii::app()->controller->route, ['site/loginAdmin','product/index','product/create']) && $asset == 'test')
						continue;
					$jsPrint .= "<script type='text/javascript' src='" . Constant::frontAssetUrl() . "/assets/" . $asset . "'></script>";
				}

				break;
		}
	
		return $jsPrint;
	}
}
?>
