<?php

namespace main\app\ctrl;

use main\app\classes\ProjectLogic;
use main\app\model\OriginModel;
use main\app\model\project\ProjectModel;
use main\app\classes\OriginLogic;
use main\app\classes\UserLogic;
use main\app\classes\SettingsLogic;

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
        $data['sub_nav_active'] = 'project';

        $outProjectTypeList = [];
        $projectModel = new ProjectModel();
        $projectTypeAndCount = $projectModel->getAllProjectTypeCount();
        foreach ($projectTypeAndCount as $key=>$value){
            switch ($key){
                case 'WHOLE':
                    $outProjectTypeList['All'] = $value;
                    break;
                case 'SCRUM':
                    $outProjectTypeList[ProjectLogic::$typeAll[ProjectLogic::PROJECT_TYPE_SCRUM]] = $value;
                    break;
                case 'KANBAN':
                    $outProjectTypeList[ProjectLogic::$typeAll[ProjectLogic::PROJECT_TYPE_KANBAN]] = $value;
                    break;
                case 'SOFTWARE_DEV':
                    $outProjectTypeList[ProjectLogic::$typeAll[ProjectLogic::PROJECT_TYPE_SOFTWARE_DEV]] = $value;
                    break;
                case 'PROJECT_MANAGE':
                    $outProjectTypeList[ProjectLogic::$typeAll[ProjectLogic::PROJECT_TYPE_PROJECT_MANAGE]] = $value;
                    break;
                case 'FLOW_MANAGE':
                    $outProjectTypeList[ProjectLogic::$typeAll[ProjectLogic::PROJECT_TYPE_FLOW_MANAGE]] = $value;
                    break;
                case 'TASK_MANAGE':
                    $outProjectTypeList[ProjectLogic::$typeAll[ProjectLogic::PROJECT_TYPE_TASK_MANAGE]] = $value;
                    break;
            }

        }

        $data['type_list'] = $outProjectTypeList;

        $this->render('gitlab/project/main.php', $data);
    }

    public function fetchAll()
    {
        $projectModel = new ProjectModel();
        list($projects, $total) = $projectModel->getAll(1 , 20);
        $model = new OriginModel();
        $originsMap = $model->getMapIdAndPath();

        foreach ($projects as &$item) {
            $item['type_name'] = isset(ProjectLogic::$typeAll[$item['type']])?ProjectLogic::$typeAll[$item['type']]:'未知';
            $item['path'] = $originsMap[$item['origin_id']];
            $item['create_time_text'] = format_unix_time($item['create_time'], time());
            $item['create_time_origin'] = date('y-m-d H:i:s', $item['create_time']);
        }
        unset($item);

        $userLogic = new UserLogic();
        $data['users'] = $userLogic->getAllNormalUser();
        unset($userLogic);


        $data['projects'] = $projects;
        $this->ajaxSuccess('success', $data);
    }

    public function test()
    {
        echo (new SettingsLogic)->dateTimezone();
    }


}
