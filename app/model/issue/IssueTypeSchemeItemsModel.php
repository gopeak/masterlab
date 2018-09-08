<?php

namespace main\app\model\issue;

use main\app\model\CacheModel;

/**
 *  事项类型方案子项1:M 关系的字段方案模型
 */
class IssueTypeSchemeItemsModel extends CacheModel
{
    public $prefix = 'issue_';

    public $table = 'type_scheme_data';

    const   DATA_KEY = 'issue_type_scheme_data/';

    public $fields = '*';


    public $masterId = '';

    /**
     * 用于实现单例模式
     * @var self
     */
    protected static $instance;


    public function __construct($masterId = '', $persistent = false)
    {
        parent::__construct($persistent);

        $this->uid = $masterId;
    }

    public function getAll($primaryKey = true, $fields = '*')
    {
        if ($fields == '*') {
            $table = $this->getTable();
            $fields = " id as k,{$table}.*";
        }
        return $this->getRows($fields, [], null, $this->primaryKey, 'asc', null, $primaryKey);
    }


    /**
     * 创建一个自身的单例对象
     * @param string $masterId
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

    public function getItemsBySchemeId($schemeId)
    {
        return $this->getRows('*', ['scheme_id' => $schemeId]);
    }

    public function deleteBySchemeId($schemeId)
    {
        $conditions = [];
        $conditions['scheme_id'] = intval($schemeId);
        return $this->delete($conditions);
    }
}
