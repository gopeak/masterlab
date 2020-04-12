<?php

namespace main\app\ctrl\admin;

use main\app\classes\PermissionGlobal;
use main\app\ctrl\BaseAdminCtrl;
use main\app\event\CommonPlacedEvent;
use main\app\event\Events;
use main\app\model\issue\IssueModel;
use main\app\model\project\ProjectCatalogLabelModel;
use main\app\model\project\ProjectModel;
use main\app\model\ActivityModel;
use main\app\model\project\ProjectLabelModel;
use main\app\model\project\ProjectUserRoleModel;
use main\app\model\project\ProjectVersionModel;
use main\app\model\project\ProjectModuleModel;
use main\app\classes\ProjectLogic;
use main\app\classes\UserAuth;
use main\app\classes\PermissionLogic;

/**
 * 后台的项目管理模块
 */
class Project extends BaseAdminCtrl
{
    public static $page_sizes = [10, 20, 50, 100];

    /**
     * 后台的项目管理的构造函数
     * Project constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct();
        $userId = UserAuth::getId();
        $this->addGVar('top_menu_active', 'system');
        $check = PermissionGlobal::check($userId, PermissionGlobal::MANAGER_PROJECT_PERM_ID);

        if (!$check) {
            $this->error('权限错误', '您还未获取此模块的权限！');
            exit;
        }
    }

    public function pageIndex()
    {
        $data = [];
        $data['title'] = 'Projects';
        $data['nav_links_active'] = 'project';
        $data['left_nav_active'] = 'list';
        $this->render('twig/admin/project/project_list.twig', $data);
    }

    public function pageArchived()
    {
        $data = [];
        $data['title'] = 'Projects';
        $data['nav_links_active'] = 'project';
        $data['left_nav_active'] = 'archived';
        $this->render('twig/admin/project/project_list_archived.twig', $data);
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
     * @param int $is_archived
     * @throws \Exception
     */
    public function filterData($page = 1, $is_archived = 0)
    {
        $is_archived = intval($is_archived);
        $pageLength = 30;

        $projectLogic = new ProjectLogic();

        if ($is_archived) {
            $projects = $projectLogic->projectListJoinUserArchived();
        } else {
            $projects = $projectLogic->projectListJoinUser();
        }

        foreach ($projects as &$item) {
            $item = ProjectLogic::formatProject($item);
            if ($item['archived'] == 'Y') {
                $item['name'] = $item['name'] . ' [已归档]';
            }
        }
        unset($item);

        $data['total'] = count($projects);
        $data['page'] = $page;
        $data['pages'] = $pageLength;
        $data['rows'] = array_slice($projects, $page - 1, $pageLength); //$projects;

        $this->ajaxSuccess('操作成功', $data);
    }


    /**
     * 项目归档
     * @throws \Exception
     */
    public function doArchived()
    {
        $projectId = null;
        if (isset($_REQUEST['project_id'])) {
            $projectId = (int)$_REQUEST['project_id'];
        }
        if (empty($projectId)) {
            $this->ajaxFailed('参数错误', '参数错误');
        }

        $model = new ProjectModel();
        $ret = $model->updateById(['archived' => 'Y'], $projectId);

        if (!$ret) {
            $this->ajaxFailed('服务器错误', '更新数据失败');
        } else {
            // 分发事件
            $event = new CommonPlacedEvent($this, $project=$model->getById($projectId));
            $this->dispatcher->dispatch($event,  Events::onProjectArchive);
            $this->ajaxSuccess('归档成功');
        }
    }

    /**
     * 删除项目
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

        $currentUid = $uid = UserAuth::getId();
        $model = $projectModel = new ProjectModel($uid);
        $project = $projectModel->getById($projectId);

        $model->db->beginTransaction();

        $retDelProject = $model->deleteById($projectId);
        if ($retDelProject) {
            // 删除对应的事项
            $issueModel = new IssueModel();
            $issueModel->deleteItemsByProjectId($projectId);

            // 删除版本
            $projectVersionModel = new ProjectVersionModel($uid);
            $projectVersionModel->deleteByProject($projectId);

            // 删除模块
            $projectModuleModel = new ProjectModuleModel($uid);
            $projectModuleModel->deleteByProject($projectId);

            // 删除标签
            $projectLabelModel = new ProjectLabelModel();
            $projectLabelModel->deleteByProject($projectId);

            // 删除分类
            $projectCatalogLabelModel = new ProjectCatalogLabelModel();
            $projectCatalogLabelModel->deleteByProject($projectId);

            // 删除初始化的角色
            $projectUserRoleModel = new ProjectUserRoleModel();
            $projectUserRoleModel->deleteByProject($projectId);

            // 分发事件
            $event = new CommonPlacedEvent($this, $project);
            $this->dispatcher->dispatch($event,  Events::onProjectDelete);

            $activityModel = new ActivityModel();
            $activityInfo = [];
            $activityInfo['action'] = '删除了项目';
            $activityInfo['type'] = ActivityModel::TYPE_PROJECT;
            $activityInfo['obj_id'] = $projectId;
            $activityInfo['title'] = $project['name'];
            $activityModel->insertItem($currentUid, $projectId, $activityInfo);
        }

        $model->db->commit();
        $this->ajaxSuccess('操作成功');
    }
}
