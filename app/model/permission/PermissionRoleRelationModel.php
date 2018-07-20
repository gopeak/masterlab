<?php

namespace main\app\model\permission;

use main\app\model\BaseDictionaryModel;
/**
 * 用户角色所有权限
 */
class PermissionRoleRelationModel extends BaseDictionaryModel
{
    public $prefix = 'permission_';

    public $table = 'role_relation';

    public function __construct( $persistent = false )
    {
        parent::__construct( $persistent);

    }

    public function getPermIdsByRoleId( $roleId )
    {
        $list = $this->getRows('perm_id', ['role_id' => $roleId] , true);

        if (empty($list))
        {
            return [];
        }
        $data = [];
        foreach ( $list as $item )
        {
            $data[] = $item['perm_id'];
        }
        return  array_unique($data);
    }

    /**
     * 新增
     * @param $roleId
     * @param $permId
     * @return array
     * @throws \Exception
     */
    public function add( $roleId, $permId )
    {
        $info = [];
        $info['role_id'] = $roleId;
        $info['perm_id'] = $permId;
        return $this->insert($info);
    }


    public function getPermIdsByRoleIds( $roleIds )
    {
        if (empty($roleIds) || !is_array($roleIds))
        {
            return [];
        }
        $params = [];
        $table = $this->getTable();
        $sql = "select perm_id from {$table}   where  1 ";

        $roleIds_str = implode(',', $roleIds);
        $sql .= " AND  role_id IN ({$roleIds_str}) GROUP BY perm_id";

        $rows = $this->db->getRows($sql, $params, true);

        if ( empty($rows) )
        {
            return  [];
        }

        return array_keys($rows);
    }

    public function deleteByRoleId( $roleId )
    {
        $where = ['role_id' => $roleId];
        $row	=	$this->delete(  $where );
        return  $row;
    }
}
