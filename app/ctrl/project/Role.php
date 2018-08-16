<?php
/**
 * Created by PhpStorm.
 */

namespace main\app\ctrl\project;

use main\app\classes\PermissionLogic;
use main\app\classes\UserAuth;
use main\app\ctrl\BaseCtrl;
use main\app\ctrl\BaseUserCtrl;
use main\app\model\permission\PermissionModel;
use main\app\classes\RewriteUrl;
use main\app\model\project\ProjectRoleModel;
use main\app\model\project\ProjectRoleRelationModel;

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

    public function index()
    {
        $data = [];
        $data['title'] = '项目角色';
        parent::addGVar('top_menu_active', 'project');
        $data['nav_links_active'] = 'setting';
        $data['sub_nav_active'] = 'project_role';
        $data = RewriteUrl::setProjectData($data);
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
            $this->ajaxFailed('system_data_not_delete');
        }
        $ret = $model->deleteById($id);

        if (!$ret) {
            $this->ajaxFailed('服务器错误', '删除角色失败');
        }
        // @todo  清除关联数据 清除缓存
        $this->ajaxSuccess('ok');
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
        if (!PermissionLogic::check($role['project_id'], $userId, 'ADMINISTER_PROJECTS')) {
            $this->ajaxFailed(' 权限受限 ', '您没有权限执行此操作');
        }

        $model = new ProjectRoleRelationModel();
        $model->db->connect();
        try {
            $model->db->beginTransaction();
            $model->deleteByRoleId($roleId);
            foreach ($permIdsList as $perm) {
                $model->add($roleId, $perm);
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
}
