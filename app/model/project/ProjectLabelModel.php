<?php

namespace main\app\model\project;

use main\app\model\BaseDictionaryModel;

/**
 *  标签模型
 */
class ProjectLabelModel extends BaseDictionaryModel
{
    public $prefix = 'project_';

    public $table = 'label';

    const  DATA_KEY = 'project_label/';

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

    public function getByName($title)
    {
        $where = ['title' => trim($title)];
        $row = $this->getRow("*", $where);
        return $row;
    }

    public function getsByProject($projectId)
    {
        $params = ['project_id' => (int)$projectId];
        $rows = $this->getRows("*", $params);
        return $rows;
    }

    public function removeById($projectId, $id)
    {
        $where = ['project_id' => $projectId, 'id' => $id];
        $row = $this->delete($where);
        return $row;
    }

    public function checkNameExist($projectId, $name)
    {
        $table = $this->getTable();
        $conditions['project_id'] = $projectId;
        $conditions['title'] = $name;
        $sql = "SELECT count(*) as cc  FROM {$table} Where project_id=:project_id AND title=:title  ";
        $count = $this->db->getOne($sql, $conditions);
        return $count > 0;
    }

}
