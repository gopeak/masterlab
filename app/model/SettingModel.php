<?php

namespace main\app\model;
/**
 *
 * @author sven
 *
 */
class SettingModel extends DbModel
{
    /**
     * 表名称
     * @var string
     */
    public  $table = 'setting';

    /**
     * 数据的键值
     * @var string
     */
    const  DATA_KEY = "setting/";

    /**
     * 要获取字段
     * @var string
     */
    public $fields = '*';

    /**
     * 用于实现单例模式
     * @var self
     */
    protected static $instance;

    /**
     * 创建一个自身的单例对象
     * @param bool $persistentt
     * @throws PDOException
     * @return self
     */
    public static function getInstance( $persistentt=false )
    {
        if( !isset(self::$instance[intval($persistentt)] ) || !is_object( self::$instance[intval($persistentt)]) ) {

            self::$instance[intval($persistentt)]  = new self( $persistentt );
        }
        return self::$instance[intval($persistentt)] ;
    }


    /**
     *
     * 新增数据
     * @param $insertInfo
     */
    public function insertSetting( $_key, $_value, $module='', $title='', $format='string'  )
    {
        $info = [];
        $info['_key'] = $_key;
        $info['_value'] = $_value;
        $info['module'] = $module;
        $info['title'] = $title;
        $info['format'] = $format;
        $ret = parent::insert( $info );
        return $ret;
    }

    /**
     * 更新配置项
     * @param $_key
     * @param $_value
     * @param bool $module
     * @param bool $title
     * @param bool $format
     * @return bool|int
     */
    public function updateSetting( $_key, $_value ,$module=false, $title=false, $format=false  )
    {
        $info = [];
        $info['_value'] = $_value;
        if( $module!==false )  $info['module'] = $module;
        if( $title!==false )  $info['title'] = $title;
        if( $format!==false )  $info['format'] = $format;

        $where = ['_key'=>$_key] ;
        list( $ret ) = parent::update( $info , $where );
        return $ret;
    }

    /**
     * 通过关键字删除配置项
     * @param $key
     * @return bool
     */
    public function delSetting( $key )
    {
        $where =  ['_key'=>$key ];//" Where _key='$key'  ";
        $flag =  parent::delete( $where ) ;
        return $flag;
    }

    /**
     * 通过模块获取
     * @param string $module
     * @return array
     */
    public function getSettingByModule( $module='',$primaryKey=false ){

        $condition = [];
        if( !empty($module) ){
            $condition['module'] = $module;
        }
        return $this->getRows(  $fields="*", $condition ,$append=null, $ordryBy=null,
            $sort = null, $limit = null, $primaryKey);
    }

    /**
     * 获取配置项的内容
     * @param $key
     * @return bool|float|int|mixed|string
     */
    public function getSetting ( $key )
    {
        $row = $this->getSettingRow( $key );
        return $this->formatValue( $row );
    }

    /**
     * 根据format字段值来返回不同的数据
     * @param $row
     * @return bool|float|int|mixed|string
     */
    public function formatValue ( $row )
    {
        if( !isset( $row['_value']) ) {
            return false;
        }
        $ret = $row['_value'];
        if( $row['format']=='int' ) {
            $ret = intval( $row['_value'] );
        }
        if( $row['format']=='string' ) {
            $ret = strval( $row['_value'] );
        }
        if( $row['format']=='float' ) {
            $ret = floatval ( $row['_value'] );
        }
        if( $row['format']=='json' ) {
            $ret = json_decode ( $row['_value'] , true );
        }

        return $ret;
    }

    /**
     * 获取一整行配置项
     * @param $key
     * @return array  一条查询数据
     */
    public function getSettingRow ( $key )
    {
        $fields	=  "*" ;
        $where =  ['_key'=>$key ]; //" Where _key='$key'  ";
        $row	= parent::getRow( $fields, $where );
        return $row;
    }

    /**
     * 根据id获取一整行配置项
     * @param $id
     * @return array 一条查询数据
     */
    public function getSettingById( $id )
    {
        $fields	=  "*" ;
        $where	=  ['id'=>$id ];//" Where `id` =".$id;
        $row	= parent::getRow( $fields, $where );
        return $row;
    }

    /**
     * 获取配置项的内容
     * @param $key
     * @return bool|float|int|mixed|string
     */
    public function getValue( $key )
    {
        return $this->getSetting( $key );
    }

}

