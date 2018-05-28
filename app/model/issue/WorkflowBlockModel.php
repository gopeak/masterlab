<?php

namespace main\app\model\issue;

use main\app\model\CacheModel;

/**
 *  工作流数据
 */
class WorkflowBlockModel extends CacheModel
{
    public $prefix = '';

    public $table = 'workflow_block';

    public $fields = '*';

    public $masterId = '';

    /**
     * 用于实现单例模式
     * @var self
     */
    protected static $instance;

    public function __construct($masterId = '', $persistent = false)
    {
        parent::__construct($masterId, $persistent);
        $this->masterId = $masterId;
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

    public function getItemsByWorkflowId($workflowId)
    {
        return $this->getRows('*', ['workflow_id' => $workflowId]);
    }

    public function add($workflowId, $info)
    {
        $info['workflow_id'] = intval($workflowId);
        return $this->insert($info);
    }

    public function deleteByWorkflowId($workflowId)
    {
        $conditions = [];
        $conditions['workflow_id'] = intval($workflowId);
        return $this->delete($conditions);
    }
}
