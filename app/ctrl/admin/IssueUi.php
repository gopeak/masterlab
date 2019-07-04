<?php

namespace main\app\ctrl\admin;

use main\app\ctrl\BaseCtrl;
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

    /**
     * @throws \Exception
     */
    public function pageIndex()
    {
        $data = [];
        $data['title'] = 'Users';
        $data['nav_links_active'] = 'issue';
        $data['sub_nav_active'] = 'ui';
        $data['left_nav_active'] = 'issue_ui';
        $this->render('gitlab/admin/issue_ui.php', $data);
    }

    /**
     * 获取所有事项类型
     * @throws \Exception
     */
    public function fetchAll()
    {
        $issueTypeLogic = new IssueTypeLogic();
        $issueTypes = $issueTypeLogic->getAdminIssueTypes();
        $data = [];
        $data['issue_types'] = $issueTypes;
        $this->ajaxSuccess('', $data);
    }

    /**
     * 获取单条事项类型
     * @throws \Exception
     */
    public function get()
    {
        $id = null;
        if (isset($_GET['_target'][3])) {
            $id = (int)$_GET['_target'][3];
        }
        if (isset($_REQUEST['id'])) {
            $id = (int)$_REQUEST['id'];
        }
        if (!$id) {
            $this->ajaxFailed('参数错误,id不能为空');
        }
        $id = (int)$id;
        $model = new IssueTypeModel();
        $row = $model->getById($id);
        $this->ajaxSuccess('操作成功', (object)$row);
    }

    /**
     * 获取某一事项的UI数据
     * @throws \Exception
     */
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
        $this->ajaxSuccess('操作成功', $data);
    }

    /**
     * 保存界面数据
     * @throws \Exception
     */
    public function saveCreateConfig()
    {
        $issueTypeId = null;
        $data = null;
        $uiType = IssueUiModel::UI_TYPE_CREATE;
        $requireArr = [];
        if (isset($_POST['issue_type_id'])) {
            $issueTypeId = (int)$_POST['issue_type_id'];
        }
        if (isset($_POST['ui_type'])) {
            $uiType = trimStr($_POST['ui_type']);
        }
        if (isset($_POST['data'])) {
            $data = $_POST['data'];
        }
        if (isset($_POST['required_arr'])) {
            $requireArr = $_POST['required_arr'];
        }
        //print_r($requireArr);

        $err = [];
        if (empty($issueTypeId)) {
            $err['issue_type_id'] = '事项类型不能为空';
        }

        if (empty($data)) {
            $err['data'] = '界面数据不能为空';
        }
        $defineUiTypeArr = [];
        $defineUiTypeArr[] = IssueUiModel::UI_TYPE_CREATE;
        $defineUiTypeArr[] = IssueUiModel::UI_TYPE_EDIT;
        $defineUiTypeArr[] = IssueUiModel::UI_TYPE_VIEW;
        if (!in_array($uiType, $defineUiTypeArr)) {
            $err['ui_type'] = '界面类型不能为空';
        }

        if (!empty($err)) {
            $this->ajaxFailed('参数错误', $err, BaseCtrl::AJAX_FAILED_TYPE_FORM_ERROR);
        }

        $issueTypeId = (int)$issueTypeId;

        $model = new IssueUiModel();
        $model->db->connect();
        try {
            $model->db->pdo->beginTransaction();
            $model->deleteByIssueType($issueTypeId, $uiType);

            $issueUiTabModel = new IssueUiTabModel();
            $issueUiTabModel->deleteByIssueType($issueTypeId, $uiType);
            $jsonData = $data;
            if (is_string($data)) {
                $jsonData = json_decode($data, true);
            }

            if (!$jsonData) {
                $this->ajaxFailed('参数错误', '界面数据格式应该为json');
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
                        $required = in_array($fieldId,$requireArr) ? '1':'0';
                        $model->addField(
                            $issueTypeId,
                            $uiType,
                            $fieldId,
                            $tabId,
                            $countFields,
                            $required
                        );
                    }
                }
            }
            $model->db->pdo->commit();
            $this->ajaxSuccess('ok');
        } catch (\PDOException $e) {
            $model->db->pdo->rollBack();
            $this->ajaxFailed('服务器错误', '数据更新失败' . $e->getMessage());
        }
    }
}
