<?php

namespace main\app\ctrl\admin;

use main\app\ctrl\BaseAdminCtrl;
use main\app\model\project\ProjectModel;

/**
 * 系统管理的项目模块
 */
class Project extends BaseAdminCtrl
{
    public static $page_sizes = [10,20,50,100];

    public function index()
    {
        $data = [];

        $projectModel = new ProjectModel();
        $list = $projectModel->getAll();

        // $data['list'] = $list;
        $data['title'] = 'Projects';
        $data['nav_links_active'] = 'project';
        $data['left_nav_active'] = 'list';
        $this->render('gitlab/admin/project_list.php', $data);
    }

    public function gets()
    {
        $projectModel = new ProjectModel();
        $rows = $projectModel->getNormal();
        $this->ajaxSuccess('', $rows);
    }

    public function filterData($page = 1, $page_size = 20)
    {
        $projectModel = new ProjectModel();
        list($rows, $total) = $projectModel->getFilter($page, $page_size);

        $data['total'] = $total;
        $data['page'] = $page;
        $data['pages'] = ceil($total / $page_size);
        $data['rows'] = $rows;

        $this->ajaxSuccess('', $data);
    }


    public function category()
    {
        $data = [];
        $data['title'] = 'Projects-category';
        $data['nav_links_active'] = 'project';
        $data['left_nav_active'] = 'category';
        $this->render('gitlab/admin/ProjectCategory.php', $data);
    }


    public function update($project_id, $params)
    {
        if (empty($uid)) {
            $this->ajaxFailed('no_uid');
        }
        // @todo 全局权限
        $model = new ProjectModel();
        $ret = $model->updateById($project_id, $params);
        if (!$ret) {
            $this->ajaxFailed('delete_failed');
        } else {
            $this->ajaxSuccess('success');
        }
    }

    /**
     * 删除项目
     * @param $project_id
     */
    public function delete($project_id)
    {
        if (empty($uid)) {
            $this->ajaxFailed('no_uid');
        }
        // @todo 全局权限
        $model = new ProjectModel();
        $ret = $model->deleteById($project_id);
        if (!$ret) {
            $this->ajaxFailed('delete_failed');
        } else {
            $this->ajaxSuccess('success');
        }
    }
}
