<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
    public $arrAnswer = array();
    public $topTitle = Constant::PROJECT_NAME; 
    public $login_user = null;
    public $dataTempBarang = [];
    
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='main';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();

  public function init() {
    Yii::app()->clientScript->reset();
		function doPrintResult($result = [])
		{
      header("Cache-Control: no-cache");
      header("Content-Type: application/json");
      
			echo json_encode($result);
			Yii::app()->end();
		}

    $keyToken = Helper::getInstance()->hashSha256("token");
    //check expiry token
    $existingToken = Helper::getInstance()->getState($keyToken);
    if (isset($existingToken['time'])) {
      $diffMinute = Helper::getInstance()->checkSubMinute($existingToken['time']);
      if ($diffMinute > 55) { //every 55 minute refresh token
        //set null
        Helper::getInstance()->setState($keyToken, null);
      }
    }

    //check token
    if (empty(Helper::getInstance()->getState($keyToken))) {
        $result = new Returner;
        $token = ApiHelper::getInstance()->callUrl([
          'url' => 'api/v1/kiosk/token',
          'parameter' => [
            'method' => 'POST',
            'postfields' => [
              'username' => 'kiosk',
              'password' => 'kioskEfisiens1'
            ]
          ]
        ]);
        if (!isset($token['data']['access_token'], $token['data']['token_type'])){
          $res = $result->dump("Invalid Token :: " . (isset($token['message']) ? $token['message'] : '-'));
          doPrintResult($res);
        }
        //set state
        Helper::getInstance()->setState($keyToken, [
          'token' => $token['data']['token_type'] . " " . $token['data']['access_token'],
          'time' => date('Y-m-d H:i:s')
        ]);
    }

    Yii::app()->attachEventHandler('onError',array($this,'handleError'));
    // Yii::app()->attachEventHandler('onException', array($this, 'handleException'));
	}

  public function handleError(CEvent $event)
	{        
		if ($event instanceof CExceptionEvent)
		{
            $result = new Returner();

			$error = $result->dumpV2($event->message, null, 500, ['name' => 'status_code', 'value' => "500"]);
			unset($error['message_debug']);
            doPrintResult($error);
		}
		elseif($event instanceof CErrorEvent)
		{
			$result = new Returner();

			$error = $result->dumpV2($event->message, null, 500, ['name' => 'status_code', 'value' => "500"]);
			unset($error['message_debug']);
            doPrintResult($error);
		}

		$event->handled = TRUE;
	}

    public function handleException($event)
    {
        $exception = $event->exception;

        if ($exception instanceof CHttpException) {
            $result = new Returner();

			$error = $result->dumpV2($exception->getMessage(), null, $exception->statusCode, ['name' => 'status_code', 'value' => (string)$exception->statusCode]);
			unset($error['message_debug']);
            doPrintResult($error);
        }
        
        $event->handled = TRUE;
    }

		public function IndonesiaTgl($tanggal, $withTime = false){
          date_default_timezone_set("Asia/Jakarta");

          $tanggal = $tanggal;
          $time = date('H:i:s', strtotime($tanggal));
           $namaBln = array("01" => "Januari", "02" => "Februari", "03" => "Maret", "04" => "April", "05" => "Mei", "06" => "Juni", 
                   "07" => "Juli", "08" => "Agustus", "09" => "September", "10" => "Oktober", "11" => "November", "12" => "Desember");
                   
          $tgl=substr($tanggal,8,2);
          $bln=substr($tanggal,5,2);
          $thn=substr($tanggal,0,4);
          $tanggal ="$tgl ".(isset($namaBln[$bln]) ? $namaBln[$bln] : '???')." $thn";
        
          return $tanggal."".($withTime ? " ".$time : "");
          }

        public function getDay($date)
        {
          $indonesianDate = [
            '0' => 'Minggu',
            '1' => 'Senin',
            '2' => 'Selasa',
            '3' => 'Rabu',
            '4' => 'Kamis',
            '5' => 'Jumat',
            '6' => 'Sabtu'
          ];
          $day = date('w', strtotime($date));
          return $indonesianDate[$day];
        }

        public function getNamaLengkap($id){
            $result = "";
            if(is_numeric($id)){
                $user = User::model()->findByPk($id);
                if(isset($user))
                    $result = $user->namaLengkap;
            }

            return $result;
        }

        public function timeOrDate($date){
            $result = 0;
            if(isset($date) && !empty($date)){
                $starthari = time();
                $tgl_catatan = $date;
                $sejak = ($starthari - strtotime($tgl_catatan))/60;
                if ($sejak > (60*168)) { //jika masuk ini berarti pake tanggal
                    $result = 1;
               }
           } 
           return $result;  
       }

        public function time_since($original)
        {
            if (isset($original) && !empty($original)){
                    date_default_timezone_set('Asia/Jakarta');
                    $chunks = array(
                      array(60 * 60 * 24 * 365, 'tahun'),
                      array(60 * 60 * 24 * 30, 'bulan'),
                      array(60 * 60 * 24 * 7, 'minggu'),
                      array(60 * 60 * 24, 'hari'),
                      array(60 * 60, 'jam'),
                      array(60, 'menit'),
                  );

                    $today = time();
                    $since = $today - $original;

                    if ($since > 604800)
                    {
                        $print = date("M jS", $original);
                        if ($since > 31536000)
                        {
                          $print .= ", " . date("Y", $original);
                      }
                      return $print;
                  }

                  for ($i = 0, $j = count($chunks); $i < $j; $i++)
                  {
                    $seconds = $chunks[$i][0];
                    $name = $chunks[$i][1];

                    if (($count = floor($since / $seconds)) != 0)
                      break;
              }

              $print = ($count == 1) ? '1 ' . $name : "$count {$name}";
              return $print . ' yang lalu';
          }
          
        }

        public function randomString($length) {
            $keys = array_merge(range(0,9), range('a', 'z'));

            $key = "";
            for($i=0; $i < $length; $i++) {
                $key .= $keys[mt_rand(0, count($keys) - 1)];
            }
            return $key;
        }

        public function formatDateSlash($date)
        {
          if (!isset($date))
            return "-";

            return date('d/m/Y', strtotime($date));
        }

        public function sideNav($role = null){
          echo $this->renderPartial('/menu/sideNav', array('role' => $role), false);
        }

        public function menuTab($data = []){
          if (!empty($data)){
            if (isset($data['label'])){
              $menuID = Menu::model()->findByAttributes(['label' => $data['label']]);
              if (isset($menuID->id)){
                  $data = Menu::model()->findAllByAttributes(['parent' => $menuID->id],['order' => 'position, id ASC']);
              } else {
                $data = array(
                    array('label'=>'List User', 'url'=>'user/admin', 'icon' => 'fa-list-ul'),
                  );
              }
            } else {
              $count = count($data);
              for ($i=0; $i < $count; $i++) { 
                if (!isset($data[$i]['label']) || !isset($data[$i]['url']))
                  exit('Url is not valid');
              }
            }
          }
          
          echo $this->renderPartial('/menu/tab', array('data' => $data), false);
        }

        public function shortIndonesiaTgl($tanggal, $withTime = false){
          date_default_timezone_set("Asia/Jakarta");
  
          $tanggal = $tanggal;
          $time = date('H:i:s', strtotime($tanggal));
            $namaBln = array("01" => "Jan", "02" => "Feb", "03" => "Mar", "04" => "Apr", "05" => "Mei", "06" => "Jun", 
                    "07" => "Jul", "08" => "Agu", "09" => "Sep", "10" => "Okt", "11" => "Nov", "12" => "Des");
                    
          $tgl=substr($tanggal,8,2);
          $bln=substr($tanggal,5,2);
          $thn=substr($tanggal,0,4);
          $tanggal ="$tgl ".(isset($namaBln[$bln]) ? $namaBln[$bln] : '???')." $thn";
        
          return $tanggal."".($withTime ? " ".$time : "");
        }

        public function subMenu($data = []){
          $count = count($data);
          for ($i=0; $i < $count; $i++) { 
            if (!isset($data[$i]['label']) || !isset($data[$i]['url']))
              continue;
          }
          
            echo $this->renderPartial('/menu/sub', array('data' => $data), false);
        }

        public function mainMenu()
        {
          $menu = Menu::model()->findAll("parent IS NULL OR parent = '' ORDER BY position ASC, id ASC");
          echo $this->renderPartial('/menu/mainMenu', array('data' => $menu), false);
        }

        public function class2id($className)
        {
          return trim(strtolower(str_replace('_','-',preg_replace('/(?<![A-Z])[A-Z]/', '-\0', $className))),'-');
        }
        
        public function encode($value) {
          if (!$value) {
              return false;
          }
      
          $key = sha1('EnCRypT10nK#Y!RiSRNn');
          $strLen = strlen($value);
          $keyLen = strlen($key);
          $j = 0;
          $crypttext = '';
      
          for ($i = 0; $i < $strLen; $i++) {
              $ordStr = ord(substr($value, $i, 1));
              if ($j == $keyLen) {
                  $j = 0;
              }
              $ordKey = ord(substr($key, $j, 1));
              $j++;
              $crypttext .= strrev(base_convert(dechex($ordStr + $ordKey), 16, 36));
          }
      
          return $crypttext;
      }
      
      
      public function decode($value) {
          if (!$value) {
              return false;
          }
      
          $key = sha1('EnCRypT10nK#Y!RiSRNn');
          $strLen = strlen($value);
          $keyLen = strlen($key);
          $j = 0;
          $decrypttext = '';
      
          for ($i = 0; $i < $strLen; $i += 2) {
              $ordStr = hexdec(base_convert(strrev(substr($value, $i, 2)), 36, 16));
              if ($j == $keyLen) {
                  $j = 0;
              }
              $ordKey = ord(substr($key, $j, 1));
              $j++;
              $decrypttext .= chr($ordStr - $ordKey);
          }
      
          return $decrypttext;
      }

      public function resizer($photo)
      {
        // Get the image info from the photo
        $image_info = getimagesize($photo);
        $width = $new_width = $image_info[0];
        $height = $new_height = $image_info[1];
        $type = $image_info[2];

        // Load the image
        switch ($type)
        {
          case IMAGETYPE_JPEG:
          $image = imagecreatefromjpeg($photo);
          break;
          case IMAGETYPE_GIF:
          $image = imagecreatefromgif($photo);
          break;
          case IMAGETYPE_PNG:
          $image = imagecreatefrompng($photo);
          break;
          default:
          die('Error loading '.$photo.' - File type '.$type.' not supported');
        }

    // Create a new, resized image
        $new_width = 300;
        $new_height = $height / ($width / $new_width);
        $new_image = imagecreatetruecolor($new_width, $new_height);
        imagecopyresampled($new_image, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

    // Save the new image over the top of the original photo
        switch ($type)
        {
          case IMAGETYPE_JPEG:
          imagejpeg($new_image, $photo, 300);
          break;
          case IMAGETYPE_GIF:
          imagegif($new_image, $photo);         
          break;
          case IMAGETYPE_PNG:
          imagepng($new_image, $photo);
          break;
          default:
          die('Error saving image: '.$photo);
        }

      }
}
