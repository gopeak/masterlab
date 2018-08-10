<?php

namespace main\app\ctrl\admin;

use main\app\classes\UserAuth;
use main\app\ctrl\BaseAdminCtrl;
use main\app\model\issue\WorkflowModel;
use main\app\model\issue\WorkflowSchemeModel;
use main\app\classes\WorkflowLogic;

/**
 * 系统管理-->事项类型-->工作流
 */
class Workflow extends BaseAdminCtrl
{
    public function index()
    {
        $data = [];
        $data['title'] = 'Users';
        $data['nav_links_active'] = 'issue_attribute';
        $data['left_nav_active'] = 'workflow';
        $this->render('gitlab/admin/workflow.php', $data);
    }

    public function view()
    {
        $data = [];
        $data['title'] = 'Users';
        $data['nav_links_active'] = 'issue_attribute';
        $data['left_nav_active'] = 'workflow';
        $id = isset($_GET['_target'][3]) ? (int)$_GET['_target'][3]:null;
        if (!$id) {
            $this->error('参数错误,id不能为空');
        }
        $workflowModel = new WorkflowModel();
        $workflow = $workflowModel->getById($id);

        $this->render('gitlab/admin/workflow_view.php', $workflow);
    }

    public function create($params = [])
    {
        $data = [];
        $data['title'] = 'Users';
        $data['nav_links_active'] = 'issue_attribute';
        $data['left_nav_active'] = 'workflow';
        $id = 1;
        $workflowModel = new WorkflowModel();
        $data['workflow'] = $workflowModel->getById($id);
        $data['params'] = $params;
        $this->render('gitlab/admin/workflow_new.php', $data);
    }

    public function edit($params = [])
    {
        $data = [];
        $data['title'] = 'Users';
        $data['nav_links_active'] = 'issue_attribute';
        $data['left_nav_active'] = 'workflow';
        $id = isset($_GET['_target'][3]) ? (int)$_GET['_target'][3]:null;
        $id = isset($_GET['id']) ? (int)$_GET['id']:$id;
        if (!$id) {
            $this->error('参数错误');
        }
        $workflowModel = new WorkflowModel();
        $data['workflow'] = $workflowModel->getById($id);
        $data['params'] = $params;
        $data['id'] = $id;

        $this->render('gitlab/admin/workflow_edit.php', $data);
    }

    /**
     * 获取所有数据
     * @throws \Exception
     */
    public function fetchAll()
    {
        $logic = new WorkflowLogic();
        $workflow = $logic->getAdminWorkflow();

        $workflowSchemeModel = new WorkflowSchemeModel();
        $workflowSchemes = $workflowSchemeModel->getAllItems();

        $data = [];
        $data['workflow'] = $workflow;
        $data['workflow_schemes'] = $workflowSchemes;

        $this->ajaxSuccess('', $data);
    }

    /**
     * @param $id
     * @throws \Exception
     */
    public function get($id)
    {
        $id = (int)$id;
        $model = new WorkflowModel();
        $row = $model->getById($id);

        $this->ajaxSuccess('ok', (object)$row);
    }

    /**
     * @param null $params
     * @throws \Exception
     */
    public function add($params = null)
    {
        if (empty($params)) {
            $error_msg['tip'] = '参数错误';
        }

        if (!isset($params['name']) || empty($params['name'])) {
            $error_msg['field']['title'] = '参数错误';
        }

        if (isset($params['name']) && empty($params['name'])) {
            $error_msg['field']['name'] = 'name_is_empty';
        }

        if (!empty($error_msg)) {
            $this->ajaxFailed($error_msg, [], 600);
        }

        $info = [];
        $info['name'] = $params['name'];
        $userAuth = new UserAuth();
        if ($userAuth->getId()) {
            $info['create_uid'] = $userAuth->getId();
        }
        $info['create_time'] = time();
        $info['is_system'] = '0';


        if (isset($params['description'])) {
            $info['description'] = $params['description'];
        }
        if (isset($params['data'])) {
            $info['data'] = $params['data'];
        }
        $model = new WorkflowModel();
        if (isset($model->getByName($info['name'])['id'])) {
            $this->ajaxFailed('name_exists', [], 600);
        }

        list($ret, $msg) = $model->insert($info);
        if ($ret) {
            $this->ajaxSuccess('ok');
        } else {
            $this->ajaxFailed('server_error:' . $msg, [], 500);
        }
    }

    /**
     * 更新用户资料
     * @param $id
     * @param $params
     */
    public function update($id, $params)
    {
        $error_msg = [];
        if (empty($params)) {
            $error_msg['tip'] = '参数错误';
        }

        if (!empty($error_msg)) {
            $this->ajaxFailed($error_msg, [], 600);
        }

        $id = (int)$id;
        $model = new WorkflowModel();
        $info = [];
        $info['update_time'] = time();

        if (isset($params['name'])) {
            $info['name'] = $params['name'];
            $group = $model->getByName($info['name']);
            //var_dump($group);
            if (isset($group['id']) && ($group['id'] != $id)) {
                $this->ajaxFailed('name_exists', [], 600);
            }
        }
        if (isset($params['description'])) {
            $info['description'] = $params['description'];
        }
        if (isset($params['data'])) {
            $info['data'] = $params['data'];
        }

        $ret = $model->updateById($id, $info);
        if ($ret) {
            $this->ajaxSuccess('ok');
        } else {
            $this->ajaxFailed('server_error', [], 500);
        }
    }

    public function delete($id)
    {
        if (empty($id)) {
            $this->ajaxFailed('参数错误');
        }
        $id = (int)$id;
        $model = new WorkflowModel();
        $ret = $model->deleteById($id);
        if (!$ret) {
            $this->ajaxFailed('参数错误', 'id不能为空');
        } else {
            $this->ajaxSuccess('success');
        }
    }
}
