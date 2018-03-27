<?php

namespace main\app\model\user;
use main\app\model\DbModel;

/**
 * @todo进行sql参数化绑定
 * 
 * @author Sven
 */
class IpLoginTimesModel extends DbModel
{
    public $prefix = 'user_';
    public $table = 'ip_login_times';
    public $fields = ' * ';
    public $primary_key = 'id';

    private $_table = '';


    /**
     * 用于实现单例模式
     * @var self
     */
    protected static $_instance;

    /**
     * 创建一个自身的单例对象
     * @param array $dbConfig
     * @param bool $persistent
     * @throws PDOException
     * @return self
     */
    public static function getInstance( $persistent=false )
    {
        if( !isset(self::$_instance[intval($persistent)] ) || !is_object( self::$_instance[intval($persistent)]) ) {

            self::$_instance[intval($persistent)]  = new self( $persistent );
        }
        return self::$_instance[intval($persistent)] ;
    }

 	
 	function __construct( $persistent=false ) {
 		parent::__construct( $persistent );
        $this->_table = $this->getTable();
 	}

    /**
     *  获取ip的尝试登录次数
     * @param $ip
     * @return array 一条查询数据
     */
 	public function getIpLoginTimes( $ip ) {

        $sql  = "select * from {$this->getTable()} where ip='$ip'";
 	     
        return $this->db->getRow( $sql );
 	}

    /**
     * 插入ip的登录次数
     * @param $ip
     * @return bool 返回true或者false
     */
    public function insertIp( $ip ,$times ){
        $now = time();
        $sql = " insert into  {$this->_table} Set ip='$ip',  times=$times, up_time=$now  ";
        $ret = $this->db->query( $sql );
        return $ret;
    }

    /**
     * 初始化插入ip的登录次数
     * @param $ip
     * @return bool 返回true或者false
     */
    public function resetInsertIp( $ip ){
        $now = time();
        $sql = " update {$this->_table} set times=0,up_time=$now  where ip='$ip'";
        $ret = $this->db->query( $sql );
        return $ret;
    }

    /**
     * 更新ip的尝试登录次数
     * @param $ip
     * @param $times
     * @return bool 返回true或者false
     */
    public function updateIpTime( $ip,$times ){
        $now = time();
        $sql = " update {$this->_table} set times=$times,up_time=$now where ip='$ip'";
        $ret = $this->db->query( $sql );
        return $ret;
    }

    
    
}

