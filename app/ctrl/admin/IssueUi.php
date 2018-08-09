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
 * 事项类型的界面方案
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

    public function get()
    {
        $id = null;
        if (isset($_GET['_target'][2])) {
            $id = (int)$_GET['_target'][2];
        }
        if (isset($_REQUEST['id'])) {
            $id = (int)$_REQUEST['id'];
        }
        if (!$id) {
            $this->ajaxFailed('id_is_null');
        }
        $id = (int)$id;
        $model = new IssueTypeModel();
        $row = $model->getById($id);
        $this->ajaxSuccess('ok', (object)$row);
    }

    public function getUiConfig()
    {
        $issueTypeId = 0;
        $type = 'create';
        if (isset($_GET['issue_type_id'])) {
            $issueTypeId = (int)$_GET['issue_type_id'];
        }
        if (isset($_GET['type'])) {
            $type = safeStr($_GET['type']);
        }

        $issueTypeId = (int)$issueTypeId;
        $model = new IssueUiModel();
        $data['configs'] = $model->getsByUiType($issueTypeId, $type);

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
        $data['tabs'] = $issueUiTabModel->getItemsByIssueTypeIdType($issueTypeId, $type);
        $this->ajaxSuccess('ok', $data);
    }

    public function saveCreateConfig()
    {
        $issueTypeId = null;
        $data = null;
        $uiType = IssueUiModel::UI_TYPE_CREATE;
        if (isset($_POST['issue_type_id'])) {
            $issueTypeId = (int)$_POST['issue_type_id'];
        }
        if (isset($_POST['ui_type'])) {
            $uiType = $_POST['ui_type'];
        }
        if (isset($_POST['data'])) {
            $data = $_POST['data'];
        }

        $error_msg = [];
        if (empty($issueTypeId)) {
            $error_msg['field']['issue_type_id'] = '参数错误';
        }

        if (empty($data)) {
            $error_msg['field']['data'] = '参数错误';
        }
        $defineUiTypeArr = [];
        $defineUiTypeArr[] = IssueUiModel::UI_TYPE_CREATE;
        $defineUiTypeArr[] = IssueUiModel::UI_TYPE_EDIT;
        $defineUiTypeArr[] = IssueUiModel::UI_TYPE_VIEW;
        if (!in_array($uiType, [$defineUiTypeArr])) {
            $error_msg['field']['ui_type'] = '参数错误';
        }

        if (!empty($error_msg)) {
            $this->ajaxFailed($error_msg, [], 600);
        }

        $issueTypeId = (int)$issueTypeId;

        $model = new IssueUiModel();
        $model->db->connect();
        try {
            $model->db->pdo->beginTransaction();
            $model->deleteByIssueType($issueTypeId, $uiType);

            $issueUiTabModel = new IssueUiTabModel();
            $issueUiTabModel->deleteByIssueType($issueTypeId, $uiType);

            $jsonData = json_decode($data, true);
            // var_dump($jsonData);
            if (!$jsonData) {
                $this->ajaxFailed('参数错误', [], 500);
            }
            $count = count($jsonData);
            foreach ($jsonData as $tabId => $tab) {
                $count--;
                if ($tabId != 0) {
                    list($addRet, $insertId) = $issueUiTabModel->add($issueTypeId, $count, $tab['display'], $uiType);
                    if ($addRet) {
                        $tabId = $insertId;
                    }
                }
                $fields = $tab['fields'];
                if ($fields) {
                    $countFields = count($fields);
                    foreach ($fields as $fieldId) {
                        $countFields--;
                        $model->addField(
                            $issueTypeId,
                            $uiType,
                            $fieldId,
                            $tabId,
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

}
