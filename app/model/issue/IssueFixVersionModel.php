<?php

namespace main\app\model\issue;

/**
 *  问题修复版本模型
 */
class IssueFixVersionModel extends BaseIssueItemsModel
{
    public $prefix = 'issue_';

    public $table = 'fix_version';

    public $fields = '*';

    public $issue_id = '';

    const   DATA_KEY = 'issue_fix_version';

    /**
     * 用于实现单例模式
     * @var self
     */
    protected static $instance;

    public function __construct($issue_id = '', $persistent = false)
    {
        parent::__construct($issue_id, $persistent);
        $this->issue_id = $issue_id;
    }

    /**
     * 创建一个自身的单例对象
     * @param string $issue_id
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
}
