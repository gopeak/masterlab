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
    protected static $_instance;

    /**
     * 创建一个自身的单例对象
     * @param bool $persistent
     * @throws PDOException
     * @return self
     */
    public static function getInstance($persistent = false)
    {
        if (!isset(self::$_instance[intval($persistent)]) || !is_object(self::$_instance[intval($persistent)])) {
            self::$_instance[intval($persistent)] = new self($persistent);
        }
        return self::$_instance[intval($persistent)];
    }

    public function getCurUserFilter($uid)
    {
        return $this->getRows('*', ['uid' => $uid]);
    }

    public function getItemById($id)
    {
        return $this->getRowById($id);
    }

    public function insertItem($info)
    {
        return $this->insert($info);
    }

    public function updateItemId($id, $info)
    {
        return $this->updateById($id, $info);
    }

    public function deleteById($id)
    {
        return $this->deleteById($id);
    }

}