<?php

namespace main\app\model\issue;

use main\app\model\BaseDictionaryModel;

/**
 *  事项优先级模型
 *
 */
class IssuePriorityModel extends BaseDictionaryModel
{
    public $prefix = 'issue_';

    public $table = 'priority';

    const   DATA_KEY = 'issue_priority/';

    public $fields = '*';

    /**
     * 用于实现单例模式
     * @var self
     */
    protected static $instance;

    /**
     * 创建一个自身的单例对象
     * @param bool $persistent
     * @throws \Exception
     * @return self
     */
    public static function getInstance($persistent = false)
    {
        $index = intval($persistent);
        if (!isset(self::$instance[$index]) || !is_object(self::$instance[$index])) {
            self::$instance[$index]  = new self($persistent);
        }
        return self::$instance[$index];
    }

    public function getAllItem($primaryKey = true)
    {
        $table = $this->getTable();
        $fields = " id as k,{$table}.*";
        return $this->getRows($fields, [], null, 'sequence', 'desc', null, $primaryKey);
    }

    public function getByName($name)
    {
        $conditions['name'] = trim($name);
        $row = $this->getRow('*', $conditions);
        return $row;
    }

    public function getById($id)
    {
        $conditions['id'] = $id;
        $row = $this->getRow('*', $conditions);
        return $row;
    }

    public function getByKey($key)
    {
        $where = ['_key' => trim($key)];
        $row = $this->getRow("*", $where);
        return $row;
    }

    public function getIdByKey($key)
    {
        $where = ['_key' => trim($key)];
        $id = $this->getOne("id", $where);
        return $id;
    }
}
