<?php

namespace main\app\model\issue;

use main\app\model\BaseDictionaryModel;

/**
 *  工作流方案
 *
 */
class WorkflowSchemeModel extends BaseDictionaryModel
{
    public $prefix = '';

    public $table = 'workflow_scheme';

    const  DATA_KEY = 'workflow_scheme/';

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

    public function getByName($name)
    {
        $where = ['name' => trim($name)];
        $row = $this->getRow("*", $where);
        return $row;
    }

    /**
     * 获取所有
     * @param bool $primaryKey
     * @return array
     * @throws \Exception
     */
    public function fetchAll($primaryKey = false)
    {
        $table = $this->getTable();
        $fields = " id as k,{$table}.*";
        return $this->getRows($fields, [], null, 'id', 'asc', null, $primaryKey);
    }
}
