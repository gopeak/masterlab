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
            foreach ($issueTypesTplIdArr as $tplId) {
                if ($tpl['id'] == $tplId) {
                    $tpl['type_id_arr'][] = $tplId;
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
        if (!isset($params['key']) || empty($params['key'])) {
            $errorMsg['key'] = '关键字不能为空';
        }
        if (isset($params['name']) && empty($params['name'])) {
            $errorMsg['name'] = '名称不能为空';
        }

        $model = new IssueDescriptionTemplateModel();
        if (isset($model->getByName($params['name'])['id'])) {
            $errorMsg['name'] = '名称已经被使用';
        }
        if (!empty($errorMsg)) {
            $this->ajaxFailed('参数错误', $errorMsg, BaseCtrl::AJAX_FAILED_TYPE_FORM_ERROR);
        }

        $info = [];
        $info['name'] = $params['name'];
        if (isset($params['description'])) {
            $info['description'] = $params['description'];
        }
        list($ret, $msg) = $model->insert($info);
        if ($ret) {
            $this->ajaxSuccess('ok');
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
        if (isset($params['description'])) {
            $info['description'] = $params['description'];
        }
        $ret = $model->updateById($id, $info);
        if ($ret) {
            $this->ajaxSuccess('ok');
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
        $ret = $model->deleteById($id);
        if (!$ret) {
            $this->ajaxFailed('服务器错误', '删除数据失败');
        } else {
            $this->ajaxSuccess('success');
        }
    }
}
