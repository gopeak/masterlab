<?php
 namespace main\lib;

/**
 *  https://github.com/phpredis/phpredis/
 * \Redis 缓存抽象层
 */
class MyRedis
{

    public $config;

    /**
     *  redis实例,高级用法请直接通过此属性调用
     * @var \Redis
     */
    public $redis;

    public $use;

    public $connected = false;


    /**
     * MyRedis constructor.
     * @param  array $config
     * @param bool $use
     */
    public function __construct( $config, $use = false)
    {
        $this->config = $config;
        $this->use = $use;
    }

    /***
     * 连接 redis服务器
     * @return bool
     * @throws \Exception
     */
    public function connect()
    {
        if ( !$this->use ){
            return false;
        }
        if (! is_object($this->redis)) {
            if (! extension_loaded("redis")) {
                throw new \Exception('\Redis extension is not loaded!', 500);
            }
            
            $redis = new \Redis();
            foreach ( $this->config as $info) {
                $redis->connect($info[0], $info[1]);
            }
            
            $redis->setOption(\Redis::OPT_SERIALIZER, \Redis::SERIALIZER_PHP);
            $this->redis = $redis;
            $this->connected = true;
        }
        return true;
    }
    
    
    public function pconnect( $timeout = 15)
    {
        if ( !$this->use ){
            return false;
        }

        if (! is_object($this->redis)) {
            if (! extension_loaded("redis")) {
                throw new \Exception('\Redis extension is not loaded!', 500);
            }
    
            $redis = new \Redis();
            foreach ( $this->config as $info) {
                $redis->pconnect($info[0], $info[1], $timeout);
            }
    
            $this->redis = $redis;
            $this->connected = true;
        }
        return $this->redis;
    }

    public function get($key)
    {
        if (! $this->connect())
            return false;
        $flag = $this->redis->get($key);
        // var_dump( $flag );
        return $flag;
    }

    /**
     * 将数据从缓存中取出
     * 
     * @param string $keys  array('key0', 'key1', 'key5')
     * @global $this->redis 为\Redis类的对象
     * @return mixed
     */
    public function mget( $keys )
    {
        if (! $this->connect()){
            return false;
        }
        return $this->redis->mGet($keys);
    }

    /**
     * 存储多个键值，
     * 
     * @param string $key  array('key0' => 'value0', 'key1' => 'value1')
     * @global $this->redis 为\Redis类的对象
     * @return bool
     */
    public function mset($keys )
    {
        if (! $this->connect()){
            return false;
        }
        return $this->redis->mSet( $keys );
    }

    /**
     * 将数据存入缓存中
     * 
     * @param string $key  key
     * @param mixed $value  要存入的数据
     * @param int $life 存活时间
     * @global $this->redis 为\Redis类的对象
     * @return bool
     */
    public function set($key, $value, $life = 0)
    {
        if (empty($key)) {
            return false;
        }
        if (! $this->connect()){
            return false;
        }

        $flag = $this->redis->set($key, $value, $life);
        if (! $flag) {
            Log::error( " redis set $key  ".print_r($value ,true )."  error "  , 'redis/error'); 
        }
        return $flag;
    }

    /**
     * 将数据更新到缓存中，如果存在缓存
     * 
     * @param string $key  key
     * @param mixed $value  要存入的数据
     * @global $this->redis 为\Redis类的对象
     * @return bool
     */
    public function replace( $key, $value )
    {
        if (! $this->connect()){
            return false;
        }

        $flag = $this->redis->getSet($key, $value );
        
        if (! $flag) {
            Log::error( " redis replace $key ".print_r($value ,true )." error "  , 'redis/error');
        }
        return $flag;
    }

    /**
     * 删除
     * 
     * @param mixed  $key  key
     * @global $this->redis 为\Redis类的对象
     */
    public function delete( $key )
    {
        if (! $this->connect()){
            return ;
        }
         $this->redis->delete( $key );
    }

    /**
     * 清除公共缓存
     * 
     * @param   $keys
     * @return bool
     */
    public function clearCache( $keys )
    {
        if (! $this->connect()){
            return false;
        }

        foreach( $keys as $key ) {
             $this->redis->delete($key);
        }
        return true;
    }

    /**
     * 清除所有缓存，请慎用
     */
    public function flush()
    {
        if (! $this->connect()){
            return false;
        }
        return $this->redis->flushAll();
    }
    
    public function inc( $key, $value )
    {
        if (empty($key)) {
            return false;
        }
        if (! $this->connect()){
            return false;
        }
        $flag = $this->redis->incrBy( $key, $value );
        if (! $flag) {

            Log::error( " redis incrBy $key  ".print_r($value ,true )."  error "  , 'redis/error');
        }
        return $flag;
    }
    
    public function dec( $key, $value )
    {
        if (empty($key)) {
            return false;
        }
        if (! $this->connect()){
            return false;
        }
        $flag = $this->redis->decrBy( $key, $value );
        if (! $flag) {
            Log::error( " redis decrBy $key  ".print_r($value ,true )."  error "  , 'redis/error');
        }
        return $flag;
    }


}
