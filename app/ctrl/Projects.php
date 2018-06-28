<?php

namespace main\app\ctrl;

use main\app\classes\ProjectLogic;
use main\app\model\OrgModel;
use main\app\model\project\ProjectModel;
use main\app\classes\UserLogic;
use main\app\classes\SettingsLogic;
use main\lib\MySqlDump;

class Projects extends BaseUserCtrl
{

    public function __construct()
    {
        parent::__construct();
        parent::addGVar('top_menu_active', 'project');
    }

    /**
     * index
     */
    public function index()
    {
        $data = [];
        $data['title'] = '项目';
        $data['sub_nav_active'] = 'project';

        $dataKey = array(
            'count',
            'display_name'
        );

        $outProjectTypeList = [];
        $projectModel = new ProjectModel();
        $projectTypeAndCount = $projectModel->getAllProjectTypeCount();
        foreach ($projectTypeAndCount as $key => $value) {
            switch ($key) {
                case 'WHOLE':
                    $outProjectTypeList[0] = array_combine($dataKey, [$value, 'All']);
                    break;
                case 'SCRUM':
                    $outProjectTypeList[ProjectLogic::PROJECT_TYPE_SCRUM] =
                    array_combine($dataKey, [$value, ProjectLogic::$typeAll[ProjectLogic::PROJECT_TYPE_SCRUM]]);
                    break;
                case 'KANBAN':
                    $outProjectTypeList[ProjectLogic::PROJECT_TYPE_KANBAN] =
                    array_combine($dataKey, [$value, ProjectLogic::$typeAll[ProjectLogic::PROJECT_TYPE_KANBAN]]);
                    break;
                case 'SOFTWARE_DEV':
                    $outProjectTypeList[ProjectLogic::PROJECT_TYPE_SOFTWARE_DEV] =
                    array_combine($dataKey, [$value, ProjectLogic::$typeAll[ProjectLogic::PROJECT_TYPE_SOFTWARE_DEV]]);
                    break;
                case 'PROJECT_MANAGE':
                    $outProjectTypeList[ProjectLogic::PROJECT_TYPE_PROJECT_MANAGE] =
                    array_combine($dataKey, [$value, ProjectLogic::$typeAll[ProjectLogic::PROJECT_TYPE_PROJECT_MANAGE]]);
                    break;
                case 'FLOW_MANAGE':
                    $outProjectTypeList[ProjectLogic::PROJECT_TYPE_FLOW_MANAGE] =
                    array_combine($dataKey, [$value, ProjectLogic::$typeAll[ProjectLogic::PROJECT_TYPE_FLOW_MANAGE]]);
                    break;
                case 'TASK_MANAGE':
                    $outProjectTypeList[ProjectLogic::PROJECT_TYPE_TASK_MANAGE] =
                    array_combine($dataKey, [$value, ProjectLogic::$typeAll[ProjectLogic::PROJECT_TYPE_TASK_MANAGE]]);
                    break;
            }
        }

        $data['type_list'] = $outProjectTypeList;

        $this->render('gitlab/project/main.php', $data);
    }

    public function fetchAll($typeId = 0)
    {
        $typeId = intval($typeId);
        $projectModel = new ProjectModel();
        if($typeId){
            $projects = $projectModel->filterByType($typeId, false);
        }else{
            $projects = $projectModel->getAll(false);
        }

        $model = new OrgModel();
        $originsMap = $model->getMapIdAndPath();
        $types = ProjectLogic::$typeAll;
        foreach ($projects as &$item) {
            $item['type_name'] = isset($types[$item['type']]) ? $types[$item['type']] : '--';
            $item['path'] = isset($originsMap[$item['org_id']]) ? $originsMap[$item['org_id']] : 'default';
            $item['create_time_text'] = format_unix_time($item['create_time'], time());
            $item['create_time_origin'] = date('y-m-d H:i:s', $item['create_time']);
            $item['first_word'] = mb_substr(ucfirst($item['name']), 0, 1, 'utf-8');
            list($item['avatar'], $item['avatar_exist']) = ProjectLogic::formatAvatar($item['avatar']);
        }

        $userLogic = new UserLogic();
        $data['users'] = $userLogic->getAllNormalUser();
        unset($userLogic);

        $data['projects'] = $projects;
        $this->ajaxSuccess('success', $data);
    }

    public function test()
    {

        set_time_limit(0);
        ignore_user_abort(true);

        echo (new SettingsLogic)->dateTimezone();
        $dbConfig = getConfigVar('database');
        $dbConfig = $dbConfig['database']['default'];

        $time = -microtime(true);

        $dump = new \main\lib\MySqlDump($dbConfig);
        $dumpFile = STORAGE_PATH .'dump ' . date('Y-m-d H-i') . '.sql.gz';
        $dumpFile = STORAGE_PATH .'dump_test.sql.gz';
        $dump->save($dumpFile);

        $time += microtime(true);
        echo "FINISHED (in $time s)";
    }

    public function test2()
    {

        set_time_limit(0);
        ignore_user_abort(true);

        $dbConfig = getConfigVar('database');
        $dbConfig = $dbConfig['database']['default'];

        $dumpFile = STORAGE_PATH .'dump_test.sql.gz';

        $time = -microtime(true);

        $import = new \main\lib\MySqlImport($dbConfig);

        $import->onProgress = function ($count, $percent) {
            if ($percent !== null) {
                echo (int) $percent . " %\r";
            } elseif ($count % 10 === 0) {
                echo '.';
            }
        };

        $import->load($dumpFile);

        $time += microtime(true);
        echo "FINISHED (in $time s)";
    }


}
