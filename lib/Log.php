<?php
namespace main\lib;


class Log
{

    /**
     * 用于实现单例模式
     *
     * @var \MongoDB\Collection
     */
    public static $_collectionInstance;

    /**
     * 用于实现单例模式
     *
     * @var \MongoDB
     */
    public static $_mongodbInstance;

    /**
     * 数据库预连接，保存到$link变量中
     * 
     * @throws PDOException
     * @access public
     */
    public static function connect()
    {
        if (empty(self::$_mongodbInstance)) {
            try {
                $mongoConfig =  getConfigVar('cache')['mongodb']['server'];
                $monogoClient = new \MongoDB\Client("mongodb://{$mongoConfig[0]}:{$mongoConfig[1]}");
                self::$_mongodbInstance = $monogoClient;
            } catch (\Exception $e) {
                throw new \Exception("无法连接mongodb数据库！" . $e->getMessage(), 3001);
            }
            
            if ( !self::$_mongodbInstance ) {
                throw new \Exception("无法连接mongodb数据库！", 3001);
            }
        }
        
        return self::$_mongodbInstance;
    }

    /**
     * 数据库预连接，保存到$link变量中
     * 
     * @throws PDOException
     * @access public
     */
    public static function getCollection()
    {
        if (empty(self::$_collectionInstance)) {
            try {
                $mongoConfig =  getConfigVar('cache')['mongodb']['server'];
                $mongodb = self::connect();
                $collection = $mongodb->selectCollection($mongoConfig[2], 'php_log');
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

    public static function insertLog( $type, $msg ,$module='' )
    {
        $collection = self::getCollection();
        if( !is_string( $msg ) ) $msg = json_encode( $msg );
        $collection->insertOne( [ 'type' => $type, 'msg' => $msg ."<hr>\n", 'module'=>$module, 'time'=>time() ] );
        
    }
    
    
    public static function debug(  $msg ,$module='' )
    {
        self::insertLog( __FUNCTION__, $msg , $module );
        
    }
    
    
    public static function warn(  $msg ,$module='' )
    {
        self::insertLog( __FUNCTION__, $msg , $module );
    
    }
       
    public static function error(  $msg ,$module='' )
    {
        self::insertLog( __FUNCTION__, $msg , $module );
    
    }
         
    public static function notic(  $msg ,$module='' )
    {
        self::insertLog( __FUNCTION__, $msg , $module );
    
    }
     
    

    public static function fatal(  $msg ,$module='' )
    {
        self::insertLog( __FUNCTION__, $msg , $module );
    
    }
    
 
    
    
    
}