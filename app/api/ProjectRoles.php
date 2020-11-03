<?php
namespace main\app\api;

use main\app\classes\LogOperatingLogic;
use main\app\classes\UserLogic;
use main\app\event\CommonPlacedEvent;
use main\app\event\Events;
use main\app\model\project\ProjectRoleModel;
use main\app\model\project\ProjectUserRoleModel;

class ProjectRoles extends BaseAuth
{
    /**
     * @return array
     */
    public function v1()
    {
        if (in_array($this->requestMethod, self::$method_type)) {
            $handleFnc = $this->requestMethod . 'Handler';
            return $this->$handleFnc();
        }
        return self::returnHandler('api方法错误');
    }

    /**
     * Restful POST 添加项目角色
     * {{API_URL}}/api/project_roles/v1/?project_id=1&access_token==xyz
     * @return array
     * @throws \Exception
     */
    private function postHandler()
    {
        $uid = $this->masterUid;
        $projectId = null;
        if (isset($_GET['project_id'])) {
            $projectId = (int)$_GET['project_id'];
        }
        if (empty($projectId)) {
            return self::returnHandler('项目id不能为空.', [], Constants::HTTP_BAD_REQUEST);
        }

        $errorMsg = [];
        if (!isset($_POST['name']) || empty($_POST['name'])) {
            $errorMsg['name'] = '标题不能为空';
        }

        if (isset($_POST['name']) && empty($_POST['name'])) {
            $errorMsg['name'] = '名称不能为空';
        }

        if (!empty($errorMsg)) {
            return self::returnHandler('参数错误', $errorMsg, Constants::HTTP_BAD_REQUEST);
        }

        $info = [];
        $info['is_system'] = '0';
        $info['project_id'] = $projectId;
        $info['name'] = $_POST['name'];

        if (isset($_POST['description'])) {
            $info['description'] = $_POST['description'];
        }

        $model = new ProjectRoleModel();
        if (isset($model->getByName($info['name'])['id'])) {
            return self::returnHandler('名称已经被使用', [], Constants::HTTP_BAD_REQUEST);
        }

        list($ret, $msg) = $model->insert($info);
        if ($ret) {
            //写入操作日志
            $logData = [];
            $logData['user_name'] = $this->masterAccount;
            $logData['real_name'] = $this->masterAccount;
            $logData['obj_id'] = $msg;
            $logData['module'] = LogOperatingLogic::MODULE_NAME_PROJECT;
            $logData['page'] = $_SERVER['REQUEST_URI'];
            $logData['action'] = LogOperatingLogic::ACT_ADD;
            $logData['remark'] = '添加项目角色';
            $logData['pre_data'] = [];
            $logData['cur_data'] = $info;
            LogOperatingLogic::add($uid, $projectId, $logData);

            $info['id'] = $msg;
            $event = new CommonPlacedEvent($this, $info);
            $this->dispatcher->dispatch($event, Events::onProjectRoleAdd);
            return self::returnHandler('项目角色添加成功', ['id' => $msg]);
        } else {
            return self::returnHandler('数据库插入失败,详情 :' . $msg, [], Constants::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Restful GET , 获取项目角色列表
     * 获取列表: {{API_URL}}/api/project_roles/v1/?project_id=1&access_token==xyz
     * @return array
     * @throws \Exception
     */
    private function getHandler()
    {
        $uid = $this->masterUid;
        $projectId = 0;

        if (isset($_GET['project_id'])) {
            $projectId = intval($_GET['project_id']);
        }

        if (!$projectId) {
            return self::returnHandler('项目id不能为空.', [], Constants::HTTP_BAD_REQUEST);
        }

        $final = [];
        $model = new ProjectRoleModel();
        $final['roles'] = $model->getsByProject($projectId);

        return self::returnHandler('OK', $final);
    }

    /**
     * Restful PATCH ,更新项目一个项目角色
     * {{API_URL}}/api/project_roles/v1/36?access_token==xyz
     * @return array
     * @throws \Exception
     */
    private function patchHandler()
    {
        $uid = $this->masterUid;
        $roleId = 0;

        if (isset($_GET['_target'][3])) {
            $roleId = intval($_GET['_target'][3]);
        }
        if (!$roleId) {
            return self::returnHandler('需要有角色ID', [], Constants::HTTP_BAD_REQUEST);
        }

        $errorMsg = [];
        $patch = self::_PATCH();
        if (empty($patch)) {
            return self::returnHandler('没有提交表单数据.', [], Constants::HTTP_BAD_REQUEST);
        }

        if (!isset($patch['name']) || empty($patch['name'])) {
            $errorMsg['name'] = '名称不能为空';
        }
        $model = new ProjectRoleModel();
        $currentRow = $model->getById($roleId);
        if (!isset($currentRow['id'])) {
            return self::returnHandler('id错误,找不到对应的数据.', [], Constants::HTTP_BAD_REQUEST);
        }
        if ($currentRow['is_system'] == '1') {
            return self::returnHandler('预定义的角色不能编辑.', [], Constants::HTTP_BAD_REQUEST);
        }

        $row = $model->getByName($patch['name']);
        //var_dump($row);
        if (isset($row['id']) && ($row['id'] != $roleId)) {
            $errorMsg['name'] = '名称已经被使用';
        }

        if (!empty($errorMsg)) {
            return self::returnHandler('参数错误', $errorMsg, Constants::HTTP_BAD_REQUEST);
        }

        $info = [];
        $info['name'] = $patch['name'];
        if (isset($patch['description'])) {
            $info['description'] = $patch['description'];
        }
        $ret = $model->updateById($roleId, $info);
        if ($ret) {
            //写入操作日志
            $logData = [];
            $logData['user_name'] = $this->masterAccount;
            $logData['real_name'] = $this->masterAccount;
            $logData['obj_id'] = 0;
            $logData['module'] = LogOperatingLogic::MODULE_NAME_PROJECT;
            $logData['page'] = $_SERVER['REQUEST_URI'];
            $logData['action'] = LogOperatingLogic::ACT_EDIT;
            $logData['remark'] = '修改项目角色';
            $logData['pre_data'] = $currentRow;
            $logData['cur_data'] = $info;
            LogOperatingLogic::add($uid, $currentRow['project_id'], $logData);

            $info['id'] = $roleId;
            $event = new CommonPlacedEvent($this, ['pre_data' => $currentRow, 'cur_data' => $info]);
            $this->dispatcher->dispatch($event, Events::onProjectRoleUpdate);
            return self::returnHandler('修改成功', array_merge($row, ['id' => $roleId]));
        } else {
            return self::returnHandler('更新数据失败', [], Constants::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Restful DELETE ,删除项目角色
     * {{API_URL}}/api/project_roles/v1/36?project_id=1&access_token==xyz
     * @return array
     * @throws \Exception
     */
    private function deleteHandler()
    {
        $uid = $this->masterUid;

        $roleId = 0;
        $projectId = null;

        if (isset($_GET['_target'][3])) {
            $roleId = intval($_GET['_target'][3]);
        }
        if (!$roleId) {
            return self::returnHandler('需要有项目角色ID', [], Constants::HTTP_BAD_REQUEST);
        }


        if (isset($_GET['project_id'])) {
            $projectId = (int)$_GET['project_id'];
        }
        if (empty($projectId)) {
            return self::returnHandler('项目id不能为空.', [], Constants::HTTP_BAD_REQUEST);
        }

        $model = new ProjectRoleModel();
        $role = $model->getRowById($roleId);
        if (!isset($role['id'])) {
            return self::returnHandler('找不到对应的用户角色', [], Constants::HTTP_BAD_REQUEST);
        }

        if ($role['project_id'] != $projectId) {
            return self::returnHandler('项目信息不匹配', [], Constants::HTTP_BAD_REQUEST);
        }

        if ($role['is_system'] == '1') {
            return self::returnHandler('预定义角色不能删除', [], Constants::HTTP_BAD_REQUEST);
        }
        $ret = $model->deleteById($roleId);

        if (!$ret) {
            return self::returnHandler('删除角色失败', [], Constants::HTTP_BAD_REQUEST);
        } else {
            $projectUserRoleModel = new ProjectUserRoleModel();
            $projectUserRoleModel->delProjectRole($roleId);
        }
        // @todo  清除关联数据 清除缓存

        $callFunc = function ($value) {
            return '已删除';
        };
        $role2 = array_map($callFunc, $role);
        //写入操作日志
        $logData = [];
        $logData['user_name'] = $this->masterAccount;
        $logData['real_name'] = $this->masterAccount;
        $logData['obj_id'] = 0;
        $logData['module'] = LogOperatingLogic::MODULE_NAME_PROJECT;
        $logData['page'] = $_SERVER['REQUEST_URI'];
        $logData['action'] = LogOperatingLogic::ACT_DELETE;
        $logData['remark'] = '删除项目角色';
        $logData['pre_data'] = $role;
        $logData['cur_data'] = $role2;
        LogOperatingLogic::add($uid, $role['project_id'], $logData);

        $event = new CommonPlacedEvent($this, $role);
        $this->dispatcher->dispatch($event, Events::onProjectRoleRemove);
        return self::returnHandler('操作成功');
    }
}
