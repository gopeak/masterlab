<?php

namespace main\app\ctrl\admin;

use main\app\classes\UserLogic;
use main\app\ctrl\BaseAdminCtrl;
use main\app\model\user\UserGroupModel;
use main\app\model\user\UserModel;
use main\app\model\user\GroupModel;
use main\app\model\issue\IssueResolveModel;
use main\app\model\issue\IssueTypeSchemeItemsModel;
use main\app\model\issue\IssueTypeSchemeModel;
use main\app\classes\IssueStatusLogic;

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
        $group = $model->getById($id);

        $this->ajaxSuccess('ok', (object)$group);
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

    public function delete($id)
    {
        if (empty($id)) {
            $this->ajaxFailed('param_is_empty');
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
