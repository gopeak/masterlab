<?php

namespace main\app\model\agile;

use main\app\model\BaseDictionaryModel;

/**
 *  Sprint 模型
 *
 */
class SprintModel extends BaseDictionaryModel
{
    public $prefix = 'agile_';

    public $table = 'sprint';

    const   DATA_KEY = 'agile_sprint/';

    public $fields = '*';

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
            self::$instance[$index] = new self($persistent);
        }
        return self::$instance[$index];
    }

    public function getById($id)
    {
        return $this->getRowById($id);
    }

    public function getByName($name)
    {
        $where = ['name' => trim($name)];
        $row = $this->getRow("*", $where);
        return $row;
    }

    /**
     * 通过项目id和名称获取记录
     * @param $projectId
     * @param $name
     * @return array
     */
    public function getByProjectAndName($projectId, $name)
    {
        $conditions = [];
        if (!empty($projectId)) {
            $conditions['project_id'] = $projectId;
        }
        $conditions['name'] = trim($name);
        $row = $this->getRow('*', $conditions);
        return $row;
    }

    public function getActive($projectId)
    {
        $conditions = ['active' => 1];
        $conditions['project_id'] = intval($projectId);
        $row = $this->getRow("*", $conditions);
        return $row;
    }

    /**
     * 获取所有
     * @param bool $primaryKey 是否把主键作为索引
     * @return array
     * @throws \Exception
     */
    public function getAllItems($primaryKey = true, $fields = '*')
    {
        $table = $this->getTable();
        $fields = " id as k,{$table}.*";
        return $this->getRows($fields, array(), null, 'order_weight', 'desc', null, $primaryKey);
    }

    /**
     * 获取某个项目的Sprint
     * @param $projectId
     * @param bool $primaryKey
     * @return array
     */
    public function getItemsByProject($projectId, $primaryKey = false)
    {
        $fields = "*";
        $conditions = [];
        $conditions['project_id'] = intval($projectId);
        $appendSql = " 1 ORDER BY `active` DESC,`order_weight` DESC ";
        return $this->getRows($fields, $conditions, $appendSql, null, null, null, $primaryKey);
    }

    /**
     * 获取多个项目的Sprint
     * @param $projectIdArr
     * @param bool $primaryKey
     * @return array
     */
    public function getItemsByProjectIdArr($projectIdArr, $primaryKey = false)
    {
        if (!is_array($projectIdArr) || empty($projectIdArr)) {
            return [];
        }
        $fields = "*";
        $projectIdStr = implode(',', $projectIdArr);
        $table = $this->getTable();
        $sql = " SELECT {$fields} FROM {$table}  WHERE project_id in ({$projectIdStr}) ORDER BY `active` DESC,`order_weight` DESC ";
        return $this->db->getRows($sql, [], $primaryKey);
    }

    /**
     * 获取某个项目的Sprint总数
     * @param $projectId
     * @return array
     */
    public function getCountByProject($projectId)
    {
        $fields = "count(*) as cc";
        $conditions = [];
        $conditions['project_id'] = intval($projectId);
        return (int)$this->getOne($fields, $conditions);
    }

    public function deleteByProjectId($projectId)
    {
        $conditions = [];
        $conditions['project_id'] = intval($projectId);
        return $this->delete($conditions);
    }
}
