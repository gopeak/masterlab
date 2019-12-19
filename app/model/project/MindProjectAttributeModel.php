<?php

namespace main\app\model\project;

use main\app\model\CacheModel;

/**
 * 项目思维导图的格式
 */
class MindProjectAttributeModel extends CacheModel
{
    public $prefix = 'mind_';

    public $table = 'project_attribute';

    const   DATA_KEY = 'mind_project_attribute/';

    /**
     * ProjectRoleModel constructor.
     * @param string $uid
     * @param bool $persistent
     * @throws \Exception
     */
    public function __construct($uid = '', $persistent = false)
    {
        parent::__construct($uid, $persistent);
        $this->uid = $uid;
    }

    /**
     * 获取某个设置信息
     * @param $id
     * @return array
     */
    public function getById($id)
    {
        return $this->getRowById($id);
    }

    /**
     * 新增项目的思维导图格式
     * @param $info
     * @param $projectId
     * @return array
     * @throws \Exception
     */
    public function insertByProjectId($info, $projectId)
    {
        $info ['project_id'] = $projectId;
        $flag = $this->insert($info);
        return $flag;
    }

    /**
     * 更新项目思维导图格式
     * @param $updateInfo
     * @param $projectId
     * @return array
     * @throws \Exception
     */
    public function updateByProjectId($updateInfo, $projectId)
    {
        $where = ['project_id' => $projectId];
        $flag = $this->update($updateInfo, $where);
        return $flag;
    }

    /**
     * 获取某个项目的思维导图格式
     * @return array
     */
    public function getByProject($projectId)
    {
        return $this->getRow('*', ['project_id' => $projectId]);
    }

    /**
     * 删除项目的思维导图格式
     * @param $projectId
     * @return int
     */
    public function deleteByProjectId( $projectId)
    {
        $where = ['project_id' => $projectId];
        $flag = $this->delete($where);
        return $flag;
    }
}