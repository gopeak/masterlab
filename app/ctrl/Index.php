<?php

namespace main\app\ctrl;

use main\app\classes\SystemLogic;
use main\app\classes\UserAuth;

/**
 * Class Index
 * @package main\app\ctrl
 */
class Index extends BaseCtrl
{


    /**
     * 首页的控制器
     * Index constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * index
     */
    public function pageIndex()
    {
        $dashboard = new Dashboard();
        $dashboard->pageIndex();
    }

    /**
     * @param array $params
     * @throws \Exception
     */
    public function mailTest($params = [])
    {
        $title = 'MyTile';
        $content = '邮件测试';
        $reply = '79720699@qq.com';
        $mailer = '121642038@qq.com';
        unset($params);
        $systemLogic = new SystemLogic();
        ob_start();
        list($ret, $err) = $systemLogic->mail($mailer, $title, $content, $reply);
        unset($systemLogic);
        $data['err'] = $err;
        $data['verbose'] = ob_get_contents();
        ob_clean();
        ob_end_clean();
        if ($ret) {
            $this->ajaxSuccess('send_ok', $data);
        } else {
            $this->ajaxFailed("send_failed", $data);
        }
    }

    public function mailtest2()
    {
        $msg = '369';
        try {
            $mail = new \PHPMailer(true);
            $mail->IsSMTP();
            $mail->CharSet = 'UTF-8';
            $mail->SMTPAuth = true;
            $mail->Port = 80;
            $mail->SMTPDebug = 0;
            $mail->Host =  'smtpdm.aliyun.com';
            $mail->Username = 'sender@smtp.masterlab.vip';
            $mail->Password = 'MasterLab123Pwd';
            $mail->Timeout = 20;
            $mail->From = 'sender@smtp.masterlab.vip';
            $mail->FromName = 'Notify';

            $mail->AddAddress('23335096@qq.com');

            $mail->Subject = '123tstjuggtitle';
            $mail->Body = '<b>jugg hello index t</b>';
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

        echo $msg;
    }
}
