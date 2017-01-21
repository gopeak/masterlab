<?php

/**
 * Created by PhpStorm.
 * User: sven
 * Date: 2017/7/7 0007
 * Time: 下午 3:56
 */

namespace main\app\classes;

use main\app\model\system\MailQueueModel;
use main\app\model\user\UserGroupModel;
use main\app\model\project\ProjectUserRoleModel;
use main\app\model\user\UserModel;
use main\app\model\SettingModel;

/**
 * 系统逻辑处理类
 * Class SystemLogic
 * @package main\app\classes
 */
class SystemLogic
{
    /**
     * 通过项目角色获取邮件人
     * @param $projectIds
     * @param $roleIds
     * @return array
     */
    public function getUserEmailByProjectRole($projectIds, $roleIds)
    {
        if (empty($projectIds)) {
            return [];
        }
        $userProjectRoleModel = new ProjectUserRoleModel();
        $userIds = $userProjectRoleModel->getUidsByProjectRole($projectIds, $roleIds);

        $userModel = new UserModel();
        $emails = $userModel->getFieldByIds('email', $userIds);
        return $emails;
    }

    /**
     * 通过项目获取邮件人
     * @param $projectIds
     * @return array
     */
    public function getUserEmailByProject($projectIds)
    {
        if (empty($projectIds)) {
            return [];
        }
        $userProjectRoleModel = new ProjectUserRoleModel();
        $userIds = $userProjectRoleModel->getUidsByProjectIds($projectIds);

        $userModel = new UserModel();
        $emails = $userModel->getFieldByIds('email', $userIds);
        return $emails;
    }

    /**
     * 通过用户组获取邮件
     * @param $groups
     * @return array
     */
    public function getUserEmailByGroup($groups)
    {
        if (empty($groups)) {
            return [];
        }
        $userGroupModel = new UserGroupModel();
        $userIds = $userGroupModel->getUserIdsByGroups($groups);
        $userModel = new UserModel();
        $emails = $userModel->getFieldByIds('email', $userIds);
        return $emails;
    }


    /**
     * 通用的邮件发送函数
     * @param $recipients string 收件人,多人用分号隔开
     * @param $title  string 邮件标题
     * @param $content  string 邮件内容
     * @param string $replyTo 抄送人
     * @param string $contentType
     * @return array
     * @throws \Exception
     */
    public function mail($recipients, $title, $content, $replyTo = '', $contentType = 'html')
    {
        $settingModel = new SettingModel();
        $enableMail = $settingModel->getValue('enable_mail');
        if ($enableMail != 1) {
            return [false, "未开启邮件推送选项"];
        }

        $enableAsyncMail = $settingModel->getValue('enable_async_mail');
        if ($enableAsyncMail != 1) {
            return $this->directMail($recipients, $title, $content, $replyTo, $contentType);
        } else {
            if (!is_array($recipients)) {
                $toMailer[] = $recipients;
            } else {
                $toMailer = $recipients;
            }
            return $this->asyncMail($toMailer, $title, $content, $replyTo, $contentType);
        }
    }

    /**
     * php直接发送邮件
     * @param $recipients
     * @param $title
     * @param $content
     * @param string $replyTo
     * @param string $contentType
     * @return array
     * @throws \Exception
     */
    public function directMail($recipients, $title, $content, $replyTo = '', $contentType = 'html')
    {
        $settingModel = new SettingModel();
        $settings = $settingModel->getSettingByModule('mail');
        $config = [];
        if (empty($settings)) {
            return [false, 'fetch mail setting error'];
        }
        foreach ($settings as $s) {
            $config[$s['_key']] = $settingModel->formatValue($s);
        }
        unset($settings);
        ini_set("magic_quotes_runtime", 0);
        //require_once PRE_APP_PATH . '/vendor/phpmailer/phpmailer/PHPMailerAutoload.php';
        try {
            $mail = new \PHPMailer(true);
            $mail->IsSMTP();
            $mail->CharSet = 'UTF-8'; //设置邮件的字符编码，这很重要，不然中文乱码
            $mail->SMTPAuth = true; //开启认证
            $mail->Port = $config['mail_port'];
            $mail->SMTPDebug = 0;
            $mail->Host = $config['mail_host'];    //"smtp.exmail.qq.com";
            $mail->Username = $config['mail_account'];     // "chaoduo.wei@ismond.com";
            $mail->Password = $config['mail_password'];    // "";
            $mail->Timeout = isset($config['timeout']) ? $config['timeout'] : 20;
            $mail->From = $config['send_mailer'];
            $mail->FromName = $config['send_mailer'];

            if (!empty($recipients) && is_array($recipients)) {
                foreach ($recipients as $r) {
                    $mail->AddAddress($r);
                }
            } else {
                $mail->AddAddress($recipients);
            }
            $mail->Subject = $title;
            $mail->Body = $content;
            if (!empty($replyTo)) {
                $mail->addReplyTo($replyTo);
            }

            $mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; //当邮件不支持html时备用显示，可以省略
            $mail->WordWrap = 80; // 设置每行字符串的长度
            $mail->IsHTML($contentType == 'html');
            $ret = $mail->Send();
            // print_r($mail);
            if (!$ret) {
                $msg = 'Mailer Error: ' . $mail->ErrorInfo;
                return [false, $msg];
            }
        } catch (\phpmailerException $e) {
            $msg = "邮件发送失败：" . $e->errorMessage();
            return [false, $msg];
        } catch (\Exception $e) {
            $msg = "邮件发送失败：" . $e->getMessage();
            return [false, $msg];
        }
        return [true, 'ok'];
    }

    /**
     * 通过将数据发送给异步服务，再发送邮件
     * @param $recipients
     * @param $title
     * @param $content
     * @param string $replyTo
     * @param string $contentType
     * @param string $attach
     * @return array
     * @throws \Exception
     */
    public function asyncMail($recipients, $title, $content, $replyTo = '', $contentType = 'html', $attach = '')
    {
        ignore_user_abort(true);

        $settingModel = new SettingModel();
        $settings = $settingModel->getSettingByModule('mail');
        $config = [];
        if (empty($settings)) {
            return [false, 'fetch mail setting error'];
        }
        foreach ($settings as $s) {
            $config[$s['_key']] = $settingModel->formatValue($s);
        }
        unset($settings);
        $seq = msectime();
        $sendArr = [];
        $sendArr['seq'] = $seq;
        $sendArr['host'] = $config['mail_host'];
        $sendArr['port'] = $config['mail_port'];
        $sendArr['user'] = $config['mail_account'];
        $sendArr['password'] = $config['mail_password'];
        $sendArr['from'] = $config['send_mailer'];
        $sendArr['to'] = $recipients;
        $sendArr['cc'] = $replyTo;
        $sendArr['subject'] = $title;
        $sendArr['body'] = $content;
        $sendArr['content_type'] = $contentType;
        $sendArr['attach'] = $attach;

        $mailQueModel = new MailQueueModel();
        $queue = [];
        $queue['seq'] = $seq;
        $queue['title'] = $title;
        $queue['address'] = is_string($recipients) ? $recipients : @implode(';', $recipients);
        $queue['status'] = 'ready';

        $socketHost = '127.0.0.1';
        $socketPort = 9002;
        $socketConnectTimeout = 10;
        if (isset($config['socket_server_host']) && !empty($config['socket_server_host'])) {
            $socketHost = trimStr($config['socket_server_host']);
        }
        if (isset($config['socket_connect_timeout']) && !empty($config['socket_connect_timeout'])) {
            $socketConnectTimeout = trimStr($config['socket_connect_timeout']);
        }
        $fp = @fsockopen($socketHost, $socketPort, $errno, $errstr, $socketConnectTimeout);
        if (!$fp) {
            $err = 'fsockopen failed:' . mb_convert_encoding($errno . ' ' . $errstr, "UTF-8", "GBK");
            $queue['status'] = 'error';
            $queue['error'] = $err;
            $mailQueModel->add($queue);
            return [false, $err];
        } else {
            $queue['error'] = '';
            $mailQueModel->add($queue);
            $header = '{"cmd":"Mail","sid":"' . $seq . '","ver":"1.0","seq":' . $sendArr['seq'] . ',"token":""}';
            $body = json_encode($sendArr);
            $header_len = mbstrlen($header);
            $body_len = mbstrlen($body);
            $total_size = mbstrlen($header) + $body_len + 4;

            $bin_total_size = uInt32($total_size);
            $bin_type = uInt32(1);
            $bin_header_size = uInt32($header_len);
            $bin_data = $bin_total_size . $bin_type . $bin_header_size . $header . $body;

            fwrite($fp, $bin_data);
            fclose($fp);
        }

        return [true, 'send data to async server success'];
    }
}
