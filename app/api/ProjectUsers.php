<?php


namespace main\app\api;


use main\app\classes\LogOperatingLogic;
use main\app\classes\PermissionLogic;
use main\app\classes\UserAuth;
use main\app\event\CommonPlacedEvent;
use main\app\event\Events;
use main\app\model\project\ProjectRoleModel;
use main\app\model\project\ProjectUserRoleModel;

class ProjectUsers extends BaseAuth
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
     * Restful POST 添加项目用户
     * {{API_URL}}/api/project_users/v1/?project_id=1&access_token==xyz
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

        $roleId = null;
        if (isset($_POST['role_id'])) {
            $roleId = (int)$_POST['role_id'];
        }
        if (!$roleId) {
            return self::returnHandler('role_id不能为空.', [], Constants::HTTP_BAD_REQUEST);
        }
        $roleId = intval($roleId);

        $userId = null;
        if (isset($_POST['user_id'])) {
            $userId = (int)$_POST['user_id'];
        }
        if (!$userId) {
            return self::returnHandler('user_id不能为空.', [], Constants::HTTP_BAD_REQUEST);
        }
        $userId = intval($userId);

        $model = new ProjectRoleModel();
        $role = $model->getById($roleId);

        $model = new ProjectUserRoleModel();

        if ($model->checkUniqueItemExist($userId, $role['project_id'], $roleId)) {
            return self::returnHandler('已添加过该用户, 不要重复添加', [], Constants::HTTP_BAD_REQUEST);
        }

        list($ret, $msg) = $model->insertRole($userId, $role['project_id'], $roleId);
        if (!$ret) {
            return self::returnHandler('数据库新增失败'. $msg, [], Constants::HTTP_BAD_REQUEST);
        }

        $data['role_users'] = $model->getsRoleId($roleId);


        //写入操作日志
        $logData = [];
        $logData['user_name'] = $this->authAccount;
        $logData['real_name'] = $this->authAccount;
        $logData['obj_id'] = 0;
        $logData['module'] = LogOperatingLogic::MODULE_NAME_PROJECT;
        $logData['page'] = $_SERVER['REQUEST_URI'];
        $logData['action'] = LogOperatingLogic::ACT_ADD;
        $logData['remark'] = '添加项目角色用户';
        $logData['pre_data'] = [];
        $logData['cur_data'] = ['user_id' => $userId, 'project_id' => $role['project_id'], 'role_id' => $roleId];
        LogOperatingLogic::add($uid, $role['project_id'], $logData);

        $event = new CommonPlacedEvent($this, ['user_id' => $userId, 'role_id' => $roleId]);
        $this->dispatcher->dispatch($event, Events::onProjectRoleAddUser);
        unset($model);
        return self::returnHandler('用户添加成功');
    }


}