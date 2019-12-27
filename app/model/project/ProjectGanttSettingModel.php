<?php

namespace main\app\model\project;

use main\app\model\CacheModel;

/**
 * 项目甘特图设置模型
 */
class ProjectGanttSettingModel extends CacheModel
{
    public $prefix = 'project_';

    public $table = 'gantt_setting';

    const   DATA_KEY = 'project_gantt_setting/';

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
     * 新增项目的甘特图设置
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
     * 更新项目甘特图设置
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
     * 获取某个项目的甘特图设置
     * @return array
     */
    public function getByProject($projectId)
    {
        return $this->getRow('*', ['project_id' => $projectId]);
    }

    /**
     * 删除项目的甘特图设置
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