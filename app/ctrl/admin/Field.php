<?php

namespace main\app\ctrl\admin;

use main\app\classes\UserLogic;
use main\app\ctrl\BaseAdminCtrl;
use main\app\model\user\UserGroupModel;
use main\app\model\field\FieldModel;
use main\app\model\field\FieldTypeModel;

/**
 * 字段
 */
class Field extends BaseAdminCtrl
{

    public function index()
    {
        $data = [];
        $data['title'] = 'Users';
        $data['nav_links_active'] = 'issue';
        $data['sub_nav_active'] = 'issue_attribute';
        $data['left_nav_active'] = 'field';
        $this->render('gitlab/admin/field.php', $data);
    }

    public function fetchAll()
    {
        $model = new FieldModel();
        $data['fields'] = $model->getAll(false);

        $model = new FieldTypeModel();
        $data['field_types'] = $model->getAll(false);

        $this->ajaxSuccess('', $data);
    }

    public function get($id)
    {
        $id = (int)$id;
        $model = new FieldModel();
        $row = $model->getRowById($id);
        $row['options'] = json_decode($row['options']);
        $this->ajaxSuccess('ok', (object)$row);
    }

    /**
     * 新增字段
     * @param array $params
     */
    public function add($params = null)
    {
        if (empty($params)) {
            $error_msg['tip'] = 'param_is_empty';
        }

        if (!isset($params['field_type_id']) || empty($params['field_type_id'])) {
            $error_msg['field']['field_type_id'] = 'param_is_empty';
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
        $info['type'] = $params['field_type_id'];
        $info['is_system'] = '0';
        if (isset($params['description'])) {
            $info['description'] = $params['description'];
        }
        if (isset($params['options'])) {
            $info['options'] = $params['options'];
        }
        $model = new FieldModel();
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

        $info = [];
        $info['name'] = $params['name'];
        if (isset($params['field_type_id'])) {
            $info['field_type_id'] = $params['field_type_id'];
        }
        if (isset($params['description'])) {
            $info['description'] = $params['description'];
        }
        if (isset($params['options'])) {
            $info['options'] = $params['options'];
        }

        $model = new FieldModel();
        $group = $model->getByName($info['name']);
        //var_dump($group);
        if (isset($group['id']) && ($group['id'] != $id)) {
            //$this->ajaxFailed('name_exists', [], 600);
        }

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
        $model = new FieldModel();
        $ret = $model->deleteById($id);
        if (!$ret) {
            $this->ajaxFailed('delete_failed');
        } else {
            $this->ajaxSuccess('success');
        }
    }
}
