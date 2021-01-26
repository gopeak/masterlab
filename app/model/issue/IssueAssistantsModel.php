<?php
namespace main\app\model\issue;

use main\app\model\BaseDictionaryModel;

/**
 *  协助人
 *
 */
class IssueAssistantsModel extends BaseIssueItemsModel
{
    public $prefix = 'issue_';

    public $table = 'assistant';
    
    public $fields = '*';

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

    /**
     * @param $userId
     * @return array
     */
    public function getItemsByUserId($userId)
    {
        $conditions['user_id'] = $userId;
        return $this->getRows('*', $conditions);
    }

    /**
     * @param $issueId
     * @return mixed
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getCountByUserId($issueId)
    {
        $conditions['user_id'] = $issueId;
        return max(0, (int)$this->getField('count(distinct issue_id) as cc', $conditions));
    }
}
