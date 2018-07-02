<?php

namespace main\app\model\issue;

use main\app\model\CacheModel;

/**
 *  事项回收站
 */
class IssueRecycleModel extends CacheModel
{
    public $prefix = 'issue_';

    public $table = 'recycle';

    public $fields = '*';

    public $project_id = '';

    const   DATA_KEY = 'issue_recycle';

    /**
     * 用于实现单例模式
     * @var self
     */
    protected static $instance;

    /**
     * 创建一个自身的单例对象
     * @param bool $persistent
     * @throws \PDOException
     * @return self
     */
    public static function getInstance($persistent = false)
    {
        $index = intval($persistent);
        if (!isset(self::$instance[$index]) || !is_object(self::$instance[$index])) {
            self::$instance[$index]  = new self($persistent);
        }
        return self::$instance[$index] ;
    }

    public function getById($id)
    {
        return $this->getRowById($id);
    }

    public function getItemsByProjectId($project_id)
    {
        return $this->getRows('*', ['project_id' => $project_id]);
    }

    public function insertItem($info)
    {
        return $this->insert($info);
    }

    public function updateItemById($id, $info)
    {
        return $this->updateById($id, $info);
    }

    public function deleteItemById($id)
    {
        return $this->deleteById($id);
    }
}
