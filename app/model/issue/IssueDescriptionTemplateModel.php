<?php

namespace main\app\model\issue;

use main\app\model\BaseDictionaryModel;

/**
 *  描述模板模型
 *
 */
class IssueDescriptionTemplateModel extends BaseDictionaryModel
{
    public $prefix = 'issue_';

    public $table = 'description_template';

    const   DATA_KEY = 'issue_description_template/';

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
        return self::$instance[$index];
    }

    public function getToolbars($primaryKey = true)
    {
        $table = $this->getTable();
        $fields = " id as k,{$table}.*";
        return $this->getRows($fields, [], null, 'id', 'desc', 3, $primaryKey);
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
}
