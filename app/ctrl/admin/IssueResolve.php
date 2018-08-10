<?php

namespace main\app\ctrl\admin;

use main\app\ctrl\BaseAdminCtrl;
use main\app\model\issue\IssueResolveModel;

/**
 * 解决结果管理控制器
 */
class IssueResolve extends BaseAdminCtrl
{

    public function index()
    {
        $data = [];
        $data['title'] = 'Users';
        $data['nav_links_active'] = 'issue';
        $data['sub_nav_active'] = 'issue_attribute';
        $data['left_nav_active'] = 'resolve';
        $this->render('gitlab/admin/issue_resolve.php', $data);
    }

    public function fetchAll()
    {
        $model = new IssueResolveModel();
        $issue_resolves = $model->getAll(false);
        $data = [];
        $data['issue_resolve'] = $issue_resolves;

        $this->ajaxSuccess('', $data);
    }

    public function get($id)
    {
        $id = (int)$id;
        $model = new IssueResolveModel();
        $row = $model->getById($id);

        $this->ajaxSuccess('ok', (object)$row);
    }

    /**
     * @param array $params
     */
    public function add($params = null)
    {
        if (empty($params)) {
            $errorMsg['tip'] = '参数错误';
        }

        if (!isset($params['name']) || empty($params['name'])) {
            $errorMsg['field']['name'] = '参数错误';
        }

        if (isset($params['name']) && empty($params['name'])) {
            $errorMsg['field']['name'] = 'name_is_empty';
        }

        if (!empty($errorMsg)) {
            $this->ajaxFailed($errorMsg, [], 600);
        }

        $info = [];
        $info['name'] = $params['name'];
        $info['is_system'] = '0';
        if (isset($params['description'])) {
            $info['description'] = $params['description'];
        }
        if (isset($params['font_awesome'])) {
            $info['font_awesome'] = $params['font_awesome'];
        }

        $model = new IssueResolveModel();
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
     * 更新
     * @param $id
     * @param $params
     */
    public function update($params = [])
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
        $errorMsg = [];
        if (empty($params)) {
            $errorMsg['tip'] = '参数错误';
        }

        if (!isset($params['name']) || empty($params['name'])) {
            $errorMsg['field']['name'] = '参数错误';
        }

        if (!empty($errorMsg)) {
            $this->ajaxFailed($errorMsg, [], 600);
        }

        $id = (int)$id;
        $model = new IssueResolveModel();
        $info = [];
        $info['name'] = $params['name'];
        if (isset($params['description'])) {
            $info['description'] = $params['description'];
        }
        if (isset($params['font_awesome'])) {
            $info['font_awesome'] = $params['font_awesome'];
        }
        $row = $model->getByName($info['name']);
        if (isset($row['id']) && ($row['id'] != $id)) {
            $this->ajaxFailed('name_exists', [], 600);
        }
        unset($row);

        $ret = $model->updateById($id, $info);
        if ($ret) {
            $this->ajaxSuccess('ok');
        } else {
            $this->ajaxFailed('server_error', [], 500);
        }
    }

    /**
     * 删除
     * @param $id
     */
    public function delete()
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
        if (empty($id)) {
            $this->ajaxFailed('参数错误');
        }
        $id = (int)$id;
        $model = new IssueResolveModel();
        $ret = $model->deleteById($id);
        if (!$ret) {
            $this->ajaxFailed('delete_failed');
        } else {
            $this->ajaxSuccess('success');
        }
    }
}
