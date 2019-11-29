<?php

namespace main\app\ctrl;

use main\app\classes\PermissionGlobal;
use main\app\classes\PermissionLogic;
use main\app\classes\ProjectLogic;
use main\app\classes\UserAuth;
use main\app\model\OrgModel;
use main\app\model\project\ProjectModel;
use main\app\classes\UserLogic;
use main\app\classes\SettingsLogic;
use main\app\classes\ConfigLogic;
use main\app\model\project\ProjectUserRoleModel;
use main\app\model\user\UserModel;
use main\app\classes\UploadLogic;
use main\lib\MySqlDump;

/**
 * 项目列表
 * Class Projects
 * @package main\app\ctrl
 */
class Projects extends BaseUserCtrl
{

    /**
     * Projects constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct();
        parent::addGVar('top_menu_active', 'project');
    }

    /**
     * @throws \Exception
     */
    public function pageIndex()
    {
        $data = [];
        $data['title'] = '项目';
        $data['sub_nav_active'] = 'project';

        $dataKey = array(
            'count',
            'display_name'
        );

        $outProjectTypeList = [];
        $projectTypeAndCount = ProjectLogic::getAllProjectTypeTotal();

        foreach ($projectTypeAndCount as $key => $value) {
            switch ($key) {
                case 'WHOLE':
                    $outProjectTypeList[0] = array_combine($dataKey, [$value, '全部']);
                    break;
                case 'SCRUM':
                    $outProjectTypeList[ProjectLogic::PROJECT_TYPE_SCRUM] =
                        array_combine($dataKey, [$value, ProjectLogic::$typeAll[ProjectLogic::PROJECT_TYPE_SCRUM]]);
                    break;
                case 'SOFTWARE_DEV':
                    $outProjectTypeList[ProjectLogic::PROJECT_TYPE_SOFTWARE_DEV] =
                        array_combine($dataKey, [$value, ProjectLogic::$typeAll[ProjectLogic::PROJECT_TYPE_SOFTWARE_DEV]]);
                    break;
                case 'TASK_MANAGE':
                    $outProjectTypeList[ProjectLogic::PROJECT_TYPE_TASK_MANAGE] =
                        array_combine($dataKey, [$value, ProjectLogic::$typeAll[ProjectLogic::PROJECT_TYPE_TASK_MANAGE]]);
                    break;
            }
        }

        $data['type_list'] = $outProjectTypeList;
        ConfigLogic::getAllConfigs($data);
        $this->render('gitlab/project/main.php', $data);
    }

    /**
     * @param int $typeId
     * @throws \Exception
     */
    public function fetchAll($typeId = 0)
    {
        $userId = UserAuth::getId();
        $typeId = intval($typeId);
        $isAdmin = false;

        // 至少获取20个项目用户
        $fetchProjectUserNum = 20;
        if (isset($_GET['fetch_project_user_num'])) {
            $fetchProjectUserNum = max(1, intval($_GET['fetch_project_user_num']));
        }

        $projectIdArr = PermissionLogic::getUserRelationProjectIdArr($userId);

        $projectModel = new ProjectModel();
        if ($typeId) {
            $projects = $projectModel->filterByType($typeId, false);
        } else {
            $projects = $projectModel->getAll(false);
        }

        if (PermissionGlobal::check($userId, PermissionGlobal::ADMINISTRATOR)) {
            $isAdmin = true;
        }
        $userLogic = new UserLogic();
        $projectUserIdArr = $userLogic->getAllProjectUserIdArr();
        $userLogic = new UserLogic();
        $users = $userLogic->getAllNormalUser();

        foreach ($projects as $key => &$item) {
            $item = ProjectLogic::formatProject($item);
            // 剔除没有访问权限的项目
            if (!$isAdmin && !in_array($item['id'], $projectIdArr)) {
                unset($projects[$key]);
            }
            $userArr = [];
            if (isset($projectUserIdArr[$item['id']])) {
                $leaderUserId = $item['lead'];
                $userIdArr[] = $leaderUserId;
                $userIdArr = array_unique($projectUserIdArr[$item['id']]);
                $i = 0;
                foreach ($userIdArr as $userId) {
                    if (isset($users[$userId])) {
                        $i++;
                        // 获取N个成员
                        if ($i > $fetchProjectUserNum) {
                            break;
                        }
                        $user = $users[$userId];
                        $user['is_leader'] = false;
                        if ($userId == $leaderUserId) {
                            $user['is_leader'] = true;
                        }
                        $userArr[] = $user;
                    }
                }
            }
            $item['join_user_id_arr'] = $userArr;
        }


        unset($userLogic, $item);

        $projects = array_values($projects);
        $data['projects'] = $projects;

        $this->ajaxSuccess('success', $data);
    }

    /**
     * 项目的上传文件接口
     * @throws \Exception
     */
    public function upload()
    {
        $uuid = '';
        if (isset($_REQUEST['qquuid'])) {
            $uuid = $_REQUEST['qquuid'];
        }

        $originName = '';
        if (isset($_REQUEST['qqfilename'])) {
            $originName = $_REQUEST['qqfilename'];
        }

        $fileSize = 0;
        if (isset($_REQUEST['qqtotalfilesize'])) {
            $fileSize = (int)$_REQUEST['qqtotalfilesize'];
        }

        $uploadLogic = new UploadLogic();
        $ret = $uploadLogic->move('qqfile', 'avatar', $uuid, $originName, $fileSize);
        header('Content-type: application/json; charset=UTF-8');

        $resp = [];
        if ($ret['error'] == 0) {
            $resp['success'] = true;
            $resp['error'] = '';
            $resp['url'] = $ret['url'];
            $resp['filename'] = $ret['filename'];
            $resp['relate_path'] = $ret['relate_path'];
        } else {
            $resp['success'] = false;
            $resp['error'] = $ret['message'];
            $resp['error_code'] = $ret['error'];
            $resp['url'] = $ret['url'];
            $resp['filename'] = $ret['filename'];
        }
        echo json_encode($resp);
        exit;
    }


    public function test()
    {
        echo (new SettingsLogic)->dateTimezone();
    }


    /**
     * 初始化项目角色
     * @throws \Exception
     */
    public function initRole()
    {
        $ret = [];
        $projectArr = (new ProjectModel())->getAll(false);
        foreach ($projectArr as $item) {
            $ret[] = ProjectLogic::initRole($item['id']);
        }
        $this->ajaxSuccess('ok', $ret);
    }
}
