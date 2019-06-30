<?php

namespace main\app\model\issue;

use main\app\model\CacheModel;

/**
 *  事项关注
 */
class IssueFollowModel extends CacheModel
{
    public $prefix = 'issue_';

    public $table = 'follow';

    public $fields = '*';

    public $project_id = '';

    const   DATA_KEY = 'issue_follow';


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
            self::$instance[$index] = new self($persistent);
        }
        return self::$instance[$index];
    }

    public function getById($id)
    {
        return $this->getRowById($id);
    }

    public function getItemsByIssueUserId($issueId, $userId)
    {
        $conditions['issue_id'] = $issueId;
        $conditions['user_id'] = $userId;
        return $this->getRow('*', $conditions);
    }

    public function getItemsByUserId($userId)
    {
        $conditions['user_id'] = $userId;
        return $this->getRows('*', $conditions);
    }

    public function getCountByIssueId($issueId)
    {
        $conditions['issue_id'] = $issueId;
        return max(0, (int)$this->getOne('count(*) as cc', $conditions));
    }

    public function getItemsByIssueId($issueId)
    {
        $conditions['issue_id'] = $issueId;
        return $this->getRows('*', $conditions);
    }

    public function add($issueId, $userId)
    {
        $info['issue_id'] = $issueId;
        $info['user_id'] = $userId;
        return $this->replace($info);
    }

    public function deleteItemByIssueUserId($issueId, $userId)
    {
        $conditions['issue_id'] = $issueId;
        $conditions['user_id'] = $userId;
        return $this->delete($conditions);
    }

    public function deleteItemById($id)
    {
        return $this->deleteById($id);
    }
}
