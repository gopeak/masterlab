<?php

namespace main\app\classes;

class Instance
{
    private static $_instances = [];
    
    public static function getInstance()
    {
        $class = static::className();
        if (empty(self::$_instances[$class])) {
            self::$_instances[$class] = new $class();
        }
        return self::$_instances[$class];
    }
    
    public static function className()
    {
        return get_called_class();
    }
    
    protected function __construct()
    {
        
    }
}
