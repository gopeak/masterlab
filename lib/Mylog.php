<?php
namespace main\lib;

class Mylog extends Log
{

    /**
     * 用于实现单例模式
     *
     * @var \MongoDB\Collection
     */
    public static $_collectionInstance;

 
    /**
     * 数据库预连接，保存到$link变量中
     * 
     * @throws \Exception
     * @access public
     */
    public static function getCollection()
    {
        if (empty(self::$_collectionInstance)) {
            $mongoConfig = getConfigVar('cache')['mongodb']['server'];
            try {
                $mongodb = self::connect();
                $collection = $mongodb->selectCollection($mongoConfig[2], 'my_log');
                self::$_collectionInstance = $collection;
            } catch (\Exception $e) {
                
                throw new \Exception("无法选择Collection:" . $mongoConfig[2] . '   ' . $e->getMessage(), 3001);
            }
            
            if (! self::$_collectionInstance ) {
                throw new \Exception("无法选择Collection:" . $mongoConfig[2], 3001);
            }
        }
        return self::$_collectionInstance;
    }

    
    
    
}