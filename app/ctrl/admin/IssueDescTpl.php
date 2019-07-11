<?php

namespace main\app\ctrl\admin;

use main\app\ctrl\BaseCtrl;
use main\app\ctrl\BaseAdminCtrl;
use main\app\model\issue\IssueTypeModel;
use main\app\model\issue\IssueTypeSchemeModel;
use main\app\model\issue\IssueDescriptionTemplateModel;
use main\app\classes\IssueTypeLogic;

/**
 * 事项类型管理控制器
 */
class IssueDescTpl extends BaseAdminCtrl
{

    public function pageIndex()
    {
        $data = [];
        $data['title'] = 'Users';
        $data['nav_links_active'] = 'issue';
        $data['sub_nav_active'] = 'issue_type';
        $data['left_nav_active'] = 'type_tpl';
        $this->render('gitlab/admin/issue_desc_tpl.php', $data);
    }

    /**
     * 获取所有数据
     * @throws \Exception
     */
    public function fetchAll()
    {
        $model = new IssueDescriptionTemplateModel();
        $tpls = $model->getAllItems(false);

        $issueTypeModel = new IssueTypeModel();
        $issueTypes = $issueTypeModel->getAllItems();
        $issueTypesTplIdArr = [];
        foreach ($issueTypes as $issueType) {
            if (!empty($issueType['form_desc_tpl_id'])) {
                $issueTypesTplIdArr[$issueType['id']] = $issueType['form_desc_tpl_id'];
            }
        }

        foreach ($tpls as &$tpl) {
            $tpl['type_id_arr'] = [];
            foreach ($issueTypesTplIdArr as $typeId => $tplId) {
                if ($tpl['id'] == $tplId) {
                    $tpl['type_id_arr'][] = $typeId;
                }
            }
            $tpl['created_text'] = format_unix_time($tpl['created']);
            $tpl['updated_text'] = format_unix_time($tpl['updated']);
        }

        $data = [];
        $data['issue_types'] = $issueTypes;
        $data['tpls'] = $tpls;

        $this->ajaxSuccess('', $data);
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
        $model = new IssueDescriptionTemplateModel();
        $group = $model->getById($id);

        $this->ajaxSuccess('ok', (object)$group);
    }

    public function fetchBindIssueTypes()
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

        $issueTypeModel = new IssueTypeModel();
        $issueTypes = $issueTypeModel->getAllItems(false);
        $issueTypesTplIdArr = [];
        //print_r($issueTypes);
        foreach ($issueTypes as $issueType) {
            if ($issueType['form_desc_tpl_id']==$id) {
                $issueTypesTplIdArr[] = $issueType['id'];
            }
        }
        $data = [];
        $data['issue_types'] = $issueTypes;
        $data['bind_issue_types'] = $issueTypesTplIdArr;

        $this->ajaxSuccess('ok', $data);
    }

    /**
     * @param $params
     * @throws \Exception
     */
    public function bindIssueTypes($params)
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
        $idArr = $params['for_issue_types'];
        if (!is_array($idArr)) {
            $this->ajaxFailed('param_is_error');
        }
        $issueTypeModel = new IssueTypeModel();
        foreach ($idArr as $typeId) {
            $issueTypeModel->updateItem($typeId, ['form_desc_tpl_id'=>$id]);
        }

        $this->ajaxSuccess("操作成功");
    }

    /**
     * 添加数据
     * @param null $params
     * @throws \Exception
     */
    public function add($params = null)
    {
        if (empty($params)) {
            $this->ajaxFailed('错误', '没有提交表单数据');
        }
        if (isset($params['name']) && empty($params['name'])) {
            $errorMsg['name'] = '名称不能为空';
        }

        $model = new IssueDescriptionTemplateModel();
        if (isset($model->getItemByName($params['name'])['id'])) {
            $errorMsg['name'] = '名称已经被使用';
        }
        if (!empty($errorMsg)) {
            $this->ajaxFailed('参数错误', $errorMsg, BaseCtrl::AJAX_FAILED_TYPE_FORM_ERROR);
        }

        $info = [];
        $info['name'] = $params['name'];
        $info['created'] = time();
        if (isset($params['content'])) {
            $info['content'] = $params['content'];
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
     * @param array $params
     * @throws \Exception
     */
    public function update($params = [])
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
        $model = new IssueDescriptionTemplateModel();
        $row = $model->getByName($params['name']);
        if (isset($row['id']) && ($row['id'] != $id)) {
            $errorMsg['name'] = '名称已经被使用';
        }
        if (!empty($errorMsg)) {
            $this->ajaxFailed('参数错误', $errorMsg, BaseCtrl::AJAX_FAILED_TYPE_FORM_ERROR);
        }

        $info = [];
        $info['name'] = $params['name'];
        $info['updated'] = time();
        if (isset($params['content'])) {
            $info['content'] = $params['content'];
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
        $id = (int)$id;
        $model = new IssueDescriptionTemplateModel();
        $ret = $model->deleteItem($id);
        if (!$ret) {
            $this->ajaxFailed('服务器错误', '删除数据失败');
        } else {
            $this->ajaxSuccess('操作成功');
        }
    }
}
