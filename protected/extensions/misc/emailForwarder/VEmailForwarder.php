<?php

class VEmailForwarder extends CWidget {

    public static function getEmail($email){
        if(!preg_match("/.*k24klik\.com.*/i", OBAT24_SERVER)){
            if(!preg_match("/.*\@k24\.co\.id/", $email) && !preg_match("/.*\@k24klik\.com/", $email)){
                // $email = Yii::app()->params['adminEmail'];
                $email = EMAIL_CS;
            }
        }
        
        return $email;
    }

}