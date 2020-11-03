<?php

namespace main\app\model\user;


/**
 * 记录用户上一次的创建的事项数据
 */
class UserIssueLastCreateDataModel extends BaseUserItemModel
{
    public $prefix = 'user_';

    public $table = 'issue_last_create_data';

    const   DATA_KEY = 'user_issue_last_create_data/';

    public function __construct($userId = '', $persistent = false)
    {
        parent::__construct($userId, $persistent);
        $this->uid = $userId;
    }

    /**
     * @param $userId
     * @param $projectId
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getData($userId, $projectId)
    {
        return $this->getRow('*', ['user_id' => $userId, 'project_id' => $projectId]);
    }

    /**
     * @param $userId
     * @param $projectId
     * @param $data
     * @return array
     * @throws \Exception
     */
    public function insertData($userId, $projectId, $data)
    {
        $arr = [];
        $arr['user_id'] = $userId;
        $arr['project_id'] = $projectId;
        $arr['issue_data'] = $data;
        return $this->replace($arr);
    }

    /**
     * @param $userId
     * @param $projectId
     * @return int
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Doctrine\DBAL\Exception\InvalidArgumentException
     */
    public function deleteByProject($userId, $projectId)
    {
        $conditions = ['user_id' => $userId, 'project_id' => $projectId];
        return $this->delete($conditions);
    }
}
