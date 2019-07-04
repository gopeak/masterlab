<?php

namespace main\app\ctrl\admin;

use main\app\classes\UserAuth;
use main\app\ctrl\BaseAdminCtrl;
use main\app\ctrl\BaseCtrl;
use main\app\model\issue\IssueStatusModel;
use main\app\model\issue\WorkflowModel;
use main\app\model\issue\WorkflowSchemeModel;
use main\app\classes\WorkflowLogic;

/**
 * 系统管理-->事项类型-->工作流
 */
class Workflow extends BaseAdminCtrl
{

    public function pageIndex()
    {
        $data = [];
        $data['title'] = 'Users';
        $data['nav_links_active'] = 'issue_attribute';
        $data['left_nav_active'] = 'workflow';
        $data['nav_links_active'] = 'issue';
        $this->render('gitlab/admin/workflow.php', $data);
    }

    /**
     * 详情页面
     */
    public function pageView()
    {
        $data = [];
        $data['title'] = 'Users';
        $data['nav_links_active'] = 'issue';
        $data['left_nav_active'] = 'workflow';
        $id = isset($_GET['_target'][3]) ? (int)$_GET['_target'][3] : null;
        if (!$id) {
            $this->error('参数错误,id不能为空');
        }
        $workflowModel = new WorkflowModel();
        $workflow = $workflowModel->getById($id);

        $this->render('gitlab/admin/workflow_view.php', $data + $workflow);
    }

    /**
     * 新增页面
     * @param array $params
     */
    public function pageCreate($params = [])
    {
        $data = [];
        $data['title'] = 'Users';
        $data['nav_links_active'] = 'issue_attribute';
        $data['left_nav_active'] = 'workflow';
        $data['nav_links_active'] = 'issue';
        $id = 1;
        $workflowModel = new WorkflowModel();
        $data['workflow'] = $workflowModel->getById($id);
        $data['params'] = $params;
        $this->render('gitlab/admin/workflow_new.php', $data);
    }

    /**
     * 编辑页面
     * @param array $params
     */
    public function pageEdit($params = [])
    {
        $data = [];
        $data['title'] = 'Users';
        $data['nav_links_active'] = 'issue_attribute';
        $data['left_nav_active'] = 'workflow';
        $data['nav_links_active'] = 'issue';
        $id = isset($_GET['_target'][3]) ? (int)$_GET['_target'][3] : null;
        $id = isset($_GET['id']) ? (int)$_GET['id'] : $id;
        if (!$id) {
            $this->error('参数错误');
        }
        $workflowModel = new WorkflowModel();
        $data['workflow'] = $workflowModel->getById($id);
        $json = $data['workflow']['data'];
        $jsonArr = json_decode($json, true);

        $statusModel = new IssueStatusModel();
        $statusRows = $statusModel->getAllItem();
        $statusKeyArr = [];
        foreach ($statusRows as $statusRow) {
            $statusKeyArr[$statusRow['_key']] = $statusRow['_key'];
        }
        foreach ($jsonArr['blocks'] as $block) {
            $key = str_replace('state_', '', $block['id']);
            if (in_array($key, $statusKeyArr)) {
                unset($statusKeyArr[$key]);
            }
        }
        $sizeY = 0;
        foreach ($statusKeyArr as $item) {
            $statusRow = $statusModel->getByKey($item);
            $sizeY = $sizeY + 80;
            $adds = [];
            $adds['id'] = 'state_'.$item;
            $adds['positionX'] = 1250;
            $adds['positionY'] = $sizeY;
            $adds['innerHTML'] = $statusRow['name'] . '  <div class="ep" action="' . $statusRow['name'] . '"></div>';
            $adds['innerText'] = $statusRow['name'];
            $jsonArr['blocks'][] = $adds;
        }
        $data['workflow']['data'] = json_encode($jsonArr);
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
        $workflowSchemes = $workflowSchemeModel->getAll();

        $data = [];
        $data['workflow'] = $workflow;
        $data['workflow_schemes'] = $workflowSchemes;

        $this->ajaxSuccess('ok', $data);
    }

    /**
     * 获取单条数据
     * @param $id
     * @throws \Exception
     */
    public function get($id)
    {
        $id = null;
        if (isset($_GET['_target'][3])) {
            $id = (int)$_GET['_target'][3];
        }
        if (isset($_REQUEST['id'])) {
            $id = (int)$_REQUEST['id'];
        }
        if (!$id) {
            $this->ajaxFailed('参数错误', 'id不能为空');
        }
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
            $this->ajaxFailed('提示', '名称已经被使用', BaseCtrl::AJAX_FAILED_TYPE_TIP);
        }

        list($ret, $msg) = $model->insertItem($info);
        if ($ret) {
            $this->ajaxSuccess('操作成功');
        } else {
            $this->ajaxFailed('服务器错误:', '数据库插入失败,详情 :' . $msg);
        }
    }

    /**
     * 更新
     * @param $id
     * @param $params
     * @throws \Exception
     */
    public function update($id, $params)
    {
        $id = null;
        if (isset($_GET['_target'][3])) {
            $id = (int)$_GET['_target'][3];
        }
        if (isset($_REQUEST['id'])) {
            $id = (int)$_REQUEST['id'];
        }
        if (!$id) {
            $this->ajaxFailed('参数错误', 'id不能为空');
        }
        if (empty($params)) {
            $this->ajaxFailed('错误', '没有提交表单数据');
        }

        $model = new WorkflowModel();
        $info = [];
        $info['update_time'] = time();

        if (isset($params['name'])) {
            $info['name'] = $params['name'];
            $group = $model->getByName($info['name']);
            //var_dump($group);
            if (isset($group['id']) && ($group['id'] != $id)) {
                $this->ajaxFailed('提示', '名称已经被使用', BaseCtrl::AJAX_FAILED_TYPE_TIP);
            }
        }
        if (isset($params['description'])) {
            $info['description'] = $params['description'];
        }
        if (isset($params['data'])) {
            $info['data'] = $params['data'];
        }

        $ret = $model->updateItem($id, $info);
        if ($ret) {
            $this->ajaxSuccess('操作成功');
        } else {
            $this->ajaxFailed('服务器错误', '更新数据失败');
        }
    }

    /**
     * 删除
     * @throws \Exception
     */
    public function delete()
    {
        $id = null;
        if (isset($_GET['_target'][3])) {
            $id = (int)$_GET['_target'][3];
        }
        if (isset($_REQUEST['id'])) {
            $id = (int)$_REQUEST['id'];
        }
        if (!$id) {
            $this->ajaxFailed('参数错误', 'id不能为空');
        }
        $model = new WorkflowModel();
        $ret = $model->deleteItem($id);
        if (!$ret) {
            $this->ajaxFailed('服务器错误', '删除数据失败');
        } else {
            $this->ajaxSuccess('操作成功');
        }
    }
}
