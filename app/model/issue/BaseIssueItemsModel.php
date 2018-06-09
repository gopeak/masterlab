<?php

namespace main\app\model\issue;

use main\app\model\CacheModel;

/**
 *  与用户 1:M 关系的模型基类
 */
class BaseIssueItemsModel extends CacheModel
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
        $this->uid = $issueId;
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

    public function getItemById($id)
    {
        return $this->getRow('*', ['id' => $id]);
    }
    public function getItemsByIssueId($issueId)
    {
        return $this->getRows('*', ['issue_id' => $issueId]);
    }

    public function insertItemByIssueId($issueId, $info)
    {
        $info['issue_id'] = $issueId;
        return $this->insert($info);
    }

    public function updateItemById($id, $info)
    {
        $conditions['id'] = $id;
        return $this->update($info, $conditions);
    }

    public function updateItemByIssueId($issueId, $info)
    {
        $conditions['issue_id'] = $issueId;
        return $this->update($info, $conditions);
    }

    public function deleteItemByIssueId($issueId)
    {
        $conditions = [];
        $conditions['issue_id'] = $issueId;
        return $this->delete($conditions);
    }
    public function deleteItemById($id)
    {
        return $this->deleteById($id);
    }
}
