<?php

namespace main\app\model\issue;

use main\app\model\CacheModel;

/**
 *  过滤器
 */
class IssueFilterModel extends CacheModel
{
    public $prefix = 'issue_';

    public $table = 'filter';

    public $fields = '*';

    public $project_id = '';

    const   DATA_KEY = 'issue_filter';


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

    public function getCurUserFilter($userId)
    {
        return $this->getRows('*', ['author' => $userId]);
    }

    public function getItemById($id)
    {
        return $this->getRowById($id);
    }

    public function addItem($info)
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
