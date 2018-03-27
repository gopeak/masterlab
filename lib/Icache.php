<?php
/**
 * 抽象缓存层接口设计
 *
 */
interface  Icache
{
 
    /**
     * 将数据从缓存中取出
     * @param string $key  key
     * @return bool
     */
    public function __construct( $config, $use = false ) ;
    
    /**
     * 缓存服务器的连接，要求只连接一次，禁止重复链接
     * 
     */
    public function connect();
    
    /**
     * 通过键值获取值
     * @param $key
     * @throws \Exception
     */
    public function get($key);


    /**
     * 将数据从缓存中取出
     * @param string $key  key
     * @return bool
     */
    public function mget( $keys );


    /**
     * 将数据存入缓存中
     * @param string $key   key
     * @param mix    $value 要存入的数据
     * @param int    $life  存活时间
     * @return bool
     */
    public function set($key,$value,$life=0);
    
    
    /**
     * 将数据存入缓存中
     * @param string $keys    包含键值和数值
     * @param int    $life  存活时间
     * @return bool
     */
    public function mset($keys,$life=0);
    
    /**
     * 将数据存入缓存中
     * @param string $key   key
     * @param mix    $value 要存入的数据
     * @param int    $life  存活时间
     * @return bool
     */
    public function append($key,$value,$life=0);
    /**
     * 将数据更新到缓存中，如果存在缓存
     * @param string $key   key
     * @param mix    $value 要存入的数据
     * @param int    $life  存活时间
     * @global $this->link 为Memache类的对象
     * @return bool
     */
    public function replace($key,$value,$life=0);

    /**
     * 将数据更新到缓存中，如果存在缓存
     * @param string $key   key
     * @param mix    $value 要存入的数据
     * @param int    $life  存活时间
     * @global $this->link 为Memache类的对象
     * @return bool
     */
    public function delete($key);

    /**
     * 清除公共缓存
     * @param $userid
     */
    public function clearCache($keys);
    
    /**
     * 清除所有缓存，请慎用
     */
    public function flush();    
    
    
    
}
