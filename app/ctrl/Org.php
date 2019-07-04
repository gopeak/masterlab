<?php

namespace main\app\ctrl;

use main\app\classes\LogOperatingLogic;
use main\app\classes\OrgLogic;
use main\app\classes\PermissionGlobal;
use main\app\classes\PermissionLogic;
use main\app\classes\ProjectLogic;
use main\app\classes\ConfigLogic;
use main\app\classes\UserAuth;
use main\app\model\issue\IssueFileAttachmentModel;
use main\app\model\OrgModel;
use main\app\model\ActivityModel;
use main\app\model\project\ProjectModel;
use main\app\model\project\ProjectUserRoleModel;

class Org extends BaseUserCtrl
{

    public function __construct()
    {
        parent::__construct();
        parent::addGVar('top_menu_active', 'org');
    }

    /**
     * index
     */
    public function pageIndex()
    {
        $data = [];
        $data['title'] = '组织';
        $data['nav_links_active'] = 'org';
        $data['sub_nav_active'] = 'all';
        $this->render('gitlab/org/main.php', $data);
    }

    /**
     * detail
     */
    public function pageDetail($id = null)
    {
        if (isset($_GET['_target'][2])) {
            $id = (int)$_GET['_target'][2];
        }
        if (isset($_GET['id'])) {
            $id = (int)$_GET['id'];
        }

        $model = new OrgModel();
        $org = $model->getById($id);
        if (empty($org)) {
            $this->error('org_no_found');
        }

        $data = [];
        $data['title'] = $org['name'];
        $data['nav_links_active'] = 'org';
        $data['sub_nav_active'] = 'all';
        $data['id'] = $id;
        ConfigLogic::getAllConfigs($data);
        $this->render('gitlab/org/detail.php', $data);
    }

    /**
     * @param null $id
     * @throws \Exception
     */
    public function fetchProjects($id = null)
    {
        if (isset($_GET['_target'][2])) {
            $id = (int)$_GET['_target'][2];
        }
        if (isset($_GET['id'])) {
            $id = (int)$_GET['id'];
        }

        $userId = UserAuth::getId();
        $isAdmin = false;

        $projectIdArr = PermissionLogic::getUserRelationProjectIdArr($userId);

        if (PermissionGlobal::check($userId, PermissionGlobal::ADMINISTRATOR)) {
            $isAdmin = true;
        }

        $model = new OrgModel();
        $org = $model->getById($id);
        if (empty($org)) {
            $this->ajaxFailed('参数错误', '组织数据为空');
        }

        $model = new ProjectModel();
        $projects = $model->getsByOrigin($id);
        foreach ($projects as $key => &$project) {
            $project = ProjectLogic::formatProject($project);

            if (!$isAdmin && !in_array($project['id'], $projectIdArr)) {
                unset($projects[$key]);
            }
        }

        $data = [];
        $data['projects'] = array_values($projects);

        $this->ajaxSuccess('success', $data);
    }

    /**
     * @throws \Exception
     */
    public function fetchAll()
    {
        $userId = UserAuth::getId();
        $isAdmin = false;

        $data = [];
        $orgLogic = new OrgLogic();
        $orgs = $orgLogic->getOrigins();

        if (PermissionGlobal::check($userId, PermissionGlobal::ADMINISTRATOR)) {
            $isAdmin = true;
        }
        $projectIdArr = PermissionLogic::getUserRelationProjectIdArr($userId);

        $model = new ProjectModel();
        $fields = 'id,type,org_id,org_path,name,url,`key`,avatar,create_time,un_done_count,done_count';
        $projects = $model->getAllByFields($fields);
        $orgProjects = [];
        foreach ($projects as &$p) {
            if ($isAdmin || in_array($p['id'], $projectIdArr)) {
                $p = ProjectLogic::formatProject($p);
                $orgProjects[$p['org_id']][] = $p;
            }
        }
        // var_dump($projects);

        $relationOrgIdArr = array_keys($orgProjects);

        foreach ($orgs as $key => &$org) {
            $id = $org['id'];
            $org['projects'] = [];
            $org['is_more'] = false;
            if (isset($orgProjects[$id])) {
                $org['projects'] = $orgProjects[$id];
                if (count($org['projects']) > 20) {
                    $org['is_more'] = true;
                    $org['projects'] = array_slice($org['projects'], 0, 20);
                }
            }
            if (isset($org['avatar_file']) && !empty($org['avatar_file']) && file_exists(STORAGE_PATH . 'attachment/' . $org['avatar_file'])) {
                $org['avatarExist'] = true;
            } else {
                $org['avatarExist'] = false;
                $org['first_word'] = mb_substr(ucfirst($org['name']), 0, 1, 'utf-8');
            }

            if ($org['path'] == 'default') {
                continue;
            }

            if (!$isAdmin && !in_array($id, $relationOrgIdArr)) {
                unset($orgs[$key]);
            }
        }
        unset($projects, $orgProjects);

        $data['orgs'] = array_values($orgs);
        $this->ajaxSuccess('success', $data);
    }

    public function pageCreate()
    {
        $data = [];
        $data['title'] = '创建组织';
        $data['nav_links_active'] = 'org';
        $data['sub_nav_active'] = 'all';

        $data['id'] = '';
        $data['action'] = 'add';

        // 控制器已经使用的则不能使用
        $mapConfigArr = getCommonConfigVar('map');
        $ctrlKeyArr = array_keys($mapConfigArr['ctrl']);
        foreach ($ctrlKeyArr as &$ctrlName) {
            if (strpos($ctrlName, '.') !== false) {
                list($ctrlName,) = explode('.', $ctrlName);
            }
            $ctrlName = strtolower($ctrlName);
        }
        $data['ctrlKeyArr'] = array_unique($ctrlKeyArr);
        $this->render('gitlab/org/form.php', $data);
    }

    /**
     * @param null $id
     * @throws \Exception
     */
    public function pageEdit($id = null)
    {
        $data = [];
        $data['title'] = '编辑组织';
        $data['nav_links_active'] = 'org';
        $data['sub_nav_active'] = 'all';

        if (isset($_GET['_target'][2])) {
            $id = (int)$_GET['_target'][2];
        }
        if (isset($_GET['id'])) {
            $id = (int)$_GET['id'];
        }
        $data['id'] = $id;
        $data['action'] = 'edit';
        $this->render('gitlab/org/form.php', $data);
    }

    /**
     * @param null $id
     * @throws \Exception
     */
    public function get($id = null)
    {
        if (isset($_GET['_target'][2])) {
            $id = (int)$_GET['_target'][2];
        }
        if (isset($_GET['id'])) {
            $id = (int)$_GET['id'];
        }
        $model = new OrgModel();
        $org = $model->getById($id);
        if (empty($org)) {
            $this->ajaxFailed('参数错误', '组织数据为空');
        }

        if (strpos($org['avatar'], 'http://') === false) {
            if (file_exists(STORAGE_PATH . 'attachment/' . $org['avatar'])) {
                $org['avatar'] = ATTACHMENT_URL . $org['avatar'];
                $org['avatarExist'] = true;
            } else {
                $org['avatarExist'] = false;
                $org['first_word'] = mb_substr(ucfirst($org['name']), 0, 1, 'utf-8');
            }
        }

        $data = [];
        $data['org'] = $org;

        $this->ajaxSuccess('success', $data);
    }

    /**
     * 检查组织是否可以删除
     * @param null $id
     * @throws \Exception
     */
    public function checkDelete($id = null)
    {
        if (isset($_GET['_target'][2])) {
            $id = (int)$_GET['_target'][2];
        }
        if (isset($_GET['id'])) {
            $id = (int)$_GET['id'];
        }
        $model = new OrgModel();
        $org = $model->getById($id);
        if (empty($org)) {
            $this->ajaxFailed('参数错误', '组织数据为空');
        }

        $projectModel = new ProjectModel();
        $rows = $projectModel->getsByOrigin($id);

        $data = [];
        $data['delete'] = true;
        $data['err_msg'] = '';
        $data['projects'] = [];
        if (!empty($rows)) {
            $data['err_msg'] = '因该组织下还存在项目,请先将所属项目移动至default组织下，才能能删除';
            $data['delete'] = false;
            $data['projects'] = $rows;
        }

        $this->ajaxSuccess('success', $data);
    }

    /**
     * @param $err
     * @param $params
     */
    private function checkParam(&$err, $params)
    {
        $path = $params['path'];
        $name = $params['name'];

        if (!isset($params['path']) || empty(trimStr($params['path']))) {
            $err['path'] = '组织关键字不能为空';
        }
        if (!isset($params['name']) || empty(trimStr($params['name']))) {
            $err['name'] = '组织名称不能为空';
        }

        if (!preg_match("/^[a-zA-Z0-9]+$/", $path)) {
            $err['path'] = '组织关键字必须全部为英文字母,不能包含空格和特殊字符';
        }

        // 控制器已经使用的则不能使用
        $mapConfigArr = getCommonConfigVar('map');
        $ctrlKeyArr = array_keys($mapConfigArr['ctrl']);
        foreach ($ctrlKeyArr as &$ctrlName) {
            if (strpos($ctrlName, '.') !== false) {
                list($ctrlName,) = explode('.', $ctrlName);
            }
            $ctrlName = strtolower($ctrlName);
        }
        if (in_array(trimStr(strtolower($path)), $ctrlKeyArr)) {
            $err['path'] = '组织关键字不可用,该关键字与系统关键字冲突';
        }

        $model = new OrgModel();
        $org = $model->getByName($name);
        if (isset($org['id'])) {
            $err['name'] = '名称已经存在';
        }

        $model = new OrgModel();
        $org = $model->getByPath($path);
        if (isset($org['id'])) {
            $err['path'] = '路径已经存在';
        }
    }


    /**
     *  处理添加
     * @param array $params
     * @throws \Exception
     */
    public function add($params = [])
    {
        if (!$this->isAdmin) {
            $this->ajaxFailed('您没有权限进行此操作,系统管理才能创建项目');
        }

        if (empty($params)) {
            $this->ajaxFailed('错误', '无表单数据提交');
        }
        $currentUid = $this->getCurrentUid();
        //print_r($params);
        $err = [];
        $this->checkParam($err, $params);
        if (!empty($err)) {
            $this->ajaxFailed('参数错误', $err, BaseCtrl::AJAX_FAILED_TYPE_FORM_ERROR);
        }

        $model = new OrgModel();
        $info = [];
        $info['path'] = $params['path'];
        $info['name'] = $params['name'];
        if (empty(trimStr($info['name']))) {
            $this->ajaxFailed('名称不能为空');
        }
        $info['description'] = $params['description'];
        if (isset($params['fine_uploader_json']) && !empty($params['fine_uploader_json'])) {
            $avatar = json_decode($params['fine_uploader_json'], true);
            if (isset($avatar[0]['uuid'])) {
                $uuid = $avatar[0]['uuid'];
                $fileModel = new IssueFileAttachmentModel();
                $file = $fileModel->getByUuid($uuid);
                if (isset($file['file_name'])) {
                    $info['avatar'] = $file['file_name'];
                }
            }
        }

        if (isset($params['scope'])) {
            $info['scope'] = $params['scope'];
        }

        $info['created'] = time();
        $info['create_uid'] = $currentUid;

        list($ret, $insertId) = $model->insertItem($info);
        if (!$ret) {
            $this->ajaxFailed('服务器错误', '新增数据错误,错误信息:' . $insertId);
        }

        $activityModel = new ActivityModel();
        $activityInfo = [];
        $activityInfo['action'] = '创建了组织';
        $activityInfo['type'] = ActivityModel::TYPE_ORG;
        $activityInfo['obj_id'] = $insertId;
        $activityInfo['title'] = $info['name'];
        $activityModel->insertItem($currentUid, 0, $activityInfo);

        //写入操作日志
        $logData = [];
        $logData['user_name'] = $this->auth->getUser()['username'];
        $logData['real_name'] = $this->auth->getUser()['display_name'];
        $logData['obj_id'] = 0;
        $logData['module'] = LogOperatingLogic::MODULE_NAME_ORG;
        $logData['page'] = $_SERVER['REQUEST_URI'];
        $logData['action'] = LogOperatingLogic::ACT_ADD;
        $logData['remark'] = '创建组织';
        $logData['pre_data'] = [];
        $logData['cur_data'] = $info;
        LogOperatingLogic::add($currentUid, 0, $logData);

        $this->ajaxSuccess('success');
    }

    /**
     * 更新组织信息
     * @param $params
     * @throws \Exception
     */
    public function update($params = [])
    {
        if (!$this->isAdmin) {
            $this->ajaxFailed('您没有权限进行此操作,系统管理才能创建项目');
        }

        if (empty($params)) {
            $this->ajaxFailed('错误', '无表单数据提交');
        }
        $id = null;
        if (isset($_GET['_target'][2])) {
            $id = (int)$_GET['_target'][2];
        }
        if (isset($_REQUEST['id'])) {
            $id = (int)$_REQUEST['id'];
        }
        if (!$id) {
            $this->ajaxFailed('参数错误', 'id不能为空');
        }

        $model = new OrgModel();
        $org = $model->getById($id);

        $info = [];
        if (isset($params['name'])) {
            $info['name'] = $params['name'];
            if (empty(trimStr($info['name']))) {
                $this->ajaxFailed('名称不能为空');
            }
            $checkOrg = $model->getByName($info['name']);
            if (isset($checkOrg['id']) && $id != $checkOrg['id']) {
                $this->ajaxFailed('名称:' . $info['name'] . '已经存在');
            }
        }

        if (isset($params['description'])) {
            $info['description'] = $params['description'];
        }

        if (isset($params['fine_uploader_json']) && !empty($params['fine_uploader_json'])) {
            $avatar = json_decode($params['fine_uploader_json'], true);
            if (isset($avatar[0]['uuid'])) {
                $uuid = $avatar[0]['uuid'];
                $fileModel = new IssueFileAttachmentModel();
                $file = $fileModel->getByUuid($uuid);
                if (isset($file['file_name'])) {
                    $info['avatar'] = $file['file_name'];
                }
            }
        }

        $noModified = true;
        foreach ($info as $k => $v) {
            if ($v != $org[$k]) {
                $noModified = false;
            }
        }
        if ($noModified) {
            $this->ajaxSuccess('success');
        }

        if (!empty($info)) {
            $info['updated'] = time();
        }

        if (isset($info['path'])) {
            unset($info['path']);
        }

        list($ret, $err) = $model->updateById($id, $info);
        if (!$ret) {
            $this->ajaxFailed('服务器错误', '更新数据失败,详情:' . $err);
        }

        $currentUid = $this->getCurrentUid();
        $activityModel = new ActivityModel();
        $activityInfo = [];
        $activityInfo['action'] = '更新了组织';
        $activityInfo['type'] = ActivityModel::TYPE_ORG;
        $activityInfo['obj_id'] = $id;
        $activityInfo['title'] = $org['name'];
        $activityModel->insertItem($currentUid, 0, $activityInfo);

        //写入操作日志
        $logData = [];
        $logData['user_name'] = $this->auth->getUser()['username'];
        $logData['real_name'] = $this->auth->getUser()['display_name'];
        $logData['obj_id'] = 0;
        $logData['module'] = LogOperatingLogic::MODULE_NAME_PROJECT;
        $logData['page'] = $_SERVER['REQUEST_URI'];
        $logData['action'] = LogOperatingLogic::ACT_EDIT;
        $logData['remark'] = '修改组织信息';
        $logData['pre_data'] = $org;
        $logData['cur_data'] = $info;
        LogOperatingLogic::add($currentUid, 0, $logData);

        $this->ajaxSuccess('success');
    }

    /**
     * 删除组织
     * @throws \Exception
     */
    public function delete()
    {
        // @todo 判断权限:全局权限和项目角色
        if (!$this->isAdmin) {
            $this->ajaxFailed('您没有权限进行此操作,系统管理才能创建项目');
        }
        $id = null;
        if (isset($_GET['_target'][2])) {
            $id = (int)$_GET['_target'][2];
        }
        if (isset($_GET['id'])) {
            $id = (int)$_GET['id'];
        }
        if (!$id) {
            $this->ajaxFailed('参数错误', 'id不能为空');
        }

        $model = new OrgModel();
        $org = $model->getById($id);
        if (empty($org)) {
            $this->ajaxFailed('错误', 'id异常，组织数据为空');
        }
        $ret = $model->deleteById($id);
        if (!$ret) {
            $this->ajaxFailed('服务器错误', '数据库操作失败');
        }
        // 将所属的项目设置为默认组织
        $projModel = new ProjectModel();
        $projects = $projModel->getsByOrigin($id);
        if (!empty($projects)) {
            foreach ($projects as $project) {
                $projModel->updateById(['org_id' => '1'], $project['id']);
            }
        }

        $currentUid = $this->getCurrentUid();
        $activityModel = new ActivityModel();
        $activityInfo = [];
        $activityInfo['action'] = '删除了组织';
        $activityInfo['type'] = ActivityModel::TYPE_ORG;
        $activityInfo['obj_id'] = $id;
        $activityInfo['title'] = $org['name'];
        $activityModel->insertItem($currentUid, 0, $activityInfo);

        $callFunc = function ($value) {
            return '已删除';
        };
        $org2 = array_map($callFunc, $org);
        //写入操作日志
        $logData = [];
        $logData['user_name'] = $this->auth->getUser()['username'];
        $logData['real_name'] = $this->auth->getUser()['display_name'];
        $logData['obj_id'] = 0;
        $logData['module'] = LogOperatingLogic::MODULE_NAME_ORG;
        $logData['page'] = $_SERVER['REQUEST_URI'];
        $logData['action'] = LogOperatingLogic::ACT_DELETE;
        $logData['remark'] = '删除组织';
        $logData['pre_data'] = $org;
        $logData['cur_data'] = $org2;
        LogOperatingLogic::add($currentUid, 0, $logData);

        $this->ajaxSuccess('ok');
    }
}
