<?php

namespace main\app\plugin\activity\ctrl;

use main\app\classes\LogOperatingLogic;
use main\app\classes\PermissionLogic;
use main\app\classes\RewriteUrl;
use main\app\classes\UserAuth;
use main\app\classes\UserLogic;
use main\app\ctrl\BaseCtrl;
use main\app\ctrl\BaseUserCtrl;
use main\app\model\project\ProjectCatalogLabelModel;
use main\app\model\project\ProjectRoleModel;
use main\app\model\ActivityModel;
use main\app\model\user\UserModel;

/**
 *
 *  活动日志插件的控制器
 * @package main\app\ctrl\project
 */
class Index extends BaseUserCtrl
{

    public function __construct()
    {
        parent::__construct();

        // 载入插件配置
    }

    public function myRender($tpl, $dataArr = [], $partial = false)
    {
        $this->initCSRF();
        // 向视图传入通用的变量
        $this->addGVar('_GET', $_GET);
        $this->addGVar('site_url', ROOT_URL);
        $this->addGVar('attachment_url', ATTACHMENT_URL);
        $this->addGVar('_version', MASTERLAB_VERSION);
        $this->addGVar('csrf_token', $this->csrfToken);
        $user = [];
        $curUid = UserAuth::getInstance()->getId();
        if ($curUid) {
            $user = UserModel::getInstance($curUid)->getUser();
            $user = UserLogic::format($user);
        }
        $this->addGVar('user', $user);

        $dataArr = array_merge(self::$gTplVars, $dataArr);
        ob_start();
        ob_implicit_flush(false);
        extract($dataArr, EXTR_PREFIX_SAME, 'tpl_');

        require_once PLUGIN_PATH .'activity/view/'. $tpl;

        echo ob_get_clean();
    }

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
     * @throws \Exception
     */
    public function add()
    {
        $uid = $this->getCurrentUid();
        $projectId = null;
        if (isset($_POST['project_id'])) {
            $projectId = (int)$_POST['project_id'];
        }
        if (empty($projectId)) {
            $this->ajaxFailed('参数错误', '项目id不能为空');
        }

        $errorMsg = [];
        if (!isset($_POST['name']) || empty($_POST['name'])) {
            $errorMsg['name'] = '名称不能为空';
        }
        if (!isset($_POST['label_id_arr']) || empty($_POST['label_id_arr'])) {
            $errorMsg['label_id_arr'] = '包含标签不能为空';
        }

        if (!isset($_POST['font_color']) || empty($_POST['font_color'])) {
            $_POST['font_color'] = 'blueviolet';
        }
        if (!empty($errorMsg)) {
            $this->ajaxFailed('参数错误', $errorMsg, BaseCtrl::AJAX_FAILED_TYPE_FORM_ERROR);
        }
        $projectCatalogLabelModel = new ProjectCatalogLabelModel();

        if ($projectCatalogLabelModel->checkNameExist($projectId, $_POST['name'])) {
            $this->ajaxFailed('分类名称已存在.', array(), 500);
        }
        $insertArr = [];
        $insertArr['project_id'] = $projectId;
        $insertArr['name'] = $_POST['name'];
        $insertArr['font_color'] = $_POST['font_color'];
        $insertArr['label_id_json'] = json_encode($_POST['label_id_arr']);
        if (isset($_POST['description'])) {
            $insertArr['description'] = $_POST['description'];
        }
        if (isset($_POST['order_weight'])) {
            $insertArr['order_weight'] = (int)$_POST['order_weight'];
        }

        list($ret, $errMsg) = $projectCatalogLabelModel->insert($insertArr);
        if ($ret) {
            $activityModel = new ActivityModel();
            $activityInfo = [];
            $activityInfo['action'] = '创建了分类';
            $activityInfo['type'] = ActivityModel::TYPE_PROJECT;
            $activityInfo['obj_id'] = $errMsg;
            $activityInfo['title'] = $insertArr['name'];
            $activityModel->insertItem($uid, $projectId, $activityInfo);

            //写入操作日志
            $logData = [];
            $logData['user_name'] = $this->auth->getUser()['username'];
            $logData['real_name'] = $this->auth->getUser()['display_name'];
            $logData['obj_id'] = $errMsg;
            $logData['module'] = LogOperatingLogic::MODULE_NAME_PROJECT;
            $logData['page'] = $_SERVER['REQUEST_URI'];
            $logData['action'] = LogOperatingLogic::ACT_ADD;
            $logData['remark'] = '添加分类';
            $logData['pre_data'] = [];
            $logData['cur_data'] = $insertArr;
            LogOperatingLogic::add($uid, $projectId, $logData);

            $this->ajaxSuccess('提示', '分类添加成功');
        } else {
            $this->ajaxFailed('提示', '服务器执行失败:'.$errMsg);
        }
    }


    /**
     * @param $id
     * @param $title
     * @param $bg_color
     * @param $description
     * @throws \Exception
     */
    public function update()
    {
        $currentUserId = $this->getCurrentUid();
        $id = null;
        if (isset($_POST['id'])) {
            $id = (int)$_POST['id'];
        }
        if (empty($id)) {
            $this->ajaxFailed('提示', '参数错误,id不能为空');
        }

        $errorMsg = [];
        if (isset($_POST['name']) && empty($_POST['name'])) {
            $errorMsg['name'] = '名称不能为空';
        }
        if (isset($_POST['label_id_arr']) && empty($_POST['label_id_arr'])) {
            $errorMsg['label_id_arr'] = '包含标签不能为空';
        }
        if (!empty($errorMsg)) {
            $this->ajaxFailed('参数错误', $errorMsg, BaseCtrl::AJAX_FAILED_TYPE_FORM_ERROR);
        }

        $updateArr = [];
        if (isset($_POST['name'])) {
            $updateArr['name'] = $_POST['name'];
        }
        if (isset($_POST['label_id_arr'])) {
            $updateArr['label_id_json'] = json_encode($_POST['label_id_arr']);
        }
        if (isset($_POST['font_color'])) {
            $updateArr['font_color'] = $_POST['font_color'];
        }
        if (isset($_POST['description'])) {
            $updateArr['description'] = $_POST['description'];
        }
        if (isset($_POST['order_weight'])) {
            $updateArr['order_weight'] = (int)$_POST['order_weight'];
        }

        $model = new ProjectCatalogLabelModel();
        $catalog = $model->getById($id);
        if (empty($catalog)) {
            $this->ajaxFailed('提示', '参数错误, 数据为空');
        }
        if (!isset($this->projectPermArr[PermissionLogic::ADMINISTER_PROJECTS])) {
            $this->ajaxFailed('提示', '您没有权限访问该页面,需要项目管理权限');
        }
        if ($catalog['project_id'] != $this->projectId) {
            $this->ajaxFailed('提示', '参数错误, 非当前项目的数据');
        }
        if ($catalog['name'] != $updateArr['name']) {
            if ($model->checkNameExist($catalog['project_id'], $updateArr['name'])) {
                $this->ajaxFailed('提示', '分类名已存在');
            }
        }
        $ret = $model->updateById($id, $updateArr);
        if ($ret[0]) {
            $activityModel = new ActivityModel();
            $activityInfo = [];
            $activityInfo['action'] = '更新了分类';
            $activityInfo['type'] = ActivityModel::TYPE_PROJECT;
            $activityInfo['obj_id'] = $id;
            $activityInfo['title'] = $updateArr['name'];
            $activityModel->insertItem($currentUserId, $catalog['project_id'], $activityInfo);

            //写入操作日志
            $logData = [];
            $logData['user_name'] = $this->auth->getUser()['username'];
            $logData['real_name'] = $this->auth->getUser()['display_name'];
            $logData['obj_id'] = 0;
            $logData['module'] = LogOperatingLogic::MODULE_NAME_PROJECT;
            $logData['page'] = $_SERVER['REQUEST_URI'];
            $logData['action'] = LogOperatingLogic::ACT_EDIT;
            $logData['remark'] = '修改分类';
            $logData['pre_data'] = $catalog;
            $logData['cur_data'] = $updateArr;
            LogOperatingLogic::add($currentUserId, $catalog['project_id'], $logData);

            $this->ajaxSuccess('提示','修改成功');
        } else {
            $this->ajaxFailed('提示','更新失败');
        }
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


        $callFunc = function ($value) {
            return '已删除';
        };
        $info2 = array_map($callFunc, $info);
        //写入操作日志
        $logData = [];
        $logData['user_name'] = $this->auth->getUser()['username'];
        $logData['real_name'] = $this->auth->getUser()['display_name'];
        $logData['obj_id'] = 0;
        $logData['module'] = LogOperatingLogic::MODULE_NAME_PROJECT;
        $logData['page'] = $_SERVER['REQUEST_URI'];
        $logData['action'] = LogOperatingLogic::ACT_DELETE;
        $logData['remark'] = '删除分类';
        $logData['pre_data'] = $info;
        $logData['cur_data'] = $info2;
        LogOperatingLogic::add($currentUid, $project_id, $logData);

        $this->ajaxSuccess('提示','操作成功');
    }
}
