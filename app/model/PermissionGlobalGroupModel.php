<?php
namespace main\app\model;
use main\app\model\CacheModel;
/**
 *   
 *
 */
class PermissionGlobalGroupModel extends CacheModel
{
	public $prefix = 'permission_';

	public  $table = 'global_group';
	
	const   DATA_KEY = 'permission_global_group/';

    public function __construct( $uid ='',$persistent=false )
	{
		parent::__construct( $uid,$persistent );
		$this->uid = $uid;
	}

    public function getAll(){

        return $this->getRows(  $fields="*", $conditions=array() , $append=null,
            $sort = 'id asc', $limit = null, $primary_key=false );
    }

	public function getsByParentId( $parent_id ){

        $conditions = [];
        $conditions['perm_global_id'] = $parent_id;
        return $this->getRows(  $fields="*", $conditions, $append=null,
            $sort = 'id asc', $limit = null, $primary_key=false );
    }

    public function getByParentIdAndGroupId( $parent_id ,$group_id){

        $conditions = [];
        $conditions['perm_global_id'] = $parent_id;
        $conditions['group_id'] = $group_id;
        return $this->getRow(  $fields="*" ,$conditions );
    }

    public function add( $parent_id,$group_id ){

        $info = [];
        $info['perm_global_id'] = $parent_id;
        $info['group_id'] = $group_id;
        $info['is_system'] = '0';

        return $this->insert( $info );
    }


}