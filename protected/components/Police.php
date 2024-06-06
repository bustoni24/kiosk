<?php

class Police {

    public function filtering($post = [], $get = [])
    {
        $result = new Returner;

        $ipClient = $this->getClientIPOnly();
        if (Setting::getValue("IP_BLACKLIST_CONFIG", 1) && !empty($ipClient)) {
            $ip_list = array();
            $addIP = Setting::getValue("IP_BLACKLIST", "");
            if (!empty($addIP)) {
                $arrIP = explode(',', $addIP);
                foreach ($arrIP as $addIp_) {
                    array_push($ip_list, $addIp_);
                }
            }

            if (in_array($ipClient, $ip_list)) {
                return $result->dumpV2("Forbidden", null, 403);
            }
        }
        $isDdosAttackPost = $this->isDDosAttack($post);
        $isDdosAttackGet = $this->isDDosAttack($get);
        if ($isDdosAttackPost || $isDdosAttackGet) {
            $saveLog = (int)Setting::getValue("LOG_POLICE", 1) == 1;
            if ($saveLog) {

                $url = SERVER;
                $url .= "/" . Yii::app()->controller->getId();
                $url .= "/" . Yii::app()->controller->action->id;
                if (isset($_SERVER['QUERY_STRING']) && !empty($_SERVER['QUERY_STRING']))
                    $url .= "?" . $_SERVER['QUERY_STRING'];
                //save log police
                ApiHelper::getInstance()->callUrl([
                    'url' => 'apiMobile/savePolice',
                    'parameter' => [
                        'method' => 'POST',
                        'postfields' => [
                            'date' => date('Y-m-d H:i:s'),
                            'user_ip' => $this->getClientIP(),
                            'url' => $url,
                            'params' => "POST: " . json_encode($_POST) . " | GET: " . json_encode($_GET),
                            'session' => "COOKIE: " . json_encode($_COOKIE) . " | SESSION: " . json_encode($_SESSION),
                            'user_agent' => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : null,
                            ]
                    ]
                ]);
            }

            return $result->dumpV2("Oops, something wrong!", null, 503);
        }

        return $result->successV2();
    }

    public function insertLogPolice($post = [])
    {
        $addDesc = isset($post['keterangan']) ? $post['keterangan'] : '';

        $url = SERVER;
        $url .= "/" . Yii::app()->controller->getId();
        $url .= "/" . Yii::app()->controller->action->id;
        if (isset($_SERVER['QUERY_STRING']) && !empty($_SERVER['QUERY_STRING']))
            $url .= "?" . $_SERVER['QUERY_STRING'];

        ApiHelper::getInstance()->callUrl([
            'url' => 'apiMobile/savePolice',
            'parameter' => [
                'method' => 'POST',
                'postfields' => [
                    'date' => date('Y-m-d H:i:s'),
                    'user_ip' => $this->getClientIP(),
                    'url' => $url,
                    'params' => "POST: " . json_encode($_POST) . " | GET: " . json_encode($_GET) . " :: " . $addDesc,
                    'session' => "COOKIE: " . json_encode($_COOKIE) . " | SESSION: " . json_encode($_SESSION),
                    'user_agent' => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : null,
                    ]
            ]
        ]);

        $this->insertIpBlacklist();
    }

    public function insertIpBlacklist() {
        $configIpList = Setting::getValue("IP_BLACKLIST", "");
        $configIpListArr = explode(",", $configIpList);

        $ipClient = $this->getClientIPOnly();
        if (empty($ipClient))
            return false;

        if (!in_array($ipClient, $configIpListArr)) {
            $configIpList .= (!empty($configIpList) ? "," : "") . $ipClient;


            ApiHelper::getInstance()->callUrl([
                'url' => 'apiMobile/insertIpBlacklist',
                'parameter' => [
                    'method' => 'POST',
                    'postfields' => [
                        'name' => 'IP_BLACKLIST',
                        'keterangan' => 'LOG IP yang berusaha menyerang efisiensi',
                        'value' => $configIpList
                        ]
                ]
            ]);
        }
    }

    public function isDDosAttack($get) {
        $configSwitch = Setting::getValue("IP_BLACKLIST_CONFIG", 1);
        if (!$configSwitch)
            return false;

        if (!isset($get) || empty($get))
            return false;

        /* Check By Keyword */
        foreach ($get as $value) {
            if ($this->isDdosKeywordFound($value)) {

                /* Insert ke config IP ddos */
                $this->insertIpBlacklist();

                return true;
            }
        }

        return false;
    }

    public function isDdosKeywordFound($string) {

        if (!is_string($string))
            return false;

        $patterns = $this->getListDDosKeywords();
        foreach ($patterns as $pattern) {
            if (strstr($string, $pattern))
                return true;
        }        

        return false;
    }

    public function getListDDosKeywords() {
        // Pola : 
        // 1. '/**_**/AND/**_**/GTID_SUBSET'
        // 2. /**/
        // Tinggal tambahkan ke config jika ada pola2 lain
        
        $configPatterns = Setting::getValue('KEYWORD_PATTERN_DDOS', '/**_**/AND/**_**/GTID_SUBSET,/**/');
        return explode(',', $configPatterns);
    }

    public function getClientIPOnly()
    {
        $ipAddress = "";
        if (isset($_SERVER['HTTP_CLIENT_IP']) && !empty($_SERVER['HTTP_CLIENT_IP']))
            $ipAddress = $_SERVER['HTTP_CLIENT_IP'];
        elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && !empty($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipAddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        elseif (isset($_SERVER['REMOTE_ADDR']) && !empty($_SERVER['REMOTE_ADDR']))
            $ipAddress = $_SERVER['REMOTE_ADDR'];

        return $ipAddress;
    }

    public function getClientIP() {
        $ipAddress = "";
        if (isset($_SERVER['HTTP_CLIENT_IP']) && !empty($_SERVER['HTTP_CLIENT_IP']))
            $ipAddress = $_SERVER['HTTP_CLIENT_IP'] . " | HTTP_CLIENT_IP";
        elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && !empty($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipAddress = $_SERVER['HTTP_X_FORWARDED_FOR'] . " | HTTP_X_FORWARDED_FOR";
        elseif (isset($_SERVER['REMOTE_ADDR']) && !empty($_SERVER['REMOTE_ADDR']))
            $ipAddress = $_SERVER['REMOTE_ADDR'] . " | REMOTE_ADDR";

        return $ipAddress;
    }

    public function getListInjection() {
        // remove list: 'select'
        return array(
            "union", "or", "table", "concat", "version", "information_schema",
            "like", "make_set", "regexp", "substr", "extractvalue", "updatexml", "sleep", "wait",
            "insert", "show", "from", "update", "truncate", "delete", "*", "waitfor", "limit",
            "having", "xml", "database", "procedure", "replace", "elt", "bool",
            "prompt", "document.cookie"
        );
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