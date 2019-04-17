<?php
namespace main\app\classes;

use main\app\model\agile\SprintModel;
use main\app\model\issue\IssueFollowModel;
use main\app\model\issue\IssueModel;
use main\app\model\project\ProjectModel;
use main\app\model\project\ProjectUserRoleModel;
use main\app\model\system\NotifySchemeDataModel;
use main\app\model\system\NotifySchemeModel;
use main\app\model\user\UserModel;

class NotifyLogic
{
    public $to = null;
    public $from = null;
    public $subject = null;
    public $body = null;
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
        // 是否开启邮件
        $settingsLogic = new SettingsLogic();
        if (!$settingsLogic->enableMail()) {
            return ;
        }

        $toTargetUidArr = [];

        $notifySchemeDataModel = new NotifySchemeDataModel();
        $notifySchemeDataResult = $notifySchemeDataModel->getSchemeData(NotifySchemeModel::DEFAULT_SCHEME_ID);

        $flagUserRoleMap = array_column($notifySchemeDataResult, 'user', 'flag');
        $flagNameMap = array_column($notifySchemeDataResult, 'name', 'flag');

        $schemeDataFlagArr = explode('@', $schemeDataFlag);
        $sourceType = $schemeDataFlagArr[0];

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

        // 提取用户的email
        $userModel = new UserModel();
        $userRows = $userModel->getUsersByIds($toTargetUidArr);
        $toEmails = array_column($userRows, 'email');

        if ($this->sendEmailInitParams(
            $toEmails,
            $sourceType,
            $flagNameMap[$schemeDataFlag],
            $projectId,
            $sourceId,
            $body
        )) {
            $systemLogic = new SystemLogic();
            $systemLogic->mail($this->to, $this->subject, $this->body);
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

    private function syncSendBySmtp()
    {
        $ret = false;
        $msg = '';
        try {
            $mail = new \PHPMailer(true);
            $mail->IsSMTP();
            $mail->CharSet = 'UTF-8';
            $mail->SMTPAuth = true;
            $mail->Port = $this->emailConfig['mail_port'];
            $mail->SMTPDebug = 0;
            $mail->Host =  $this->emailConfig['mail_host'];
            $mail->Username = $this->emailConfig['mail_account'];
            $mail->Password = $this->emailConfig['mail_password'];
            $mail->Timeout = $this->emailConfig['mail_timeout'];
            $mail->From = $this->emailConfig['send_mailer'];
            $mail->FromName = 'Notify';
            if (is_array($this->to) && !empty($this->to)) {
                foreach ($this->to as $t) {
                    $mail->AddAddress($t);
                }
            } else {
                $msg = 'Mailer Error: email address is error...';
            }

            $mail->Subject = $this->subject;
            $mail->Body = $this->body;
            $mail->AltBody = "To view the message, please use an HTML compatible email viewer!";
            $mail->WordWrap = 80;
            $mail->IsHTML(true);
            $ret = $mail->Send();
            if (!$ret) {
                $msg = 'Mailer Error: ' . $mail->ErrorInfo;
            }
        } catch (\phpmailerException $e) {
            $msg =  "邮件发送失败：" . $e->errorMessage();
        }

        return [$ret, $msg];
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
        if (empty($toEmails)) {
            return false;
        }

        // 获取发信配置信息
        /**
        $settingsLogic = new SettingsLogic();

        $this->emailConfig['mail_port'] = $settingsLogic->mailPort();
        $this->emailConfig['mail_prefix'] = $settingsLogic->mailPrefix();
        $this->emailConfig['mail_host'] = $settingsLogic->mailHost();
        $this->emailConfig['mail_account'] = $settingsLogic->mailAccount();
        $this->emailConfig['mail_password'] = $settingsLogic->mailPassword();
        $this->emailConfig['mail_timeout'] = $settingsLogic->mailTimeout();
        $this->emailConfig['send_mailer'] = $settingsLogic->sendMailer();
        */

        $sourceTitle = '';

        $projectModel = new ProjectModel();
        $projectRow = $projectModel->getById($projectId);
        $projectPathName = $projectRow['org_path'] . '/' . $projectRow['key'];

        if ($sourceType == 'issue') {
            $issueModel = new IssueModel();
            $row = $issueModel->getById($sourceId);
            $sourceTitle = $row['summary'];
            $sourceId = $projectRow['key'] . $sourceId;
        }
        if ($sourceType == 'sprint') {
            $sprintModel = SprintModel::getInstance();
            $row = $sprintModel->getById($sourceId);
            $sourceTitle = $row['name'];
        }

        $this->to = $toEmails;
        // $this->from = mb_encode_mimeheader($fromName) . ' <' . $fromEmail . '>';
        $this->subject = sprintf('[%s] %s #%s %s', $projectPathName, $schemeDataFlagName, $sourceId, $sourceTitle);
        $this->body = empty($body) ? $this->subject : $body;

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
        if ($sourceType == 'issue') {
            $issueFollowModel = new IssueFollowModel();
            $issueFollowRows = $issueFollowModel->getItemsByIssueId($rowData['id']);
            $followUserIdArr = array_column($issueFollowRows, 'user_id');
        }
        return $followUserIdArr;
    }

}
