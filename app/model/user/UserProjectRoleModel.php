<?php
namespace main\app\model\user;
use main\app\model\CacheModel;
/**
 *
 */
class UserProjectRoleModel extends CacheModel
{
	public $prefix = 'user_';

	public  $table = 'project_role';
	
	const   DATA_KEY = 'user_project_role/';
	
	public function __construct( $uid ='',$persistent=false )
	{
		parent::__construct( $uid,$persistent );
	
		$this->uid = $uid;
			
	}

    public function getUserRolesByProject( $uid  ,$project_id )
    {
        $ret = [];
        $rows = $this->getRows( '*',['uid'=>$uid,'project_id'=>$project_id] );
        foreach( $rows as $row ) {
            $ret[] = $row['project_role_id'];
        }
    }

    public function getUserRoles( $uid  )
    {
        return  $this->getRows( '*',['uid'=>$uid ] );
    }

    public function insertRole( $uid ,$project_id, $role_id )
    {
        $info = [];
        $info['uid'] = $uid;
        $info['project_id'] = $project_id;
        $info['project_role_id'] = $role_id;
        return  $this->insert( $info );
    }

    public function deleteByUid( $uid  )
    {
        $conditions = [];
        $conditions['uid'] = $uid;
        return  $this->delete( $conditions );
    }

    public function deleteByProjectRole( $uid ,$project_id, $role_id )
    {
        $conditions = [];
        $conditions['uid'] = $uid;
        $conditions['project_id'] = $project_id;
        $conditions['project_role_id'] = $role_id;
        return  $this->delete( $conditions );
    }

    public function getUidsByProjectRole( $project_ids ,$role_ids )
    {

        if (empty($project_ids)) {
            return [];
        }
        $project_ids_str = implode(',', $project_ids);
        $params = [];
        $params['project_id'] = $project_ids_str;
        $table = $this->getTable();
        $sql = "select uid from {$table}   where  project_id in(:project_id) ";
        if (!empty($role_ids)) {
            $role_ids_str = implode(',', $role_ids);
            $sql .= " AND  project_role_id in (:project_role_id )";
            $params['project_role_id'] = $role_ids_str;
        }
        $rows =  $this->db->getRows( $sql, $params, true );

        if( !empty($rows) ){
            return array_keys( $rows );
        }
        return [];
    }

}