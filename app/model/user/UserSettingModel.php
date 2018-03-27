<?php
namespace main\app\model\user;
use main\app\model\CacheModel;

/**
 *
 */
class UserSettingModel extends CacheModel
{
	public $prefix = 'user_';

	public  $table = 'setting';
	
	const   DATA_KEY = 'user_setting/';


	const DEFAULT_EMAIL_FORMAT = 'text';

	const DEFAULT_ACTIVITY_PAGE_SIZE = 100;

    const  DEFAULT_SHARE = 'public';

    const DEFAULT_NOTIFY_OTHER = false;

    const DEFAULT_AUTO_WATCH_MYSELF = true;

	function __construct( $uid ='',$persistent=false )
	{
		parent::__construct( $uid,$persistent );
	
		$this->uid = $uid;
			
	}


    function getSetting( $uid  )
    {
        return  $this->getRows( '*',['uid'=>$uid ] );

    }

    function insertSetting( $uid ,$key, $value )
    {
        $info = [];
        $info['uid'] = $uid;
        $info['_key'] = $key;
        $info['_value'] = $value;
        // INSERT INTO {$table} (`uid`,`project_id`,`role_id`) VALUES('$uid',$project_id,$role_id)
        // ON DUPLICATE UPDATE project_id=$project_id,role_id=$role_id;
        return  $this->insert( $info );
    }

    function updateSetting( $uid ,$key, $value )
    {
        $info = [];
        $info['_value'] = $value;
        $conditions = [];
        $conditions['uid'] = $uid;
        $conditions['_key'] = $key;
        return  $this->update( $info ,$conditions );
    }

    function deleteByProjectRole( $uid ,$project_id, $role_id )
    {
        $conditions = [];
        $conditions['uid'] = $uid;
        $conditions['project_id'] = $project_id;
        $conditions['role_id'] = $role_id;
        return  $this->delete( $conditions );


    }
}