<?php

namespace main\app\model\issue;

use main\app\model\BaseDictionaryModel;

/**
 *  工作流模型
 *
 */
class WorkflowModel extends BaseDictionaryModel
{
    public $prefix = '';

    public $table = 'workflow';

    const   DATA_KEY = 'workflow/';

    public $fields = '*';

    /**
     * 用于实现单例模式
     * @var self
     */
    protected static $instance;

    /**
     * 创建一个自身的单例对象
     * @param bool $persistent
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

    public function add($info)
    {
        if (isset($info['data']) && !is_string($info['data'])) {
            $info['data'] = json_encode($info['data']);
        }
        return $this->insert($info);
    }

    public function getById($id)
    {
        return $this->getRowById($id);
    }

    public function getByName($name)
    {
        $where = ['name' => trim($name)];
        $row = $this->getRow("*", $where);
        return $row;
    }
}
