<?php

namespace main\app\model\project;

use main\app\model\CacheModel;

/**
 * 迭代思维导图的格式
 */
class MindSprintAttributeModel extends CacheModel
{
    public $prefix = 'mind_';

    public $table = 'sprint_attribute';

    const   DATA_KEY = 'mind_sprint_attribute/';

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
     * @param $sprintId
     * @return array
     * @throws \Exception
     */
    public function insertBySprintId($info, $sprintId)
    {
        $info ['sprint_id'] = $sprintId;
        $flag = $this->insert($info);
        return $flag;
    }

    /**
     * 更新项目思维导图格式
     * @param $updateInfo
     * @param $sprintId
     * @return array
     * @throws \Exception
     */
    public function updateBySprintId($updateInfo, $sprintId)
    {
        $where = ['sprint_id' => $sprintId];
        $flag = $this->update($updateInfo, $where);
        return $flag;
    }

    /**
     * 替换思维导图
     * @param $updateInfo
     * @param $sprintId
     * @return array
     * @throws \Exception
     */
    public function replaceBySprintId($updateInfo)
    {
        $flag = $this->replace($updateInfo);
        return $flag;
    }

    /**
     * 获取某个项目的思维导图格式
     * @return array
     */
    public function getBySprint($sprintId)
    {
        return $this->getRow('*', ['sprint_id' => $sprintId]);
    }

    /**
     * 删除项目的思维导图格式
     * @param $sprintId
     * @return int
     */
    public function deleteBySprintId( $sprintId)
    {
        $where = ['sprint_id' => $sprintId];
        $flag = $this->delete($where);
        return $flag;
    }
}