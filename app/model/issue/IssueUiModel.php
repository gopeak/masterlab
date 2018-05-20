<?php

namespace main\app\model\issue;

use main\app\model\CacheModel;

/**
 *  问题类型方案子项1:M 关系的字段方案模型
 */
class IssueUiModel extends CacheModel
{
    public $prefix = 'issue_';

    public $table = 'ui';

    const   DATA_KEY = 'issue_ui/';

    public $fields = '*';


    public $master_id = '';

    const UI_TYPE_CREATE = 'create';
    const UI_TYPE_EDIT = 'edit';
    const UI_TYPE_VIEW = 'view';


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


    public function getItemsByProjectId($project_id, $issue_id)
    {
        return $this->getRows('*', ['project_id' => $project_id, 'issue_type_id' => $issue_id]);
    }

    public function getsByProjectIdIssueId($project_id, $issue_type_id, $type)
    {
        $conditions = ['project_id' => $project_id, 'issue_type_id' => $issue_type_id, 'ui_type' => $type];
        return $this->getRows('*', $conditions, null, 'order_weight', 'desc');
    }

    public function getsByIssueIdType($issue_type_id, $type)
    {
        $conditions = ['issue_type_id' => $issue_type_id, 'ui_type' => $type];
        return $this->getRows('*', $conditions, null, 'order_weight', 'desc');
    }

    public function addField($project_id, $issue_type_id, $type, $field_id, $tab_id, $order_weight)
    {
        $data = [];
        $data['project_id'] = intval($project_id);
        $data['issue_type_id'] = intval($issue_type_id);
        $data['ui_type'] = $type;
        $data['field_id'] = intval($field_id);
        $data['tab_id'] = intval($tab_id);
        $data['order_weight'] = intval($order_weight);

        return $this->insert($data);
    }

    public function deleteByIssueType($issue_type_id, $type)
    {
        $conditions = [];
        $conditions['issue_type_id'] = intval($issue_type_id);
        $conditions['ui_type'] = $type;
        return $this->delete($conditions);
    }
}
