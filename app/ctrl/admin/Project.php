<?php

namespace main\app\ctrl\admin;

use main\app\ctrl\BaseAdminCtrl;
use main\app\model\project\ProjectListCountModel;
use main\app\model\project\ProjectModel;
use main\app\model\OrgModel;
use main\app\classes\ProjectLogic;

/**
 * 系统管理的项目模块
 */
class Project extends BaseAdminCtrl
{
    public static $page_sizes = [10, 20, 50, 100];

    public function pageIndex()
    {
        $data = [];

        // $data['list'] = $list;
        $data['title'] = 'Projects';
        $data['nav_links_active'] = 'project';
        $data['left_nav_active'] = 'list';
        $this->render('gitlab/admin/project_list.php', $data);
    }

    /**
     * 获取关联用户的项目数据
     * @throws \Exception
     */
    public function gets()
    {
        $projectLogic = new ProjectLogic();
        $rows = $projectLogic->projectListJoinUser();
        $this->ajaxSuccess('ok', $rows);
    }

    /**
     * 项目查询
     * @param int $page
     * @throws \Exception
     */
    public function filterData($page = 1)
    {
        $pageLength = 30;

        $projectLogic = new ProjectLogic();
        $projects = $projectLogic->projectListJoinUser();

        foreach ($projects as &$item) {
            $item = ProjectLogic::formatProject($item);
        }
        unset($item);

        $data['total'] = count($projects);
        $data['page'] = $page;
        $data['pages'] = $pageLength;
        $data['rows'] = array_slice($projects, $page-1, $pageLength); //$projects;

        $this->ajaxSuccess('', $data);
    }


    /**
     * 更新
     * @param $params
     * @throws \Exception
     */
    public function update($params)
    {
        $projectId = null;
        if (isset($_GET['_target'][3])) {
            $projectId = (int)$_GET['_target'][3];
        }
        if (isset($_REQUEST['project_id'])) {
            $projectId = (int)$_REQUEST['project_id'];
        }
        if (empty($projectId)) {
            $this->ajaxFailed('参数错误', '项目id不能为空');
        }
        // @todo 全局权限
        $model = new ProjectModel();
        $ret = $model->updateById($projectId, $params);
        if (!$ret) {
            $this->ajaxFailed('服务器错误', '更新数据失败');
        } else {
            $this->ajaxSuccess('success');
        }
    }


    /**
     * 删除
     * @throws \Exception
     */
    public function delete()
    {
        $projectId = null;
        $projectTypeId = null;

        if (isset($_GET['_target'][3])) {
            $projectId = (int)$_GET['_target'][3];
        }
        if (isset($_REQUEST['project_id'])) {
            $projectId = (int)$_REQUEST['project_id'];
        }
        if (empty($projectId)) {
            $this->ajaxFailed('参数错误', '项目id不能为空');
        }

        if (isset($_REQUEST['project_type_id'])) {
            $projectTypeId = (int)$_REQUEST['project_type_id'];
        }
        if (empty($projectTypeId)) {
            $this->ajaxFailed('参数错误', '项目类型id不能为空');
        }

        $model = new ProjectModel();
        $model->db->beginTransaction();

        $ret1 = $model->deleteById($projectId);
        $projectListCountModel = new ProjectListCountModel();
        $ret2 = $projectListCountModel->decrByTypeid($projectTypeId);
        if ($ret1 && $ret2) {
            $model->db->commit();
            $this->ajaxSuccess('success');
        } else {
            $model->db->rollBack();
            $this->ajaxFailed('服务器错误', '删除数据失败');
        }
    }
}
