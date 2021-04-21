<?php
namespace main\app\api;

use main\app\classes\LogOperatingLogic;
use main\app\classes\UserLogic;
use main\app\event\CommonPlacedEvent;
use main\app\event\Events;
use main\app\model\project\ProjectRoleModel;
use main\app\model\project\ProjectUserRoleModel;
use main\app\model\SettingModel;

/**
 * Class ProjectUsers
 * @package main\app\api
 */
class ProjectUsers extends BaseAuth
{
    public $isTriggerEvent = false;


    /**
     * @return array
     * @throws \Exception
     */
    public function v1()
    {
        if (in_array($this->requestMethod, self::$method_type)) {
            $handleFnc = $this->requestMethod . 'Handler';
            return $this->$handleFnc();
        }
        $this->isTriggerEvent = (bool)SettingModel::getInstance()->getSettingValue('api_trigger_event');
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
        $logData['user_name'] = $this->masterAccount;
        $logData['real_name'] = $this->masterAccount;
        $logData['obj_id'] = 0;
        $logData['module'] = LogOperatingLogic::MODULE_NAME_PROJECT;
        $logData['page'] = $_SERVER['REQUEST_URI'];
        $logData['action'] = LogOperatingLogic::ACT_ADD;
        $logData['remark'] = '添加项目角色用户';
        $logData['pre_data'] = [];
        $logData['cur_data'] = ['user_id' => $userId, 'project_id' => $role['project_id'], 'role_id' => $roleId];
        LogOperatingLogic::add($uid, $role['project_id'], $logData);
        if($this->isTriggerEvent){
            $event = new CommonPlacedEvent($this, ['user_id' => $userId, 'role_id' => $roleId]);
            $this->dispatcher->dispatch($event, Events::onProjectRoleAddUser);
        }

        unset($model);
        return self::returnHandler('用户添加成功', ['id' => $msg]);
    }

    /**
     * Restful GET , 获取项目用户列表
     * 获取列表: {{API_URL}}/api/project_users/v1/?project_id=1&access_token==xyz
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

        $userLogic = new UserLogic();
        $projectUsers = $userLogic->getUsersAndRoleByProjectId($projectId);
        foreach ($projectUsers as &$user) {
            $user = UserLogic::format($user);
        }
        $final['project_users'] = $projectUsers;
        $final['not_project_users'] = $userLogic->getNotProjectUser($projectId);
        $projectRolemodel = new ProjectRoleModel();
        $final['roles'] = $projectRolemodel->getsByProject($projectId);

        return self::returnHandler('OK', $final);
    }

    /**
     * Restful DELETE ,删除项目用户
     * {{API_URL}}/api/project_users/v1/?project_id=1&user_id=9999&access_token==xyz
     * @return array
     * @throws \Exception
     */
    private function deleteHandler()
    {
        $uid = $this->masterUid;

        $projectId = null;
        if (isset($_GET['project_id'])) {
            $projectId = (int)$_GET['project_id'];
        }
        if (empty($projectId)) {
            return self::returnHandler('项目id不能为空.', [], Constants::HTTP_BAD_REQUEST);
        }

        $delUserId = 0;
        if (isset($_GET['project_id'])) {
            $delUserId = intval($_GET['user_id']);
        }
        if (!$delUserId) {
            return self::returnHandler('user_id不能为空.', [], Constants::HTTP_BAD_REQUEST);
        }

        $model = new ProjectUserRoleModel();
        $model->delProjectUser($projectId, $delUserId);
        if($this->isTriggerEvent){
            $event = new CommonPlacedEvent($this, ['user_id' => $delUserId, 'project_id' => $projectId]);
            $this->dispatcher->dispatch($event, Events::onProjectUserRemove);
        }

        return self::returnHandler('操作成功');
    }
}