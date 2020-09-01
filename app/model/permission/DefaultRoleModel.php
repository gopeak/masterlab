<?php

namespace main\app\model\permission;

use main\app\model\BaseDictionaryModel;
/**
 * 默认角色定义
 */
class DefaultRoleModel extends BaseDictionaryModel
{
    public $prefix = 'permission_';

    public $table = 'default_role';

    /**
     * DefaultRoleModel constructor.
     * @param string $uid
     * @param bool $persistent
     */
    public function __construct($uid = '', $persistent = false)
    {
        parent::__construct($uid, $persistent);
        $this->uid = $uid;
    }

    /**
     * 通过id获取数据
     * @param $id
     * @return array
     */
    public function getById($id)
    {
        return $this->getRowById($id);
    }

    /**
     * 获取所有数据
     * @return array
     */
    public function getsAll()
    {
        return $this->getRows('*', ['project_id' => 0]);
    }

    /**
     * 获取某个项目的所有角色
     * @param $projectId
     * @param bool $primaryKey
     * @return array
     */
    public function getsByProject($projectId, $primaryKey = false)
    {
        return $this->getRows('*', ['project_id' => $projectId], null, 'id', 'desc', $primaryKey);
    }

    /**
     * 根据项目ID和角色名称获取项目角色ID
     * @param $projectId
     * @param $roleName
     * @return mixed
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getProjectRoleIdByProjectIdRoleName($projectId, $roleName)
    {
        return $this->getField('id', ['project_id' => $projectId, 'name' => $roleName]);
    }
}
