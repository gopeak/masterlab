<?php

namespace main\app\ctrl\admin;

use main\app\ctrl\BaseAdminCtrl;
use main\app\model\issue\WorkflowSchemeModel;
use main\app\model\issue\WorkflowSchemeDataModel;
use main\app\model\issue\IssueTypeModel;

use main\app\model\issue\IssueTypeSchemeModel;
use main\app\model\issue\WorkflowModel;
use main\app\classes\WorkflowLogic;

/**
 * WorkflowScheme
 */
class WorkflowScheme extends BaseAdminCtrl
{

    public function index()
    {
        $data = [];
        $data['title'] = 'Users';
        $data['nav_links_active'] = 'issue';
        $data['sub_nav_active'] = 'issue_type';
        $data['left_nav_active'] = 'workflow_scheme';
        $this->render('gitlab/admin/workflow_scheme.php', $data);
    }

    public function fetchAll()
    {
        $workflowSchemeModel = new WorkflowSchemeModel();
        $workflowScheme = $workflowSchemeModel->getAllItems(false);

        $workflowModel = new WorkflowModel();
        $workflow = $workflowModel->getAll();

        $issueTypeModel = new IssueTypeModel();
        $issueTypes = $issueTypeModel->getAll();

        $workflowSchemeDataModel = new WorkflowSchemeDataModel();
        $workflowSchemeData = $workflowSchemeDataModel->getAllItems();
        $tmp = [];
        foreach ($workflowSchemeData as $row) {
            $issueTypeId = $row['issue_type_id'];
            $workflowId = $row['workflow_id'];
            $issueTypeId = empty($issueTypeId) ? 1 : $issueTypeId;
            $workflowId = empty($workflowId) ? 1 : $workflowId;

            $row['workflow_name'] = isset($workflow[$workflowId]['name']) ? $workflow[$workflowId]['name'] : '';
            $row['issue_name'] = isset($issueTypes[$issueTypeId]['name']) ? $issueTypes[$issueTypeId]['name'] : '';
            $tmp[$row['scheme_id']][] = $row;
        }
        $workflowSchemeData = $tmp;

        foreach ($workflowScheme as &$s) {
            $s['relation'] = isset($workflowSchemeData[$s['id']]) ? $workflowSchemeData[$s['id']] : [];
        }

        $data = [];
        $data['workflow_scheme'] = $workflowScheme;
        $data['issue_types'] = array_values($issueTypes);
        $data['workflow'] = array_values($workflow);

        $this->ajaxSuccess('', $data);
    }

    public function get($id = 0)
    {
        $id = (int)$id;
        $model = new WorkflowSchemeModel();
        $scheme = $model->getRowById($id);

        $workflowModel = new WorkflowModel();
        $workflow = $workflowModel->getAll();

        $issueTypeModel = new IssueTypeModel();
        $issueTypes = $issueTypeModel->getAll();

        $workflowSchemeDataModel = new WorkflowSchemeDataModel();
        $workflowSchemeData = $workflowSchemeDataModel->getItemsBySchemeId($id);
        if ($workflowSchemeData) {
            foreach ($workflowSchemeData as &$row) {
                $issueTypeId = $row['issue_type_id'];
                $workflowId = $row['workflow_id'];
                $issueTypeId = empty($issueTypeId) ? 1 : $issueTypeId;
                $workflowId = empty($workflowId) ? 1 : $workflowId;

                $row['workflow_name'] = isset($workflow[$workflowId]['name']) ? $workflow[$workflowId]['name'] : '';
                $row['issue_name'] = isset($issueTypes[$issueTypeId]['name']) ? $issueTypes[$issueTypeId]['name'] : '';
            }
        }

        $data = [];
        $data['scheme'] = (object) $scheme;
        $data['workflow'] = $workflow;
        $data['scheme_data'] = $workflowSchemeData;

        $this->ajaxSuccess('ok', $data);
    }

    /**
     * @param array $params
     */
    public function add($params = null)
    {
        if (empty($params)) {
            $error_msg['tip'] = 'param_is_empty';
        }

        if (!isset($params['name']) || empty($params['name'])) {
            $error_msg['field']['name'] = 'param_is_empty';
        }

        if (!empty($error_msg)) {
            $this->ajaxFailed($error_msg, [], 600);
        }

        $info = [];
        $info['name'] = $params['name'];
        if (isset($params['description'])) {
            $info['description'] = $params['description'];
        }

        $model = new WorkflowSchemeModel();
        if (isset($model->getByName($info['name'])['id'])) {
            $this->ajaxFailed('name_exists', [], 600);
        }

        list($ret, $msg) = $model->insert($info);
        if ($ret) {
            if (isset($params['issue_type_workflow'])) {
                $issue_type_workflow = json_decode($params['issue_type_workflow'], true);
                $workflowLogic = new WorkflowLogic();
                $workflowLogic->updateSchemeTypesWorkflow($msg, $issue_type_workflow);
            }
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
            $error_msg['tip'] = 'param_is_empty';
        }

        if (!isset($params['name']) || empty($params['name'])) {
            $error_msg['field']['name'] = 'param_is_empty';
        }

        if (!empty($error_msg)) {
            $this->ajaxFailed($error_msg, [], 600);
        }

        $id = (int)$id;

        $info = [];
        $info['name'] = $params['name'];
        if (isset($params['description'])) {
            $info['description'] = $params['description'];
        }


        $model = new WorkflowSchemeModel();
        $row = $model->getByName($info['name']);
        //var_dump($row);
        if (isset($row['id']) && ($row['id'] != $id)) {
            $this->ajaxFailed('name_exists', [], 600);
        }

        $ret = $model->updateById($id, $info);
        if ($ret) {
            if (isset($params['issue_type_workflow'])) {
                $issue_type_workflow = json_decode($params['issue_type_workflow'], true);
                $workflowLogic = new WorkflowLogic();
                $workflowLogic->updateSchemeTypesWorkflow($id, $issue_type_workflow);
            }
            $this->ajaxSuccess('ok');
        } else {
            $this->ajaxFailed('server_error', [], 500);
        }
    }

    public function delete($id)
    {
        if (empty($id)) {
            $this->ajaxFailed('param_is_empty');
        }
        $id = (int)$id;
        $model = new WorkflowSchemeModel();
        $ret = $model->deleteById($id);
        if (!$ret) {
            $this->ajaxFailed('delete_failed');
        } else {
            $model = new WorkflowSchemeDataModel();
            $model->deleteBySchemeId($id);
            $this->ajaxSuccess('success');
        }
    }
}
