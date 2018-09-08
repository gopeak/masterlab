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


    /**
     * BaseIssueItemsModel constructor.
     * @param string $issueId
     * @param bool $persistent
     */
    public function __construct($issueId = '', $persistent = false)
    {
        parent::__construct($issueId, $persistent);
        $this->issueId = $issueId;
    }


    /**
     * @param $id
     * @return array
     */
    public function getItemById($id)
    {
        return $this->getRow('*', ['id' => $id]);
    }

    /**
     * @param $issueId
     * @return array
     */
    public function getItemsByIssueId($issueId)
    {
        return $this->getRows('*', ['issue_id' => $issueId]);
    }

    /**
     * @param $issueId
     * @param $info
     * @return array
     * @throws \Exception
     */
    public function insertItemByIssueId($issueId, $info)
    {
        $info['issue_id'] = $issueId;
        return $this->insert($info);
    }

    /**
     * @param $id
     * @param $info
     * @return array
     * @throws \Exception
     */
    public function updateItemById($id, $info)
    {
        $conditions['id'] = $id;
        return $this->update($info, $conditions);
    }

    /**
     * @param $issueId
     * @param $info
     * @return array
     * @throws \Exception
     */
    public function updateItemByIssueId($issueId, $info)
    {
        $conditions['issue_id'] = $issueId;
        return $this->update($info, $conditions);
    }

    /**
     * @param $issueId
     * @return int
     */
    public function deleteItemByIssueId($issueId)
    {
        $conditions = [];
        $conditions['issue_id'] = $issueId;
        return $this->delete($conditions);
    }

    /**
     * @param $id
     * @return bool
     */
    public function deleteItemById($id)
    {
        return $this->deleteById($id);
    }
}
