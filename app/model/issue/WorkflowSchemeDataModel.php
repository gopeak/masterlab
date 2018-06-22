<?php

namespace main\app\model\issue;

use main\app\model\CacheModel;

/**
 *  工作流方案子项1:M 关系的字段方案模型
 */
class WorkflowSchemeDataModel extends CacheModel
{
    public $prefix = '';

    public $table = 'workflow_scheme_data';

    const   DATA_KEY = 'workflow_scheme_data/';

    public $fields = '*';

    public $masterId = '';

    /**
     * 用于实现单例模式
     * @var self
     */
    protected static $instance;

    public function __construct($master_id = '', $persistent = false)
    {
        parent::__construct($master_id, $persistent);

        $this->uid = $master_id;
    }

    /**
     * 创建一个自身的单例对象
     * @param string $masterId
     * @param bool $persistent
     * @throws \PDOException
     * @return self
     */
    public static function getInstance($masterId = '', $persistent = false)
    {
        $index = intval($persistent);
        if (!isset(self::$instance[$index]) || !is_object(self::$instance[$index])) {
            self::$instance[$index] = new self($masterId, $persistent);
        }
        self::$instance[$index]->masterId = $masterId;
        return self::$instance[$index];
    }

    public function getAllItems($primaryKey = true)
    {
        $table = $this->getTable();
        $fields = " id as k,{$table}.*";
        return $this->getRows($fields, [], null, 'id', 'asc', null, $primaryKey);
    }

    public function getItemsBySchemeId($schemeId)
    {
        return $this->getRows('*', ['scheme_id' => $schemeId]);
    }

    public function getWorkflowId($schemeId, $issueTypeId)
    {
        return $this->getOne('workflow_id', ['scheme_id' => $schemeId,'issue_type_id'=>$issueTypeId]);
    }

    public function deleteBySchemeId($schemeId)
    {
        $conditions = [];
        $conditions['scheme_id'] = intval($schemeId);
        return $this->delete($conditions);
    }
}
