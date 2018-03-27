<?php
namespace main\app\model\user;
use main\app\model\CacheModel;
/**
 *  
 * 注册验证码模块
 *
 */
class RegVerifyCodeModel extends CacheModel
{
	/**
	 * 数据库表名
	 */
	public  $table = 'reg_vcode';
	
	const   DATA_KEY = 'reg_vcode/'; 
	
	function __construct( $uid ='',$persistent=false )
	{
		parent::__construct( $uid,$persistent );
	
		$this->uid = $uid;
			
	}
	
	
    /**
     *  获取注册验证码的记录信息,通过Phone
     *  @param $phone
     * @return array
     */
    public function getByPhone($phone )
    {
        //使用缓存机制
        $fields	=	'*';
        $where	=	" Where `phone`='$phone'  limit 1 ";
        $key	=	self::DATA_KEY.$phone;
        $table  =   $this->getTable() ;
        $final	=	parent::getRowByKey(  $fields, $where, $key );
        return $final; 
	 
    }
 
    
    /**
     * 
     * 插入一条注册验证码记录
     * @param bool
     */
    public function insertRegVerifyCode($insertInfo )
    {
    	
        $key = self::DATA_KEY.$insertInfo['phone'];
        $re = parent::insertByKey( $this->getTable(), $insertInfo, $key );
        
        return $re;
        
    }
    
    
	/**    
	 * 删除注册验证码记录
	 * Enter description here ...
	 */
    public function deleteById($id )
    {
    	
    	$key   = "";// self::DATA_KEY.$id;
    	$table = $this->getTable();
        $where = " Where id = '$id'";

        $flag =  parent::deleteBykey( $table, $where, $key );
        return $flag;
    }
    
    /**
     * 删除注册验证码记录
     * Enter description here ...
     */
    public function deleteByPhone($phone )
    {
    	 
    	$key   = self::DATA_KEY.$phone;
    	$table = $this->getTable();
    	$where = " Where phone = '$phone'";
    
    	$flag =  parent::deleteBykey( $table, $where, $key );
    	return $flag;
    }
    
    
}