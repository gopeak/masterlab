<?php

namespace main\app\model;

/**
 *  ActivityModel 模型
 */
class ActivityModel extends CacheModel
{
    public $prefix = 'main_';

    public $table = 'activity';

    public $fields = '*';

    const TYPE_AGILE = 'agile';

    const TYPE_USER = 'user';

    const TYPE_ISSUE = 'issue';

    const TYPE_ISSUE_COMMIT = 'issue_comment';

    const TYPE_PROJECT = 'project';

    const TYPE_ORG = 'org';

    /**
     * ActivityModel constructor.
     * @param string $userId
     * @param bool $persistent
     */
    public function __construct($userId = '', $persistent = false)
    {
        parent::__construct($userId, $persistent);
    }

    /**
     * @param $userId
     * @param $projectId
     * @param $info
     * @return array
     * @throws \Exception
     */
    public function insertItem($userId, $projectId, $info)
    {
        $info['user_id'] = $userId;
        $info['project_id'] = $projectId;
        $info['date'] = date('Y-m-d');
        $info['time'] = time();
        return $this->insert($info);
    }

    /**
     * @param $userId
     * @return int
     */
    public function deleteByUserId($userId)
    {
        $conditions = [];
        $conditions['user_id'] = $userId;
        return $this->delete($conditions);
    }
}
