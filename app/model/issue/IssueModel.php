<?php

namespace main\app\model\issue;

use main\app\model\CacheModel;

/**
 *  事项模型
 */
class IssueModel extends CacheModel
{
    public $prefix = 'issue_';

    public $table = 'main';

    public $fields = '*';

    public $project_id = '';

    const   DATA_KEY = 'issue_main';

    /**
     * 用于实现单例模式
     * @var self
     */
    protected static $instance;

    /**
     * 创建一个自身的单例对象
     * @param bool $persistent
     * @throws \PDOException
     * @return self
     */
    public static function getInstance($persistent = false)
    {
        $index = intval($persistent);
        if (!isset(self::$instance[$index]) || !is_object(self::$instance[$index])) {
            self::$instance[$index]  = new self($persistent);
        }
        return self::$instance[$index] ;
    }

    /**
     * @param $id
     * @return array
     */
    public function getById($id)
    {
        return $this->getRowById($id);
    }

    /**
     * 通过id数组获取事项列表
     * @param $idArr
     * @return array
     */
    public function getsByIds($idArr)
    {
        if (empty($idArr)) {
            return [];
        }
        $idStr = implode(',', $idArr);
        $sql = "select * from " . $this->getTable() . " where id in({$idStr})";
        $rows = $this->db->getRows($sql);
        return $rows;
    }

    /**
     * 获取子任务的总数
     * @param $id
     * @return int
     */
    public function getChildrenCount($id)
    {
        return (int)$this->getOne('count(*) as cc', ['master_id'=>$id]);
    }

    /**
     * 获取某个项目的所有的任务
     * @param $project_id
     * @return array
     */
    public function getItemsByProjectId($project_id)
    {
        return $this->getRows('*', ['project_id' => $project_id]);
    }

    /**
     * 新增
     * @param $info
     * @return array
     * @throws \Exception
     */
    public function insertItem($info)
    {
        return $this->insert($info);
    }

    /**
     * 更新
     * @param $id
     * @param $info
     * @return array
     * @throws \Exception
     */
    public function updateItemById($id, $info)
    {
        return $this->updateById($id, $info);
    }

    /**
     * 更新时间
     * @param $id
     * @return array
     * @throws \Exception
     */
    public function updateTime($id)
    {
        return $this->updateItemById($id, ['updated'=>time()]);
    }


    /**
     * 删除
     * @param $id
     * @return bool
     */
    public function deleteItemById($id)
    {
        return $this->deleteById($id);
    }

    /**
     * 删除某个项目下的所有事项
     * @param $project_id
     * @return int
     */
    public function deleteItemsByProjectId($project_id)
    {
        return $this->delete(['project_id' => $project_id]);
    }
}
