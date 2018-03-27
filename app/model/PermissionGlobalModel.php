<?php
namespace main\app\model;
use main\app\model\CacheModel;
/**
 *
 *
 */
class PermissionGlobalModel extends CacheModel
{
	public $prefix = 'permission_';

	public  $table = 'global';
	
	const   DATA_KEY = 'permission_global/';

    public function __construct( $uid ='',$persistent=false )
	{
		parent::__construct( $uid,$persistent );
		$this->uid = $uid;
	}

	public function getAll(){

        return $this->getRows(  $fields="*", $conditions=array() , $append=null,
            $sort = 'id asc', $limit = null, $primary_key=false );
    }



}