<?php

namespace main\app\ctrl;

use main\app\model\OriginModel;
use main\app\model\project\ProjectModel;
use main\app\classes\OriginLogic;

class Projects extends BaseUserCtrl
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
        $data['title'] = '项目';
        $this->render('gitlab/project/main.php', $data);
    }

    public function fetchAll()
    {
        $projectModel = new ProjectModel();
        $projects = $projectModel->getAll();
        $model = new OriginModel();
        $originsMap = $model->getMapIdAndPath();

        foreach ($projects as &$item) {
            $item['path'] = $originsMap[$item['origin_id']];
            $item['create_time'] = format_unix_time($item['create_time'], time());
        }
        unset($item);

        $data['projects'] = $projects;
        $this->ajaxSuccess('success', $data);
    }


}
