<?php

namespace main\app\ctrl\admin;

use main\app\ctrl\BaseAdminCtrl;
use main\app\model\project\ProjectCategoryModel;

/**
 * 系统管理的项目分类模块
 */
class ProjectCategory extends BaseAdminCtrl
{

    static $page_sizes = [ 10, 20, 50, 100 ];


    public function _list()
    {

        $data = [];
        $data['title'] = 'Users';
        $this->render('gitlab/admin/users.php', $data);
    }

    public function all()
    {

        $projectCategoryModel = new ProjectCategoryModel();
        $rows = $projectCategoryModel->getAll();
        $this->ajaxSuccess('ok', $rows);
    }

    /**
     * 添加
     */
    public function add($name, $description)
    {

        $name = trimStr($name);
        $description = trimStr($description);

        if (empty($name)) {
            $this->ajaxFailed('param_error:name_is_empty');
        }

        $projectCategoryModel = new ProjectCategoryModel();
        $category = $projectCategoryModel->getByName($name);
        if (isset($category['name'])) {
            $this->ajaxFailed('project_category_name_exists');
        }

        $info = [];
        $info['name'] = $name;
        $info['description'] = $description;

        $ret = $projectCategoryModel->insert($info);
        if ($ret[0]) {
            $this->ajaxSuccess('add_success');
        } else {
            $this->ajaxFailed('add_failed');
        }

    }

    public function update($project_id, $name, $description)
    {

        $name = trimStr($name);
        $description = trimStr($description);
        $project_id = intval($project_id);
        if (empty($project_id)) {
            $this->ajaxFailed('param_error:project_id_is_empty');
        }

        if (empty($name)) {
            $this->ajaxFailed('param_error:name_is_empty');
        }

        $projectCategoryModel = new ProjectCategoryModel();
        $category = $projectCategoryModel->getByName($name);
        if (isset($category['name']) && $category['id'] != $project_id) {
            $this->ajaxFailed('project_category_name_exists');
        }

        $info = [];
        $info['name'] = $name;
        $info['description'] = $description;

        $ret = $projectCategoryModel->updateById($project_id, $info);
        if ($ret[0]) {
            $this->ajaxSuccess('update_success');
        } else {
            $this->ajaxFailed('update_failed');
        }
    }

    /**
     * 删除
     */
    public function delete($project_id)
    {

        // @todo 全局权限
        $project_id = intval($project_id);
        if (empty($project_id)) {
            $this->ajaxFailed('param_error:project_id_is_empty');
        }

        $projectCategoryModel = new ProjectCategoryModel();
        $ret = $projectCategoryModel->deleteById($project_id);
        if (!$ret) {
            $this->ajaxFailed('delete_failed');
        } else {
            $this->ajaxSuccess('success');
        }
    }
}
