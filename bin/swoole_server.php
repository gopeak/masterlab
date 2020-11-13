<?php
require_once './bootstrap.php';
require_once $rootDir . '/vendor/autoload.php';
use main\app\model\SettingModel;
use main\app\model\system\MailQueueModel;


$socketHost = trimStr($config['socket_server_host']);
$socketPort = (int)$config['socket_server_port'];
$server = new Swoole\Server($socketHost, $socketPort);

//设置异步任务的工作进程数量
$server->set(array('task_worker_num' => 12));

$server->set([
    'daemonize' => false, //是否作为守护进程
    'open_length_check' => true,
    'package_max_length' => 1024*1024*10,
    'package_length_type' => 'N', //see php pack()
    'package_length_offset' => 0,
    'package_body_offset' => 4,
]);

//此回调函数在worker进程中执行
$server->on('receive', function($serv, $fd, $from_id, $data) {
    $len = unpack('N', $data)['1'];
    $body = substr($data, -$len);
    //投递异步任务
    $task_id = $serv->task($body);
    echo "Dispatch AsyncTask: id=$task_id\n";
});

//处理异步任务(此回调函数在task进程中执行)
$server->on('task', function ($serv, $task_id, $from_id, $data) {

   // echo "New AsyncTask[id=$task_id]".PHP_EOL;
    $bodyArr = json_decode($data, true);
    $sendArr = $bodyArr;
    print_r($sendArr);
    $recipients = $sendArr['to'];
    $replyTo = $sendArr['cc'];
    $title = $sendArr['subject'] ;
    $content = $sendArr['body'];
    $sendArr['attach'] = isset($sendArr['attach']) ? $sendArr['attach'] : '';

    $mailQueModel = new MailQueueModel();
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

    try {
        $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
        $mail->IsSMTP();
        $mail->CharSet = 'UTF-8'; //设置邮件的字符编码，这很重要，不然中文乱码
        $mail->SMTPAuth = true; //开启认证
        $mail->Port = (int)$sendArr['port'];
        $mail->SMTPDebug =  0;
        $mail->Host = $sendArr['host'];
        $mail->Username = $sendArr['user'];
        $mail->Password = $sendArr['password'];
        $mail->Timeout = isset($sendArr['timeout']) ? $sendArr['timeout'] : 20;
        $mail->From = trimStr($sendArr['from']);
        $mail->FromName = $sendArr['from_name'];
        if (isset($config['is_exchange_server']) && $config['is_exchange_server'] == '1') {
            $mail->setFrom($mail->From, $mail->FromName);
        }
        // 保留原代码，兼容已有的配置
        if (in_array($mail->Port, [465, 994, 995, 993])) {
            $mail->SMTPSecure = 'ssl';
        } else {
            $mail->SMTPSecure = 'tls';
        }
        // 是否启用ssl
        if (isset($config['is_ssl'])) {
            if ($config['is_ssl'] == '1') {
                $mail->SMTPSecure = 'ssl';
            } else {
                $mail->SMTPSecure = 'tls';
            }
        }
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        if(is_string($recipients)){
            $recipients = [$recipients];
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
        if(is_string($replyTo)){
            $replyTo = [$replyTo];
        }
        if (!empty($replyTo)) {
            if (is_array($replyTo)) {
                foreach ($replyTo as $r) {
                    $mail->addReplyTo(trimStr($r));
                }
            }
        }

        $mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; //当邮件不支持html时备用显示，可以省略
        $mail->WordWrap = 80; // 设置每行字符串的长度
        $contentType = isset($sendArr['content_type']) ? $sendArr['content_type'] : 'html';
        $mail->IsHTML($contentType == 'html');
        $ret = $mail->Send();
        if (!$ret) {
            $msg = 'Mailer Error: ' . $mail->ErrorInfo;
            $mailQueModel->update(['status'=>MailQueueModel::STATUS_ERROR, 'error'=>$msg], ['seq'=>$sendArr['seq']]);
        }
    } catch (\phpmailerException $e) {
        // print_r($e->getCode());
        //print_r($e->getTrace());
        $msg = "邮件发送失败：" . $e->errorMessage();
        echo $msg;
        $mailQueModel->update(['status'=>MailQueueModel::STATUS_ERROR, 'error'=>$msg], ['seq'=>$sendArr['seq']]);

    } catch (\Exception $e) {
        $msg = "邮件发送失败：" . $e->getMessage();
        echo $msg;
        $mailQueModel->update(['status'=>MailQueueModel::STATUS_ERROR, 'error'=>$msg], ['seq'=>$sendArr['seq']]);
    }
    $mailQueModel->update(['status'=>MailQueueModel::STATUS_DONE, 'error'=>''], ['seq'=>$sendArr['seq']]);
    //返回任务执行的结果
    $serv->finish("$data -> OK");
});


//处理异步任务的结果(此回调函数在worker进程中执行)
$server->on('finish', function ($serv, $task_id, $data) {
    echo "AsyncTask[$task_id] Finished ".PHP_EOL;
});


Swoole\Timer::tick(1000, function(){

    echo "crontab checking \n";

    $rootDir = realpath(dirname(__FILE__). '/../') ;
    $json = file_get_contents($rootDir.'/bin/cron.json');
    $cronArr = json_decode($json, true);

    if(!$cronArr['schedule']){
        return;
    }
    foreach ($cronArr['schedule'] as $item) {
        $exp = substr($item['exp'],2);
        //echo $exp." ";
        $cron = Cron\CronExpression::factory($exp);
        //echo $cron->getNextRunDate()->format('Y-m-d H:i:s')." \n";
        // echo $cron->getNextRunDate()->getTimestamp()."\n";
        $runTime = $cron->getNextRunDate()->getTimestamp();
        $offsetTime = $runTime-time();
        if($offsetTime<2 && $offsetTime>-2){
            log_cron("脚本:".$item['name']." ".$item['file']." 触发");
            echo $item['name'].' '.$cron->getNextRunDate()->format('Y-m-d H:i:s')." \n";
            // 达到时间要求
            $cronPhpBin = $item['exe_bin'];
            if(!file_exists($cronPhpBin)){
                list($phpBinRet, $phpBin) = get_php_bin_dir();
                if(!$phpBinRet){
                    return;
                }
                $cronPhpBin = $phpBin;
            }
            exec("ps aux | grep ".$item['file'], $output, $return);
            if ($return == 0) {
                echo $item['file'].", process is running\n";
                continue;
            }
            $command = $cronPhpBin.' '.$item['arg'].' '.$item['file'];
            exec($command, $output);
            log_cron(print_r($output, true));
            log_cron("脚本:".$item['name']." ".$item['file']." 执行结束");
        }

    }



});

$server->start();