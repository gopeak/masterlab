<?php

namespace main\app\model;

/**
 *  Timeline模型
 */
class TimelineModel extends CacheModel
{
    public $prefix = 'main_';

    public $table = 'timeline';

    public $fields = '*';

    public $issueId = '';

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
     * @param $issueId
     * @return array
     * @throws \Exception
     */
    public function getItemsByIssueId($issueId)
    {
        return $this->getRows('*', ['issue_id' => $issueId], null, 'id', 'desc');
    }

    public function getCountByIssueId($issueId)
    {
        $conditions['issue_id'] = $issueId;
        return max(0, (int)$this->getOne('count(*) as cc', $conditions));
    }

    /**
     * @param $issueId
     * @param $info
     * @return array
     * @throws \Exception
     */
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
