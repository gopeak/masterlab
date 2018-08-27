<?php

namespace main\app\ctrl;

use main\app\classes\OrgLogic;
use main\app\classes\ProjectLogic;
use main\app\model\issue\IssueFileAttachmentModel;
use main\app\model\OrgModel;
use main\app\model\project\ProjectModel;

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
    public function index()
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
    public function detail($id = null)
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

        $model = new OrgModel();
        $org = $model->getById($id);
        if (empty($org)) {
            $this->ajaxFailed('参数错误', '组织数据为空');
        }

        $model = new ProjectModel();
        $projects = $model->getsByOrigin($id);

        $data = [];
        $data['projects'] = $projects;

        $this->ajaxSuccess('success', $data);
    }

    /**
     * @throws \Exception
     */
    public function fetchAll()
    {
        $data = [];
        $orgLogic = new OrgLogic();
        $orgs = $orgLogic->getOrigins();

        $projectLogic = new ProjectLogic();
        $projects = $projectLogic->projectListJoinUser();

        //var_dump($projects);
        $orgProjects = [];
        foreach ($projects as $p) {
            $orgProjects[$p['org_id']][] = $p;
        }
        foreach ($orgs as &$org) {
            $id = $org['id'];
            $org['projects'] = [];
            $org['is_more'] = false;
            if (isset($orgProjects[$id])) {
                $org['projects'] = $orgProjects[$id];
                if (count($org['projects']) > 10) {
                    $org['is_more'] = true;
                    $org['projects'] = array_slice($org['projects'], 0, 10);
                }
            }
        }
        unset($projects, $orgProjects);
        $data['orgs'] = $orgs;
        $this->ajaxSuccess('success', $data);
    }

    public function create()
    {
        $data = [];
        $data['title'] = '创建组织';
        $data['nav_links_active'] = 'org';
        $data['sub_nav_active'] = 'all';

        $data['id'] = '';
        $data['action'] = 'add';
        $this->render('gitlab/org/form.php', $data);
    }

    public function edit($id = null)
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
            $org['avatar'] = ATTACHMENT_URL . $org['avatar'];
        }

        $data = [];
        $data['org'] = $org;

        $this->ajaxSuccess('success', $data);
    }

    /**
     *  处理添加
     * @param array $params
     * @throws \Exception
     */
    public function add($params = [])
    {
        // @todo 判断权限:全局权限和项目角色
        $uid = $this->getCurrentUid();

        $err = [];
        if (!isset($params['path']) || empty(trimStr($params['path']))) {
            $err['path'] = '路径为空';
        }
        if (!isset($params['name']) || empty(trimStr($params['name']))) {
            $err['name'] = '名称为空';
        }
        if (!empty($err)) {
            $this->ajaxFailed('参数错误', $err, BaseCtrl::AJAX_FAILED_TYPE_FORM_ERROR);
        }
        $path = $params['path'];
        $model = new OrgModel();
        $org = $model->getByPath($path);
        if (isset($org['id'])) {
            $err['path'] = '路径已经存在';
        }
        $name = $params['name'];
        $org = $model->getByName($name);
        if (isset($org['id'])) {
            $err['name'] = '名称已经存在';
        }
        if (!empty($err)) {
            $this->ajaxFailed('参数错误', $err, BaseCtrl::AJAX_FAILED_TYPE_FORM_ERROR);
        }

        $info = [];
        $info['path'] = $params['path'];
        $info['name'] = $params['name'];
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

        $info['scope'] = $params['scope'];
        $info['created'] = time();
        $info['create_uid'] = $uid;

        list($ret, $insertId) = $model->insert($info);
        if (!$ret) {
            $this->ajaxFailed('服务器错误', '新增数据错误,错误信息:' . $insertId);
        }
        $this->ajaxSuccess('success');
    }

    /**
     * 更新组织信息
     * @param $params
     * @throws \Exception
     */
    public function update($params = [])
    {
        // @todo 判断权限:全局权限和项目角色
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

        list($ret, $err) = $model->updateById($id, $info);
        if (!$ret) {
            $this->ajaxFailed('服务器错误', '更新数据失败,详情:' . $err);
        }
        $this->ajaxSuccess('success');
    }

    /**
     * 删除组织
     * @throws \Exception
     */
    public function delete()
    {
        // @todo 判断权限:全局权限和项目角色
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
        $this->ajaxSuccess('ok');
    }
}
