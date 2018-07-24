<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/24
 * Time: 0:13
 */

namespace main\app\ctrl;


class Dashboard extends BaseUserCtrl
{

    public function __construct()
    {
        parent::__construct();
        parent::addGVar('top_menu_active','index');
    }

    /**
     * index
     */
    public function index()
    {
        $data = [];
        $data['title'] = '首页';
        $data['top_menu_active'] = 'org';
        $data['nav_links_active'] = 'org';
        $data['sub_nav_active'] = 'all';
        $this->render('gitlab/dashboard.php', $data);
    }
}