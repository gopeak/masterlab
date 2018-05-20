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

    /**
     * 获取所有
     * @param bool $primaryKey 是否把主键作为索引
     * @return array
     */
    public function getAll($primaryKey = true)
    {
        $table = $this->getTable();
        return $this->getRows($fields = " id as k,{$table}.*", $conditions = array(), $append = null, $orderBy = 'id',
            $sort = 'asc', $limit = null, $primaryKey);
    }

    public function getItemsBySchemeId($scheme_id)
    {
        return $this->getRows('*', ['scheme_id' => $scheme_id]);
    }


    public function deleteBySchemeId($scheme_id)
    {
        $conditions = [];
        $conditions['scheme_id'] = intval($scheme_id);
        return $this->delete($conditions);
    }
}
