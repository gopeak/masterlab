<?php

namespace main\app\model\issue;

use main\app\model\BaseDictionaryModel;

/**
 *  问题优先级模型
 *
 */
class IssuePriorityModel extends BaseDictionaryModel
{
    public $prefix = 'issue_';

    public $table = 'priority';

    const   DATA_KEY = 'issue_priority/';

    public $fields = '*';

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

    public function getByName($name)
    {
        $conditions['name'] = trim($name);
        $row = $this->getRow('*', $conditions);
        return $row;
    }
}
