<?php 

class Map extends CWidget{
	public static function splitNumeric($string){
        $data = explode(' ', $string);
        $jum = count($data);
        $cek = $data[$jum - 1];

        if(is_numeric($cek)){
            $result['zip_code'] = $cek;
            $province = "";
            for($i = 0; $i<$jum-1; $i++){
                if($province == ""){
                    $province .= $data[$i];
                }else{
                    $province .= " ".$data[$i];
                }
            }
        }else{
            $province = $string;
            
        }
        $result['province'] = $province;
        return $result;
    }

    public static function clean($string) {
       $string = str_replace(' ', '&', $string); // Replaces all spaces with hyphens.
       $string = preg_replace('/[^A-Za-z0-9\-&]/', '', $string);
       $string = str_replace('&', ' ', $string);
       return $string;
    }

    public static function searchCountry($country){        
        $country = trim($country);

        if ($country == "Timor-Leste") {
            $country = "Timor Leste";
        }

        $sql = "SELECT id FROM `country` where LOWER(country.name) like LOWER('%".$country."%') limit 1";
        $result = Yii::app()->db->createCommand($sql)->queryAll();
        if(isset($result) && count($result) > 0){
            return $result[0]['id'];
        } else {
            $sql = "SELECT id FROM `country` where LOWER(country.name) like LOWER('%other%') limit 1";
            $result = Yii::app()->db->createCommand($sql)->queryAll();
            return $result[0]['id']; // other country
        }
    }

    public static function searchProvince($province, $id_country){        
        $province = trim($province);
        $province = strtolower($province);
        $province = str_replace('provinsi ', '', $province);
        $province = str_replace('prov ', '', $province);
        $province = VFormatter::filterProvince($province);

        $sql = "SELECT id FROM `province` where country_id = ".$id_country." AND LOWER(province.name) like LOWER('".$province."') limit 1";
        $result = Yii::app()->db->createCommand($sql)->queryAll();
        if (isset($result[0])) {
            return $result[0]['id'];
        } else {
            $sql = "SELECT id FROM `province` where country_id = ".$id_country." AND LOWER(province.name) like LOWER('%".$province."%') limit 1";
            $result = Yii::app()->db->createCommand($sql)->queryAll();
            if (isset($result[0]))
                return $result[0]['id'];
        }
        return 0;
    }

    public static function searchCity($city, $id_province){        
        $city = trim($city);
        $city = strtolower($city);
        $city = str_replace('kab ', 'kab. ', $city);
        $city = str_replace('kabupaten ', 'kab. ', $city);
        $city = VFormatter::filterCity($city);

        $sql = "SELECT id FROM `city` where province_id = ".$id_province." AND LOWER(city.name) like LOWER('%".$city."%') limit 1";
        $result = Yii::app()->db->createCommand($sql)->queryAll();
        if(isset($result[0])){
            return $result[0]['id'];
        }
        return 0;
    }

    public static function searchDistrict($district, $id_city){        
        $district = trim($district);
        $district = strtolower($district);
        $district = str_replace('kec. ', '', $district);
        $district = str_replace('kec ', '', $district);
        $district = str_replace('kecamatan ', '', $district);
        $district = VFormatter::filterDistrict($district);        
        $sql = "SELECT id FROM `district` where city_id = ".$id_city." AND LOWER(district.name) like LOWER('%".$district."%') limit 1";
        
        $result = Yii::app()->db->createCommand($sql)->queryAll();
        if(isset($result[0])){
            return $result[0]['id'];
        }
        return 0;
    }

    public static function searchDistrictAlternate($district, $id_city, $id_province, $id_country){
        $district = trim($district);
        $district = strtolower($district);
        $district = str_replace('kec. ', '', $district);
        $district = str_replace('kec ', '', $district);
        $district = str_replace('kecamatan ', '', $district);
        $district = VFormatter::filterDistrict($district);        
        $sql = "SELECT d.id as id_district , c.id as id_city, p.id as id_province FROM `district` as d INNER JOIN city as c on d.city_id = c.id INNER JOIN province as p on c.province_id = p.id where p.id = ".$id_province." AND LOWER(d.name) like LOWER('%".$district."%') ";
        
        $result = Yii::app()->db->createCommand($sql)->queryAll();
        $array = array();
        if(isset($result[0])){
            
            $array['id_district'] = $result[0]['id_district'];
            $array['id_city'] = $result[0]['id_city'];
            $array['id_province'] = $result[0]['id_province'];
            $array['id_country'] = $id_country;
            
        }else{
            $sql = "SELECT d.id as id_district FROM `district` d where city_id = ".$id_city;
            $result = Yii::app()->db->createCommand($sql)->queryAll();
            $array['id_district'] = $result[0]['id_district'];
            $array['id_city'] = $id_city;
            $array['id_province'] = $id_province;
            $array['id_country'] = $id_country;
        }
        return $array;   
        // coba searchDistrict dalam 1 province. 
        // kalau dapat pakai id district itu, city - country mengikuti
        // kalau tidak ambil salah satu district di city tersebut. 
    }

    public static function splitAddress($data, $lat, $long){
        $result = array('success' => 0);

        if(isset($lat) && isset($long)){
            $result = self::getAddress($lat, $long);
        }

        if(!isset($result['id_country']) || 
           !isset($result['id_province']) || 
           !isset($result['id_city']) || 
           !isset($result['id_district'])
            ){
            if(isset($data)){
                $id_country = 0;
                $id_province = 0;
                $id_city = 0;
                $id_district = 0;

                $rawdata = $data;
                if (!is_array($data) && is_string($data)) {
                    $data = explode('|', $data);
                }

                $data_new = array();
                foreach ($data as $datum) {
                    $datum_new = preg_replace('/[\x00-\x1F\x7F-\xFF]/', '', $datum);
                    if (trim(self::clean($datum_new)) != "")
                        array_push($data_new, $datum_new);
                }

                $data = $data_new;
                $rawdata = preg_replace('/[\x00-\x1F\x7F-\xFF]/', '', $rawdata);

                if(count($data) == 6){
                    $address = $data[0];
                    $village = self::clean($data[1]);    
                    $district = self::clean($data[2]);    
                    $city = self::clean($data[3]);    
                    $province = self::clean($data[4]);    
                    $country = self::clean($data[5]);  

                    $tmp = self::splitNumeric($province);
                    $province = $tmp['province'];

                    
                    //find country
                    $id_country =  self::searchCountry($country);
                    if($id_country == 2){
                        $address = $rawdata;
                        $id_country = 2;
                        $id_province = 101;
                        $id_city = 9494;
                        $id_district = 9471115;
                    }else if($id_country == 3){
                        $address = $rawdata;
                        $id_country = 3;
                        $id_province = 102;
                        $id_city = 9491;
                        $id_district = 9471112;
                    }else if($id_country == 4){
                        $address = $rawdata;
                        $id_country = 4;
                        $id_province = 103;
                        $id_city = 9492;
                        $id_district = 9471113;
                    }else if($id_country == 6){
                        $address = $rawdata;
                        $id_country = 6;
                        $id_province = 104;
                        $id_city = 9493;
                        $id_district = 9471114;
                    }else if($id_country == null || $id_country == 0){
                        $address = $rawdata;
                        $id_country = 6;
                        $id_province = 104;
                        $id_city = 9493;
                        $id_district = 9471114;
                    }else{
                        //find province
                        if($id_country!=0)
                            $id_province =  self::searchProvince($province, $id_country);

                        //find city
                        if($id_province!=0)
                            $id_city =  self::searchCity($city, $id_province);

                        //find district
                        if($id_city!=0)
                            $id_district =  self::searchDistrict($district, $id_city);

                        if($id_district==0 && $id_country!=0 && $id_province!=0 && $id_city!=0){
                            $alternative = self::searchDistrictAlternate($district, $id_city,  $id_province, $id_country);
                            if(isset($alternative['id_district']) && 
                               isset($alternative['id_city']) &&
                               isset($alternative['id_province']) &&
                               isset($alternative['id_country'])
                               ){
                                $id_country = $alternative['id_country'];
                                $id_province = $alternative['id_province'];
                                $id_city = $alternative['id_city'];
                                $id_district = $alternative['id_district'];

                            }
                            
                        }
                    }
                    

                    if($id_district!=0)
                        $result['success'] = 1;
                    else 
                        $result['success'] = 2; // success incomplete
                    $result['address'] = $address;
                    $result['id_country'] = $id_country;
                    $result['id_province'] = $id_province;
                    $result['id_city'] = $id_city;
                    $result['id_district'] = $id_district;
                    $result['village'] = $village;
                    if(isset($tmp['zip_code'])){
                        $result['zip_code'] = $tmp['zip_code'];
                    }

                    
                    //return $result;
                }else if(count($data) == 5){
                    $address = $data[0];
                    $district = self::clean($data[1]);    
                    $city = self::clean($data[2]);    
                    $province = self::clean($data[3]);    
                    $country = self::clean($data[4]);  

                    $tmp = self::splitNumeric($province);
                    $province = $tmp['province'];

                    
                    //find country
                    $id_country =  self::searchCountry($country);
                    if($id_country == 2){
                        $address = $rawdata;
                        $id_country = 2;
                        $id_province = 101;
                        $id_city = 9494;
                        $id_district = 9471115;
                    }else if($id_country == 3){
                        $address = $rawdata;
                        $id_country = 3;
                        $id_province = 102;
                        $id_city = 9491;
                        $id_district = 9471112;
                    }else if($id_country == 4){
                        $address = $rawdata;
                        $id_country = 4;
                        $id_province = 103;
                        $id_city = 9492;
                        $id_district = 9471113;
                    }else if($id_country == 6){
                        $address = $rawdata;
                        $id_country = 6;
                        $id_province = 104;
                        $id_city = 9493;
                        $id_district = 9471114;
                    }else if($id_country == null || $id_country == 0){
                        $address = $rawdata;
                        $id_country = 6;
                        $id_province = 104;
                        $id_city = 9493;
                        $id_district = 9471114;
                    }else{
                        //find province
                        if($id_country!=0)
                            $id_province =  self::searchProvince($province, $id_country);

                        //find city
                        if($id_province!=0)
                            $id_city =  self::searchCity($city, $id_province);

                        //find district
                        if($id_city!=0)
                            $id_district =  self::searchDistrict($district, $id_city);

                        if($id_district==0 && $id_country!=0 && $id_province!=0 && $id_city!=0){
                            $alternative = self::searchDistrictAlternate($district, $id_city,  $id_province, $id_country);
                            if(isset($alternative['id_district']) && 
                               isset($alternative['id_city']) &&
                               isset($alternative['id_province']) &&
                               isset($alternative['id_country'])
                               ){
                                $id_country = $alternative['id_country'];
                                $id_province = $alternative['id_province'];
                                $id_city = $alternative['id_city'];
                                $id_district = $alternative['id_district'];

                            }
                            
                        }    
                    }

                    

                    if($id_district!=0)
                        $result['success'] = 1;
                    else 
                        $result['success'] = 2; // success incomplete
                    $result['address'] = $address;
                    $result['id_country'] = $id_country;
                    $result['id_province'] = $id_province;
                    $result['id_city'] = $id_city;
                    $result['id_district'] = $id_district;
                    if(isset($tmp['zip_code'])){
                        $result['zip_code'] = $tmp['zip_code'];
                    }

                    
                    //return $result;
                }else if(count($data) == 4){
                    $address = $data[0];
                    $city = self::clean($data[1]);    
                    $province = self::clean($data[2]);    
                    $country = self::clean($data[3]);    

                    $tmp = self::splitNumeric($province);
                    $province = $tmp['province'];

                    //find country
                    $id_country =  self::searchCountry($country);
                    if($id_country == 2){
                        $address = $rawdata;
                        $id_country = 2;
                        $id_province = 101;
                        $id_city = 9494;
                        $id_district = 9471115;
                    }else if($id_country == 3){
                        $address = $rawdata;
                        $id_country = 3;
                        $id_province = 102;
                        $id_city = 9491;
                        $id_district = 9471112;
                    }else if($id_country == 4){
                        $address = $rawdata;
                        $id_country = 4;
                        $id_province = 103;
                        $id_city = 9492;
                        $id_district = 9471113;
                    }else if($id_country == 6){
                        $address = $rawdata;
                        $id_country = 6;
                        $id_province = 104;
                        $id_city = 9493;
                        $id_district = 9471114;
                    }else if($id_country == null || $id_country == 0){
                        $address = $rawdata;
                        $id_country = 6;
                        $id_province = 104;
                        $id_city = 9493;
                        $id_district = 9471114;
                    } else {
                        /* di comment karena tidak mendapatkan $district
                        //find province
                        if($id_country!=0)
                            $id_province =  self::searchProvince($province, $id_country);

                        //find city
                        if($id_province!=0)
                            $id_city =  self::searchCity($city, $id_province);

                        if($id_district == 0){
                            $alternative = self::searchDistrictAlternate($district, $id_city,  $id_province, $id_country);
                            if(isset($alternative['id_district']) &&
                               isset($alternative['id_city']) &&
                               isset($alternative['id_province']) &&
                               isset($alternative['id_country'])
                               ){
                                $id_country = $alternative['id_country'];
                                $id_province = $alternative['id_province'];
                                $id_city = $alternative['id_city'];
                                $id_district = $alternative['id_district'];

                            }
                        }
                        */
                    }



                    if($id_district!=0)
                        $result['success'] = 1;
                    else 
                        $result['success'] = 2; // success incomplete

                    $result['address'] = $address;
                    $result['id_country'] = $id_country;
                    $result['id_province'] = $id_province;
                    $result['id_city'] = $id_city;
                    if(isset($id_district))
                        $result['id_district'] = $id_district;
                    
                    if(isset($tmp['zip_code'])){
                        $result['zip_code'] = $tmp['zip_code'];
                    }

                    
                    
                    //return $result;

                } else {
                    $countries = Yii::app()->db->createCommand("SELECT id, LOWER(name) AS name FROM `country` where LOWER(country.name) NOT IN ('indonesia') ")->queryAll();
                    $countryOtherId = 5;
                    $searchSingleInCountryId = null;
                    if (count($countries) > 0) {
                        $lastString = strtolower($data[count($data) - 1]);
                        $lastString = str_replace('-', ' ', $lastString);
                        $lastString = str_replace('sweden', 'swedia', $lastString);
                        foreach ($countries as $country) {
                            if (!isset($country['id']) || !isset($country['name']))
                                continue;

                            if (strtolower($country['name']) == 'other') {
                                $countryOtherId = $country['id'];
                                continue;
                            }

                            if (!isset($result['id_country']) && strpos(strtolower($lastString), $country['name']) !== false) {
                                $result['success'] = 1;
                                $result['id_country'] = $country['id'];
                                $searchSingleInCountryId = $country['id'];
                            }
                        }
                    }

                    if (!isset($result['id_country'])) {
                        $result['success'] = 1;
                        $result['id_country'] = $countryOtherId;
                        $searchSingleInCountryId = $countryOtherId;
                    }

                    if (isset($searchSingleInCountryId)) {
                        $province_single = Yii::app()->db->createCommand("SELECT id FROM `province` where country_id = '".$searchSingleInCountryId."' LIMIT 1")->queryRow();
                        if (isset($province_single) && isset($province_single['id'])) {
                            $result['id_province'] = $province_single['id'];
                            $city_single = Yii::app()->db->createCommand("SELECT id FROM `city` where province_id = '" . $province_single['id'] . "' LIMIT 1")->queryRow();
                            if (isset($city_single) && isset($city_single['id'])) {
                                $result['id_city'] = $city_single['id'];
                                $district_single = Yii::app()->db->createCommand("SELECT id FROM `district` where city_id = '" . $city_single['id'] . "' LIMIT 1")->queryRow();
                                if (isset($district_single) && isset($district_single['id'])) {
                                    $result['id_district'] = $district_single['id'];
                                }
                            }
                        }
                    }

                    $result['address'] = $rawdata;

                    //$result['message'] = 'Data alamat tidak valid';
                    //return $result;
                }
                
                
            }else{
                $result['message'] = 'Alamat tidak valid';
                //return $result;
            }
        }
        
        return $result;

    }


    public static function getDrivingDistance($lat1, $long1, $lat2, $long2, $mapType = null) {
        if (!isset($mapType))
            $mapType = EnvironmentVariable::getValue("MAPS_TYPE");

        if (isset($mapType)
            && $mapType == "ALTERNATIVES") {
            $appIDHere = HERE_APP_ID;
            $appCodeHere = HERE_APP_CODE;
            $randomKey = rand(1,3);
            if ($randomKey == 3) {
                $appIDHere = HERE_APP_ID_3;
                $appCodeHere = HERE_APP_CODE_3;
            } elseif ($randomKey == 2) {
                $appIDHere = HERE_APP_ID_2;
                $appCodeHere = HERE_APP_CODE_2;
            }

            $url = "https://route.api.here.com/routing/7.2/calculateroute.json?app_id=" . $appIDHere.
                "&app_code=" . $appCodeHere.
                "&waypoint0=geo!" . $lat1 . "," . $long1.
                "&waypoint1=geo!" . $lat2 . "," . $long2.
                "&mode=fastest;car;traffic:disabled";

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL               => $url,
                CURLOPT_RETURNTRANSFER    => true,
                CURLOPT_FOLLOWLOCATION    => true,
                CURLOPT_MAXREDIRS         => 10,
                CURLOPT_TIMEOUT           => 30,
                CURLOPT_CUSTOMREQUEST     => 'GET',
            ));

            $response = curl_exec($curl);
            curl_close($curl);

            $arrayResponse = json_decode($response, true);
            $dist = array(
                'value' => 0,
                'text' => "",
                'response_raw' => (isset($arrayResponse['response']) ? $arrayResponse['response'] : $arrayResponse));

            if (isset($arrayResponse['response']['route']) && !empty($arrayResponse['response']['route'])) {
                $dist['value'] = $arrayResponse['response']['route'][0]['summary']['distance'];
                $dist['text'] = $arrayResponse['response']['route'][0]['summary']['text'];
            }

            if ($dist['value'] != 0) {
                return $dist;
            } else {
                return self::getDrivingDistance($lat1, $long1, $lat2, $long2, "GMAPS");
            }
        } else {
            $url = "https://maps.googleapis.com/maps/api/distancematrix/json?key=" . GMAP_KEY . "&origins=" . $lat1 . "," . $long1 . "&destinations=" . $lat2 . "," . $long2 . "&mode=driving&language=en-EN";

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $response = curl_exec($ch);
            curl_close($ch);

            $response_a = json_decode($response, true);
            $dist = array(
                'value' => 0,
                'text' => "",
                'response_raw' => $response_a);

            if (isset($response_a['rows']) && !empty($response_a['rows'])) {
                $dist['value'] = $response_a['rows'][0]['elements'][0]['distance']['value'];
                $dist['text'] = $response_a['rows'][0]['elements'][0]['distance']['text'];
            }

            return $dist;
        }
    }

    public static function getDirectDistance($latitude1, $longitude1, $latitude2, $longitude2) {  
        $earth_radius = 6371;  // in kilometer
        $latitude1 = floatval($latitude1);
        $longitude1 = floatval($longitude1);
        $latitude2 = floatval($latitude2);
        $longitude2 = floatval($longitude2);

        $dLat = deg2rad($latitude2 - $latitude1);  
        $dLon = deg2rad($longitude2 - $longitude1);  
          
        $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * sin($dLon/2) * sin($dLon/2);  
        $c = 2 * asin(sqrt($a));  
        $d = $earth_radius * $c;  
          
        return $d;  
    }

    public static function getDirectDistanceAlt($modelCartDetail) {
        $lng1   = $modelCartDetail->longitude;
        $lng2   = $modelCartDetail->outlet->longitude;
        $lat1   = $modelCartDetail->latitude;
        $lat2   = $modelCartDetail->outlet->latitude;
        $dist   = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($lng1 - $lng2));
        return rad2deg(acos($dist)) * 111.13384;
    }

    public static function getLatLong($address) {
	    $configMaps = EnvironmentVariable::model()->find("name = 'MAPS_TYPE'");
	    if (isset($configMaps)
            && isset($configMaps->value)
            && $configMaps->value == "ALTERNATIVES") {
            $q = rawurlencode($address);
	        $url = "https://us1.locationiq.com/v1/search.php?key=" . LOCATION_IQ_TOKEN . "&q=" . $q . "&format=json";

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL               => $url,
                CURLOPT_RETURNTRANSFER    => true,
                CURLOPT_FOLLOWLOCATION    => true,
                CURLOPT_MAXREDIRS         => 10,
                CURLOPT_TIMEOUT           => 30,
                CURLOPT_CUSTOMREQUEST     => 'GET',
            ));

            $response = curl_exec($curl);
            curl_close($curl);

            $arrayResponse = json_decode($response, true);
            if (isset($arrayResponse[0]['lat'])
                && isset($arrayResponse[0]['lon'])) {
                $lat = $arrayResponse[0]['lat'];
                $lng = $arrayResponse[0]['lon'];
                return array('success' => 1, 'lat' => $lat, 'long' => $lng);
            } else {
                // return array('success'=> 0, 'message' => 'tidak berhasil mendapatkan alamat');

                return self::latLongByGmaps($address);
            }
        } else {
            $url = "https://maps.googleapis.com/maps/api/geocode/json?key=" . GMAP_KEY . "&address=" . urlencode($address) . "&sensor=true";

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $response = curl_exec($ch);
            curl_close($ch);

            $response_a = json_decode($response, true);
            if (isset($response_a['results'][0]['geometry']['location']['lat']) && isset($response_a['results'][0]['geometry']['location']['lng'])) {
                $lat = $response_a['results'][0]['geometry']['location']['lat'];
                $lng = $response_a['results'][0]['geometry']['location']['lng'];
                return array('success' => 1, 'lat' => $lat, 'long' => $lng);
            } else {
                return array('success'=> 0, 'message' => 'tidak berhasil mendapatkan alamat');
            }
        }
    }

    public static function getAddress($lat, $long) {
        $configMaps = EnvironmentVariable::model()->find("name = 'MAPS_TYPE'");
        if (isset($configMaps)
            && isset($configMaps->value)
            && $configMaps->value == "ALTERNATIVES") {
            $url = "https://us1.locationiq.com/v1/reverse.php?key=" . LOCATION_IQ_TOKEN . "&lat=" . $lat . "&lon=" . $long . "&format=json&accept-language=id";

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL               => $url,
                CURLOPT_RETURNTRANSFER    => true,
                CURLOPT_FOLLOWLOCATION    => true,
                CURLOPT_MAXREDIRS         => 10,
                CURLOPT_TIMEOUT           => 30,
                CURLOPT_CUSTOMREQUEST     => 'GET',
            ));

            $response = curl_exec($curl);
            curl_close($curl);

            $result = array();
            $arrayResponse = json_decode($response, true);

            if (!isset($arrayResponse) || !isset($arrayResponse['display_name']))
                return self::addressByGmaps($lat, $long);

            $rawAlamat = explode(", ", $arrayResponse['display_name']);
            $rawAlamat = array_reverse($rawAlamat);
            for ($i = 0; $i < count($rawAlamat); $i++) {
                if ($i == 0) {
                    $result['negara'] = $rawAlamat[$i];
                } elseif ($i == 1 && is_numeric($rawAlamat[$i])) {
                    $result['zip_code'] = $rawAlamat[$i];
                } elseif ($i == 2 || $i == 1) {
                    $result['provinsi'] = $rawAlamat[$i];
                } elseif ($i == 3 || $i == 2) {
                    $result['kota'] = $rawAlamat[$i];
                } elseif ($i == 4 || $i == 3) {
                    $result['kecamatan'] = $rawAlamat[$i];
                } elseif ($i == 5 || $i == 4) {
                    $result['kelurahan'] = $rawAlamat[$i];
                } elseif (!isset($result['address'])) {
                    $result['address'] = $rawAlamat[$i];
                } else {
                    $result['address'] = $rawAlamat[$i] . ", " . $result['address'];
                }
            }

            if (isset($result['address'])) {
                $matches = null;
                $re = '/[^\x00-\x7F]/m';
                preg_match_all($re, $result['address'], $matches);

                if (isset($matches[0]) && !empty($matches[0]))
                    $result['address'] = " ";
            }

            $country = "";
            $province = "";
            $city = "";
            $district = "";

            if (isset($result['negara']))
                $country = self::clean($result['negara']);
            if (isset($result['provinsi']))
                $province = self::clean($result['provinsi']);
            if (isset($result['kota']))
                $city = self::clean($result['kota']);
            if (isset($result['kecamatan']))
                $district = self::clean($result['kecamatan']);

            $id_country = null;
            $id_province = null;
            $id_city = null;
            $id_district = null;

            $id_country = self::searchCountry($country);
            if ($id_country == 2) {
                $result['id_country'] = 2;
                $result['id_province'] = 101;
                $result['id_city'] = 9494;
                $result['id_district'] = 9471115;
            } elseif ($id_country == 3) {
                $result['id_country'] = 3;
                $result['id_province'] = 102;
                $result['id_city'] = 9491;
                $result['id_district'] = 9471112;
            } elseif ($id_country == 4) {
                $result['id_country'] = 4;
                $result['id_province'] = 103;
                $result['id_city'] = 9492;
                $result['id_district'] = 9471113;
            } elseif ($id_country == 6) {
                /*
                $result['id_country'] = 6;
                $result['id_province'] = 104;
                $result['id_city'] = 9493;
                $result['id_district'] = 9471114;
                */

                $result = self::addressByGmaps($lat, $long);
            } elseif ($id_country == 1) {
                // find province
                if ($id_country != 0)
                    $id_province =  self::searchProvince($province, $id_country);

                // find city
                if ($id_province != 0)
                    $id_city = self::searchCity($city, $id_province);

                // find district
                if ($id_city != 0)
                    $id_district = self::searchDistrict($district, $id_city);

                if ($id_district == 0 && $id_country != 0 && $id_province != 0 && $id_city != 0) {
                    $alternative = self::searchDistrictAlternate($district, $id_city,  $id_province, $id_country);
                    if (isset($alternative['id_district'])
                        && isset($alternative['id_city'])
                        && isset($alternative['id_province'])
                        && isset($alternative['id_country'])
                    ) {
                        $id_country = $alternative['id_country'];
                        $id_province = $alternative['id_province'];
                        $id_city = $alternative['id_city'];
                        $id_district = $alternative['id_district'];
                    }
                }

                $result['id_country'] = $id_country;
                $result['id_province'] = $id_province;
                $result['id_city'] = $id_city;
                $result['id_district'] = $id_district;

                if ($id_country == null || $id_country == 0
                    || $id_province == null || $id_province == 0
                    || $id_city == null || $id_city == 0
                    || $id_district == null || $id_district == 0)
                {
                    $result = self::addressByGmaps($lat, $long);
                }
            } else {
                /*
                $result['id_country'] = 6;
                $result['id_province'] = 104;
                $result['id_city'] = 9493;
                $result['id_district'] = 9471114;
                */

                $result = self::addressByGmaps($lat, $long);
            }

            return $result;
        } else {
            $url = "https://maps.googleapis.com/maps/api/geocode/json?key=" . GMAP_KEY . "&latlng=".$lat.",".$long."&sensor=true";

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            $response = curl_exec($ch);
            curl_close($ch);
            $response_a = json_decode($response, true);

            if (!isset($response_a['results'][0]['address_components']))
                return array('success' => 0, 'message' => 'alamat tidak ditemukan');

            $tmp = $response_a['results'][0]['address_components'];

            $result = array();
            foreach ($tmp as $key) {
                if ($key['types'][0] == 'administrative_area_level_4')
                    $result['kelurahan'] = $key['long_name'];
                elseif ($key['types'][0] == 'administrative_area_level_3')
                    $result['kecamatan'] = $key['long_name'];
                elseif ($key['types'][0] == 'administrative_area_level_2')
                    $result['kota'] = $key['long_name'];
                elseif ($key['types'][0] == 'administrative_area_level_1')
                    $result['provinsi'] = $key['long_name'];
                elseif ($key['types'][0] == 'country')
                    $result['negara'] = $key['long_name'];
                elseif ($key['types'][0] == 'route')
                    $result['address'] = $key['long_name'];
            }

            if (isset($result['address'])) {
                // $result['address'] = '区贵港市桂平';
                $matches = null;
                $re = '/[^\x00-\x7F]/m';
                preg_match_all($re, $result['address'], $matches);

                if (isset($matches[0]) && !empty($matches[0]))
                    $result['address'] = " ";
            }

            $district = "";
            $city = "";
            $province = "";
            $country = "";

            if (isset($result['kecamatan']))
                $district = self::clean($result['kecamatan']);
            if (isset($result['kota']))
                $city = self::clean($result['kota']);
            if (isset($result['provinsi']))
                $province = self::clean($result['provinsi']);
            if (isset($result['negara']))
                $country = self::clean($result['negara']);

            $id_country =  self::searchCountry($country);
            $id_province = null;
            $id_city = null;
            $id_district = null;

            if ($id_country == 2) {
                $result['id_country'] = 2;
                $result['id_province'] = 101;
                $result['id_city'] = 9494;
                $result['id_district'] = 9471115;
            } elseif ($id_country == 3) {
                $result['id_country'] = 3;
                $result['id_province'] = 102;
                $result['id_city'] = 9491;
                $result['id_district'] = 9471112;
            } elseif ($id_country == 4) {
                $result['id_country'] = 4;
                $result['id_province'] = 103;
                $result['id_city'] = 9492;
                $result['id_district'] = 9471113;
            } elseif ($id_country == 6) {
                $result['id_country'] = 6;
                $result['id_province'] = 104;
                $result['id_city'] = 9493;
                $result['id_district'] = 9471114;
            } elseif ($id_country == 1) {
                // find province
                if ($id_country != 0)
                    $id_province =  self::searchProvince($province, $id_country);

                // find city
                if ($id_province != 0)
                    $id_city = self::searchCity($city, $id_province);

                // find district
                if ($id_city != 0)
                    $id_district = self::searchDistrict($district, $id_city);

                if ($id_district == 0 && $id_country != 0 && $id_province != 0 && $id_city != 0) {
                    $alternative = self::searchDistrictAlternate($district, $id_city,  $id_province, $id_country);
                    if (isset($alternative['id_district'])
                        && isset($alternative['id_city'])
                        && isset($alternative['id_province'])
                        && isset($alternative['id_country'])
                    ) {
                        $id_country = $alternative['id_country'];
                        $id_province = $alternative['id_province'];
                        $id_city = $alternative['id_city'];
                        $id_district = $alternative['id_district'];
                    }
                }

                $result['id_country'] = $id_country;
                $result['id_province'] = $id_province;
                $result['id_city'] = $id_city;
                $result['id_district'] = $id_district;
            } else {
                $result['id_country'] = 6;
                $result['id_province'] = 104;
                $result['id_city'] = 9493;
                $result['id_district'] = 9471114;
            }

            return $result;
        }
    }

    private static function latLongByGmaps($address) {
        $url = "https://maps.googleapis.com/maps/api/geocode/json?key=" . GMAP_KEY . "&address=" . urlencode($address) . "&sensor=true";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        $response = curl_exec($ch);
        curl_close($ch);

        $response_a = json_decode($response, true);
        if (isset($response_a['results'][0]['geometry']['location']['lat']) && isset($response_a['results'][0]['geometry']['location']['lng'])) {
            $lat = $response_a['results'][0]['geometry']['location']['lat'];
            $lng = $response_a['results'][0]['geometry']['location']['lng'];
            return array('success' => 1, 'lat' => $lat, 'long' => $lng);
        } else {
            return array('success'=> 0, 'message' => 'tidak berhasil mendapatkan alamat');
        }
    }

    private static function addressByGmaps($lat, $long) {
        $url = "https://maps.googleapis.com/maps/api/geocode/json?key=" . GMAP_KEY . "&latlng=".$lat.",".$long."&sensor=true";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        $response_a = json_decode($response, true);

        if (!isset($response_a['results'][0]['address_components']))
            return array('success' => 0, 'message' => 'alamat tidak ditemukan');

        $tmp = $response_a['results'][0]['address_components'];

        $result = array();
        foreach ($tmp as $key) {
            if ($key['types'][0] == 'administrative_area_level_4')
                $result['kelurahan'] = $key['long_name'];
            elseif ($key['types'][0] == 'administrative_area_level_3')
                $result['kecamatan'] = $key['long_name'];
            elseif ($key['types'][0] == 'administrative_area_level_2')
                $result['kota'] = $key['long_name'];
            elseif ($key['types'][0] == 'administrative_area_level_1')
                $result['provinsi'] = $key['long_name'];
            elseif ($key['types'][0] == 'country')
                $result['negara'] = $key['long_name'];
            elseif ($key['types'][0] == 'route')
                $result['address'] = $key['long_name'];
        }

        if (isset($result['address'])) {
            // $result['address'] = '区贵港市桂平';
            $matches = null;
            $re = '/[^\x00-\x7F]/m';
            preg_match_all($re, $result['address'], $matches);

            if (isset($matches[0]) && !empty($matches[0]))
                $result['address'] = " ";
        }

        $district = "";
        $city = "";
        $province = "";
        $country = "";

        if (isset($result['kecamatan']))
            $district = self::clean($result['kecamatan']);
        if (isset($result['kota']))
            $city = self::clean($result['kota']);
        if (isset($result['provinsi']))
            $province = self::clean($result['provinsi']);
        if (isset($result['negara']))
            $country = self::clean($result['negara']);

        $id_country =  self::searchCountry($country);
        $id_province = null;
        $id_city = null;
        $id_district = null;

        if ($id_country == 2) {
            $result['id_country'] = 2;
            $result['id_province'] = 101;
            $result['id_city'] = 9494;
            $result['id_district'] = 9471115;
        } elseif ($id_country == 3) {
            $result['id_country'] = 3;
            $result['id_province'] = 102;
            $result['id_city'] = 9491;
            $result['id_district'] = 9471112;
        } elseif ($id_country == 4) {
            $result['id_country'] = 4;
            $result['id_province'] = 103;
            $result['id_city'] = 9492;
            $result['id_district'] = 9471113;
        } elseif ($id_country == 6) {
            $result['id_country'] = 6;
            $result['id_province'] = 104;
            $result['id_city'] = 9493;
            $result['id_district'] = 9471114;
        } elseif ($id_country == 1) {
            // find province
            if ($id_country != 0)
                $id_province =  self::searchProvince($province, $id_country);

            // find city
            if ($id_province != 0)
                $id_city = self::searchCity($city, $id_province);

            // find district
            if ($id_city != 0)
                $id_district = self::searchDistrict($district, $id_city);

            if ($id_district == 0 && $id_country != 0 && $id_province != 0 && $id_city != 0) {
                $alternative = self::searchDistrictAlternate($district, $id_city,  $id_province, $id_country);
                if (isset($alternative['id_district'])
                    && isset($alternative['id_city'])
                    && isset($alternative['id_province'])
                    && isset($alternative['id_country'])
                ) {
                    $id_country = $alternative['id_country'];
                    $id_province = $alternative['id_province'];
                    $id_city = $alternative['id_city'];
                    $id_district = $alternative['id_district'];
                }
            }

            $result['id_country'] = $id_country;
            $result['id_province'] = $id_province;
            $result['id_city'] = $id_city;
            $result['id_district'] = $id_district;
        } else {
            $result['id_country'] = 6;
            $result['id_province'] = 104;
            $result['id_city'] = 9493;
            $result['id_district'] = 9471114;
        }

        return $result;
    }

    private static function sortByDrivingDistance($a, $b) {
        return $a['driving_distance'] > $b['driving_distance'];
    }

    private static function sortByDirectDistance($a, $b) {
        return $a['direct_distance'] > $b['direct_distance'];
    }
    
    public static function getOutletTerdekat($listOutlet, $latitude, $longitude){
        $dataOutlet = array();
        
        $idOutlets = "";
        foreach ($listOutlet as $id) {
            if($idOutlets == "")
                $idOutlets .= $id;
            else
                $idOutlets .= "," . $id;
        }


        $sqlOutlet = 'select location.id, location.name, location.latitude, location.longitude from location inner join stock_outlet on stock_outlet.outlet_code = location.kode_outlet where id in ('.$idOutlets.')';   
        $outlets = Yii::app()->db->createCommand($sqlOutlet)->queryAll();

        $tmpSort = array();
        foreach ($outlets as $outlet) {
            $dist = Map::getDirectDistance($outlet['latitude'], $outlet['longitude'], $latitude, $longitude);
            $outlet['direct_distance'] = $dist;
            array_push($tmpSort, $outlet);
        }
        
        usort($tmpSort, array('Map', 'sortByDirectDistance'));
        
        $nearOutlets = array();
        $limit = 3;
        if(count($tmpSort) < $limit)
            $limit = count($tmpSort);
        for ($i=0; $i < $limit; $i++) { 
            $outlet = $tmpSort[$i];
            $dist = Map::getDrivingDistance($outlet['latitude'], $outlet['longitude'], $latitude, $longitude);
            $outlet['driving_distance'] = $dist['value']/1000.0;
            array_push($nearOutlets, $outlet);
        }

        usort($nearOutlets, array('Map', 'sortByDrivingDistance'));

        return $nearOutlets[0];
    }

    public static function getDirectDistance2($latitude1="", $longitude1="", $latitude2="", $longitude2="") {  

        $earth_radius = 6371;  // in kilometer
        $latitude1 = floatval($latitude1);
        $longitude1 = floatval($longitude1);
        $latitude2 = floatval($latitude2);
        $longitude2 = floatval($longitude2);

        $dLat = deg2rad($latitude2 - $latitude1);  
        $dLon = deg2rad($longitude2 - $longitude1);  
          
        $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * sin($dLon/2) * sin($dLon/2);  
        $c = 2 * asin(sqrt($a));  
        $d = $earth_radius * $c;  
          
        return $d;  
    }

}

?>