<?php

namespace main\app\plugin\activity;

use main\app\classes\LogOperatingLogic;
use main\app\classes\PermissionLogic;
use main\app\classes\RewriteUrl;
use main\app\classes\UserAuth;
use main\app\classes\UserLogic;
use main\app\ctrl\BaseCtrl;
use main\app\ctrl\BaseUserCtrl;
use main\app\model\PluginModel;
use main\app\model\project\ProjectCatalogLabelModel;
use main\app\model\project\ProjectRoleModel;
use main\app\model\ActivityModel;
use main\app\model\user\UserModel;
use main\app\plugin\BasePluginCtrl;

/**
 *
 *  活动日志插件的入口
 * @package main\app\ctrl\project
 */
class Index extends BasePluginCtrl
{

    public $pluginInfo = [];

    public function __construct()
    {
        parent::__construct();
        $dirName = pathinfo(__FILE__)['dirname'];
        $pluginModel = new PluginModel();
        $this->pluginInfo = $pluginModel->getByName($dirName);
    }

    /**
     * @throws \Exception
     */
    public function pageIndex()
    {
        $data = [];
        $data['title'] = '项目活动日志';
        $data['nav_links_active'] = 'activity';
        $data = RewriteUrl::setProjectData($data);
        // 权限判断
        if (!empty($data['project_id'])) {
            if (!$this->isAdmin && !PermissionLogic::checkUserHaveProjectItem(UserAuth::getId(), $data['project_id'])) {
                $this->warn('提 示', '您没有权限访问该项目,请联系管理员申请加入该项目');
                die;
            }
        }
        $projectId = $data['project_id'];
        $data['current_uid'] = UserAuth::getId();
        $userLogic = new UserLogic();
        $projectUsers = $userLogic->getUsersAndRoleByProjectId($projectId);

        foreach ($projectUsers as &$user) {
            $user = UserLogic::format($user);
        }
        $data['project_users'] = $projectUsers;

        $projectRolemodel = new ProjectRoleModel();
        $data['roles'] = $projectRolemodel->getsByProject($projectId);

        $this->myRender('index.php', $data);
    }


    /**
     * @param $id
     * @throws \Exception
     */
    public function fetch($id)
    {
        if (!isset($id)) {
            $this->ajaxFailed('提示', '缺少参数');
        }
        $model = new ProjectCatalogLabelModel();
        $arr = $model->getById($id);
        $this->ajaxSuccess('success', $arr);
    }

    /**
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
        $model = new ProjectCatalogLabelModel();
        $data['catalogs'] = $model->getByProject($projectId);
        $this->ajaxSuccess('ok', $data);
    }


    /**
     * @param $project_id
     * @param $label_id
     * @throws \Exception
     */
    public function delete($project_id, $label_id)
    {
        $id = null;
        if (isset($_POST['id'])) {
            $id = (int)$_POST['id'];
        }
        if (!$id) {
            $this->ajaxFailed('参数错误', 'id不能为空');
        }
        $id = intval($id);
        $model = new ProjectCatalogLabelModel();
        $info = $model->getById($id);
        if ($info['project_id'] != $this->projectId) {
            $this->ajaxFailed('提示', '参数错误,非当前项目的分类无法删除');
        }
        $model->deleteItem($id);
        $currentUid = $this->getCurrentUid();
        $activityModel = new ActivityModel();
        $activityInfo = [];
        $activityInfo['action'] = '删除了分类';
        $activityInfo['type'] = ActivityModel::TYPE_PROJECT;
        $activityInfo['obj_id'] = $label_id;
        $activityInfo['title'] = $info['name'];
        $activityModel->insertItem($currentUid, $project_id, $activityInfo);

        $this->ajaxSuccess('提示','操作成功');
    }
}
