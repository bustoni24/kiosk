<?php

date_default_timezone_set("Asia/Jakarta");

class UserIdentity extends CUserIdentity {
    private $_id; //set id untuk unique identifier
    public $role;
    public $arPermission = array('');	
    public $error_msg = "";

    public function authenticate() {
        $user = $this->username;
        $pass = $this->password;
        
        $ip = isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : null);
        $userAgent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] . ', IP: ' . $ip : $ip;
        $parameters = [
            'url' => 'apiMobile/login',
            'parameter' => [
                'method' => 'POST',
                'postfields' => [
                    'username' => $user,
                    'password' => md5($pass),
                    'user_agent' => $userAgent,
                    'type' => 'admin'
                ]
            ]
        ];
        $login = ApiHelper::getInstance()->callUrl($parameters);
        // Helper::getInstance()->dump($login);
        if (isset($login['data'])) {
            $this->_id = $login['data']['id'];
            $this->setState('sdm_id', $login['data']['sdm_id']);
            $this->setState('username', $login['data']['username']);
            $this->setState('role', $login['data']['role']);
            $this->setState('nama', $login['data']['name']);
            $this->setState('no_hp', $login['data']['no_hp']);
            $this->setState('alamat', $login['data']['alamat']);
            $this->setState('saldo', $login['data']['saldo']);
            $this->setState('tipe_agen', $login['data']['tipe_agen']);
            $this->setState('agen_id', $login['data']['agen_id']);
            $this->setState('tipe_sdm', isset($login['data']['tipe_sdm']) ? $login['data']['tipe_sdm'] : 'efisiensi');
            $this->setState('titik_id', isset($login['data']['titik_id']) ? $login['data']['titik_id'] : null);
            $this->setState('must_deposit', isset($login['data']['must_deposit']) ? $login['data']['must_deposit'] : null);
            $this->setState('user_agent', $userAgent);

            $this->errorCode = self::ERROR_NONE;

            return !$this->errorCode;
        } else {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
            return !$this->errorCode;
        }
    }

    public function updateSaldoSate($saldo = null)
    {  
        if (isset($saldo)) {
            $this->setState('saldo', $saldo);
        }
    }

    public function getId() {
        return $this->_id;
    }
    
}