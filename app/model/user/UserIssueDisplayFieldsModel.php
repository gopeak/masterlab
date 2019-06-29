<?php

namespace main\app\model\user;


/**
 *
 */
class UserIssueDisplayFieldsModel extends BaseUserItemModel
{
    public $prefix = 'user_';

    public $table = 'issue_display_fields';

    const   DATA_KEY = 'user_issue_display_fields/';

    public function __construct($userId = '', $persistent = false)
    {
        parent::__construct($userId, $persistent);

        $this->uid = $userId;
    }

    /**
     * @param $userId
     * @param $projectId
     * @return array
     */
    public function getByUserProject($userId, $projectId)
    {
        return $this->getRow('*', ['user_id' => $userId, 'project_id' => $projectId]);
    }

    /**
     * @param $userId
     * @param $projectId
     * @param $fieldsStr
     * @return array
     * @throws \Exception
     */
    public function replaceFields($userId, $projectId, $fieldsStr)
    {
        $info = [];
        $info['user_id'] = $userId;
        $info['project_id'] = $projectId;
        $info['fields'] = $fieldsStr;
        return $this->replaceItem($userId, $info);
    }

    /**
     * @param $userId
     * @param $projectId
     * @return int
     */
    public function deleteSettingByDate($userId, $projectId)
    {
        $conditions = ['user_id' => $userId, 'project_id' => $projectId];
        return $this->delete($conditions);
    }
}
