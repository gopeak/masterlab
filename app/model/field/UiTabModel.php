<?php

namespace main\app\model\field;

use main\app\model\CacheModel;

/**
 *  项目1:M 关系的字段方案模型
 */
class UiTabModel extends CacheModel
{

    public $prefix = 'issue_';

    public $table = 'ui_tab';

    public $fields = '*';

    public $project_id = '';

    const   DATA_KEY = '';

    /**
     * 用于实现单例模式
     * @var self
     */
    protected static $instance;

    public function __construct($project_id = '', $persistent = false)
    {
        parent::__construct($project_id, $persistent);
        $this->uid = $project_id;
    }

    /**
     * 创建一个自身的单例对象
     * @param string $project_id
     * @param bool $persistent
     * @throws PDOException
     * @return self
     */
    public static function getInstance($project_id = '', $persistent = false)
    {
        $index = $project_id . strval(intval($persistent));
        if (!isset(self::$instance[$index]) || !is_object(self::$instance[$index])) {
            self::$instance[$index] = new self($project_id, $persistent);
        }
        return self::$instance[$index];
    }

    public function getItemsByProjectId($project_id)
    {
        return $this->getRows('*', ['project_id' => $project_id]);
    }

    public function getItemsByProjectAndType($project_id, $issue_type, $issue_ui_type)
    {
        return $this->getRows('*', ['project_id' => $project_id, 'issue_type' => $issue_type, 'issue_ui_type' => $issue_ui_type]);
    }

    public function insertItem($project_id, $info)
    {
        $info['project_id'] = $project_id;
        return $this->insert($info);
    }

    public function updateItemByProjectId($project_id, $info)
    {
        $conditions['project_id'] = $project_id;
        return $this->update($info, $conditions);
    }

    public function deleteByProjectId($project_id)
    {
        $conditions = [];
        $conditions['project_id'] = $project_id;
        return $this->delete($conditions);
    }
}
