<?php

namespace main\app\model\issue;

use main\app\model\CacheModel;

/**
 *  问题类型方案子项1:M 关系的字段方案模型
 */
class IssueUiTabModel extends CacheModel
{
    public $prefix = 'issue_';

    public $table = 'ui_tab';

    const   DATA_KEY = 'issue_ui_tab/';

    public $fields = '*';


    public $master_id = '';


    /**
     * 用于实现单例模式
     * @var self
     */
    protected static $_instance;


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
        if (!isset(self::$_instance[$index]) || !is_object(self::$_instance[$index])) {
            self::$_instance[$index] = new self($master_id, $persistent);
        }
        return self::$_instance[$index];
    }

    public function getItemsByIssueTypeId($issueTypeId)
    {
        return $this->getRows('*', ['issue_type_id' => $issueTypeId]);
    }

    public function getItemsByIssueTypeIdType($issueTypeId, $type)
    {
        $conditions = [ 'issue_type_id' => $issueTypeId, 'ui_type' => $type];
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
