<?php

/**
 * Created by PhpStorm.
 * User: sven
 * Date: 2017/7/7 0007
 * Time: 下午 3:56
 */

namespace main\app\classes;

use main\app\model\user\UserGroupModel;
use main\app\model\user\UserProjectRoleModel;
use main\app\model\user\UserModel;
use main\app\model\SettingModel;

class SystemLogic
{
    public function getUserEmailByProjectRole($project_ids, $role_ids)
    {
        if (empty($project_ids)) {
            return [];
        }
        $userProjectRoleModel = new UserProjectRoleModel();
        $uids = $userProjectRoleModel->getUidsByProjectRole($project_ids, $role_ids);

        $userModel = new UserModel();
        $emails = $userModel->getFieldByIds('email', $uids);
        return $emails;

    }

    public function getUserEmailByGroup($groups)
    {
        if (empty($groups)) {
            return [];
        }
        $userGroupModel = new UserGroupModel();
        $user_ids = $userGroupModel->getUserIdsByGroups($groups);
        $userModel = new UserModel();
        $emails = $userModel->getFieldByIds('email', $user_ids);
        return $emails;

    }

    public function mail($recipients, $title, $content, $replyTo = '', $content_type = 'html')
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
        require_once PRE_APP_PATH . '/vendor/phpmailer/phpmailer/PHPMailerAutoload.php';

        $data = [];
        try {
            $mail = new \PHPMailer(true);
            $mail->IsSMTP();
            $mail->CharSet = 'UTF-8'; //设置邮件的字符编码，这很重要，不然中文乱码
            $mail->SMTPAuth = true; //开启认证
            $mail->Port = $config['mail_port'];
            $mail->SMTPDebug = 0;
            $mail->Host = $config['mail_host'];    //"smtp.exmail.qq.com";
            $mail->Username = $config['mail_account'];     // "chaoduo.wei@ismond.com";
            $mail->Password = $config['mail_password'];    // "Simarui123";
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
            $mail->IsHTML($content_type == 'html');
            $ret = $mail->Send();
            if (!$ret) {
                $msg = 'Mailer Error: ' . $mail->ErrorInfo;
                return [false, $msg];
            }
        } catch (phpmailerException $e) {
            $msg = "邮件发送失败：" . $e->errorMessage();
            return [false, $msg];
        } catch (\Exception $e) {
            $msg = "邮件发送失败：" . $e->errorMessage();
            return [false, $msg];
        }
        return [true, 'ok'];

    }


}