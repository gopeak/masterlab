<?php

namespace main\app\ctrl\admin;

use main\app\classes\UserLogic;
use main\app\ctrl\BaseAdminCtrl;
use main\app\model\user\UserGroupModel;
use main\app\model\user\UserModel;
use main\app\model\user\GroupModel;
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

    public function index()
    {
        $data = [];
        $data['title'] = 'Users';
        $data['nav_links_active'] = 'issue';
        $data['sub_nav_active'] = 'issue_type';
        $data['left_nav_active'] = 'type_scheme';
        $this->render('gitlab/admin/issue_type_scheme.php', $data);
    }

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

        $issue_types = $params['issue_types'];
        if (!is_array($issue_types)) {
            $this->ajaxFailed('param_is_error');
        }

        if (!empty($error_msg)) {
            $this->ajaxFailed($error_msg, [], 600);
        }

        $info = [];
        $info['name'] = $params['name'];
        $info['is_default'] = '0';
        if (isset($params['description'])) {
            $info['description'] = $params['description'];
        }

        $model = new IssueTypeSchemeModel();
        if (isset($model->getByName($info['name'])['id'])) {
            $this->ajaxFailed('name_exists', [], 600);
        }

        list($ret, $msg) = $model->insert($info);
        if ($ret) {
            if (isset($params['issue_types'])) {
                $issueTypeLogic = new IssueTypeLogic();
                $issueTypeLogic->updateSchemeTypes($msg, $params['issue_types']);
            }
            $this->ajaxSuccess('ok');
        } else {
            $this->ajaxFailed('server_error:' . $msg, [], 500);
        }
    }

    /**
     *
     * @param $id
     * @param $params
     */
    public function update($params = null)
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

        $info = [];
        $info['name'] = $params['name'];
        if (isset($params['description'])) {
            $info['description'] = $params['description'];
        }


        $model = new IssueTypeSchemeModel();
        $row = $model->getByName($info['name']);
        //var_dump($row);
        if (isset($row['id']) && ($row['id'] != $id)) {
            $this->ajaxFailed('name_exists', [], 600);
        }

        $ret = $model->updateById($id, $info);
        if ($ret) {
            if (isset($params['issue_types'])) {
                $issue_types = $params['issue_types'];
                if (is_array($issue_types)) {
                    $issueTypeLogic = new IssueTypeLogic();
                    $issueTypeLogic->updateSchemeTypes($id, $params['issue_types']);
                }
            }
            $this->ajaxSuccess('ok');
        } else {
            $this->ajaxFailed('server_error', [], 500);
        }
    }

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
            $this->ajaxFailed('param_is_empty');
        }
        $id = (int)$id;
        $model = new IssueTypeSchemeModel();
        $ret = $model->deleteById($id);
        if (!$ret) {
            $this->ajaxFailed('delete_failed');
        } else {
            $model->deleteBySchemeId($id);
            $this->ajaxSuccess('success');
        }
    }
}
