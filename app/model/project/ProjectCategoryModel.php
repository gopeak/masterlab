<?php
namespace main\app\model\project;
use main\app\model\CacheModel;
/**
 *   项目模型
 */
class ProjectCategoryModel extends CacheModel
{
	public $prefix = 'project_';

	public  $table = 'category';
	
	const   DATA_KEY = 'project_category/';
	
	function __construct( $uid ='',$persistent=false )
	{
		parent::__construct( $uid,$persistent );
	
		$this->uid = $uid;
			
	}

    public function getAll(){

        return $this->getRows(  $fields="*", $conditions=array() , $append=null,$ordryBy='id',
            $sort = 'asc', $limit = null, $primaryKey=true );
    }


    public function getByName( $name  )
    {
        $fields	=	"*,{$this->primaryKey} as k";
        $where = ['name' => trim($name)];
        $row	=	$this->getRow($fields, $where );
        return  $row;
    }
    
}