<?php

namespace main\app\model\issue;

use main\app\model\CacheModel;

/**
 *  事项类型方案子项1:M 关系的字段方案模型
 */
class IssueUiTabModel extends CacheModel
{
    public $prefix = 'issue_';

    public $table = 'ui_tab';

    const   DATA_KEY = 'issue_ui_tab/';

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

    public function getItemsByIssueTypeIdType($issueTypeId, $type)
    {
        $conditions = ['issue_type_id' => $issueTypeId, 'ui_type' => $type];
        return $this->getRows('*', $conditions, null, 'order_weight', 'asc');
    }

    public function add($issueTypeId, $orderWeight, $name, $type)
    {
        $data = [];
        $data['issue_type_id'] = intval($issueTypeId);
        $data['order_weight'] = intval($orderWeight);
        $data['name'] = $name;
        $data['ui_type'] = $type;
        return $this->insert($data);
    }

    public function deleteByIssueType($issueTypeId, $type)
    {
        $conditions = [];
        $conditions['issue_type_id'] = intval($issueTypeId);
        $conditions['ui_type'] = $type;
        return $this->delete($conditions);
    }
}
