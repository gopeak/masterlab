<?php
/**
 * Created by PhpStorm.
 */

namespace main\app\ctrl\admin;

use main\app\classes\LogOperatingLogic;
use main\app\ctrl\BaseCtrl;
use main\app\ctrl\BaseUserCtrl;
use main\app\classes\PermissionLogic;
use main\app\classes\RewriteUrl;
use main\app\classes\UserLogic;
use main\app\classes\UserAuth;
use main\app\event\CommonPlacedEvent;
use main\app\event\Events;
use main\app\model\CacheKeyModel;
use main\app\model\permission\DefaultRoleModel;
use main\app\model\permission\DefaultRoleRelationModel;
use main\app\model\permission\ProjectPermissionModel;
use main\app\model\user\UserModel;
use main\app\model\project\ProjectRoleModel;
use main\app\model\project\ProjectUserRoleModel;
use main\app\model\project\ProjectRoleRelationModel;
use main\app\model\ActivityModel;

/**
 * 项目角色控制器
 */
class ProjectTplRole extends BaseUserCtrl
{

    public function __construct()
    {
        parent::__construct();
        parent::addGVar('top_menu_active', 'project');
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
        $model = new DefaultRoleModel();
        $data = $model->getById($id);
        if (empty($data)) {
            $this->ajaxFailed('参数错误', '数据为空');
        }
        $this->ajaxSuccess('success', $data);
    }

    /**
     * 获取项目模板的所有角色
     * @throws \Exception
     */
    public function fetchAll()
    {
        $projectId = null;
        if (isset($_GET['_target'][3])) {
            $projectId = (int)$_GET['_target'][3];
        }
        if (isset($_GET['id'])) {
            $projectId = (int)$_GET['id'];
        }
        if (empty($projectId)) {
            $this->ajaxFailed('参数错误', '项目id不能为空');
        }
        $model = new DefaultRoleModel();
        $data['roles'] = $model->getsByProject($projectId);
        $this->ajaxSuccess('ok', $data);
    }

    /**
     * 新增角色
     * @param null $params
     * @throws \Exception
     */
    public function add($params = null)
    {
        $uid = $this->getCurrentUid();
        $projectTplId = null;
        if (isset($_GET['_target'][3])) {
            $projectTplId = (int)$_GET['_target'][3];
        }
        if (isset($_GET['id'])) {
            $projectTplId = (int)$_GET['id'];
        }
        if (empty($projectTplId)) {
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
        $info['project_tpl_id'] = $projectTplId;
        $info['name'] = $params['name'];

        if (isset($params['description'])) {
            $info['description'] = $params['description'];
        }
        $model = new DefaultRoleModel();
        if (isset($model->getByName($info['name'])['id'])) {
            $this->ajaxFailed('提示', '名称已经被使用', BaseCtrl::AJAX_FAILED_TYPE_TIP);
        }
        list($ret, $msg) = $model->insert($info);
        if ($ret) {
            $this->ajaxSuccess('添加成功');
        } else {
            $this->ajaxFailed('服务器错误:', '数据库插入失败,详情 :' . $msg);
        }
    }

    /**
     * 更新角色
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
        if (isset($_POST['id'])) {
            $id = (int)$_POST['id'];
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
        $model = new DefaultRoleModel();
        $currentRow = $model->getById($id);
        if (!isset($currentRow['id'])) {
            $this->ajaxFailed('错误', 'id错误,找不到对应的数据');
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
            $this->ajaxSuccess('操作成功');
        } else {
            $this->ajaxFailed('服务器错误', '更新数据失败');
        }
    }


    /**
     * 删除角色
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
        if (isset($_GET['id'])) {
            $id = (int)$_GET['id'];
        }
        if (!$id) {
            $this->ajaxFailed('参数错误', 'id不能为空');
        }
        $id = intval($id);
        $model = new DefaultRoleModel();
        $role = $model->getRowById($id);
        if (!isset($role['id'])) {
            $this->ajaxFailed('参数错误', '找不到对应的用户角色');
        }
        $ret = $model->deleteById($id);
        if (!$ret) {
            $this->ajaxFailed('服务器错误', '删除角色失败');
        }
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
        if (isset($_GET['role_id'])) {
            $roleId = (int)$_GET['role_id'];
        }
        if (!$roleId) {
            //$this->ajaxFailed('参数错误', 'role_id不能为空');
            @header('Content-Type:application/json');
            echo json_encode([]);
            exit;
        }
        $roleId = intval($roleId);
        $permissionModel = new ProjectPermissionModel();
        $permissionRoleRelationModel = new DefaultRoleRelationModel();

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
        if (isset($_POST['role_id'])) {
            $roleId = (int)$_POST['role_id'];
        }
        if (!$roleId) {
            $this->ajaxFailed('参数错误', 'role_id不能为空');
        }
        $roleId = intval($roleId);
        if (!isset($_POST['permission_ids'])) {
            $this->ajaxFailed(' 参数错误 ', 'permission_Ids不能为空');
        }

        $permissionIds = $_POST['permission_ids'];
        $permIdsList = explode(',', $permissionIds);
        if (!is_array($permIdsList)) {
            $this->ajaxFailed(' 参数错误 ', '获取权限数据失败');
        }

        // @todo 判断是否拥有权限
        $userId = UserAuth::getId();
        $model = new DefaultRoleModel();
        $role = $model->getById($roleId);
        if (!$this->isAdmin) {
            if (!PermissionLogic::check($role['project_id'], $userId, PermissionLogic::ADMINISTER_PROJECTS)) {
                $this->ajaxFailed(' 权限受限 ', '您没有权限执行此操作');
            }
        }

        $model = new DefaultRoleRelationModel();
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

        $event = new CommonPlacedEvent($this, ['role_id' => $roleId, 'perm' => $permIdsList]);
        $this->dispatcher->dispatch($event, Events::onProjectRolePermUpdate);
        $this->ajaxSuccess('ok', []);
    }

}
