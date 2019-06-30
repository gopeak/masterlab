<?php

namespace main\app\ctrl\admin;

use main\app\ctrl\BaseCtrl;
use main\app\ctrl\BaseAdminCtrl;
use main\app\model\issue\IssueTypeModel;
use main\app\model\issue\IssueTypeSchemeModel;
use main\app\classes\IssueTypeLogic;

/**
 * 事项类型管理控制器
 */
class IssueType extends BaseAdminCtrl
{

    public function pageIndex()
    {
        $data = [];
        $data['title'] = 'Users';
        $data['nav_links_active'] = 'issue';
        $data['sub_nav_active'] = 'issue_type';
        $data['left_nav_active'] = 'type';
        $this->render('gitlab/admin/issue_type.php', $data);
    }

    /**
     * 获取所有数据
     * @throws \Exception
     */
    public function fetchAll()
    {
        $issueTypeLogic = new IssueTypeLogic();
        $issueTypes = $issueTypeLogic->getAdminIssueTypes();

        $issueTypeSchemeModel = new IssueTypeSchemeModel();
        $issueTypeSchemes = $issueTypeSchemeModel->getAll();

        $data = [];
        $data['issue_types'] = $issueTypes;
        $data['issue_type_schemes'] = $issueTypeSchemes;

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
        $model = new IssueTypeModel();
        $group = $model->getById($id);

        $this->ajaxSuccess('操作成功', (object)$group);
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

        $model = new IssueTypeModel();
        if (isset($model->getByName($params['name'])['id'])) {
            $errorMsg['name'] = '名称已经被使用';
        }
        if (isset($model->getByKey($params['key'])['id'])) {
            $errorMsg['key'] = '关键字已经被使用';
        }
        if (!empty($errorMsg)) {
            $this->ajaxFailed('参数错误', $errorMsg, BaseCtrl::AJAX_FAILED_TYPE_FORM_ERROR);
        }

        $info = [];
        $info['name'] = $params['name'];
        $info['_key'] = $params['key'];
        $info['catalog'] = 'Custom';
        if (isset($params['description'])) {
            $info['description'] = $params['description'];
        }
        if (isset($params['font_awesome'])) {
            $info['font_awesome'] = $params['font_awesome'];
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
        $model = new IssueTypeModel();
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
        if (isset($params['font_awesome'])) {
            $info['font_awesome'] = $params['font_awesome'];
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
        $model = new IssueTypeModel();
        $ret = $model->deleteItem($id);
        if (!$ret) {
            $this->ajaxFailed('服务器错误', '删除数据失败');
        } else {
            $this->ajaxSuccess('操作成功');
        }
    }
}
