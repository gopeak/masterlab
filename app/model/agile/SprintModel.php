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
            self::$instance[$index]  = new self($persistent);
        }
        return self::$instance[$index] ;
    }

    public function getByName($name)
    {
        $where = ['name' => trim($name)];
        $row = $this->getRow("*", $where);
        return $row;
    }

    public function getActive()
    {
        $where = ['active' => 1];
        $row = $this->getRow("*", $where);
        return $row;
    }

    /**
     * 获取所有
     * @param bool $primaryKey 是否把主键作为索引
     * @return array
     * @throws \Exception
     */
    public function getAllItems($primaryKey = true, $fields='*')
    {
        $table = $this->getTable();
        $fields = " id as k,{$table}.*";
        return $this->getRows($fields, array(), null, 'order_weight', 'desc', null, $primaryKey);
    }

    /**
     * 获取某个项目的Sprint
     * @param bool $primaryKey 是否把主键作为索引
     * @return array
     * @throws \Exception
     */
    public function getItemsByProject($projectId, $primaryKey = false)
    {
        $table = $this->getTable();
        $fields = "*";
        $conditions = [];
        $conditions['project_id'] = intval($projectId);
        return $this->getRows($fields, $conditions, null, 'order_weight', 'desc', null, $primaryKey);
    }

    public function deleteByProjectId($projectId)
    {
        $conditions = [];
        $conditions['project_id'] = intval($projectId);
        return $this->delete($conditions);
    }
}
