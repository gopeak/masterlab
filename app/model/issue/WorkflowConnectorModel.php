<?php
namespace main\app\model\issue;

use main\app\model\CacheModel;

/**
 *  工作流数据
 */
class WorkflowConnectorModel extends CacheModel
{
    public $prefix = '';

    public $table = 'workflow_connector';

    const   DATA_KEY = 'workflow_connector/';

    public $fields = '*';


    public $master_id = '';

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
     * @param string $master_id
     * @param bool $persistent
     * @throws PDOException
     * @return self
     */
    public static function getInstance($master_id = '', $persistent = false)
    {
        $index = $master_id . strval(intval($persistent));
        if (!isset(self::$instance[$index]) || !is_object(self::$instance[$index])) {
            self::$instance[$index] = new self($master_id, $persistent);
        }
        return self::$instance[$index];
    }

    public function getItemsByWorkflowId($scheme_id)
    {
        return  $this->getRows('*', ['workflow_id'=>$scheme_id ]);
    }


    public function deleteByWorkflowId($scheme_id)
    {
        $conditions = [];
        $conditions['workflow_id'] = intval($scheme_id);
        return  $this->delete($conditions);
    }
}
