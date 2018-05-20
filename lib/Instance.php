<?php

namespace main\app\classes;

class Instance
{
    private static $instances = [];
    
    public static function getInstance()
    {
        $class = static::className();
        if (empty(self::$instances[$class])) {
            self::$instances[$class] = new $class();
        }
        return self::$instances[$class];
    }
    
    public static function className()
    {
        return get_called_class();
    }
    
    protected function __construct()
    {
    }
}
