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
use main\app\model\CacheKeyModel;
use main\app\model\permission\PermissionModel;
use main\app\model\user\UserModel;
use main\app\model\project\ProjectRoleModel;
use main\app\model\project\ProjectUserRoleModel;
use main\app\model\project\ProjectRoleRelationModel;
use main\app\model\ActivityModel;

/**
 * 项目角色控制器
 */
class Role extends BaseUserCtrl
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
        $data['title'] = '项目角色';
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
        $this->render('gitlab/project/setting_project_role.php', $data);
    }

    /**
     * @param null $id
     * @throws \Exception
     */
    public function get($id = null)
    {
        if (isset($_GET['_target'][3])) {
            $id = (int)$_GET['_target'][3];
        }
        if (isset($_GET['id'])) {
            $id = (int)$_GET['id'];
        }
        $model = new ProjectRoleModel();
        $data = $model->getById($id);
        if (empty($data)) {
            $this->ajaxFailed('参数错误', '数据为空');
        }
        $this->ajaxSuccess('success', $data);
    }

    /**
     * 获取项目的所有角色
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
        $this->ajaxSuccess('ok', $data);
    }

    /**
     * 新增一个自定义的角色
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
     * 更新一个自定义的角色
     * @param array $params
     * @throws \Exception
     */
    public function update($params = [])
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
        $errorMsg = [];
        if (empty($params)) {
            $this->ajaxFailed('错误', '没有提交表单数据');
        }

        if (!isset($params['name']) || empty($params['name'])) {
            $errorMsg['name'] = '名称不能为空';
        }
        $model = new ProjectRoleModel();
        $currentRow = $model->getById($id);
        if (!isset($currentRow['id'])) {
            $this->ajaxFailed('错误', 'id错误,找不到对应的数据');
        }
        if ($currentRow['is_system'] == '1') {
            $this->ajaxFailed('提示', '预定义的角色不能编辑', BaseCtrl::AJAX_FAILED_TYPE_TIP);
        }

        $row = $model->getByName($params['name']);
        //var_dump($row);
        if (isset($row['id']) && ($row['id'] != $id)) {
            $errorMsg['name'] = '名称已经被使用';
        }

        if (!empty($errorMsg)) {
            $this->ajaxFailed('参数错误', $errorMsg, BaseCtrl::AJAX_FAILED_TYPE_FORM_ERROR);
        }

        $id = (int)$id;
        $info = [];
        $info['name'] = $params['name'];
        if (isset($params['description'])) {
            $info['description'] = $params['description'];
        }
        $ret = $model->updateById($id, $info);
        if ($ret) {
            $currentUid = $this->getCurrentUid();
            $activityModel = new ActivityModel();
            $activityInfo = [];
            $activityInfo['action'] = '更新了项目角色';
            $activityInfo['type'] = ActivityModel::TYPE_PROJECT;
            $activityInfo['obj_id'] = $id;
            $activityInfo['title'] = $info['name'];
            $activityModel->insertItem($currentUid, $currentRow['project_id'], $activityInfo);

            //写入操作日志
            $logData = [];
            $logData['user_name'] = $this->auth->getUser()['username'];
            $logData['real_name'] = $this->auth->getUser()['display_name'];
            $logData['obj_id'] = 0;
            $logData['module'] = LogOperatingLogic::MODULE_NAME_PROJECT;
            $logData['page'] = $_SERVER['REQUEST_URI'];
            $logData['action'] = LogOperatingLogic::ACT_EDIT;
            $logData['remark'] = '修改项目角色';
            $logData['pre_data'] = $currentRow;
            $logData['cur_data'] = $info;
            LogOperatingLogic::add($uid, $currentRow['project_id'], $logData);

            $this->ajaxSuccess('ok');
        } else {
            $this->ajaxFailed('服务器错误', '更新数据失败');
        }
    }


    /**
     * 删除用户角色
     * @param $id
     * @throws \Exception
     */
    public function delete($id)
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
        } else {
            $projectUserRoleModel = new ProjectUserRoleModel();
            $projectUserRoleModel->delProjectRole($id);
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
            return '已删除' ;
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
    public function deleteRoleUser()
    {
        if (!isPost()) {
            $this->ajaxFailed('服务器错误', '请求失败');
        }
        if (isset($_POST['id'])) {
            $id = (int)$_POST['id'];
        }
        if (!$id) {
            $this->ajaxFailed('参数错误', 'id不能为空');
        }
        if (isset($_POST['user_id'])) {
            $user_id = (int)$_POST['user_id'];
        }
        if (!$user_id) {
            $this->ajaxFailed('参数错误', 'user_id不能为空');
        }
        if (isset($_POST['project_id'])) {
            $project_id = (int)$_POST['project_id'];
        }
        if (!$project_id) {
            $this->ajaxFailed('参数错误', 'project_id不能为空');
        }
        if (isset($_POST['role_id'])) {
            $role_id = (int)$_POST['role_id'];
        }
        if (!$role_id) {
            $this->ajaxFailed('参数错误', 'role_id不能为空');
        }

        $id = intval($id);
        $user_id = intval($user_id);
        $project_id = intval($project_id);
        $role_id = intval($role_id);


        $model = new ProjectUserRoleModel();
        $model->deleteUniqueItem($id, $user_id, $project_id, $role_id);

        $this->ajaxSuccess('操作成功');
    }

    /**
     * 删除项目的某个用户
     * @throws \Exception
     */
    public function deleteProjectUser()
    {
        if (!isPost()) {
            $this->ajaxFailed('服务器错误', '请求失败');
        }
        if (isset($_POST['user_id'])) {
            $user_id = (int)$_POST['user_id'];
        }
        if (!$user_id) {
            $this->ajaxFailed('参数错误', 'user_id不能为空');
        }
        if (isset($_POST['project_id'])) {
            $project_id = (int)$_POST['project_id'];
        }
        if (!$project_id) {
            $this->ajaxFailed('参数错误', 'project_id不能为空');
        }

        $user_id = intval($user_id);
        $project_id = intval($project_id);

        $model = new ProjectUserRoleModel();
        $model->delProjectUser($project_id, $user_id);

        $this->ajaxSuccess('操作成功');
    }

    /**
     * 获取角色树形关系的json格式
     */
    public function permTree()
    {
        $roleId = null;
        if (isset($_GET['_target'][3])) {
            $roleId = (int)$_GET['_target'][3];
        }
        if (isset($_REQUEST['role_id'])) {
            $roleId = (int)$_REQUEST['role_id'];
        }
        if (!$roleId) {
            //$this->ajaxFailed('参数错误', 'role_id不能为空');
            @header('Content-Type:application/json');
            echo json_encode([]);
            exit;
        }
        $roleId = intval($roleId);
        $permissionModel = new PermissionModel();
        $permissionRoleRelationModel = new ProjectRoleRelationModel();

        $parentList = $permissionModel->getParent();
        $childrenList = $permissionModel->getChildren();
        $permIdList = $permissionRoleRelationModel->getPermIdsByRoleId($roleId);

        unset($permissionModel);
        unset($permissionRoleRelationModel);

        //组装数据
        $data = [];
        $i = 0;
        foreach ($parentList as $p) {
            $data[$i]['id'] = $p['id'];
            $data[$i]['text'] = $p['name'];
            $data[$i]['state'] = in_array($p['id'], $permIdList) ? ['selected' => true] : ['selected' => false];
            $data[$i]['icon'] = "fa fa-lock";

            $data[$i]['children'] = [];
            $j = 0;
            foreach ($childrenList as $k => $c) {
                if ($c['parent_id'] == $p['id']) {
                    $data[$i]['children'][$j]['id'] = $k;
                    $data[$i]['children'][$j]['text'] = $c['name'];
                    $data[$i]['children'][$j]['state'] = in_array($k, $permIdList) ? ['selected' => true] : ['selected' => false];
                    $j++;
                }
            }
            $i++;
        }
        @header('Content-Type:application/json');
        echo json_encode($data);
        exit;
    }

    /**
     * 更新角色权限
     * @throws \Exception
     */
    public function updatePerm()
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
        if (!isset($_REQUEST['permission_ids'])) {
            $this->ajaxFailed(' 参数错误 ', 'permission_Ids不能为空');
        }

        $permissionIds = $_REQUEST['permission_ids'];
        $permIdsList = explode(',', $permissionIds);
        if (!is_array($permIdsList)) {
            $this->ajaxFailed(' 参数错误 ', '获取权限数据失败');
        }

        // @todo 判断是否拥有权限
        $userId = UserAuth::getId();
        $model = new ProjectRoleModel();
        $role = $model->getById($roleId);
        if (!PermissionLogic::check($role['project_id'], $userId, PermissionLogic::ADMINISTER_PROJECTS)) {
            $this->ajaxFailed(' 权限受限 ', '您没有权限执行此操作');
        }

        $model = new ProjectRoleRelationModel();
        $model->db->connect();
        try {
            $model->db->beginTransaction();
            $model->deleteByRoleId($roleId);
            foreach ($permIdsList as $perm) {
                $model->add($role['project_id'], $roleId, $perm);
            }
            $model->db->commit();

            //写入操作日志
            $logData = [];
            $logData['user_name'] = $this->auth->getUser()['username'];
            $logData['real_name'] = $this->auth->getUser()['display_name'];
            $logData['obj_id'] = 0;
            $logData['module'] = LogOperatingLogic::MODULE_NAME_PROJECT;
            $logData['page'] = $_SERVER['REQUEST_URI'];
            $logData['action'] = LogOperatingLogic::ACT_EDIT;
            $logData['remark'] = '修改项目角色权限';
            $logData['pre_data'] = [];
            $logData['cur_data'] = [];
            LogOperatingLogic::add($uid, $role['project_id'], $logData);
        } catch (\PDOException $exception) {
            $model->db->rollBack();
            unset($model->db);
            unset($model);
            $this->ajaxFailed(' 服务器错误 ', '执行数据库操作失败,详情:' . $exception->getMessage());
        }
        unset($model);
        $this->ajaxSuccess('ok', []);
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
     * 为项目角色添加用户
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
        $logData['cur_data'] = ['user_id'=>$userId, 'project_id'=>$role['project_id'], 'role_id'=>$roleId];
        LogOperatingLogic::add($uid, $role['project_id'], $logData);

        unset($model);
        $this->ajaxSuccess('ok', $data);
    }

    /**
     * 修改项目下的某用户的角色
     * @throws \Exception
     */
    public function modifyProjectUserHasRoles()
    {
        if (!isPost()) {
            $this->ajaxFailed('服务器错误', '请求失败');
        }
        if (isset($_POST['user_id'])) {
            $userId = (int)$_POST['user_id'];
        }
        if (!$userId) {
            $this->ajaxFailed('参数错误', 'user_id不能为空');
        }
        if (isset($_POST['project_id'])) {
            $projectId = (int)$_POST['project_id'];
        }
        if (!$projectId) {
            $this->ajaxFailed('参数错误', 'project_id不能为空');
        }
        if (isset($_REQUEST['role_id'])&& is_array($_REQUEST['role_id'])) {
            $roleIds = $_REQUEST['role_id'];
        } else {
            $this->ajaxFailed('请选择用户角色', 'role_id为非预期参数');
        }
        if (empty($roleIds)) {
            $this->ajaxFailed('参数错误', 'role_id不能为空');
        }

        CacheKeyModel::getInstance()->clearCache('dict/permission');

        $model = new ProjectUserRoleModel();
        $model->db->beginTransaction();

        if (!$model->delProjectUser($projectId, $userId)) {
            $model->db->rollBack();
        }

        $insertRows = [];
        $projectUserRoleModel = new ProjectUserRoleModel();
        foreach ($roleIds as $roleId) {
            if ($projectUserRoleModel->checkUniqueItemExist($userId, $projectId, $roleId)) {
                // 该用户已有改角色,忽略
                continue;
            }
            $insertRows[] = ['user_id' => $userId, 'project_id' => $projectId, 'role_id' => $roleId];
        }

        if (empty($insertRows)) {
            // 没有可写数据, 说明用户没有角色
            $model->db->rollBack();
        }

        $projectUserRoleModel = new ProjectUserRoleModel();
        if (!$projectUserRoleModel->insertRoles($insertRows)) {
            $model->db->rollBack();
            $this->ajaxFailed(' 服务器错误 ', '数据库新增失败');
        }

        $model->db->commit();

        $data = [];
        $this->ajaxSuccess('修改成功', $data);
    }


    /**
     * 为项目添加成员及对应的角色, 一个用户一次添加多个角色
     * @throws \Exception
     */
    public function addProjectMemberRoles()
    {
        $projectId = 0;
        $roleIds = [];
        $uid = $this->getCurrentUid();

        if (isset($_REQUEST['role_id']) && is_array($_REQUEST['role_id'])) {
            $roleIds = $_REQUEST['role_id'];
        } else {
            $this->ajaxFailed('参数错误', 'role_id为非预期参数');
        }
        if (empty($roleIds)) {
            $this->ajaxFailed('参数错误', 'role_id不能为空');
        }

        $userId = null;
        if (isset($_REQUEST['user_id'])) {
            $userId = (int)$_REQUEST['user_id'];
        }
        if (!$userId) {
            $this->ajaxFailed('参数错误', 'user_id不能为空');
        }
        $userId = intval($userId);

        CacheKeyModel::getInstance()->clearCache('dict/permission');

        $projectRoleModel = new ProjectRoleModel();
        $projectUserRoleModel = new ProjectUserRoleModel();
        $insertRows = [];
        foreach ($roleIds as $roleId) {
            $role = $projectRoleModel->getById($roleId);

            if ($projectId == 0) {
                $projectId = $role['project_id'];
            }

            if ($projectId != $role['project_id']) {
                $this->ajaxFailed(' 异常 ', '非预期数据写入');
            }

            if ($projectUserRoleModel->checkUniqueItemExist($userId, $projectId, $roleId)) {
                // 该用户已有该角色,忽略
                continue;
            }

            $insertRows[] = ['user_id' => $userId, 'project_id' => $projectId, 'role_id' => $roleId];
        }

        if (empty($insertRows)) {
            $this->ajaxFailed(' 没有可写入的数据 ', '没有可写入的数据');
        }

        if (!$projectUserRoleModel->insertRoles($insertRows)) {
            $this->ajaxFailed(' 服务器错误 ', '数据库新增失败');
        }

        // 获取该项目成员的角色信息
        $data['cur_user_role'] = $projectUserRoleModel->getUserRolesByProject($userId, $projectId);


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
        $logData['cur_data'] = ['user_id' => $userId, 'project_id' => $projectId, 'role_id' => implode(",", $roleIds)];
        LogOperatingLogic::add($uid, $role['project_id'], $logData);

        $this->ajaxSuccess('ok', $data);
    }
}
