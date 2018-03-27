<?php
namespace main\app\model\project;
use main\app\model\CacheModel;
/**
 *   项目模块模型
 */
class ProjectVersionModel extends CacheModel
{
	public $prefix = 'project_';

	public  $table = 'version';
	
	const   DATA_KEY = 'project_version/';
	
	function __construct( $uid ='',$persistent=false )
	{
		parent::__construct( $uid,$persistent );
	
		$this->uid = $uid;
			
	}

    public function getAll(){

        return $this->getRows(  $fields="id as k,*", $conditions=array() , $append=null,$orderBy='id',
            $sort = 'asc', $limit = null, $primary_key=true );
    }


    public function getByProject( $project_id  )
    {
        $fields	=	"*,{$this->primary_key} as k";
        $where = ['project_id' => $project_id];
        $rows	=	$this->getRows($fields, $where );
        return  $rows;
    }

    public function getByProjectPrimaryKey( $project_id  )
    {
        $fields	=	"*,{$this->primary_key} as k";
        $where = ['project_id' => $project_id];
        $rows	=	$this->getRows($fields, $where ,$append = null, $orderBy = null, $sort = null, $limit = null, true);
        return  $rows;
    }

    public function getByProjectIdName( $project_id  ,$name )
    {
        $fields	=	"*,{$this->primary_key} as k";
        $where = ['project_id' => $project_id,'name'=>$name];
        $row	=	$this->getRow($fields, $where );
        return  $row;
    }

    public function updateReleaseStatus($project_id, $version_id, $release = 0)
    {
        $where = ['project_id'=>$project_id, 'id'=>$version_id];
        $flag = $this->update( array('released' => $release), $where );
        return $flag[0];
    }

    public function deleteByVersinoId($project_id, $version_id  )
    {
        $where = ['project_id'=>$project_id, 'id'=>$version_id];
        $row	=	$this->delete(  $where );
        return  $row;
    }

    public function deleteByProject( $project_id  )
    {
        $where = ['project_id' => $project_id];
        $row	=	$this->delete(  $where );
        return  $row;
    }

    public function checkNameExist( $project_id  ,$name )
    {
        $table = $this->getTable();
        $conditions['project_id '] = $project_id ;
        $conditions['name'] = $name;
        $sql = "SELECT count(*) as cc  FROM {$table} Where project_id=:project_id AND name=:name  ";
        $count = $this->db->getOne( $sql,$conditions );
        return $count>0;
    }

    public function checkNameExistExcludeCurrent( $id, $project_id  ,$name )
    {
        $table = $this->getTable();
        $conditions['id '] = $id ;
        $conditions['project_id '] = $project_id ;
        $conditions['name'] = $name;
        $sql = "SELECT count(*) as cc  FROM {$table} Where id!=:id AND  project_id=:project_id AND name=:name  ";
        $count = $this->db->getOne( $sql,$conditions );
        return $count>0;
    }


}