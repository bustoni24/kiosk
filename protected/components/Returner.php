<?php
/**
 * Created by PhpStorm.
 * User: rohman
 * Date: 14/01/20
 * Time: 15:34
 */

class Returner {

    const ERROR_NOT_SET = 1;
    const ERROR_EMPTY = 2;
    const ERROR_NOT_MATCH = 3;

    private $result = ['success' => false, 'message' => "Terjadi kesalahan", 'message_debug' => ""];
    public $log;
    public $errorMessage;
    public $removeDebugging = true;

    function put($key, $value = null) {
        if (is_array($key)) {
            foreach ($key as $key_ => $value_) {
                $this->result[$key_] = $value_;
            }
        } else {
            $this->result[$key] = $value;
        }
    }

    function putAdd($key, $value = null) {
        if (is_array($key)) {
            foreach ($key as $key_ => $value_) {
                if (isset($this->result[$key_]))
                    $this->result[$key_] .= " > " . $value_;
                else
                    $this->result[$key_] = $value_;
            }
        } else {
            if (isset($this->result[$key]))
                $this->result[$key] .= " > " . $value;
            else
                $this->result[$key] = $value;
        }
    }

    function get($key) {
        if (isset($this->result[$key]))
            return $this->result[$key];
        return null;
    }

    function attachLogger($log) {
        $this->log = $log;
    }

    function success($message = "") {
        $this->result['success'] = true;
        $this->result['message'] = $message;
        $this->result['message_debug'] = "";

        return $this->dump();
    }

    function dump($message = null, $messageDebug = null) {
        if (isset($message))
            $this->result['message'] = $message;
        if (isset($messageDebug))
            $this->result['message_debug'] = $messageDebug;
        if (isset($this->log) && method_exists($this->log, 'write')) {
            $resultLog = $this->result;
            unset($resultLog['cartDetail'], $resultLog['cart_detail'], $resultLog['shopeepayLog']);
            $this->log->write("returnerDump::" . json_encode($resultLog));
        }
        if ($this->removeDebugging)
            unset($this->result['message_debug']);
        return $this->result;
    }

    function unsets($key) {
        if (isset($this->result[$key]))
            unset($this->result[$key]);
    }

    function has($key) {
        if (isset($this->result[$key]))
            return true;
        else
            return false;
    }

    function successV2($message = "") {
        $this->result['success'] = true;
        $this->result['message'] = $message;
        $this->result['resultCode'] = 200;

        return $this->dump();
    }

    function dumpV2($message = null, $messageDebug = null, $resultCode = null, $custom = []) {
        if (isset($message))
            $this->result['message'] = $message;
        if (isset($custom['name'], $custom['value'])){
            $this->result[$custom['name']] = $custom['value'];
        }
        if (isset($messageDebug))
            $this->result['message_debug'] = $messageDebug;
        if (isset($resultCode)){
            $this->result['resultCode'] = $resultCode;
            http_response_code($resultCode);
        }
        if (isset($this->log) && method_exists($this->log, 'write')) {
            $resultLog = $this->result;
            unset($resultLog['cartDetail'], $resultLog['cart_detail'], $resultLog['shopeepayLog']);
            $this->log->write("returnerDump::" . json_encode($resultLog));
        }
        if ($this->removeDebugging)
            unset($this->result['message_debug']);
        return $this->result;
    }

    function display($message = null, $messageDebug = null) {
        echo json_encode($this->dump($message, $messageDebug));
        return $this->result;
    }

    function displaySuccess($message = "") {
        echo json_encode($this->success($message));
        return $this->result;
    }

    function getErrorMessage($parameter = [], $error_type)
    {
        $this->errorMessage = [];
        if (!empty($parameter) && isset($error_type)) {
            foreach ($parameter as $name => $param_) {
                switch ($error_type) {
                    case self::ERROR_NOT_SET:
                        if (!$param_)
                         $this->errorMessage[] = "$name must be filled";
                        break;

                    case self::ERROR_EMPTY:
                        if (!$param_)
                            $this->errorMessage[] = "$name cannot be blank";
                        break;

                    case self::ERROR_NOT_MATCH:
                        if (!$param_)
                            $this->errorMessage[] = "invalid $name";
                        break;
                    
                    default:
                        # code...
                        break;
                }
                
            }
        }
        return $this->errorMessage;
    }
}