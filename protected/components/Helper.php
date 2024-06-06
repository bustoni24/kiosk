<?php

class Helper {

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
        $new_width = 500;
        $new_height = $height / ($width / $new_width);
        $new_image = imagecreatetruecolor($new_width, $new_height);
        imagecopyresampled($new_image, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

// Save the new image over the top of the original photo
        switch ($type)
        {
            case IMAGETYPE_JPEG:
            imagejpeg($new_image, $photo, 500);
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

    public function resize($namafile){
        try {
            $key = "";
            // $input = "logotest.png";
            // $output = "Output.png";
            $input = $namafile;
            $output = $namafile;
            $url = "https://api.tinify.com/shrink";
            $options = array(
              "http" => array(
                "method" => "POST",
                "header" => array(
                  "Content-type: image/png",
                  "Authorization: Basic " . base64_encode("api:$key")
                ),
                "content" => file_get_contents($input)
              ),
              "ssl" => array(
                /* Uncomment below if you have trouble validating our SSL certificate.
                   Download cacert.pem from: http://curl.haxx.se/ca/cacert.pem */
                 "cafile" => dirname(__FILE__) ."/../../cacert.pem",
                "verify_peer" => false
              )
            );

            $result = @fopen($url, "r", false, stream_context_create($options));
            if ($result) {
              /* Compression was successful, retrieve output from Location header. */
              foreach ($http_response_header as $header) {
                if (substr($header, 0, 10) === "Location: ") {
                  file_put_contents($output, fopen(substr($header, 10), "rb", false));
                  // print("Compression success");
                }
              }
            } else {
              /* Something went wrong! */
              // print("Compression failed");
            }
        } catch (Exception $e) {
            // print("Compression failed");
        }
    }

   public function getRupiah($number) {
      if (is_numeric($number) && $number > 0)
        return number_format($number, 0, ",", ".");
      else 
        return $number;
    }

  public function does_url_exists($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($code == 200) {
            $status = 200;
        } else {
            $status = 404;
        }
        curl_close($ch);
        return $status;
    }

  public function getRitDisplay()
  {
    $count = (int)Setting::getValue("RIT", 3);
    $rit = [];
    for ($i=1; $i <= $count; $i++) { 
      $rit[$i] = 'RIT ' . $i;
    }

    return $rit;
  }

  public function hashSha256($body = [])
    {
        $encode_data = json_encode($body, JSON_UNESCAPED_SLASHES);
        $encode_data = preg_replace('/\s+/S', "", $encode_data);
        return strtolower(hash("sha256", $encode_data));
    }

  public function setState($name = null, $value = null)
  {
    $result = null;
    if (!isset($name)) {
      return $result;
    }
    Yii::app()->user->setState($name, $value);
  }

  public function getState($name = null)
  {
    $result = [];
    if (!isset($name)) {
      return $result;
    }
      if (Yii::app()->user->getState($name) !== null) {
        $result = Yii::app()->user->getState($name);
      }
    return $result;
  }

   public function dump($data = [])
   {
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
    exit;
   }

    private static $instance;

    private function __construct()
    {
        // Hide the constructor
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}