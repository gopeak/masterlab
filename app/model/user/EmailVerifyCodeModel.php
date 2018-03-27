<?php
namespace main\app\model\user;
use main\app\model\CacheModel;
/**
 *  
 * 邮箱验证码模块
 *
 */
class EmailVerifyCodeModel extends CacheModel
{
    public $prefix = 'user_';

	public  $table = 'email_active';
	
	const   DATA_KEY = 'email_active/';
	
	function __construct( $uid ='',$persistent=false )
	{
		parent::__construct( $uid,$persistent );
	
		$this->uid = $uid;
			
	}
	
	
    /**
     *  获取邮箱验证码的记录信息,通过Phone
     *  @param $email
     * @return array
     */
    public function getByEmail($email )
    {
        //使用缓存机制
        $fields	=	'*';
        $where	=	['email'=>$email];
        $key	=	self::DATA_KEY.$email;
        $final	=	parent::getRowByKey(  $fields, $where, $key );
        return $final; 
	 
    }

    /**
     * @param $email
     * @param $verify_code
     * @return array
     */
    public function getByEmailVerify($email , $verify_code )
    {
        //使用缓存机制
        $fields	=	'*';
        $where	=	['email'=>$email ,'verify_code'=>$verify_code];
        $key	=	self::DATA_KEY.$email;
        $final	=	parent::getRowByKey(  $fields, $where, $key );
        return $final;

    }


    /**
     * 邮箱激活记录
     * @param array $uid
     * @param $email
     * @param $verify_code
     * @return bool
     */
    public function insertVerifyCode($uid, $email, $username, $verify_code )
    {
        //执行SQL语句，返回影响行数，如果有错误，则会被捕获并跳转到出错页面
        $table = $this->getTable();
        $time = time();
        $email = $this->db->pdo->quote( $email );
        $username = $this->db->pdo->quote( $username );
        $sql = "INSERT IGNORE INTO {$table} SET email=$email, uid='$uid', username=$username,verify_code='$verify_code', time='$time' ";
        $sql .=" ON DUPLICATE KEY UPDATE verify_code='$verify_code'; ";
        //var_dump( $sql );
        $ret = $this->exec($sql);
        
        return $ret;
        
    }
    
   
    /**
     * 删除邮箱验证码记录
     */
    public function deleteByEmail($email )
    {
    	 
    	$key   = self::DATA_KEY.$email;
    	$table = $this->getTable();
    	$where = ['email'=>$email];//" Where email = '$email'";
    
    	$flag =  parent::deleteBykey( $table, $where, $key );
    	return $flag;
    }
    
    
}