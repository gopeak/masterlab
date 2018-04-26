<?php
/**
 * Created by PhpStorm.
 */

namespace main\app\ctrl\project;

use main\app\classes\UserAuth;
use main\app\ctrl\BaseUserCtrl;
use main\app\model\project\ProjectModel;
use main\app\model\project\ProjectVersionModel;
use main\app\model\project\ProjectModuleModel;
use main\app\classes\ProjectLogic;

/**
 * 项目模块
 */
class Module extends BaseUserCtrl
{


    public function index()
    {
        $data = [];
        $data['title'] = '浏览 版本';
        $data['nav_links_active'] = 'module';
        $this->render('gitlab/project/module.php', $data);
    }


    public function _new()
    {
        $data = [];
        $data['title'] = '项目分类';
        $this->render('gitlab/project/module_form.php', $data);
    }

    public function edit($id)
    {
        // @todo 判断权限:全局权限和项目角色
        $id = intval($id);
        if (empty($id)) {
            $this->error('Param Error', 'id_is_empty');
        }

        $uid = $this->get_current_uid();
        $projectVersionModel = new ProjectModuleModel($uid);

        $version = $projectVersionModel->getRowById($id);
        if (!isset($version['name'])) {
            $this->error('Param Error', 'id_not_exist');
        }

        $data = [];
        $data['title'] = '项目分类';
        $data['version'] = $version;
        $this->render('gitlab/project/version_form.php', $data);
    }

    private function paramValid($projectVersionModel, $project_id, $name)
    {
        if (empty(trimStr($name))) {
            $this->ajaxFailed('param_error:name_is_null');
        }

        $version = $projectVersionModel->getByProjectIdName($project_id, $name);
        if (isset($version['name'])) {
            $this->ajaxFailed('param_error:name_exist');
        }
    }

    public function add($name, $description, $lead = 0, $default_assignee = 0)
    {
        if (isPost()) {
            $uid = $this->get_current_uid();
            $project_id = intval($_REQUEST[ProjectLogic::PROJECT_GET_PARAM_ID]);
            $projectModuleModel = new ProjectModuleModel($uid);

            $info = [];
            $info['project_id'] = $project_id;
            $info['name'] = $name;
            $info['description'] = $description;
            $info['lead'] = $lead;
            $info['default_assignee'] = $default_assignee;

            $ret = $projectModuleModel->insert($info);
            if ($ret[0]) {
                $this->ajaxSuccess('add_success');
            } else {
                $this->ajaxFailed('add_failed', array(), 500);
            }
        }
        $this->ajaxFailed('add_failed', array(), 500);
        return;
    }


    public function update($id, $name, $description, $sequence = 0, $start_date = '', $release_date = '', $url = '')
    {
        // @todo 判断权限:全局权限和项目角色
        $id = intval($id);
        $uid = $this->get_current_uid();
        $projectVersionModel = new ProjectModuleModel($uid);

        $version = $projectVersionModel->getRowById($id);
        if (!isset($version['name'])) {
            $this->ajaxFailed('param_error:id_not_exist');
        }

        $info = [];

        if (isset($_REQUEST['name'])) {
            $name = $_REQUEST['name'];
            $project_id = $version['project_id'];
            if ($projectVersionModel->checkNameExistExcludeCurrent($id, $project_id, $name)) {
                $this->ajaxFailed('param_error:name_exist');
            }
            $info['name'] = $name;
        }
        if (isset($_REQUEST['description'])) {
            $info['description'] = $_REQUEST['description'];
        }
        if (isset($_REQUEST['sequence'])) {
            $info['sequence'] = intval($_REQUEST['sequence']);
        }
        if (isset($_REQUEST['start_date'])) {
            $info['start_date'] = $_REQUEST['start_date'];
        }
        if (isset($_REQUEST['release_date'])) {
            $info['release_date'] = $_REQUEST['release_date'];
        }
        if (isset($_REQUEST['url'])) {
            $info['url'] = $_REQUEST['url'];
        }
        if (empty($info)) {
            $this->ajaxFailed('param_error:data_is_empty');
        }
        $ret = $projectVersionModel->updateById($id, $info);
        if ($ret[0]) {
            $this->ajaxSuccess('add_success');
        } else {
            $this->ajaxFailed('add_failed');
        }
    }
}
