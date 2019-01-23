<?php

namespace main\app\model\issue;

/**
 *  事项影响版本模型
 */
class IssueEffectVersionModel extends BaseIssueItemsModel
{
    public $prefix = '';

    public $table = 'issue_effect_version';

    public $fields = '*';

    const   DATA_KEY = 'issue_effect_version';

    /**
     * 用于实现单例模式
     * @var self
     */
    protected static $instance;

    /**
     * IssueEffectVersionModel constructor.
     * @param string $issueId
     * @param bool $persistent
     */
    public function __construct($issueId = '', $persistent = false)
    {
        parent::__construct($issueId, $persistent);
        $this->issueId = $issueId;
    }

    /**
     * 创建一个自身的单例对象
     * @param string $issueId
     * @param bool $persistent
     * @throws \PDOException
     * @return self
     */
    public static function getInstance($issueId = '', $persistent = false)
    {
        $index = $issueId . strval(intval($persistent));
        if (!isset(self::$instance[$index]) || !is_object(self::$instance[$index])) {
            self::$instance[$index] = new self($issueId, $persistent);
        }
        return self::$instance[$index];
    }
}
