<?php

namespace main\app\ctrl\admin;

use main\app\classes\UserLogic;
use main\app\ctrl\BaseAdminCtrl;
use main\app\model\user\UserGroupModel;
use main\app\model\user\UserModel;
use main\app\model\user\GroupModel;
use main\app\model\issue\IssueStatusModel;
use main\app\model\issue\IssueTypeSchemeItemsModel;
use main\app\model\issue\IssueTypeSchemeModel;
use main\app\classes\IssueStatusLogic;

/**
 * 问题状态管理控制器
 */
class IssueStatus extends BaseAdminCtrl
{

    public function index()
    {
        $data = [];
        $data['title'] = 'Users';
        $data['nav_links_active'] = 'issue';
        $data['sub_nav_active'] = 'issue_attribute';
        $data['left_nav_active'] = 'status';
        $this->render('gitlab/admin/issue_status.php', $data);
    }

    public function fetchAll()
    {
        $issueStatusLogic = new IssueStatusLogic();
        $issueStatus = $issueStatusLogic->getAdminIssueStatus();
        $data = [];
        $data['issue_status'] = $issueStatus;

        $this->ajaxSuccess('', $data);
    }

    public function get($id)
    {
        $id = (int)$id;
        $model = new IssueStatusModel();
        $group = $model->getById($id);

        $this->ajaxSuccess('ok', (object)$group);
    }

    /**
     * @param array $params
     */
    public function add($params = null)
    {
        if (empty($params)) {
            $errorMsg['tip'] = 'param_is_empty';
        }

        if (!isset($params['name']) || empty($params['name'])) {
            $errorMsg['field']['name'] = 'param_is_empty';
        }

        if (isset($params['name']) && empty($params['name'])) {
            $errorMsg['field']['name'] = 'name_is_empty';
        }

        if (!empty($errorMsg)) {
            $this->ajaxFailed($errorMsg, [], 600);
        }

        $info = [];
        $info['name'] = $params['name'];
        $info['key'] = $params['key'];
        $info['is_system'] = '0';
        if (isset($params['description'])) {
            $info['description'] = $params['description'];
        }
        if (isset($params['font_awesome'])) {
            $info['font_awesome'] = $params['font_awesome'];
        }

        $model = new IssueStatusModel();
        if (isset($model->getByName($info['name'])['id'])) {
            $this->ajaxFailed('name_exists', [], 600);
        }
        if (isset($model->getByKey($info['key'])['id'])) {
            $this->ajaxFailed('key_exists', [], 600);
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
    public function update($id, $params)
    {
        $errorMsg = [];
        if (empty($params)) {
            $errorMsg['tip'] = 'param_is_empty';
        }

        if (!isset($params['name']) || empty($params['name'])) {
            $errorMsg['field']['name'] = 'param_is_empty';
        }

        if (!empty($errorMsg)) {
            $this->ajaxFailed($errorMsg, [], 600);
        }

        $id = (int)$id;
        $model = new IssueStatusModel();
        $info = [];
        $info['name'] = $params['name'];
        if (isset($params['description'])) {
            $info['description'] = $params['description'];
        }
        if (isset($params['font_awesome'])) {
            $info['font_awesome'] = $params['font_awesome'];
        }
        if (isset($params['key'])) {
            $info['key'] = $params['key'];
            $row = $model->getByKey($info['key']);
            //var_dump($group);
            if (isset($row['id']) && ($row['id'] != $id)) {
                $this->ajaxFailed('key_exists', [], 600);
            }
            unset($row);
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
        $model = new IssueStatusModel();
        $ret = $model->deleteById($id);
        if (!$ret) {
            $this->ajaxFailed('delete_failed');
        } else {
            $this->ajaxSuccess('success');
        }
    }
}
