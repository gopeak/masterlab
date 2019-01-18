<?php

namespace main\app\ctrl\admin;

use main\app\ctrl\BaseCtrl;
use main\app\ctrl\BaseAdminCtrl;
use main\app\model\issue\IssuePriorityModel;

/**
 * 优先级管理控制器
 */
class IssuePriority extends BaseAdminCtrl
{

    /**
     *
     */
    public function pageIndex()
    {
        $data = [];
        $data['title'] = 'Users';
        $data['nav_links_active'] = 'issue';
        $data['sub_nav_active'] = 'issue_attribute';
        $data['left_nav_active'] = 'priority';
        $this->render('gitlab/admin/issue_priority.php', $data);
    }

    /**
     * @throws \Exception
     */
    public function fetchAll()
    {
        $model = new IssuePriorityModel();
        $rows = $model->getAll(false);
        $data = [];
        $data['rows'] = $rows;

        $this->ajaxSuccess('', $data);
    }

    /**
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
            $this->ajaxFailed('参数错误', 'id不能为空');
        }
        $id = (int)$id;
        $model = new IssuePriorityModel();
        $group = $model->getItemById($id);

        $this->ajaxSuccess('操作成功', (object)$group);
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
        if (!isset($params['key']) || empty($params['key'])) {
            $errorMsg['key'] = '关键字不能为空';
        }

        if (!isset($params['name']) || empty($params['name'])) {
            $errorMsg['name'] = '名称不能为空';
        }

        if (isset($params['name']) && empty($params['name'])) {
            $errorMsg['name'] = 'name_is_empty';
        }

        if (!empty($errorMsg)) {
            $this->ajaxFailed('参数错误', $errorMsg, BaseCtrl::AJAX_FAILED_TYPE_FORM_ERROR);
        }

        $info = [];
        $info['name'] = $params['name'];
        $info['_key'] = $params['key'];
        $info['status_color'] = isset($params['color']) ? $params['color']:'';
        $info['is_system'] = '0';
        if (isset($params['description'])) {
            $info['description'] = $params['description'];
        }
        if (isset($params['font_awesome'])) {
            $info['font_awesome'] = $params['font_awesome'];
        }


        $model = new IssuePriorityModel();
        $row = $model->getByName($info['name']);
        if (isset($row['id'])) {
            $this->ajaxFailed('提示', '该名称已经被使用', BaseCtrl::AJAX_FAILED_TYPE_TIP);
        }

        list($ret, $msg) = $model->insertItem($info);
        if ($ret) {
            $this->ajaxSuccess('操作成功');
        } else {
            $this->ajaxFailed('服务器错误', '插入数据失败,详情:' . $msg);
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
        $errorMsg = [];
        if (empty($params)) {
            $this->ajaxFailed('错误', '没有提交表单数据');
        }

        if (!isset($params['name']) || empty($params['name'])) {
            $errorMsg['name'] = '参数错误';
        }

        if (!empty($errorMsg)) {
            $this->ajaxFailed('参数错误', $errorMsg, BaseCtrl::AJAX_FAILED_TYPE_FORM_ERROR);
        }

        $id = (int)$id;
        $model = new IssuePriorityModel();
        $info = [];
        $info['name'] = $params['name'];
        if (isset($params['description'])) {
            $info['description'] = $params['description'];
        }
        if (isset($params['font_awesome'])) {
            $info['font_awesome'] = $params['font_awesome'];
        }
        if (isset($params['color'])) {
            $info['color'] = $params['color'];
        }

        $row = $model->getByName($info['name']);
        if (isset($row['id']) && ($row['id'] != $id)) {
            $this->ajaxFailed('提示', '该名称已经被使用', BaseCtrl::AJAX_FAILED_TYPE_TIP);
        }
        unset($row);

        $ret = $model->updateItem($id, $info);
        if ($ret) {
            $this->ajaxSuccess('操作成功');
        } else {
            $this->ajaxFailed('服务器错误', '更新数据失败,详情');
        }
    }

    /**
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
        $model = new IssuePriorityModel();
        $ret = $model->deleteItem($id);
        if (!$ret) {
            $this->ajaxFailed('服务器错误', '删除数据失败');
        } else {
            $this->ajaxSuccess('操作成功');
        }
    }
}
