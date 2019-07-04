<?php
/**
 * Created by PhpStorm.
 */

namespace main\app\ctrl\project;

use main\app\classes\LogOperatingLogic;
use main\app\ctrl\BaseCtrl;
use main\app\ctrl\BaseUserCtrl;
use main\app\classes\PermissionLogic;
use main\app\classes\RewriteUrl;
use main\app\classes\UserLogic;
use main\app\classes\UserAuth;
use main\app\model\permission\PermissionModel;
use main\app\model\user\UserModel;
use main\app\model\project\ProjectRoleModel;
use main\app\model\project\ProjectUserRoleModel;
use main\app\model\project\ProjectRoleRelationModel;
use main\app\model\ActivityModel;

/**
 * 项目角色控制器
 */
class User extends BaseUserCtrl
{

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
        $data['title'] = '项目用户';
        parent::addGVar('top_menu_active', 'project');
        $data['nav_links_active'] = 'setting';
        $data['sub_nav_active'] = 'project_role';
        $data = RewriteUrl::setProjectData($data);
        $userModel = new UserModel();
        $users = $userModel->getAll();
        foreach ($users as &$user) {
            $user = UserLogic::format($user);
        }
        $data['users'] = $users;
        $this->render('gitlab/project/setting_project_user.php', $data);
    }



    /**
     * 获取项目的所有用户及用户相关的项目角色
     * @throws \Exception
     */
    public function fetchAll()
    {
        $projectId = null;
        if (isset($_GET['_target'][3])) {
            $projectId = (int)$_GET['_target'][3];
        }
        if (isset($_GET['project_id'])) {
            $projectId = (int)$_GET['project_id'];
        }
        if (empty($projectId)) {
            $this->ajaxFailed('参数错误', '项目id不能为空');
        }
        $model = new ProjectRoleModel();
        $data['roles'] = $model->getsByProject($projectId);
        $roleObj = [];
        foreach ($data['roles'] as $role) {
            $roleObj[$role['id']] = $role;
        }

        $userLogic = new UserLogic();
        $userHaveRolesArr = $userLogic->getUserIdArrByProject($projectId);

        $userIdArr = array_keys($userHaveRolesArr);
        $userModel = new UserModel();
        $users = $userModel->getUsersByIds($userIdArr);
        foreach ($users as &$user) {
            $user['have_roles'] = [];
            $userId = $user['uid'];
            if (!empty($userHaveRolesArr[$userId])) {
                foreach ($userHaveRolesArr[$userId] as $roleId) {
                    $user['have_roles'][] = $roleObj[$roleId];
                }
            }
        }
        $data['users'] = $users;

        $this->ajaxSuccess('ok', $data);
    }

    /**
     * 项目新加入用户
     * @param null $params
     * @throws \Exception
     */
    public function add($params = null)
    {
        $uid = $this->getCurrentUid();
        $projectId = null;
        if (isset($_GET['_target'][3])) {
            $projectId = (int)$_GET['_target'][3];
        }
        if (isset($_GET['project_id'])) {
            $projectId = (int)$_GET['project_id'];
        }
        if (empty($projectId)) {
            $this->ajaxFailed('参数错误', '项目id不能为空');
        }
        if (empty($params)) {
            $this->ajaxFailed('错误', '没有提交表单数据');
        }

        $errorMsg = [];
        if (!isset($params['name']) || empty($params['name'])) {
            $errorMsg['name'] = '标题不能为空';
        }

        if (isset($params['name']) && empty($params['name'])) {
            $errorMsg['name'] = '名称不能为空';
        }

        if (!empty($errorMsg)) {
            $this->ajaxFailed('参数错误', $errorMsg, BaseCtrl::AJAX_FAILED_TYPE_FORM_ERROR);
        }

        $info = [];
        $info['is_system'] = '0';
        $info['project_id'] = $projectId;
        $info['name'] = $params['name'];

        if (isset($params['description'])) {
            $info['description'] = $params['description'];
        }

        $model = new ProjectRoleModel();
        if (isset($model->getByName($info['name'])['id'])) {
            $this->ajaxFailed('提示', '名称已经被使用', BaseCtrl::AJAX_FAILED_TYPE_TIP);
        }

        list($ret, $msg) = $model->insert($info);
        if ($ret) {
            $currentUid = $this->getCurrentUid();
            $activityModel = new ActivityModel();
            $activityInfo = [];
            $activityInfo['action'] = '创建了项目角色';
            $activityInfo['type'] = ActivityModel::TYPE_PROJECT;
            $activityInfo['obj_id'] = $ret[1];
            $activityInfo['title'] = $info['name'];
            $activityModel->insertItem($currentUid, $projectId, $activityInfo);

            //写入操作日志
            $logData = [];
            $logData['user_name'] = $this->auth->getUser()['username'];
            $logData['real_name'] = $this->auth->getUser()['display_name'];
            $logData['obj_id'] = 0;
            $logData['module'] = LogOperatingLogic::MODULE_NAME_PROJECT;
            $logData['page'] = $_SERVER['REQUEST_URI'];
            $logData['action'] = LogOperatingLogic::ACT_ADD;
            $logData['remark'] = '添加项目角色';
            $logData['pre_data'] = [];
            $logData['cur_data'] = $info;
            LogOperatingLogic::add($uid, $projectId, $logData);

            $this->ajaxSuccess('ok');
        } else {
            $this->ajaxFailed('服务器错误:', '数据库插入失败,详情 :' . $msg);
        }
    }



    /**
     * 删除用户角色
     * @param $id
     * @throws \Exception
     */
    public function removeUser($id)
    {
        $id = null;
        $uid = $this->getCurrentUid();
        if (isset($_GET['_target'][3])) {
            $id = (int)$_GET['_target'][3];
        }
        if (isset($_REQUEST['id'])) {
            $id = (int)$_REQUEST['id'];
        }
        if (!$id) {
            $this->ajaxFailed('参数错误', 'id不能为空');
        }

        $id = intval($id);
        $model = new ProjectRoleModel();
        $role = $model->getRowById($id);
        if (!isset($role['id'])) {
            $this->ajaxFailed('参数错误', '找不到对应的用户角色');
        }
        if ($role['is_system'] == '1') {
            $this->ajaxFailed('提示', '预定义角色不能删除', BaseCtrl::AJAX_FAILED_TYPE_TIP);
        }
        $ret = $model->deleteById($id);

        if (!$ret) {
            $this->ajaxFailed('服务器错误', '删除角色失败');
        }
        // @todo  清除关联数据 清除缓存
        $currentUid = $this->getCurrentUid();
        $activityModel = new ActivityModel();
        $activityInfo = [];
        $activityInfo['action'] = '删除了项目角色';
        $activityInfo['type'] = ActivityModel::TYPE_PROJECT;
        $activityInfo['obj_id'] = $id;
        $activityInfo['title'] = $role['name'];
        $activityModel->insertItem($currentUid, $role['project_id'], $activityInfo);

        $callFunc = function ($value) {
            return '已删除';
        };
        $role2 = array_map($callFunc, $role);
        //写入操作日志
        $logData = [];
        $logData['user_name'] = $this->auth->getUser()['username'];
        $logData['real_name'] = $this->auth->getUser()['display_name'];
        $logData['obj_id'] = 0;
        $logData['module'] = LogOperatingLogic::MODULE_NAME_PROJECT;
        $logData['page'] = $_SERVER['REQUEST_URI'];
        $logData['action'] = LogOperatingLogic::ACT_DELETE;
        $logData['remark'] = '删除项目角色';
        $logData['pre_data'] = $role;
        $logData['cur_data'] = $role2;
        LogOperatingLogic::add($uid, $role['project_id'], $logData);

        $this->ajaxSuccess('ok');
    }


    /**
     * @throws \Exception
     */
    public function fetchRoleUser()
    {
        $roleId = null;
        if (isset($_GET['_target'][3])) {
            $roleId = (int)$_GET['_target'][3];
        }
        if (isset($_REQUEST['role_id'])) {
            $roleId = (int)$_REQUEST['role_id'];
        }
        if (!$roleId) {
            $this->ajaxFailed('参数错误', 'role_id不能为空');
        }
        $roleId = intval($roleId);

        // @todo 判断是否拥有权限
        $userId = UserAuth::getId();
        $model = new ProjectRoleModel();
        $role = $model->getById($roleId);
        if (!PermissionLogic::check($role['project_id'], $userId, PermissionLogic::ADMINISTER_PROJECTS)) {
            //$this->ajaxFailed(' 权限受限 ', '您没有权限执行此操作');
        }

        $model = new ProjectUserRoleModel();
        $data['role_users'] = $model->getsRoleId($roleId);
        unset($model);
        $this->ajaxSuccess('ok', $data);
    }

    /**
     * @throws \Exception
     */
    public function addRoleUser()
    {
        $roleId = null;
        $uid = $this->getCurrentUid();
        if (isset($_GET['_target'][3])) {
            $roleId = (int)$_GET['_target'][3];
        }
        if (isset($_REQUEST['role_id'])) {
            $roleId = (int)$_REQUEST['role_id'];
        }
        if (!$roleId) {
            $this->ajaxFailed('参数错误', 'role_id不能为空');
        }
        $roleId = intval($roleId);

        $userId = null;
        if (isset($_REQUEST['user_id'])) {
            $userId = (int)$_REQUEST['user_id'];
        }
        if (!$userId) {
            $this->ajaxFailed('参数错误', 'user_id不能为空');
        }
        $userId = intval($userId);

        // @todo 判断是否拥有权限
        $currentUserId = UserAuth::getId();
        $model = new ProjectRoleModel();
        $role = $model->getById($roleId);
        if (!PermissionLogic::check($role['project_id'], $currentUserId, PermissionLogic::ADMINISTER_PROJECTS)) {
            //$this->ajaxFailed(' 权限受限 ', '您没有权限执行此操作');
        }
        $model = new ProjectUserRoleModel();

        if ($model->checkUniqueItemExist($userId, $role['project_id'], $roleId)) {
            $this->ajaxFailed(' 已添加过该用户 ', '不要重复添加');
        }

        list($ret, $msg) = $model->insertRole($userId, $role['project_id'], $roleId);
        if (!$ret) {
            $this->ajaxFailed(' 服务器错误 ', '数据库新增失败,详情:' . $msg);
        }

        $data['role_users'] = $model->getsRoleId($roleId);


        //写入操作日志
        $logData = [];
        $logData['user_name'] = $this->auth->getUser()['username'];
        $logData['real_name'] = $this->auth->getUser()['display_name'];
        $logData['obj_id'] = 0;
        $logData['module'] = LogOperatingLogic::MODULE_NAME_PROJECT;
        $logData['page'] = $_SERVER['REQUEST_URI'];
        $logData['action'] = LogOperatingLogic::ACT_ADD;
        $logData['remark'] = '添加项目角色的用户';
        $logData['pre_data'] = [];
        $logData['cur_data'] = ['user_id' => $userId, 'project_id' => $role['project_id'], 'role_id' => $roleId];
        LogOperatingLogic::add($uid, $role['project_id'], $logData);

        unset($model);
        $this->ajaxSuccess('ok', $data);
    }
}
