<?php

namespace main\app\ctrl;

use main\app\classes\PermissionGlobal;
use main\app\classes\PermissionLogic;
use main\app\classes\ProjectLogic;
use main\app\classes\UserAuth;
use main\app\model\issue\IssueModel;
use main\app\model\OrgModel;
use main\app\model\project\ProjectModel;
use main\app\classes\UserLogic;
use main\app\classes\SettingsLogic;
use main\app\classes\ConfigLogic;
use main\app\model\project\ProjectUserRoleModel;
use main\app\model\user\UserModel;
use main\app\classes\UploadLogic;
use main\app\model\user\UserSettingModel;
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
        $userId = UserAuth::getId();

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

        $data['is_admin'] = false;
        if (PermissionGlobal::check(UserAuth::getId(), PermissionGlobal::MANAGER_PROJECT_PERM_ID)) {
            $data['is_admin'] = true;
        }

        // 获取用户搜索排序的个性化设置
        $data['project_sort'] = '';
        $userSettingModel = new UserSettingModel();
        $projectsSort = $userSettingModel->getSettingByKey($userId, 'projects_sort');
        if ($projectsSort) {
            $data['projects_sort'] = $projectsSort;
        }

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

        $searchSortArr = [
            'latest_activity_desc' => ['issue_update_time', 'desc'],
            'created_desc' => ['create_time', 'desc'],
            'name_asc' => ['name', 'asc'],
        ];
        $searchKey = '';
        if (isset($_GET['name']) && !empty($_GET['name'])) {
            $searchKey = $_GET['name'];
        }
        $searchOrderBy = 'issue_update_time';
        $searchSort = 'desc';
        if (isset($_GET['sort']) && !empty($_GET['sort'])) {
            if (array_key_exists($_GET['sort'], $searchSortArr)) {
                $searchOrderBy = $searchSortArr[$_GET['sort']][0];
                $searchSort = $searchSortArr[$_GET['sort']][1];

                $userSettingModel = new UserSettingModel();
                $projectsSort = $userSettingModel->getSettingByKey($userId, 'projects_sort');
                if ($projectsSort) {
                    $userSettingModel->updateSetting($userId, 'projects_sort', $_GET['sort']);
                } else {
                    $userSettingModel->insertSetting($userId, 'projects_sort', $_GET['sort']);
                }
            }
        }
        

        // 至少获取20个项目用户
        $fetchProjectUserNum = 20;
        if (isset($_GET['fetch_project_user_num'])) {
            $fetchProjectUserNum = max(1, intval($_GET['fetch_project_user_num']));
        }

        $projectIdArr = PermissionLogic::getUserRelationProjectIdArr($userId);

        $projectModel = new ProjectModel();

        if ($typeId) {
            //$projects = $projectModel->filterByType($typeId, false);
            $projects = $projectModel->filterByNameOrKeyAndType($searchKey, $typeId, $searchOrderBy, $searchSort);
        } else {
            //$projects = $projectModel->getAll(false);
            $projects = $projectModel->filterByNameOrKey($searchKey, $searchOrderBy, $searchSort);
        }


        if (PermissionGlobal::check($userId, PermissionGlobal::MANAGER_PROJECT_PERM_ID)) {
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

        $data['is_admin'] = false;
        if ($isAdmin) {
            $data['is_admin'] = true;
        }

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
        $ret = $uploadLogic->move('qqfile', 'project_image', $uuid, $originName, $fileSize);
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
