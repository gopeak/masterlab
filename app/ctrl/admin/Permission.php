<?php

namespace main\app\ctrl\admin;


use main\app\ctrl\BaseAdminCtrl;
use main\app\model\permission\PermissionRoleModel;
use main\app\model\permission\PermissionModel;
use main\app\model\permission\PermissionRoleRelationModel;


/**
 * 系统角色权限控制器
 */
class Permission extends BaseAdminCtrl
{


    public function role()
    {
        $data = [];
        $data['title'] = 'System';
        $data['nav_links_active'] = 'system';
        $data['sub_nav_active'] = 'security';
        $data['left_nav_active'] = 'permission';
        $this->render('gitlab/admin/permission_role.php', $data);
    }

    public function roleFetch()
    {
        $model = new PermissionRoleModel();
        $roles = $model->getsAll();

        unset($model);

        $data = [];
        $data['roles'] = $roles;
        $this->ajaxSuccess('ok', $data);
    }

    public function roleGet($id)
    {
        $id = (int)$id;
        $model = new PermissionRoleModel();
        $group = $model->getById($id);

        unset($model);
        $this->ajaxSuccess('ok', (object)$group);
    }

    public function roleEdit($roleId, $permissionIds)
    {
        if ( empty($roleId) || empty($permissionIds) )
        {
            $this->ajaxFailed(' param_is_empty ', [], 600);
        }

        $permissionRoleRelation = new PermissionRoleRelationModel();

        $rows = $permissionRoleRelation->getPermIdsByRoleId($roleId);

        if ( !empty($rows) )
        {
            $permissionRoleRelation->deleteByRoleId($roleId);
        }

        $permIdsList = explode(',', $permissionIds);
        $permIdsList = array_filter($permIdsList);

        if ( !is_array($permIdsList) )
        {
            $this->ajaxFailed(' param_is_empty ', [], 600);
        }

        foreach ( $permIdsList as $v )
        {
            $permissionRoleRelation->add($roleId, $v);
        }

        unset($permissionRoleRelation);
        $this->ajaxSuccess('ok', []);
    }

    public function roleTree($roleId)
    {

        $permissionModel = new PermissionModel();

        $permissionRoleRelationModel = new PermissionRoleRelationModel();

        $parentList = $permissionModel->getParent();

        $childrenList = $permissionModel->getChildren();

        $permIdList = $permissionRoleRelationModel->getPermIdsByRoleId($roleId);

        unset($permissionModel);
        unset($permissionRoleRelationModel);

        //组装数据
        $data = [];
        $i = 0;
        foreach ($parentList as $p)
        {
            $data[$i]['id'] = $p['id'];
            $data[$i]['text'] = $p['name'];
            $data[$i]['state'] = ['opened' => false];

            $data[$i]['children'] = [];
            $j = 0;
            foreach ($childrenList as $k => $c)
            {
                if ($c['parent_id'] == $p['id'])
                {
                    $data[$i]['children'][$j]['id'] = $k;
                    $data[$i]['children'][$j]['text'] = $c['name'];
                    $data[$i]['children'][$j]['state'] = in_array($k,
                    $permIdList) ? ['selected' => true] : ['selected' => false];
                    $j++;
                }
            }
            $i++;
        }
        @header('Content-Type:application/json');
        echo json_encode($data);
        exit;
    }

}
