<?php
namespace main\app\classes;


use main\app\model\system\NotifySchemeDataModel;
use main\app\model\system\NotifySchemeModel;

class NotifyLogic
{
    public $to = null;
    public $from = null;
    public $subject = null;
    public $body = null;

    public function __construct()
    {
    }

    /**
     * @throws \Exception
     */
    public function send($schemeDataFlag, $data = ['project_id' => 0, ''])
    {
        $syncFlag = 1;
        $toEmails = [];

        $notifySchemeDataModel = new NotifySchemeDataModel();
        $notifySchemeDataResult = $notifySchemeDataModel->getSchemeData(NotifySchemeModel::DEFAULT_SCHEME_ID);

        $flagUserRoleMap = array_column($notifySchemeDataResult, 'user', 'flag');
        $flagNameMap = array_column($notifySchemeDataResult, 'name', 'flag');

        $notifyRoleArr = $flagUserRoleMap[$schemeDataFlag];

        foreach ($notifyRoleArr as $notifyRole) {
            if ($notifyRole == 'assigee') {
                array_merge($toEmails, $this->getAssigeeUser());
            }
            if ($notifyRole == 'reporter') {
                array_merge($toEmails, $this->getReporterUser());
            }
            if ($notifyRole == 'follow') {
                array_merge($toEmails, $this->getFollowUser());
            }
            if ($notifyRole == 'project') {
                array_merge($toEmails, $this->getReporterUser());
            }
        }

        $this->sendEmailInitParams($toEmails, $flagNameMap[$schemeDataFlag], '');

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
     * @param $toEmails
     * @param $subject
     * @param $body
     */
    private function sendEmailInitParams($toEmails, $subject, $body)
    {
        $fromEmail = 'notify@masterlab.vip';
        $fromName = 'Notify';

        if (is_array($toEmails)) {
            $to = [];
            foreach ($toEmails as $item) {
                $to[] = mb_encode_mimeheader($item) . ' <' . $item . '>';
            }
        } else {
            $to = $toEmails;
        }


        $projectPathName = 'default/DEV';

        $this->to = is_array($to) ? implode(',', $to) : $to;
        $this->from = mb_encode_mimeheader($fromName) . ' <' . $fromEmail . '>';
        $this->subject = sprintf('[%s] %s', $projectPathName, $subject);
        $this->body = $body;
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
     * 获取项目成员邮箱列表
     * @return array
     */
    private function getProjectUser()
    {

        return [];
    }

    /**
     * 获取该项目经办人邮箱地址
     * @return array
     */
    private function getAssigeeUser()
    {

        return [];
    }

    /**
     * 获取事项报告人的邮箱地址
     * @return array
     */
    private function getReporterUser()
    {

        return [];
    }

    /**
     * 获取事项关注者的邮箱地址
     * @return array
     */
    private function getFollowUser()
    {

        return [];
    }

}
