<?php

namespace main\app\classes;

use main\app\ctrl\admin\IssueType;
use main\app\model\agile\SprintModel;
use main\app\model\issue\IssueFollowModel;
use main\app\model\issue\IssueModel;
use main\app\model\issue\IssueStatusModel;
use main\app\model\issue\IssueTypeModel;
use main\app\model\project\ProjectModel;
use main\app\model\project\ProjectModuleModel;
use main\app\model\project\ProjectUserRoleModel;
use main\app\model\system\NotifySchemeDataModel;
use main\app\model\system\NotifySchemeModel;
use main\app\model\TimelineModel;
use main\app\model\user\UserModel;

/**
 * 邮件通知处理类
 * @package main\app\classes
 */
class NotifyLogic
{
    public $to = null;
    public $from = null;
    public $subject = null;
    public $body = null;
    public $tplVarArr = [];
    public $emailConfig = [];

    const NOTIFY_ROLE_ASSIGEE = 'assigee';
    const NOTIFY_ROLE_REPORTER = 'reporter';
    const NOTIFY_ROLE_FOLLOW = 'follow';
    const NOTIFY_ROLE_PROJECT = 'project';

    /**
     * 事项创建
     */
    const NOTIFY_FLAG_ISSUE_CREATE = 'issue@create';
    /**
     * 事项更新
     */
    const NOTIFY_FLAG_ISSUE_UPDATE = 'issue@update';
    /**
     * 事项分配
     */
    const NOTIFY_FLAG_ISSUE_ASSIGN = 'issue@assign';
    /**
     * 事项已解决
     */
    const NOTIFY_FLAG_ISSUE_RESOLVE_COMPLETE = 'issue@resolve@complete';
    /**
     * 事项已关闭
     */
    const NOTIFY_FLAG_ISSUE_CLOSE = 'issue@close';
    /**
     * 事项删除
     */
    const NOTIFY_FLAG_ISSUE_DELETE = 'issue@delete';
    /**
     * 事项评论
     */
    const NOTIFY_FLAG_ISSUE_COMMENT_CREATE = 'issue@comment@create';
    /**
     * 删除评论
     */
    const NOTIFY_FLAG_ISSUE_COMMENT_REMOVE = 'issue@comment@remove';
    /**
     * 开始解决事项
     */
    const NOTIFY_FLAG_ISSUE_RESOLVE_START = 'issue@resolve@start';
    /**
     * 停止解决事项
     */
    const NOTIFY_FLAG_ISSUE_RESOLVE_STOP = 'issue@resolve@stop';
    /**
     * 新增迭代
     */
    const NOTIFY_FLAG_SPRINT_CREATE = 'sprint@create';
    /**
     * 设置迭代进行时
     */
    const NOTIFY_FLAG_SPRINT_START = 'sprint@start';
    /**
     * 删除迭代
     */
    const NOTIFY_FLAG_SPRINT_REMOVE = 'sprint@remove';
    /**
     * 更新迭代
     */
    const NOTIFY_FLAG_SPRINT_UPDATE = 'sprint@update';



    public function __construct()
    {
    }


    /**
     * @param $issueStatusId
     * @return string
     */
    public function getEmailNotifyFlag($issueStatusId)
    {
        $statusClosedId = IssueStatusModel::getInstance()->getIdByKey('closed');
        $statusResolvedId = IssueStatusModel::getInstance()->getIdByKey('resolved');
        $statusInprogressId = IssueStatusModel::getInstance()->getIdByKey('in_progress');

        switch ($issueStatusId) {
            case $statusClosedId:
                // 状态已关闭
                $notifyFlag = self::NOTIFY_FLAG_ISSUE_CLOSE;
                break;
            case $statusResolvedId:
                // 状态已解决
                $notifyFlag = self::NOTIFY_FLAG_ISSUE_RESOLVE_COMPLETE;
                break;
            case $statusInprogressId:
                // 状态进行中
                $notifyFlag = self::NOTIFY_FLAG_ISSUE_RESOLVE_START;
                break;
            default:
                $notifyFlag = self::NOTIFY_FLAG_ISSUE_UPDATE;
        }

        return $notifyFlag;
    }

    /**
     * @param string $schemeDataFlag 标识
     * @param int $projectId 项目ID
     * @param int $sourceId 资源ID(issueid or sprintid)
     * @param string $body 邮件内容html, 如果为空自动用标题代替
     * @throws \Exception
     */
    public function send($schemeDataFlag, $projectId, $sourceId = 0, $body = '')
    {
        // 是否开启邮件
        $settingsLogic = new SettingsLogic();
        if (!$settingsLogic->enableMail()) {
            return;
        }

        $toTargetUidArr = [];

        $notifySchemeDataModel = new NotifySchemeDataModel();
        $notifySchemeDataResult = $notifySchemeDataModel->getSchemeData(NotifySchemeModel::DEFAULT_SCHEME_ID);

        $flagUserRoleMap = array_column($notifySchemeDataResult, 'user', 'flag');

        $schemeDataFlagArr = explode('@', $schemeDataFlag);
        $sourceType = $schemeDataFlagArr[0];

        if ($schemeDataFlagArr[1] == 'comment') {
            $sourceType = 'issue_comment';
        }
        $row = [];
        if ($sourceType == 'issue_comment') {
            $timelineModel = new TimelineModel();
            $timeline = $timelineModel->getRowById($sourceId);
            if (!empty($timeline)) {
                $issueModel = new IssueModel();
                $row = $issueModel->getById($timeline['issue_id']);
            }
        }
        if ($sourceType == 'issue') {
            $issueModel = new IssueModel();
            $row = $issueModel->getById($sourceId);
        }
        if ($sourceType == 'sprint') {
            $sprintModel = SprintModel::getInstance();
            $row = $sprintModel->getById($sourceId);
        }

        $notifyRoleArr = json_decode($flagUserRoleMap[$schemeDataFlag], true);

        foreach ($notifyRoleArr as $notifyRole) {
            if ($notifyRole == self::NOTIFY_ROLE_ASSIGEE) {
                $toTargetUidArr = array_merge($toTargetUidArr, $this->getAssigeeUser($row, $sourceType));
            }
            if ($notifyRole == self::NOTIFY_ROLE_REPORTER) {
                $toTargetUidArr = array_merge($toTargetUidArr, $this->getReporterUser($row, $sourceType));
            }
            if ($notifyRole == self::NOTIFY_ROLE_FOLLOW) {
                $toTargetUidArr = array_merge($toTargetUidArr, $this->getFollowUser($row, $sourceType));
            }
            if ($notifyRole == self::NOTIFY_ROLE_PROJECT) {
                $toTargetUidArr = array_merge($toTargetUidArr, $this->getProjectUser($projectId));
            }
        }
        //print_r($toTargetUidArr);
        // 提取用户的email
        $userModel = new UserModel();
        $userRows = $userModel->getUsersByIds($toTargetUidArr);
        $toEmails = array_column($userRows, 'email');
        if ($schemeDataFlagArr[1] == 'comment') {
            $sourceType = 'issue_comment';
        }
        if ($this->sendEmailInitParams(
            $toEmails,
            $sourceType,
            $schemeDataFlag,
            $projectId,
            $sourceId,
            $body
        )) {
            $systemLogic = new SystemLogic();
            $systemLogic->mail($this->to, $this->subject, $this->body);
        }
    }


    /**
     * 初始化发送邮件的参数
     * @param array $toEmails
     * @param string $sourceType
     * @param string $schemeDataFlagName
     * @param int $projectId
     * @param int $sourceId
     * @param string $body
     * @return bool
     * @throws \Exception
     */
    private function sendEmailInitParams($toEmails, $sourceType, $schemeDataFlag, $projectId, $sourceId, $body)
    {
        if (empty($toEmails)) {
            return false;
        }
        $currentUser = $_SESSION[UserAuth::SESSION_USER_INFO_KEY];
        if (empty($currentUser)) {
            $currentUser = UserModel::getInstance()->getByUid(UserAuth::getId());
        }
        $tplArr = [];
        $projectModel = new ProjectModel();
        $projectRow = $projectModel->getById($projectId);
        $projectPathName = $projectRow['org_path'] . '/' . $projectRow['key'];
        $tplArr['project_key'] = $projectRow['key'];
        $tplArr['project_name'] = $projectRow['name'];
        $tplArr['project_title'] = $projectRow['name'];
        $tplArr['project_path'] = $projectPathName;
        $tplArr['display_name'] = $currentUser['display_name'];

        if ($sourceType == 'issue' || $sourceType == 'issue_comment') {
            if ($sourceType == 'issue_comment') {
                $timelineModel = new TimelineModel();
                $timeline = $timelineModel->getRowById($sourceId);
                $tplArr['comment_content'] = $timeline['content'];
                $sourceId = $timeline['issue_id'];
            }
            $issueModel = new IssueModel();
            $row = $issueModel->getById($sourceId);
            $sourceTitle = $row['summary'];
            $tplArr['issue_title'] = $sourceTitle;
            $tplArr['issue_key'] = $row['issue_num'];
            $tplArr['issue_link'] = ROOT_URL . 'issue/detail/index/' . $row['id'];
            $issueTypeModel = new IssueTypeModel();
            $tplArr['issue_type_title'] = $issueTypeModel->getById($row['issue_type'])['name'];
            $moduleRow = (new ProjectModuleModel())->getById($row['module']);
            $tplArr['issue_module_title'] = isset($moduleRow['name']) ? $moduleRow['name'] : '';
            $tplArr['assignee_display_name'] = (new UserModel())->getByUid($row['assignee'])['display_name'];
            $tplArr['report_display_name'] = (new UserModel())->getByUid($row['reporter'])['display_name'];
        }
        if ($sourceType == 'sprint') {
            $sprintModel = SprintModel::getInstance();
            $row = $sprintModel->getById($sourceId);
            $tplArr['sprint_id'] = $row['id'];
            $tplArr['sprint_title'] = $row['name'];
            $tplArr['sprint_start_date'] = $row['name'];
            $tplArr['sprint_end_date'] = $row['end_date'];
        }
        //print_r($tplArr);
        $schemeData = (new NotifySchemeDataModel())->getByFlag($schemeDataFlag);
        $replaceKeyArr = array_keys($tplArr);
        foreach ($replaceKeyArr as &$item) {
            $item = '{' . $item . '}';
        }
        $replaceKeyData = array_values($tplArr);

        $this->to = $toEmails;
        $this->subject = str_replace($replaceKeyArr, $replaceKeyData, $schemeData['title_tpl']);
        $this->body = str_replace($replaceKeyArr, $replaceKeyData, $schemeData['body_tpl']);

        return true;
    }

    /**
     * 邮件地址数组去重
     * @param array $emailArr
     * @return array
     */
    private function mergeUserEmails($emailArr = [])
    {
        $result = array_unique($emailArr);
        return $result;
    }

    /**
     * 获取项目成员USERID
     * @param $projectId
     * @return array
     * @throws \Exception
     */
    private function getProjectUser($projectId)
    {
        $projectUserIdArr = [];
        $projectUserRoleModel = new ProjectUserRoleModel();
        $rows = $projectUserRoleModel->getByProjectId($projectId);
        if (!empty($rows)) {
            $projectUserIdArr = array_column($rows, 'user_id');
        }

        return $projectUserIdArr;
    }

    /**
     * 获取该项目经办人USERID
     * @return array
     */
    private function getAssigeeUser($rowData, $sourceType)
    {
        if (empty($rowData)) {
            return [];
        }

        $assigneeUserId = 0;
        if ($sourceType == 'issue' || $sourceType == 'issue_comment') {
            $assigneeUserId = $rowData['assignee'];
        }

        return [$assigneeUserId];
    }

    /**
     * 获取事项报告人的USERID
     * @return array
     */
    private function getReporterUser($rowData, $sourceType)
    {
        if (empty($rowData)) {
            return [];
        }

        $reporterUserId = 0;
        if ($sourceType == 'issue' || $sourceType == 'issue_comment') {
            $reporterUserId = $rowData['reporter'];
        }
        return [$reporterUserId];
    }

    /**
     * 获取事项关注者USERID
     * @param $rowData
     * @param $sourceType
     * @return array
     * @throws \Exception
     */
    private function getFollowUser($rowData, $sourceType)
    {
        if (empty($rowData)) {
            return [];
        }

        $followUserIdArr = [];
        if ($sourceType == 'issue' || $sourceType == 'issue_comment') {
            $issueFollowModel = new IssueFollowModel();
            $issueFollowRows = $issueFollowModel->getItemsByIssueId($rowData['id']);
            $followUserIdArr = array_column($issueFollowRows, 'user_id');
        }
        return $followUserIdArr;
    }

}
