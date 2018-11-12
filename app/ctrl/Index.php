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
}
