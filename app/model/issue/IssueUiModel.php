<?php

namespace main\app\model\issue;

use main\app\model\CacheModel;

/**
 *  事项类型方案子项1:M 关系的字段方案模型
 */
class IssueUiModel extends CacheModel
{
    public $prefix = 'issue_';

    public $table = 'ui';

    public $fields = '*';

    public $masterId = '';

    const UI_TYPE_CREATE = 'create';
    const UI_TYPE_EDIT = 'edit';
    const UI_TYPE_VIEW = 'view';


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

    /**
     * @param $issueTypeId
     * @return array
     */
    public function getItemsByProjectId($issueTypeId)
    {
        return $this->getRows('*', ['issue_type_id' => $issueTypeId]);
    }

    /**
     * @param $issueTypeId
     * @param $type
     * @return array
     */
    public function getsByUiType($issueTypeId, $type)
    {
        $conditions = ['issue_type_id' => $issueTypeId, 'ui_type' => $type];
        $rows = $this->getRows('*', $conditions, null, 'order_weight', 'desc');
        foreach ($rows as &$row) {
            $row['required'] = $row['required'] === '0' ? false : true;
        }
        return $rows;
    }

    /**
     * 新增一个字段
     * @param $issueTypeId
     * @param $type
     * @param $fieldId
     * @param $tabId
     * @param $orderWeight
     * @param $required
     * @return array
     * @throws \Exception
     */
    public function addField($issueTypeId, $type, $fieldId, $tabId, $orderWeight, $required = '0')
    {
        $data = [];
        $data['issue_type_id'] = intval($issueTypeId);
        $data['ui_type'] = $type;
        $data['field_id'] = intval($fieldId);
        $data['tab_id'] = intval($tabId);
        $data['order_weight'] = intval($orderWeight);
        $data['required'] = $required;

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
