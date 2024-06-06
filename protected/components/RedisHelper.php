<?php

class RedisHelper {

    public $redis;
    public $valid = true;
    private static $instance;
    protected $keyName;

    private function __construct()
    {
        if ($this->valid) {
            // Hide the constructor
            require_once(dirname(__FILE__).'/../extensions/predis/autoload.php');
            Predis\Autoloader::register();
            $this->redis = new Predis\Client();
        }
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function set($post = [], $expr=50000)
    {
        if (!$this->valid) {
            return null;
        }

        if (!isset($post['key'], $post['value']))
            return null;

        $key = $post['key'];
        $value = (array)$post['value'];
		try {
            $json = json_encode($value);
            $this->redis->set($key, $json);
            $this->redis->expire($key, $expr);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function get($key='')
    {
        if (!$this->valid) {
            return null;
        }

        if (empty($key))
            return null;

        $result = false;
        try {
            $redis = $this->redis;
            $result = $redis->get($key);
        } catch (Exception $e) {
            return null;
        }
        
        if (!$result)
            return null;

        return json_decode($result, true);
    }

    public function setNull($key = null, $expr = 0)
    {
        if (!$this->valid) {
            return null;
        }
        
        if (!isset($key))
            return null;

        try {
            $this->redis->set($key, null);
		    $this->redis->expire($key, $expr);
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * Naming convention for redis
     * feature:object:data:subobject
     * 
     * feature  : feature name
     * object   : model 
     * data     : key/identifier 
     * subobject: model
     * 
     * Example
     * desktop:list_product:10
     * 
     * Redis keys Standard Naming Conventions rules :
     * Keys are binary-safe. Any valid string including an empty string is a valid key
     * Key allowed maximum size is 512MB
     * Large size keys are not recommended due to slow performance in search and lookup cost involved.
     * Also, Short keys are not recommended such as e11r, Instead, employee:11:roles is more readable.
     * Design a schema for easy to understand by others
     * Grouping the parts of objects with data using a separator is a good idea for naming keys.
     * Also, if you are working on multiple applications, you can use namespaces for each application to differentiate between applications
     *
     * reference: https://www.w3schools.io/nosql/redis-keys-naming-convention/
     * 
     * @param string $feature
     * @param string $model
     * @param string $identifier
     * @param string $subObject 
     * @return string $keyName
     **/
    public function setKeyName($feature, $model, $identifier, $subObject = "")
    {
        $keyName = "{$feature}:{$model}:{$identifier}";

        $keyName .= (!empty($subObject) ? ":{$subObject}" : "");

        return $this->keyName = $keyName;
    }

    public function getKeyName()
    {
        return $this->keyName;
    }

    public function checkAvailableKeysByPattern($pattern) {
        return RedisHelper::getInstance()->redis->executeRaw(['KEYS', $pattern]);
    }
}