<?php

namespace main\app\ctrl\admin;

use main\app\ctrl\BaseCtrl;
use main\app\ctrl\BaseAdminCtrl;
use main\app\model\issue\IssueTypeModel;
use main\app\model\issue\IssueTypeSchemeItemsModel;
use main\app\model\issue\IssueTypeSchemeModel;
use main\app\model\project\ProjectModel;
use main\app\classes\IssueTypeLogic;

/**
 * IssueTypeScheme
 */
class IssueTypeScheme extends BaseAdminCtrl
{

    public function pageIndex()
    {
        $data = [];
        $data['title'] = 'Users';
        $data['nav_links_active'] = 'issue';
        $data['sub_nav_active'] = 'issue_type';
        $data['left_nav_active'] = 'type_scheme';
        $this->render('gitlab/admin/issue_type_scheme.php', $data);
    }

    /**
     * 获取所有数据
     * @throws \Exception
     */
    public function fetchAll()
    {
        $issueTypeLogic = new IssueTypeLogic();
        $issueTypeSchemes = $issueTypeLogic->getAdminIssueTypeSchemes();

        $issueTypeModel = new IssueTypeModel();
        $issueTypes = $issueTypeModel->getAll();

        $projectModel = new ProjectModel();
        $projects = $projectModel->getAll();

        $data = [];
        $data['issue_type_schemes'] = $issueTypeSchemes;
        $data['issue_types'] = array_values($issueTypes);
        $data['projects'] = array_values($projects);

        $this->ajaxSuccess('', $data);
    }

    /**
     * @param $id
     * @throws \Exception
     */
    public function get($id)
    {
        $id = (int)$id;
        $model = new IssueTypeSchemeModel();
        $group = $model->getRowById($id);

        $issueTypeSchemeItemsModel = new IssueTypeSchemeItemsModel();
        $issueTypes = $issueTypeSchemeItemsModel->getItemsBySchemeId($id);
        $forIssueTypesIds = [];
        foreach ($issueTypes as $row) {
            $forIssueTypesIds[] = $row['type_id'];
        }
        $group['for_issue_types'] = $forIssueTypesIds;
        $this->ajaxSuccess('ok', (object)$group);
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
        $err = [];
        if (!isset($params['name']) || empty($params['name'])) {
            $err['name'] = '名称不能为空';
        }

        $issueTypes = $params['issue_types'];
        if (!is_array($issueTypes)) {
            $err['issue_types'] = '事项类型不能为空';
        }

        $model = new IssueTypeSchemeModel();
        if (isset($model->getByName($params['name'])['id'])) {
            $err['name'] = '名称已经被使用';
        }

        if (!empty($err)) {
            $this->ajaxFailed('参数错误', $err, BaseCtrl::AJAX_FAILED_TYPE_FORM_ERROR);
        }

        $info = [];
        $info['name'] = $params['name'];
        $info['is_default'] = '0';
        if (isset($params['description'])) {
            $info['description'] = $params['description'];
        }
        list($ret, $msg) = $model->insertItem($info);
        if ($ret) {
            if (isset($params['issue_types'])) {
                $issueTypeLogic = new IssueTypeLogic();
                $issueTypeLogic->updateSchemeTypes($msg, $params['issue_types']);
            }
            $this->ajaxSuccess('操作成功');
        } else {
            $this->ajaxFailed('服务器错误:', '数据库插入失败,详情 :' . $msg);
        }
    }

    /**
     * @param null $params
     * @throws \Exception
     */
    public function update($params = null)
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
        $errorMsg = [];
        if (!isset($params['name']) || empty($params['name'])) {
            $errorMsg['name'] = '参数错误';
        }
        $model = new IssueTypeSchemeModel();
        $row = $model->getByName($params['name']);
        if (isset($row['id']) && ($row['id'] != $id)) {
            $errorMsg['name'] = '名称已经被使用';
        }
        if (!empty($errorMsg)) {
            $this->ajaxFailed('参数错误', $errorMsg, BaseCtrl::AJAX_FAILED_TYPE_FORM_ERROR);
        }

        $id = (int)$id;
        $info = [];
        $info['name'] = $params['name'];
        if (isset($params['description'])) {
            $info['description'] = $params['description'];
        }

        $ret = $model->updateItem($id, $info);
        if ($ret) {
            if (isset($params['issue_types'])) {
                $issue_types = $params['issue_types'];
                if (is_array($issue_types)) {
                    $issueTypeLogic = new IssueTypeLogic();
                    $issueTypeLogic->updateSchemeTypes($id, $params['issue_types']);
                }
            }
            $this->ajaxSuccess('操作成功');
        } else {
            $this->ajaxFailed('服务器错误', [], 500);
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

        $id = (int)$id;
        $model = new IssueTypeSchemeModel();
        $ret = $model->deleteItem($id);
        if (!$ret) {
            $this->ajaxFailed('服务器错误', '删除数据失败');
        } else {
            $model = new IssueTypeSchemeItemsModel();
            $model->deleteBySchemeId($id);
            $this->ajaxSuccess('操作成功');
        }
    }
}
