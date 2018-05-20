<?php

namespace main\app\model\user;
use main\app\model\DbModel;

/**
 *  
 * 
 * @author Sven
 */
class LoginlogModel extends DbModel
{
    public $prefix = 'user_';
    public $table = 'login_log';
    public $fields = ' * ';
    public $primaryKey = 'id';
    
 	
 	function __construct( $persistent=false ) {
 		parent::__construct( $persistent );
 	}
 
    
 	public function getLoginLog( $uid ) {
 	    
 	     $sql = " SELECT id,session_id FROM {$this->getTable()} Where uid='$uid' order by id desc ";
 	     
 	     return $this->db->getRows( $sql );
 	}

    /**
     * 记录登录日志,用于只允许单个用户登录
     * @param $uid
     * @return bool
     */
    public function loginLogInsert($uid )
    {
        $info = [];
        $info['session_id'] = session_id();
        $info['uid'] = $uid;
        $info['time'] = time();
        $info['ip'] = getIp();
        return parent::insert(  $info);

    }
 	
 	/**
 	 *  只允许用户在一个地方登录
 	 *  踢掉当前用户的其他登录状态，直接删除session文件
 	 * @param string $uid
 	 */
 	public  function kickCurrentUserOtherLogin ($uid ) {
 	
 	    $logs = $this->getLoginLog( $uid );
 	    if( !empty( $logs ) ) {
 	        $delete_logs = [];
 	        $last_id = 0;
            $last_session_id = '';
 	        foreach( $logs as $k => $log ) {
 	            $last_id = $log['id'];
                $last_session_id = $log['session_id'];
 	            unset( $k );
 	            break;
 	        }
 	        if( !empty( $logs ) ) {
 	            foreach( $logs as $k => $log ) {
                    if( $last_session_id!=$log['session_id'] ) {   
                        $delete_logs[] = $log['session_id'];
                    } 
 	            }
 	            $new_logs = array_unique( $delete_logs );
 	            // v($new_logs);
 	            if( ini_get( 'session.save_handler' )=='files' ) {
 	                $session_save_path = ini_get( 'session.save_path' );
 	                $delete_ret = false;
 	                foreach( $new_logs as  $file ) {
 	                     
 	                    if( @unlink( $session_save_path.'/sess_'.$file ) ){
                            
                            $delete_ret =  true;
                        }
 	                }
 	                if ( $delete_ret ) {
 	                    $sql = "delete from {$this->getTable()} where id !=$last_id AND uid=$uid limit 100 ";
                        //echo $sql;
 	                    $this->db->query( $sql );
 	                }
 	                
 	            }
 	        }
 	    }
 	}
    
    
    
}

