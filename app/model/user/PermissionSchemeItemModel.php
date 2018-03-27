<?php
namespace main\app\model\user;
use main\app\model\CacheModel;
/**
 *   权限方案模型
 */
class PermissionSchemeItemModel extends CacheModel
{
	public $prefix = 'permission_';

	public  $table = 'scheme_item';
	
	const   DATA_KEY = 'permission_scheme_item/';
	
	function __construct( $uid ='',$persistent=false )
	{
		parent::__construct( $uid,$persistent );
	
		$this->uid = $uid;


    }


    public function getItemsByIdPermissionKey( $scheme_id,$permission_key ){

        return $this->getRows( '*',['scheme'=>$scheme_id,'permission_key'=>$permission_key]);
    }

    public function getItemsById( $scheme_id ){

        return $this->getRows( '*',['scheme'=>$scheme_id]);
    }

}