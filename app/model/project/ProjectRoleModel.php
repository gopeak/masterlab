<?php
namespace main\app\model\project;
use main\app\model\CacheModel;
/**
 *  
 *
 *
 */
class ProjectRoleModel extends CacheModel
{
	public $prefix = 'project_';

	public  $table = 'role';
	
	const   DATA_KEY = 'project_role/';

    public function __construct( $uid ='',$persistent=false )
	{
		parent::__construct( $uid,$persistent );
	
		$this->uid = $uid;
			
	}

	public function getAll(){

        return $this->getRows(  $fields="*", $conditions=array() , $append=null,$ordryBy='id',
            $sort = 'asc', $limit = null, $primaryKey=false );
    }

    public function getIds(){

        $rows =  $this->getRows(  $fields="id as k,name", $conditions=array() , $append=null,$ordryBy=null,
            $sort = null, $limit = null, $primaryKey=true );
        return array_keys( $rows );
    }

    public function add( $info ){

        if( empty($info) ) {
            return [false,'params_is_empty'];
        }
        $info['is_system'] = 0;
        return $this->insert( $info );
    }

}