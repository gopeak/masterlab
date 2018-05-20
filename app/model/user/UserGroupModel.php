<?php
namespace main\app\model\user;
use main\app\model\CacheModel;
/**
 *  
 *
 */
class UserGroupModel extends CacheModel
{
	public $prefix = 'user_';

	public  $table = 'group';
	
	const   DATA_KEY = 'user_group/';
	
	function __construct( $uid ='',$persistent=false )
	{
		parent::__construct( $uid,$persistent );
		$this->uid = $uid;
	}

    public  function getGroupsByUid( $uid  )
    {
        $ret = [];
        $rows = $this->getRows( 'id,group_id',['uid'=>$uid] );
        foreach( $rows as $row ) {
            $ret[] = $row['group_id'];
        }
        return $ret;
    }

    public  function getUserIdsByGroups($groups  )
    {
        if (empty($groups)) {
            return [];
        }
        $groups_ids_str = implode(',', $groups);
        $params = [];
        $params['group_ids'] = $groups_ids_str;
        $table = $this->getTable();
        $sql = "select uid from {$table}   where  group_id in(:group_ids) ";

        $rows =  $this->db->getRows( $sql, $params, false );
        $ret = [];
        if( !empty($rows) ){
            foreach( $rows as $row ){
                $ret[] = $row['uid'];
            }
        }
        return $ret;
    }

    public  function getsByUserIds( $user_ids  )
    {
        if (empty($user_ids)) {
            return [];
        }
        $user_ids_str = implode(',', $user_ids);
        $params = [];
        $params['user_ids_str'] = $user_ids_str;
        $table = $this->getTable();
        $sql = "select * from {$table}   where  uid in(:user_ids_str) ";
        $rows =  $this->db->getRows( $sql, $params, false );
        $ret = [];
        if( !empty($rows) ){
            foreach( $rows as $row ){
                $ret['uid'][] = $row['group_id'];
            }
        }
        return $ret;
    }

    public  function add( $uid, $group_id  )
    {
        $info = [];
        $info['uid'] = $uid;
        $info['group_id'] = $group_id;
        return $this->insertIgnore( $info );
    }

    public  function adds( $uid, $group_ids  )
    {
        $infos = [];
        foreach( $group_ids as $gid ){
            $info = [];
            $info['uid'] = $uid;
            $info['group_id'] = $gid;
            $infos [] = $info;
        }
        return $this->insertRows( $infos );
    }

    public  function deleteByUid( $uid   )
    {
        $conditions['uid'] = $uid;
        return $this->delete( $conditions );
    }

    public  function deleteByGroupIdUid( $group_id, $uid   )
    {
        $conditions['uid'] = $uid;
        $conditions['group_id'] = $group_id;
        return $this->delete( $conditions );
    }
}
