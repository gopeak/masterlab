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
     * @param $recipients array 收件人
     * @param $title  string 邮件标题
     * @param $content  string 邮件内容
     * @param $replyTo array 抄送人
     * @param string $contentType
     * @return array
     * @throws \Exception
     */
    public function mail($recipients, $title, $content, $replyTo = [], $others = [])
    {
        $settingModel = new SettingModel();
        $enableMail = $settingModel->getValue('enable_mail');
        if ($enableMail != 1) {
            return [false, "未开启邮件推送选项"];
        }
        if (is_string($recipients)) {
            $recipients = explode(';', $recipients);
        }
        if (empty($replyTo)) {
            $replyTo = [];
        }
        if (is_string($replyTo)) {
            $replyTo = explode(';', $replyTo);
        }

        $enableAsyncMail = $settingModel->getValue('enable_async_mail');
        if ($enableAsyncMail != 1) {
            return $this->directMail($title, $content, $recipients, $replyTo, $others);
        } else {
            if (!is_array($recipients)) {
                $toMailer[] = $recipients;
            } else {
                $toMailer = $recipients;
            }
            return $this->asyncMail($title, $content, $toMailer, $replyTo, $others);
        }
    }

    /**
     * php直接发送邮件
     * @param string $title
     * @param string $content
     * @param array $recipients
     * @param array $replyTo
     * @param array $others
     * @return array
     * @throws \Exception
     */
    public function directMail($title, $content, $recipients, $replyTo = [], $others = [], $isDebug = false)
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
        // require_once PRE_APP_PATH . '/vendor/phpmailer/phpmailer/PHPMailerAutoload.php';
        // print_r($config);
        if (is_string($recipients)) {
            $recipients = str_replace(',', ';', $recipients);
            $recipients = explode(';', $recipients);
        }
        if (is_string($replyTo)) {
            $replyTo = str_replace(',', ';', $replyTo);
            $replyTo = explode(';', $replyTo);
        }
        //print_r($recipients);
        if (empty($recipients)) {
            return [false, '发送地址不能为空'];
        }
        try {
            $mail = new \PHPMailer(true);
            $mail->IsSMTP();
            $mail->CharSet = 'UTF-8'; //设置邮件的字符编码，这很重要，不然中文乱码
            $mail->SMTPAuth = true; //开启认证
            $mail->Port = (int)trimStr($config['mail_port']);
            $mail->SMTPDebug = $isDebug ? 1 : 0;
            $mail->Host = trimStr($config['mail_host']);
            $mail->Username = trimStr($config['mail_account']);
            $mail->Password = trimStr($config['mail_password']);
            $mail->Timeout = isset($config['timeout']) ? $config['timeout'] : 20;
            $mail->From = trimStr($config['send_mailer']);
            $mail->FromName = isset($others['from_name']) ? $others['from_name'] : 'Masterlab';
            if (in_array($mail->Port, [465, 994])) {
                $mail->SMTPSecure = 'ssl';
            } elseif (in_array($mail->Port, [587])) {
                $mail->SMTPSecure = 'tls';
            }

            foreach ($recipients as $addr) {
                $addr = trimStr($addr);
                if (empty($addr)) {
                    continue;
                }
                $mail->AddAddress($addr);
            }
            $mail->Subject = $title;
            $mail->Body = $content;
            if (!empty($replyTo)) {
                if (is_array($replyTo)) {
                    foreach ($replyTo as $r) {
                        $mail->addReplyTo(trimStr($r));
                    }
                }
            }

            $mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; //当邮件不支持html时备用显示，可以省略
            $mail->WordWrap = 80; // 设置每行字符串的长度
            $contentType = isset($others['content_type']) ? $others['content_type'] : 'html';
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
     * 通过异步服务，再发送邮件
     * @param array $recipients
     * @param $title
     * @param $content
     * @param array $replyTo
     * @param array $others
     * @return array
     * @throws \Exception
     */
    public function asyncMail($title, $content, $recipients, $replyTo = [], $others = [])
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
        $sendArr['seq'] = strval($seq);
        $sendArr['host'] = trimStr($config['mail_host']);
        $sendArr['port'] = trimStr(strval($config['mail_port']));
        $sendArr['user'] = trimStr($config['mail_account']);
        $sendArr['password'] = trimStr($config['mail_password']);
        $sendArr['from'] = trimStr($config['send_mailer']);
        $sendArr['from_name'] = isset($others['from_name']) ? $others['from_name'] : 'Masterlab';
        $sendArr['to'] = $recipients;
        $sendArr['cc'] = $replyTo;
        $sendArr['bcc'] = isset($others['bcc']) ? $others['bcc'] : [];
        $sendArr['subject'] = $title;
        $sendArr['body'] = $content;
        $sendArr['content_type'] = isset($others['content_type']) ? $others['content_type'] : 'html';
        $sendArr['attach'] = isset($others['attach']) ? $others['attach'] : '';

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
        if (isset($config['socket_server_port']) && !empty($config['socket_server_port'])) {
            $socketPort = intval($config['socket_server_port']);
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