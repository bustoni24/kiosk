<?php

date_default_timezone_set("Asia/Jakarta");

class UserIdentitySystem extends CUserIdentity {
    private $_id; //set id untuk unique identifier
    public $role;
    public $arPermission = array('');	

    public function authenticate() {
        $user = $this->username;
        $pass = $this->password;

        $login = ApiHelper::getInstance()->callUrl([
            'url' => 'api/v1/kiosk/loginBySistem',
            'parameter' => [
                'method' => 'POST',
                'postfields' => [
                    'username' => $user,
                    'password' => $pass
                ]
            ]
        ]);
        if (!isset($login['data'])) {
            Helper::getInstance()->dump($login['message']);
        }
        $login = (object)$login['data'];
        if ($login != null) {
            $this->_id = $login->id;
            $this->setState('id_passenger', $login->id);
            $this->setState('username', $user);
            $this->setState('nik', $login->nik);
            $this->setState('role', 'public');
            $this->setState('nama', $login->name);
            $this->setState('no_hp', $login->no_hp);

            $this->errorCode = self::ERROR_NONE;

            return !$this->errorCode;
        } else {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
            return !$this->errorCode;
        }
    }

    public function getId() {
        return $this->_id;
    }

}
