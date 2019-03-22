<?php
/**
 * Created by PhpStorm.
 * User: sven
 * Date: 2017/7/4 0004
 * Time: 下午 7:07
 */

namespace main\app\async;


class email
{
    /**
     * 发送邮件
     * @param $json_obj
     * @return array
     */
    function send_mail( $json_obj ){

        if( !isset($json_obj->to)
            || !isset($json_obj->subject)
            || !isset($json_obj->content)
            || !isset($json_obj->config)
        ){
            return [ false , '参数错误' ];
        }
        $to = $json_obj->to;
        $subject = $json_obj->subject;
        $body = $json_obj->content;
        $config = (array)$json_obj->config;

        require_once PRE_APP_PATH . '/vendor/phpmailer/phpmailer/PHPMailerAutoload.php';
        $ret = false;
        $msg = '';

        try {
            $mail = new \PHPMailer(true);
            $mail->IsSMTP();
            $mail->CharSet='UTF-8';
            $mail->SMTPAuth = true;
            $mail->Port = $config->port;
            $mail->SMTPDebug = 0;
            $mail->Host =  $config->host;
            $mail->Username = $config->username;
            $mail->Password = $config->password;
            $mail->Timeout = isset( $config->timeout ) ? $config->timeout :20  ;
            $mail->From = $config->username;
            $mail->FromName =  $config->username;
            if( is_array($to) && !empty($to) ){
                foreach ( $to as $t ){
                    $mail->AddAddress( $t );
                }
            }else{
                $mail->AddAddress($to);
            }

            $mail->Subject = $subject;
            $mail->Body = $body ;
            $mail->AltBody = "To view the message, please use an HTML compatible email viewer!";
            $mail->WordWrap = 80;
            $mail->IsHTML(true);
            $ret =  $mail->Send();
            if( !$ret ) {
                $msg = 'Mailer Error: ' . $mail->ErrorInfo;
            }

        } catch (\phpmailerException $e) {
            $msg =  "邮件发送失败：".$e->errorMessage();
        }
        return [ $ret , $msg ];
    }
}