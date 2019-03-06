<?php
namespace main\app\classes;


use main\app\model\agile\SprintModel;
use main\app\model\issue\IssueFollowModel;
use main\app\model\issue\IssueModel;
use main\app\model\project\ProjectModel;
use main\app\model\system\NotifySchemeDataModel;
use main\app\model\system\NotifySchemeModel;

class NotifyLogic
{
    public $to = null;
    public $from = null;
    public $subject = null;
    public $body = null;

    const NOTIFY_ROLE_ASSIGEE = 'assigee';
    const NOTIFY_ROLE_REPORTER = 'reporter';
    const NOTIFY_ROLE_FOLLOW = 'follow';
    const NOTIFY_ROLE_PROJECT = 'project';

    public function __construct()
    {
    }

    /**
     * @param string $schemeDataFlag    标识
     * @param int $projectId            项目ID
     * @param int $sourceId             资源ID(issueid or sprintid)
     * @param string $body              邮件内容html, 如果为空自动用标题代替
     * @throws \Exception
     */
    public function send($schemeDataFlag, $projectId, $sourceId = 0, $body = '')
    {
        $syncFlag = 1;
        $toEmails = [];

        $notifySchemeDataModel = new NotifySchemeDataModel();
        $notifySchemeDataResult = $notifySchemeDataModel->getSchemeData(NotifySchemeModel::DEFAULT_SCHEME_ID);

        $flagUserRoleMap = array_column($notifySchemeDataResult, 'user', 'flag');
        $flagNameMap = array_column($notifySchemeDataResult, 'name', 'flag');

        $schemeDataFlagArr = explode('@', $schemeDataFlag);
        $sourceType = $schemeDataFlagArr[0];

        if ($sourceType == 'issue') {
            $issueModel = new IssueModel();
            $row = $issueModel->getById($sourceId);
            $sourceTitle = $row['summary'];
        }
        if ($sourceType == 'sprint') {
            $sprintModel = SprintModel::getInstance();
            $row = $sprintModel->getById($sourceId);
            $sourceTitle = $row['name'];
        }




        $notifyRoleArr = $flagUserRoleMap[$schemeDataFlag];

        foreach ($notifyRoleArr as $notifyRole) {
            if ($notifyRole == self::NOTIFY_ROLE_ASSIGEE) {
                array_merge($toEmails, $this->getAssigeeUser($row, $sourceType));
            }
            if ($notifyRole == self::NOTIFY_ROLE_REPORTER) {
                array_merge($toEmails, $this->getReporterUser($row, $sourceType));
            }
            if ($notifyRole == self::NOTIFY_ROLE_FOLLOW) {
                array_merge($toEmails, $this->getFollowUser($row, $sourceType));
            }
            if ($notifyRole == self::NOTIFY_ROLE_PROJECT) {
                array_merge($toEmails, $this->getProjectUser($projectId));
            }
        }

        $this->sendEmailInitParams(
            $toEmails,
            $sourceType,
            $flagNameMap[$schemeDataFlag],
            $projectId,
            $sourceId,
            $body
        );

        if ($syncFlag) {
            $this->syncSend();
        } else {
            $this->asyncSend();
        }
    }

    /**
     * @return bool
     */
    private function syncSend()
    {
        $headers   = [];
        $headers[] = "MIME-Version: 1.0";
        $headers[] = 'Content-type: text/html; charset="UTF-8";';
        $headers[] = "From: {$this->from}";
        $headers[] = "Reply-To: {$this->from}";
        $headers[] = "Subject: {$this->subject}";

        $result =  mail($this->to, $this->subject, $this->body, implode("\r\n", $headers));
        return $result;
    }

    private function asyncSend()
    {

    }

    /**
     * 初始化发送邮件的参数
     * @param array $toEmails
     * @param string $sourceType
     * @param string $schemeDataFlagName
     * @param int $projectId
     * @param int $sourceId
     * @param string $body
     * @throws \Exception
     */
    private function sendEmailInitParams($toEmails, $sourceType, $schemeDataFlagName, $projectId, $sourceId, $body)
    {
        $fromEmail = 'notify@masterlab.vip';
        $fromName = 'Notify';

        $sourceTitle = '';

        if (is_array($toEmails)) {
            $to = [];
            foreach ($toEmails as $item) {
                $to[] = mb_encode_mimeheader($item) . ' <' . $item . '>';
            }
        } else {
            $to = $toEmails;
        }

        if ($sourceType == 'issue') {
            $issueModel = new IssueModel();
            $row = $issueModel->getById($sourceId);
            $sourceTitle = $row['summary'];

            new IssueFollowModel();


        }
        if ($sourceType == 'sprint') {
            $sprintModel = SprintModel::getInstance();
            $row = $sprintModel->getById($sourceId);
            $sourceTitle = $row['name'];
        }

        $projectModel = new ProjectModel();
        $row = $projectModel->getById($projectId);

        $projectPathName = $row['org_path'] . '/' . $row['key'];

        $this->to = is_array($to) ? implode(',', $to) : $to;
        $this->from = mb_encode_mimeheader($fromName) . ' <' . $fromEmail . '>';
        $this->subject = sprintf('[%s] %s #%s %s', $projectPathName, $schemeDataFlagName, $sourceId, $sourceTitle);
        $this->body = empty($body) ? $this->subject : $body;
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
     * @return array
     */
    private function getProjectUser($projectId)
    {

        return [];
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
        if ($sourceType == 'issue') {
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
        if ($sourceType == 'issue') {
            $reporterUserId = $rowData['reporter'];
        }
        return [$reporterUserId];
    }

    /**
     * 获取事项关注者USERID
     * @return array
     */
    private function getFollowUser($rowData, $sourceType)
    {
        if (empty($rowData)) {
            return [];
        }

        $reporterUserId = 0;
        if ($sourceType == 'issue') {
            $reporterUserId = $rowData['reporter'];
        }
        return [];
    }

}
