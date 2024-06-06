<?php

class Firebase {

    private static $title;
    private static $message;
    private static $image;
    private static $data;

    public static function setTitle($title) {
        self::$title = $title;
    }

    public static function setMessage($message) {
        self::$message = $message;
    }

    public static function setImage($imageUrl) {
        self::$image = $imageUrl;
    }

    public static function setPayload($data) {
        self::$data = $data;
    }

    public static function getPush() {
        $res = array();
        //$res['notification']['title'] = self::$title;
        //$res['notification']['text'] = self::$message;
        $res['data'] = self::$data;

        return $res;
    }

    public static function sendEventMessage($event_name = null, $raw = []) {
        if (count($raw) == 0 || !isset($event_name))
            return false;

        $title = Constant::PROJECT_NAME;
        $messageText = "Ulala [uhuy] sudah tersedia.";
        foreach ($raw as $key => $item) {
            $find[] = "[".$key."]";
            $replace[] = $item;
        }
        $messageText = str_replace($find, $replace, $messageText);

        self::setTitle($title);
        self::setMessage($messageText);

        $payload = array();
        $payload['message_title'] = $title;
        $payload['message'] = $messageText;
        if (isset($raw['payload'])) {
            foreach ($raw['payload'] as $key => $datum)
                $payload[$key] = $datum;
        }
        self::setPayload($payload);

        $data = self::getPush();
        
        $userID = isset($raw['user_id']) ? $raw['user_id'] : "";
        if (empty($userID))
            return false;
            

        $user = User::model()->findByPk($userID);
        if (!isset($user))
            return false;

        $success = 0;
        // return $data;
        // send to android
        if (isset($user->firebase_token_android)) {
            $response = self::send($user->firebase_token_android, $data);
            
            if (!isset($response))
                return false;

            $arrayResponse = json_decode($response);
            if ($arrayResponse->success == 1)
                $success = 1;
        }
        // return $response;

        // send to iOS
        if (isset($user->firebase_token_ios)) {
            $response = self::send($user->firebase_token_ios, $data, "IOS");
            if (!isset($response))
                return false;

            $arrayResponse = json_decode($response);
            if ($arrayResponse->success == 1)
                $success = 1;
        }

        if (isset($raw['armada_id']) && !empty($raw['armada_id'])){
            $armadaID = $raw['armada_id'];
        }

        // save message
        $message = new Message();
        $message->user_id = $userID;
        $message->sender_id = 2;
        $message->date = Date("Y-m-d H:i:s");
        if (isset($armadaID) && !empty($armadaID))
            $message->armada_id = $armadaID;
        $message->message = $messageText;
        $message->event_name = $event_name;
        $message->is_sent = $success;
        if(!$message->save()){
            var_dump("ERROR::".json_encode($message->getErrors()));
            exit;
        }

        return true;
    }

    public static function send($to, $data, $targetOS = "ANDROID") {
        if ($targetOS == "ANDROID") {
            $fields = array(
                'to' => $to,
                'data' => $data['data'],
            );
        } else {
            $fields = array(
                'to' => $to,
                'priority' => 'high',
                'notification' => ['title' => self::$title, 'body' => self::$message, 'message' => self::$message],
                'data' => $data['data'],
            );
        }
        return self::sendPushNotification($fields);
    }

    private static function sendPushNotification($fields) {
        $url = 'https://fcm.googleapis.com/fcm/send';
        $headers = array(
            'Authorization: key=' . FIREBASE_API_KEY,
            'Content-Type: application/json'
        );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        $result = curl_exec($ch);
        if ($result === FALSE) {
            // die('Failed to Send Notification: ' . curl_error($ch));
            return null;
        }

        curl_close($ch);

        return $result;
    }
}