<?php

namespace main\app\ctrl\admin;

use main\app\ctrl\BaseAdminCtrl;
use main\app\model\field\FieldModel;
use main\app\model\field\FieldTypeModel;
use main\app\model\issue\IssueTypeModel;
use main\app\model\issue\IssueUiModel;
use main\app\model\issue\IssueUiTabModel;
use main\app\classes\IssueTypeLogic;

/**
 * 问题类型的界面方案
 */
class IssueUi extends BaseAdminCtrl
{

    public function index()
    {
        $data = [];
        $data['title'] = 'Users';
        $data['nav_links_active'] = 'issue';
        $data['sub_nav_active'] = 'ui';
        $data['left_nav_active'] = 'issue_ui';
        $this->render('gitlab/admin/issue_ui.php', $data);
    }

    public function fetchAll()
    {
        $issueTypeLogic = new IssueTypeLogic();
        $issueTypes = $issueTypeLogic->getAdminIssueTypes();

        $data = [];
        $data['issue_types'] = $issueTypes;

        $this->ajaxSuccess('', $data);
    }

    public function get($id)
    {
        $id = (int)$id;
        $model = new IssueTypeModel();
        $group = $model->getById($id);

        $this->ajaxSuccess('ok', (object)$group);
    }

    public function getUiConfig($issue_type_id = 0, $type = 'create')
    {
        $projectId = 0;
        $issueTypeId = (int)$issue_type_id;
        $model = new IssueUiModel();
        $data['configs'] = $model->getsByUiType($projectId, $projectId, $issueTypeId, $type);

        $model = new FieldModel();
        $fields = $model->getAllItems(false);
        if ($fields) {
            foreach ($fields as &$v) {
                $v['options'] = json_decode($v['options']);
            }
        }
        $data['fields'] = $fields;
        $model = new FieldTypeModel();
        $data['field_types'] = $model->getAll(false);

        $issueUiTabModel = new IssueUiTabModel();
        $data['tabs'] = $issueUiTabModel->getItemsByIssueTypeIdType($projectId, $issueTypeId, $type);
        $this->ajaxSuccess('ok', $data);
    }

    public function saveCreateConfig($issue_type_id, $data)
    {
        $error_msg = [];

        if (empty($issue_type_id)) {
            $error_msg['field']['issue_type_id'] = 'param_is_empty';
        }

        if (empty($data)) {
            $error_msg['field']['data'] = 'param_is_empty';
        }

        if (!empty($error_msg)) {
            $this->ajaxFailed($error_msg, [], 600);
        }

        $projectId = 0;
        $issue_type_id = (int)$issue_type_id;

        $model = new IssueUiModel();
        $model->db->connect();
        try {
            $model->db->pdo->beginTransaction();
            $model->deleteByIssueType($projectId, $issue_type_id, IssueUiModel::UI_TYPE_CREATE);

            $issueUiTabModel = new IssueUiTabModel();
            $ret = $issueUiTabModel->deleteByIssueType($projectId, $issue_type_id, IssueUiModel::UI_TYPE_CREATE);

            $jsonData = json_decode($data, true);
            // var_dump($jsonData);
            if (!$jsonData) {
                $this->ajaxFailed('param_is_empty', [], 500);
            }
            $count = count($jsonData);
            foreach ($jsonData as $k => $tab) {
                $count--;
                $tabInsertId = 0;
                if ($k != 0) {
                    $issueUiTabModel->add($projectId, $issue_type_id, $count, $tab['display'], IssueUiModel::UI_TYPE_CREATE);
                }
                $fields = $tab['fields'];
                if ($fields) {
                    $project_id = 0;
                    $countFields = count($fields);
                    foreach ($fields as $field_id) {
                        $countFields--;
                        $model->addField(
                            $project_id,
                            $issue_type_id,
                            IssueUiModel::UI_TYPE_CREATE,
                            $field_id,
                            $k,
                            $countFields
                        );
                    }
                }
            }
            $model->db->pdo->commit();
            $this->ajaxSuccess('ok');
        } catch (\PDOException $e) {
            $model->db->pdo->rollBack();
            $this->ajaxFailed('server_error:' . $e->getMessage(), [], 500);
        }
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

        if (isset($params['name']) && empty($params['name'])) {
            $error_msg['field']['name'] = 'name_is_empty';
        }

        if (!empty($error_msg)) {
            $this->ajaxFailed($error_msg, [], 600);
        }

        $info = [];
        $info['name'] = $params['name'];
        $info['catalog'] = 'Custom';
        if (isset($params['description'])) {
            $info['description'] = $params['description'];
        }
        if (isset($params['font_awesome'])) {
            $info['font_awesome'] = $params['font_awesome'];
        }

        $model = new IssueTypeModel();
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
        if (isset($params['font_awesome'])) {
            $info['font_awesome'] = $params['font_awesome'];
        }

        $model = new IssueTypeModel();
        $group = $model->getByName($info['name']);
        //var_dump($group);
        if (isset($group['id']) && ($group['id'] != $id)) {
            $this->ajaxFailed('name_exists', [], 600);
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
            $this->ajaxFailed('param_is_empty');
        }
        $id = (int)$id;
        $model = new IssueTypeModel();
        $ret = $model->deleteById($id);
        if (!$ret) {
            $this->ajaxFailed('delete_failed');
        } else {
            $this->ajaxSuccess('success');
        }
    }
}
