<?php

namespace main\app\model\issue;

use main\app\model\CacheModel;

/**
 *  与issue 1:1 关系的模型基类
 */
class BaseIssueItemModel extends CacheModel
{
    public $prefix = '';

    public $table = '';

    public $fields = '*';

    public $issueId = '';

    const   DATA_KEY = '';
    

    /**
     * 用于实现单例模式
     * @var self
     */
    protected static $instance;

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

    public function getItemByIssueId($issueId)
    {
        return $this->getRow('*', ['issue_id' => $issueId]);
    }

    public function insertItem($issueId, $info)
    {
        $info['issue_id'] = $issueId;
        return $this->insert($info);
    }

    public function updateItemByIssueId($issueId, $info)
    {
        $conditions['issue_id'] = $issueId;
        return $this->update($info, $conditions);
    }

    public function deleteByIssueId($issueId)
    {
        $conditions = [];
        $conditions['issue_id'] = $issueId;
        return $this->delete($conditions);
    }

}
