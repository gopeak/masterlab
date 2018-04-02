<?php

namespace main\app\ctrl;

use main\app\classes\ConfigLogic;
use main\app\classes\OriginLogic;
use main\app\model\project\ProjectModel;

class Origin extends BaseUserCtrl
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * index
     */
    public function index()
    {

        $data = [];
        $data['title'] = '组织';
        $data['nav_links_active'] = 'origin';
        $data['sub_nav_active'] = 'all';
        $this->render('gitlab/origin/main.php', $data);
    }


    public function fetchAll()
    {
        $data = [];
        $originLogic = new OriginLogic();
        $data['origins'] = $originLogic->getOrigins();

        $projectModel = new ProjectModel();
        $data['projects'] = $projectModel->getAll();

        $this->ajaxSuccess('success', $data);
    }


    public function create()
    {
        $data = [];
        $data['title'] = '创建组织';
        $data['nav_links_active'] = 'origin';
        $data['sub_nav_active'] = 'all';
        $this->render('gitlab/origin/form.php', $data);
    }

    public function add()
    {

    }

}
