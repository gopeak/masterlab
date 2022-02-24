<?php

namespace main\app\ctrl\admin;

use main\app\classes\UserLogic;
use main\app\ctrl\BaseAdminCtrl;
use main\app\ctrl\BaseCtrl;
use main\app\model\permission\PermissionGlobalGroupModel;
use main\app\model\permission\PermissionGlobalModel;
use main\app\model\permission\PermissionGlobalRoleModel;
use main\app\model\permission\PermissionGlobalRoleRelationModel;
use main\app\model\permission\PermissionGlobalUserRoleModel;
use main\app\model\permission\ProjectPermissionModel;
use main\app\model\permission\DefaultRoleModel;
use main\app\model\permission\DefaultRoleRelationModel;
use main\app\model\user\GroupModel;
use main\app\model\user\UserModel;

/**
 * 系统角色权限控制器
 */
class Permission extends BaseAdminCtrl
{
    public function fetchGlobalPermissionRole()
    {
        $model = new PermissionGlobalRoleModel();
        $roles = $model->getsAll();

        $data = [];
        $data['roles'] = $roles;
        $this->ajaxSuccess('ok', $data);
    }

    /**
     * @throws \Exception
     */
    public function globalPermissionFetch()
    {
        $model = new PermissionGlobalModel();
        $perms = $model->getAll(false);
        $permGroupModel = new PermissionGlobalGroupModel();
        $permsGroups = $permGroupModel->getAll(false);

        $groupModel = new GroupModel();
        $groups = $groupModel->getAll();
        if (!empty($perms)) {
            foreach ($perms as &$p) {
                $has_groups = [];
                if (!empty($permsGroups)) {
                    foreach ($permsGroups as $pg) {
                        if ($pg['perm_global_id'] == $p['id']) {
                            if (isset($groups[$pg['group_id']])) {
                                $tmp = $groups[$pg['group_id']];
                                $tmp['perm_group_id'] = $pg['id'];
                                //$tmp['is_system'] = $pg['is_system'];
                                $has_groups[] = $tmp;
                            }
                        }
                    }
                }
                $p['groups'] = $has_groups;
            }
        }

        $data = [];
        $data['items'] = $perms;
        $data['groups'] = array_values($groups);
        $this->ajaxSuccess('ok', $data);
    }

    /**
     * @param $params
     * @throws \Exception
     */
    public function globalPermissionGroupAdd($params)
    {
        if (empty($params)) {
            $this->ajaxFailed('错误', '没有提交表单数据');
        }

        $err = [];
        if (!isset($params['perm_id'])) {
            $err['perm_id'] = '权限项不能为空';
        }

        if (!isset($params['group_id'])) {
            $err['group_id'] = '用户组不能为空';
        }
        if (!empty($err)) {
            $this->ajaxFailed('参数错误', $err, BaseCtrl::AJAX_FAILED_TYPE_FORM_ERROR);
        }

        $model = new PermissionGlobalGroupModel();

        // 判断是否重复
        $row = $model->getByParentIdAndGroupId((int)$params['perm_id'], (int)$params['group_id']);
        if (isset($row['id'])) {
            $this->ajaxFailed('提示', '您已经拥有此权限', BaseCtrl::AJAX_FAILED_TYPE_TIP);
        }

        list($ret, $last_insert_id) = $model->add((int)$params['perm_id'], (int)$params['group_id']);

        if (!$ret) {
            $this->ajaxFailed('服务器错误', '新增数据失败,详情:' . $last_insert_id);
        }
        // @todo 清除缓存
        $this->ajaxSuccess('操作成功');
    }


    /**
     * 通过角色ID获取角色信息
     * @throws \Exception
     */
    public function getGlobalPermissionRole()
    {
        if (isset($_GET['role_id'])) {
            $id = (int)$_GET['role_id'];
        }

        $model = new PermissionGlobalRoleModel();
        $data = $model->getById($id);

        if (empty($data)) {
            $this->ajaxFailed('参数错误', '数据为空');
        }
        $this->ajaxSuccess('success', $data);
    }


    /**
     * 添加全局角色ajax
     * @param $params
     * @throws \Exception
     */
    public function globalPermissionRoleAdd($params)
    {
        if (empty($params)) {
            $this->ajaxFailed('错误', '没有提交表单数据');
        }

        $err = [];
        if (!isset($params['name']) || empty($params['name'])) {
            $err['perm_id'] = '角色名不能为空';
        }

        if (!isset($params['description'])) {
            $params['description'] = '';
        }

        if (!empty($err)) {
            $this->ajaxFailed('参数错误', $err, BaseCtrl::AJAX_FAILED_TYPE_FORM_ERROR);
        }

        $params['name'] = trim($params['name']);

        $model = new PermissionGlobalRoleModel();

        // 判断是否重复
        $row = $model->getByName($params['name']);

        if (isset($row['id'])) {
            $this->ajaxFailed('提示', '您已经设置过该角色', BaseCtrl::AJAX_FAILED_TYPE_TIP);
        }

        list($ret, $last_insert_id) = $model->add($params['name'], $params['description']);

        if (!$ret) {
            $this->ajaxFailed('服务器错误', '新增数据失败,详情:' . $last_insert_id);
        }
        // @todo 清除缓存
        $this->ajaxSuccess('操作成功');
    }


    /**
     * 更新一个自定义的角色
     * @param array $params
     * @throws \Exception
     */
    public function globalPermissionRoleUpdate($params = [])
    {
        $globalRoleId = null;
        if (isset($_POST['id'])) {
            $globalRoleId = (int)$_POST['id'];
        }
        if (!$globalRoleId) {
            $this->ajaxFailed('参数错误', 'ID不能为空');
        }
        $errorMsg = [];
        if (empty($params)) {
            $this->ajaxFailed('错误', '没有提交表单数据');
        }

        if (!isset($params['name']) || empty($params['name'])) {
            $errorMsg['name'] = '名称不能为空';
        }

        $model = new PermissionGlobalRoleModel();
        $currentRow = $model->getById($globalRoleId);
        if (!isset($currentRow['id'])) {
            $this->ajaxFailed('错误', 'ID错误,找不到对应的数据');
        }
        if ($currentRow['is_system'] == '1') {
            $this->ajaxFailed('提示', '预定义的全局角色不能编辑', BaseCtrl::AJAX_FAILED_TYPE_TIP);
        }

        $row = $model->getByName($params['name']);
        //var_dump($row);
        if (isset($row['id']) && ($row['id'] != $globalRoleId)) {
            $errorMsg['name'] = '角色名已经被使用';
        }

        if (!empty($errorMsg)) {
            $this->ajaxFailed('参数错误', $errorMsg, BaseCtrl::AJAX_FAILED_TYPE_FORM_ERROR);
        }

        $id = (int)$globalRoleId;
        $info = [];
        $info['name'] = $params['name'];
        if (isset($params['description'])) {
            $info['description'] = $params['description'];
        }
        $ret = $model->updateById($id, $info);
        if ($ret) {
            $this->ajaxSuccess('更新完成');
        } else {
            $this->ajaxFailed('服务器错误', '更新数据失败');
        }
    }


    /**
     * 获取全局角色树形关系的json格式
     */
    public function permTree()
    {
        $globalRoleId = null;

        if (isset($_GET['role_id'])) {
            $globalRoleId = (int)$_GET['role_id'];
        }
        if (!$globalRoleId) {
            //$this->ajaxFailed('参数错误', 'role_id不能为空');
            @header('Content-Type:application/json');
            echo json_encode([]);
            exit;
        }
        $globalRoleId = intval($globalRoleId);
        $globalPermModel = new PermissionGlobalModel();
        $globalPermRoleRelationModel = new PermissionGlobalRoleRelationModel();

        $parentList = $globalPermModel->getParent();
        $childrenList = $globalPermModel->getChildren();
        $permIdList = $globalPermRoleRelationModel->getPermIdsByRoleId($globalRoleId);

        unset($globalPermModel);
        unset($globalPermRoleRelationModel);

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
     * 更新全局角色权限
     * @throws \Exception
     */
    public function updatePerm()
    {
        $globalRoleId = null;

        if (isset($_POST['role_id'])) {
            $globalRoleId = (int)$_POST['role_id'];
        }
        if (!$globalRoleId) {
            $this->ajaxFailed('参数错误', 'role_id不能为空');
        }
        $globalRoleId = intval($globalRoleId);
        if (!isset($_POST['permission_ids'])) {
            $this->ajaxFailed(' 参数错误 ', 'permission_Ids不能为空');
        }

        $permissionIds = $_POST['permission_ids'];
        $permIdsList = explode(',', $permissionIds);
        if (!is_array($permIdsList)) {
            $this->ajaxFailed(' 参数错误 ', '获取权限数据失败');
        }

        /*
        // @todo 判断是否拥有权限
        $userId = UserAuth::getId();
        $model = new ProjectRoleModel();
        $role = $model->getById($globalRoleId);
        if (!PermissionLogic::check($role['project_id'], $userId, PermissionLogic::ADMINISTER_PROJECTS)) {
            $this->ajaxFailed(' 权限受限 ', '您没有权限执行此操作');
        }
        */

        $model = new PermissionGlobalRoleRelationModel();
        $model->db->connect();
        try {
            $model->db->beginTransaction();
            $model->deleteByRoleId($globalRoleId);
            foreach ($permIdsList as $perm) {
                $model->add($globalRoleId, $perm);
            }
            $model->db->commit();

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
     * 删除全局角色
     * @param $id
     * @throws \Exception
     */
    public function globalPermissionRoleDelete()
    {
        $globalRoleId = null;
        if (isset($_POST['role_id'])) {
            $globalRoleId = (int)$_POST['role_id'];
        }
        if (!$globalRoleId) {
            $this->ajaxFailed('参数错误', 'ID不能为空');
        }

        $globalRoleId = intval($globalRoleId);
        $model = new PermissionGlobalRoleModel();
        $role = $model->getById($globalRoleId);

        if (!isset($role['id'])) {
            $this->ajaxFailed('参数错误', '找不到对应的用户角色');
        }
        if ($role['is_system'] == 1) {
            $this->ajaxFailed('提示', '预定义的全局角色不能删除', BaseCtrl::AJAX_FAILED_TYPE_TIP);
        }

        $model->db->beginTransaction();

        $globalPermRoleRelationModel = new PermissionGlobalRoleRelationModel();
        $globalPermUserRoleModel = new PermissionGlobalUserRoleModel();
        $ret = $model->deleteById($globalRoleId);
        if ( $ret ) {
            $globalPermRoleRelationModel->deleteByRoleId($globalRoleId);
            $globalPermUserRoleModel->deleteByRoleId($globalRoleId);
            $model->db->commit();
            $this->ajaxSuccess('操作成功');
        } else {
            $model->db->rollBack();
            $this->ajaxFailed('服务器错误', '删除角色失败');
        }
    }

    /**
     * 获取全局角色的用户列表
     * @throws \Exception
     */
    public function fetchGlobalPermRoleUsers()
    {
        $globalRoleId = null;
        if (isset($_GET['role_id'])) {
            $globalRoleId = (int)$_GET['role_id'];
        }
        if (!$globalRoleId) {
            $this->ajaxFailed('参数错误', 'ID不能为空');
        }
        $globalRoleId = intval($globalRoleId);

        // @todo 判断是否拥有权限

        $model = new PermissionGlobalUserRoleModel();
        $roleUsers = $model->getsRoleId($globalRoleId);

        if ($globalRoleId == 1) {
            foreach ($roleUsers as &$user) {
                if ($user['user_id'] == 1) {
                    $user['root'] = 1; // 是超级管理员角色并且是超级管理员账号
                } else {
                    $user['root'] = 0;
                }
            }
        }
        unset($user);

        $data['role_users'] = $roleUsers;

        $this->ajaxSuccess('ok', $data);
    }

    /**
     * 为全局角色添加用户
     * @throws \Exception
     */
    public function addGlobalPermRoleUser()
    {
        $roleId = null;
        if (isset($_POST['role_id'])) {
            $roleId = (int)$_POST['role_id'];
        }
        if (!$roleId) {
            $this->ajaxFailed('参数错误', 'ID不能为空');
        }
        $roleId = intval($roleId);

        $userId = null;
        if (isset($_POST['user_id'])) {
            $userId = (int)$_POST['user_id'];
        }
        if (!$userId) {
            $this->ajaxFailed('参数错误', 'ID不能为空');
        }
        $userId = intval($userId);

        // @todo 判断是否拥有权限

        $model = new PermissionGlobalUserRoleModel();
        if ($model->checkUniqueItemExist($userId, $roleId)) {
            $this->ajaxFailed(' 已添加过该用户 ', '不要重复添加');
        }

        list($ret, $msg) = $model->insertRole($userId, $roleId);
        if (!$ret) {
            $this->ajaxFailed(' 服务器错误 ', '数据库新增失败,详情:' . $msg);
        }

        $data['role_users'] = $model->getsRoleId($roleId);

        unset($model);
        $this->ajaxSuccess('操作成功', $data);
    }

    /**
     * 从全局角色中删除用户
     * @throws \Exception
     */
    public function deleteGlobalPermRoleUser()
    {
        if (!isPost()) {
            $this->ajaxFailed('服务器错误', '请求失败');
        }
        if (isset($_POST['id'])) {
            $id = (int)$_POST['id'];
        }
        if (!$id) {
            $this->ajaxFailed('参数错误', 'ID不能为空');
        }
        if (isset($_POST['user_id'])) {
            $userId = (int)$_POST['user_id'];
        }
        if (!$userId) {
            $this->ajaxFailed('参数错误', 'user_id不能为空');
        }

        if (isset($_POST['role_id'])) {
            $roleId = (int)$_POST['role_id'];
        }
        if (!$roleId) {
            $this->ajaxFailed('参数错误', 'role_id不能为空');
        }

        $id = intval($id);
        $userId = intval($userId);
        $roleId = intval($roleId);

        if ($userId == 1 && $roleId == 1) {
            $this->ajaxFailed('参数错误', '超级管理员不能删除');
        }

        $model = new PermissionGlobalUserRoleModel();
        $model->deleteUniqueItem($id, $userId, $roleId);

        $this->ajaxSuccess('操作成功');
    }



    /**
     * 移除权限
     * @param $id
     * @throws \Exception
     */
    public function globalPermissionGroupDelete($id)
    {
        if (empty($id)) {
            $this->ajaxFailed('参数错误', 'id不能为空');
        }

        $id = intval($id);

        $model = new PermissionGlobalGroupModel();
        $row = $model->getRowById($id);
        if (!isset($row['id'])) {
            $this->ajaxFailed('参数错误', '提交的参数错误,找不到对应的数据');
        }
        $ret = $model->deleteById($id);

        if (!$ret) {
            $this->ajaxFailed('服务器错误', '更新数据失败');
        }
        // @todo  清除关联数据 清除缓存
        $this->ajaxSuccess('操作成功');
    }

}
