<?php

namespace main\app\ctrl;

use main\app\classes\AgileLogic;
use main\app\classes\ConfigLogic;
use main\app\classes\NotifyLogic;
use main\app\classes\UserAuth;
use main\app\classes\UserLogic;
use main\app\classes\RewriteUrl;
use main\app\classes\PermissionLogic;
use main\app\classes\IssueLogic;
use main\app\classes\IssueFilterLogic;
use main\app\model\CacheKeyModel;
use main\app\model\ActivityModel;
use main\app\model\agile\SprintModel;
use main\app\model\agile\AgileBoardModel;
use main\app\model\agile\AgileBoardColumnModel;
use main\app\model\issue\IssueModel;
use main\app\model\issue\IssueDescriptionTemplateModel;
use main\app\model\issue\IssueStatusModel;
use main\app\model\issue\IssueResolveModel;
use main\app\model\project\ProjectFlagModel;


class Agile extends BaseUserCtrl
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 待办事项页面
     * @throws \Exception
     */
    public function pageBacklog()
    {
        $data = [];
        $data['title'] = 'Backlog';
        $data['top_menu_active'] = 'project';
        $data['page_type'] = 'backlog';
        $data['nav_links_active'] = 'backlog';
        $data['sub_nav_active'] = 'all';
        $data['query_str'] = http_build_query($_GET);
        $data['avl_sort_fields'] = IssueFilterLogic::$avlSortFields;
        $data['sort_field'] = isset($_GET['sort_field']) ? $_GET['sort_field'] : '';
        $data['sort_by'] = isset($_GET['sort_by']) ? $_GET['sort_by'] : '';
        $data['default_sort_field'] =  'weight';
        $data['default_sort_by'] =  'desc';

        $data = RewriteUrl::setProjectData($data);
        // 权限判断
        if (!empty($data['project_id'])) {
            $data['issue_main_url'] = ROOT_URL . substr($data['project_root_url'], 1) . '/issues';
            if (!$this->isAdmin && !PermissionLogic::checkUserHaveProjectItem(UserAuth::getId(), $data['project_id'])) {
                $this->warn('提 示', '您没有权限访问该项目,请联系管理员申请加入该项目');
                die;
            }
        }
        $data['sprint_id'] = '';
        ConfigLogic::getAllConfigs($data);

        $descTplModel = new IssueDescriptionTemplateModel();
        $data['description_templates'] = $descTplModel->getAll(false);

        $data['sprints'] = [];
        $data['active_sprint'] = [];
        if (!empty($data['project_id'])) {
            $sprintModel = new SprintModel();
            $data['sprints'] = $sprintModel->getItemsByProject($data['project_id']);
            $data['active_sprint'] = $sprintModel->getActive($data['project_id']);
        }

        $this->render('gitlab/agile/backlog.php', $data);
    }

    /**
     * 迭代页面
     * @throws \Exception
     */
    public function pageSprint()
    {
        $data = [];
        $data['title'] = 'Backlog';
        $data['top_menu_active'] = 'project';
        $data['page_type'] = 'sprint';
        $data['nav_links_active'] = 'sprints';
        $data['sub_nav_active'] = 'all';
        $data['is_sprint'] = true;
        $data['query_str'] = http_build_query($_GET);
        $data['avl_sort_fields'] = IssueFilterLogic::$avlSortFields;
        $data['sort_field'] = isset($_GET['sort_field']) ? $_GET['sort_field'] : '';
        $data['sort_by'] = isset($_GET['sort_by']) ? $_GET['sort_by'] : '';
        $data['default_sort_by'] =  'desc';
        $data = RewriteUrl::setProjectData($data);
        // 权限判断
        if (!empty($data['project_id'])) {
            $data['issue_main_url'] = ROOT_URL . substr($data['project_root_url'], 1) . '/issues';
            if (!$this->isAdmin && !PermissionLogic::checkUserHaveProjectItem(UserAuth::getId(), $data['project_id'])) {
                $this->warn('提 示', '您没有权限访问该项目,请联系管理员申请加入该项目');
                die;
            }
        }
        $sprintId = '';
        if (isset($_GET['_target'][2])) {
            $sprintId = (int)$_GET['_target'][2];
        }
        if (isset($_GET['id'])) {
            $sprintId = (int)$_GET['id'];
        }
        if (empty($sprintId)) {
            $model = new SprintModel();
            $activeSprint = $model->getActive($data['project_id']);
            if (isset($activeSprint['id'])) {
                $sprintId = $activeSprint['id'];
            } else {
                $sprints = $model->getItemsByProject($data['project_id']);
                if (isset($sprints[0]['id'])) {
                    $sprintId = $sprints[0]['id'];
                }
            }
        }
        $data['sprint_id'] = $sprintId;
        ConfigLogic::getAllConfigs($data);

        $issueLogic = new IssueLogic();
        $data['description_templates'] = $issueLogic->getDescriptionTemplates();

        $data['sprints'] = [];
        $data['active_sprint'] = [];
        if (!empty($data['project_id'])) {
            $sprintModel = new SprintModel();
            $data['sprints'] = $sprintModel->getItemsByProject($data['project_id']);
            $data['active_sprint'] = $sprintModel->getActive($data['project_id']);
        }

        $this->render('gitlab/agile/backlog.php', $data);
    }

    /**
     * 看板页面
     * @throws \Exception
     */
    public function pageBoard()
    {
        $data = [];
        $data['title'] = 'Backlog';
        $data['top_menu_active'] = 'project';
        $data['nav_links_active'] = 'kanban';
        $data['sub_nav_active'] = 'all';
        $data['query_str'] = http_build_query($_GET);
        $data = RewriteUrl::setProjectData($data);

        // 权限判断
        if (!empty($data['project_id'])) {
            $data['issue_main_url'] = ROOT_URL . substr($data['project_root_url'], 1) . '/issues';
            if (!$this->isAdmin && !PermissionLogic::checkUserHaveProjectItem(UserAuth::getId(), $data['project_id'])) {
                $this->warn('提 示', '您没有权限访问该项目,请联系管理员申请加入该项目');
                die;
            }
        }

        $agileLogic = new AgileLogic();
        $data['boards'] = $agileLogic->getBoardsByProject($data['project_id']);

        $data['active_sprint_id'] = '';
        $model = new SprintModel();
        $activeSprint = $model->getActive($data['project_id']);
        if (isset($activeSprint['id'])) {
            $data['active_sprint_id'] = $activeSprint['id'];
        } else {
            $sprints = $model->getItemsByProject($data['project_id']);
            if (isset($sprints[0]['id'])) {
                $data['active_sprint_id'] = $sprints[0]['id'];
            }
        }

        $issueLogic = new IssueLogic();
        $data['description_templates'] = $issueLogic->getDescriptionTemplates();

        ConfigLogic::getAllConfigs($data);

        $data['active_sprint'] = [];
        if (!empty($data['project_id'])) {
            $sprintModel = new SprintModel();
            $data['active_sprint'] = $sprintModel->getActive($data['project_id']);
        }
        $data['perm_kanban'] = false;
        if (!empty($data['project_id']) || !empty($this->isAdmin)) {
            $data['perm_kanban'] = PermissionLogic::check($data['project_id'], UserAuth::getId(), PermissionLogic::MANAGE_KANBAN);
        }

        $this->render('gitlab/agile/board.php', $data);
    }

    /**
     * 获取待办事项列表
     * @throws \Exception
     * @throws \ReflectionException
     */
    public function fetchBacklogIssues()
    {
        $projectId = null;
        if (isset($_GET['_target'][2])) {
            $projectId = (int)$_GET['_target'][2];
        }
        if (isset($_GET['id'])) {
            $projectId = (int)$_GET['id'];
        }
        if (empty($projectId)) {
            $this->ajaxFailed('参数错误', '项目id不能为空');
        }
        $issueLogic = new AgileLogic();
        list($fetchRet, $issues) = $issueLogic->getBacklogIssues($projectId);
        if ($fetchRet) {
            $data['issues'] = $issues;
        } else {
            $this->ajaxFailed('服务器错误', $issues);
        }
        $data['sprints'] = $issueLogic->getSprints($projectId);

        $this->ajaxSuccess('success', $data);
    }

    /**
     * 获取已经关闭的事项
     * @throws \Exception
     */
    public function fetchClosedIssuesByProject()
    {
        $projectId = null;
        if (isset($_GET['_target'][2])) {
            $projectId = (int)$_GET['_target'][2];
        }
        if (isset($_GET['id'])) {
            $projectId = (int)$_GET['id'];
        }
        if (empty($projectId)) {
            $this->ajaxFailed('参数错误', '项目id不能为空');
        }
        $issueLogic = new AgileLogic();
        $data['issues'] = $issueLogic->getClosedIssues($projectId);

        $this->ajaxSuccess('success', $data);
    }


    /**
     * 获取项目中的迭代列表
     * @throws \Exception
     */
    public function fetchSprints()
    {
        $projectId = null;
        $issueId = null;
        if (isset($_GET['issue_id'])) {
            $issueId = (int)$_GET['issue_id'];
        }
        if (isset($_GET['_target'][2])) {
            $projectId = (int)$_GET['_target'][2];
        }
        if (isset($_GET['project_id'])) {
            $projectId = (int)$_GET['project_id'];
        }
        if ($issueId && !$projectId) {
            $issueModel = new IssueModel();
            $projectId = $issueModel->getById($issueId)['project_id'];
        }
        if (empty($projectId)) {
            $this->ajaxFailed('参数错误', '项目id不能为空');
        }
        $sprintModel = new SprintModel();
        $data['sprints'] = $sprintModel->getItemsByProject($projectId);

        $this->ajaxSuccess('success', $data);
    }

    /**
     * 获取迭代数据
     * @throws \Exception
     */
    public function fetchSprint()
    {
        $sprintId = null;
        if (isset($_GET['_target'][2])) {
            $sprintId = (int)$_GET['_target'][2];
        }
        if (isset($_REQUEST['sprint_id'])) {
            $sprintId = (int)$_REQUEST['sprint_id'];
        }
        if (empty($sprintId)) {
            $this->ajaxFailed('参数错误', '迭代id不能为空');
        }
        $sprintModel = new SprintModel();
        $sprint = $sprintModel->getRowById($sprintId);
        $this->ajaxSuccess('ok', $sprint);
    }

    /**
     * 添加一个迭代
     * @throws \Exception
     */
    public function addSprint()
    {
        $projectId = null;
        if (isset($_GET['_target'][2])) {
            $projectId = (int)$_GET['_target'][2];
        }
        if (isset($_POST['project_id'])) {
            $projectId = (int)$_POST['project_id'];
        }
        if (empty($projectId)) {
            $this->ajaxFailed('参数错误', '项目id不能为空');
        }
        $model = new SprintModel();
        $activeSprint = $model->getActive($projectId);

        $info = [];
        $info['project_id'] = $projectId;
        $info['name'] = $_POST['params']['name'];
        $info['active'] = '0';
        if (!isset($activeSprint['id'])) {
            $info['active'] = '1';
        }
        if (isset($_POST['params']['description'])) {
            $info['description'] = $_POST['params']['description'];
        }
        if (isset($_POST['params']['start_date'])) {
            $info['start_date'] = $_POST['params']['start_date'];
        }
        if (isset($_POST['params']['start_date'])) {
            $info['end_date'] = $_POST['params']['end_date'];
        }
        $sprintModel = new SprintModel();
        list($ret, $msg) = $sprintModel->insertItem($info);
        if ($ret) {
            $activityModel = new ActivityModel();
            $activityInfo = [];
            $activityInfo['action'] = '创建了迭代';
            $activityInfo['type'] = ActivityModel::TYPE_AGILE;
            $activityInfo['obj_id'] = $msg;
            $activityInfo['title'] = $info['name'];
            $activityModel->insertItem(UserAuth::getId(), $projectId, $activityInfo);

            // email
            $notifyLogic = new NotifyLogic();
            $notifyLogic->send(NotifyLogic::NOTIFY_FLAG_SPRINT_CREATE, $projectId, $msg);

            $this->ajaxSuccess('ok');
        } else {
            $this->ajaxFailed('服务器错误', $msg);
        }
    }

    /**
     * 更新迭代
     * @throws \Exception
     */
    public function updateSprint()
    {
        $sprintId = null;
        if (isset($_GET['_target'][2])) {
            $sprintId = (int)$_GET['_target'][2];
        }
        if (isset($_REQUEST['sprint_id'])) {
            $sprintId = (int)$_REQUEST['sprint_id'];
        }
        if (empty($sprintId)) {
            $this->ajaxFailed('参数错误', '迭代id不能为空');
        }
        $info = [];
        $info['name'] = $_POST['params']['name'];
        if (isset($_POST['params']['description'])) {
            $info['description'] = $_POST['params']['description'];
        }
        if (isset($_POST['params']['start_date'])) {
            $info['start_date'] = $_POST['params']['start_date'];
        }
        if (isset($_POST['params']['start_date'])) {
            $info['end_date'] = $_POST['params']['end_date'];
        }
        $sprintModel = new SprintModel();
        $sprint = $sprintModel->getItemById($sprintId);
        if (empty($sprint)) {
            $this->ajaxFailed('参数错误', '迭代数据错误');
        }

        $changed = false;
        foreach ($info as $key => $value) {
            if ($sprint[$key] != $value) {
                $changed = true;
            }
        }
        if (!$changed) {
            $this->ajaxSuccess('ok');
            return;
        }
        list($ret, $msg) = $sprintModel->updateItem($sprintId, $info);
        if ($ret) {
            $activityModel = new ActivityModel();
            $activityInfo = [];
            $activityInfo['action'] = '更新了迭代';
            $activityInfo['type'] = ActivityModel::TYPE_AGILE;
            $activityInfo['obj_id'] = $sprintId;
            $activityInfo['title'] = $info['name'];
            $activityModel->insertItem(UserAuth::getId(), $sprint['project_id'], $activityInfo);
            $this->ajaxSuccess('ok');
        } else {
            $this->ajaxFailed('服务器错误', $msg);
        }
    }

    /**
     * @throws \Exception
     */
    public function deleteSprint()
    {
        $sprintId = null;
        if (isset($_GET['_target'][2])) {
            $sprintId = (int)$_GET['_target'][2];
        }
        if (isset($_REQUEST['sprint_id'])) {
            $sprintId = (int)$_REQUEST['sprint_id'];
        }
        if (empty($sprintId)) {
            $this->ajaxFailed('参数错误', '迭代id不能为空');
        }

        $sprintModel = new SprintModel();
        $sprint = $sprintModel->getItemById($sprintId);
        if (empty($sprint)) {
            $this->ajaxFailed('参数错误', '迭代数据错误');
        }

        // email
        $notifyLogic = new NotifyLogic();
        $notifyLogic->send(NotifyLogic::NOTIFY_FLAG_SPRINT_REMOVE, $sprint['project_id'], $sprintId);

        $ret = $sprintModel->deleteItem($sprintId);
        if ($ret) {
            $issueModel = new IssueModel();
            $updateInfo = ['sprint' => AgileLogic::BACKLOG_VALUE, 'backlog_weight' => 0];
            $condition = ['sprint' => $sprintId];
            $issueModel->update($updateInfo, $condition);

            $activityModel = new ActivityModel();
            $activityInfo = [];
            $activityInfo['action'] = '删除了迭代';
            $activityInfo['type'] = ActivityModel::TYPE_AGILE;
            $activityInfo['obj_id'] = $sprintId;
            $activityInfo['title'] = $sprint['name'];
            $activityModel->insertItem(UserAuth::getId(), $sprint['project_id'], $activityInfo);

            $this->ajaxSuccess('ok');
        } else {
            $this->ajaxFailed('服务器错误', '数据库删除迭代失败');
        }
    }

    /**
     * 将事项加入到迭代中
     * @throws \Exception
     */
    public function joinSprint()
    {
        $sprintId = null;
        $issueId = null;
        if (isset($_POST['issue_id'])) {
            $issueId = (int)$_POST['issue_id'];
        }
        if (isset($_POST['sprint_id'])) {
            $sprintId = (int)$_POST['sprint_id'];
        }
        if (empty($sprintId) || empty($issueId)) {
            $this->ajaxFailed('参数错误');
        }
        $issueModel = new IssueModel();
        $issue = $issueModel->getById($issueId);
        if (!isset($issue['id'])) {
            $this->ajaxFailed('参数错误', '事项不存在');
        }

        $sprintModel = new SprintModel();
        $sprint = $sprintModel->getItemById($sprintId);
        if (!isset($sprint['id'])) {
            $this->ajaxFailed('参数错误', '迭代事项不存在');
        }

        if ($issue['project_id'] != $sprint['project_id']) {
            $this->ajaxFailed('参数错误', '不同于一个项目');
        }

        $model = new IssueModel();
        list($ret, $msg) = $model->updateById($issueId, ['sprint' => $sprintId, 'sprint_weight' => 0]);
        if ($ret) {
            $this->ajaxSuccess('success');
        } else {
            $this->ajaxFailed('server_error:' . $msg);
        }
    }

    /**
     * 更新事项状态
     * @throws \Exception
     */
    public function updateIssueStatus()
    {
        $statusKey = null;
        $statusId = null;
        if (isset($_POST['status_key'])) {
            $statusKey = $_POST['status_key'];
            $statusId = IssueStatusModel::getInstance()->getIdByKey($statusKey);
        }
        if (empty($statusKey) || empty($statusId)) {
            $this->ajaxFailed('参数错误', '提交的状态参数错误');
        }

        if (isset($_POST['issue_id'])) {
            $issueId = (int)$_POST['issue_id'];
        }
        if (empty($issueId)) {
            $this->ajaxFailed('参数错误', '事项id不能为空');
        }
        if (empty(UserAuth::getId())) {
            $this->ajaxFailed('提示', '您尚未登录', BaseCtrl::AJAX_FAILED_TYPE_TIP);
        }

        $issueModel = new IssueModel();
        $issue = $issueModel->getById($issueId);
        if (!isset($issue['id'])) {
            $this->ajaxFailed('参数错误', '事项不存在');
        }

        $updateInfo = [];
        $updateInfo['status'] = $statusId;

        if (isset($_POST['is_backlog']) && $_POST['is_backlog'] == 'true') {
            $sprintModel = new SprintModel();
            $activeSprint = $sprintModel->getActive($issue['project_id']);
            if (!empty($activeSprint)) {
                $updateInfo['sprint'] = $activeSprint['id'];
            }
        }
        list($ret) = $issueModel->updateById($issueId, $updateInfo);

        // 活动记录
        $currentUid = $this->getCurrentUid();
        $activityModel = new ActivityModel();
        $activityInfo = [];
        $activityInfo['action'] = '更新事项';
        $activityInfo['type'] = ActivityModel::TYPE_ISSUE;
        $activityInfo['obj_id'] = $issueId;
        $activityInfo['title'] = ' ' . $issue['summary'] . ' 状态:' . $statusKey;
        $activityModel->insertItem($currentUid, $issue['project_id'], $activityInfo);
        $this->ajaxSuccess('success', $ret);
    }

    /**
     * 更新待办事项的排序权重
     * @throws \Exception
     */
    public function updateBacklogSprintWeight()
    {
        $prevIssueId = null;
        $nextIssueId = null;
        $issueId = null;
        $type = null;
        if (isset($_POST['issue_id'])) {
            $issueId = (int)$_POST['issue_id'];
        }
        if (isset($_POST['prev_issue_id'])) {
            $prevIssueId = (int)$_POST['prev_issue_id'];
        }
        if (isset($_POST['next_issue_id'])) {
            $nextIssueId = (int)$_POST['next_issue_id'];
        }
        if (isset($_POST['type'])) {
            $type = $_POST['type'];
        }
        if (empty($issueId)) {
            $this->ajaxFailed('参数错误');
        }
        $issueModel = new IssueModel();
        $issue = $issueModel->getById($issueId);
        if (!isset($issue['id'])) {
            $this->ajaxFailed('参数错误', '事项不存在');
        }

        if ($this->isAdmin
            || isset($projectPermArr[\main\app\classes\PermissionLogic::ADMINISTER_PROJECTS])
            || isset($projectPermArr[\main\app\classes\PermissionLogic::MANAGE_SPRINT])
            || isset($projectPermArr[\main\app\classes\PermissionLogic::MANAGE_BACKLOG])
        ) {

        } else {
            $this->ajaxFailed('在当前项目中您没有权限执行此操作');
        }

        $fieldWeight = 'backlog_weight';
        if ($type != 'backlog') {
            $fieldWeight = 'sprint_weight';
        }

        $updateWeight = null;

        // 拖动到顶部
        if (empty($prevIssueId) && !empty($nextIssueId)) {
            $nextWeight = intval($issueModel->getById($nextIssueId)[$fieldWeight]);
            $updateWeight = intval($nextWeight + AgileLogic::ORDER_WEIGHT_OFFSET);
            $issueModel->updateById($issueId, [$fieldWeight => $updateWeight]);
        }
        // 拖动到底部
        if (empty($nextIssueId) && !empty($prevIssueId)) {
            $prevWeight = intval($issueModel->getById($prevIssueId)[$fieldWeight]);
            $updateWeight = intval($prevWeight - AgileLogic::ORDER_WEIGHT_OFFSET);
            $issueModel->updateById($issueId, [$fieldWeight => $updateWeight]);
        }
        // 拖动到两个事项之间
        if (!empty($prevIssueId) && !empty($nextIssueId)) {
            $prevWeight = intval($issueModel->getById($prevIssueId)[$fieldWeight]);
            $updateWeight = intval($prevWeight - intval(AgileLogic::ORDER_WEIGHT_OFFSET / 2));
            $issueModel->updateById($issueId, [$fieldWeight => $updateWeight]);
        }
        if ($updateWeight !== null) {
            $model = new ProjectFlagModel();
            if ($fieldWeight == 'backlog_weight') {
                $flagRow = $model->getByFlag($issue['project_id'], 'backlog_weight');
                $jsonArr = json_decode($flagRow['value'], true);
                if ($jsonArr) {
                    $jsonArr[$issueId] = $updateWeight;
                }
                $saveJson = json_encode($jsonArr);
                $model->updateById($flagRow['id'], ['value' => $saveJson]);
            }
        }
        $this->ajaxSuccess('success');
    }

    /**
     * 设置 Sprint 为活动状态
     * @throws \Exception
     * @throws \Exception
     */
    public function setSprintActive()
    {
        $sprintId = null;
        if (isset($_POST['sprint_id'])) {
            $sprintId = (int)$_POST['sprint_id'];
        }
        if (empty($sprintId)) {
            $this->ajaxFailed('参数错误', '迭代id不能为空');
        }
        $sprintModel = new SprintModel();
        $sprint = $sprintModel->getItemById($sprintId);
        if (!isset($sprint['id'])) {
            $this->ajaxFailed('参数错误', '迭代数据不存在');
        }
        $updateArr = ['active' => '0'];
        $conditionArr = ['project_id' => $sprint['project_id']];
        //var_dump($updateArr, $conditionArr);
        list($upRet, $msg) = $sprintModel->update($updateArr, $conditionArr);
        if (!$upRet) {
            $this->ajaxFailed('server_error:' . $msg);
        }
        CacheKeyModel::getInstance()->clearCache('dict/' . $sprintModel->table);
        list($upRet, $msg) = $sprintModel->updateById($sprintId, ['active' => '1']);
        if ($upRet) {
            $this->ajaxSuccess('success');
        } else {
            $this->ajaxFailed('server_error:' . $msg);
        }
    }

    /**
     * 将事项移动到待办事项
     * @throws \Exception
     */
    public function joinBacklog()
    {
        $issueId = null;
        if (isset($_POST['issue_id'])) {
            $issueId = (int)$_POST['issue_id'];
        }

        if (empty($issueId)) {
            $this->ajaxFailed('参数错误', '事项id不能为空');
        }
        $model = new IssueModel();
        list($ret, $msg) = $model->updateById($issueId, ['sprint' => AgileLogic::BACKLOG_VALUE, 'backlog_weight' => 0]);
        if ($ret) {
            $this->ajaxSuccess('success');
        } else {
            $this->ajaxFailed('server_error:' . $msg);
        }
    }

    /**
     * 将事项移动到关闭列表
     * @throws \Exception
     */
    public function joinClosed()
    {
        $issueId = null;
        if (isset($_POST['issue_id'])) {
            $issueId = (int)$_POST['issue_id'];
        }

        if (empty($issueId)) {
            $this->ajaxFailed('参数错误', '事项id不能为空');
        }
        $model = new IssueModel();
        $resolveClosedId = IssueResolveModel::getInstance()->getIdByKey('done');
        $statusClosedId = IssueStatusModel::getInstance()->getIdByKey('closed');
        list($ret, $msg) = $model->updateById($issueId, ['resolve' => $resolveClosedId, 'status' => $statusClosedId]);
        if ($ret) {
            $this->ajaxSuccess('success');
        } else {
            $this->ajaxFailed('server_error:' . $msg);
        }
    }

    /**
     * 获取迭代的事项
     * @throws \Exception
     */
    public function fetchSprintIssues()
    {
        $sprintId = null;
        if (isset($_GET['_target'][2])) {
            $sprintId = (int)$_GET['_target'][2];
        }
        if (isset($_GET['id'])) {
            $sprintId = (int)$_GET['id'];
        }
        if (empty($sprintId)) {
            $data['sprint'] = new \stdClass();
            $data['issues'] = [];
            $this->ajaxSuccess('迭代参数错误,id不能为空', []);
        }
        $sortField = null;
        if (isset($_GET['sort_field']) && isset(IssueFilterLogic::$avlSortFields[$_GET['sort_field']])) {
            $sortField = $_GET['sort_field'];
        }
        $sortBy = 'desc';
        if (isset($_GET['sort_by']) && in_array($_GET['sort_by'], ['desc','asc'])) {
            $sortBy = $_GET['sort_by'];
        }

        $sprintModel = new SprintModel();
        $sprint = $sprintModel->getItemById($sprintId);
        if (empty($sprint)) {
            $sprint = new \stdClass();
        }
        $data['sprint'] = $sprint;
        $issueLogic = new AgileLogic();
        $data['issues'] = $issueLogic->getSprintIssues($sprintId, $sprint['project_id'], $sortField, $sortBy);

        $this->ajaxSuccess('success', $data);
    }

    /**
     * 获取活动的Sprint kanban信息
     * @throws \Exception
     * @throws \Exception
     */
    public function fetchBoardBySprint()
    {
        $projectId = null;
        $sprintId = null;
        if (isset($_GET['_target'][2])) {
            $sprintId = (int)$_GET['_target'][2];
        }
        if (isset($_GET['id'])) {
            $sprintId = (int)$_GET['id'];
        }
        if (isset($_GET['project_id'])) {
            $projectId = (int)$_GET['project_id'];
        }
        if (empty($sprintId)) {
            $this->ajaxFailed('参数错误');
        }
        $sprintModel = new SprintModel();
        $sprint = $sprintModel->getItemById($sprintId);
        if (empty($sprint)) {
            $this->ajaxFailed('参数错误', '迭代不存在');
        }
        if (empty($projectId) && !empty($sprint['project_id'])) {
            $projectId = $sprint['project_id'];
        }
        if (empty($projectId)) {
            $this->ajaxFailed('参数错误', '项目数据错误');
        }

        $data['sprint'] = $sprint;
        $agileLogic = new AgileLogic();

        $boardId = AgileLogic::ACTIVE_SPRINT_BOARD_ID;
        $agileBoardModel = new AgileBoardModel();
        $board = $agileBoardModel->getById($boardId);
        if (empty($board)) {
            $this->ajaxFailed('参数错误', '看板不存在');
        }
        $data['board'] = $board;

        $agileBoardColumn = new AgileBoardColumnModel();
        $columns = $agileBoardColumn->getsByBoard($boardId);
        if (empty($columns)) {
            $this->ajaxFailed('board_no_column', []);
        }
        foreach ($columns as &$column) {
            $column['issues'] = [];
        }

        list($fetchRet, $msg) = $agileLogic->getBoardColumnBySprint($sprintId, $columns);
        if (!$fetchRet) {
            $this->ajaxFailed('server_error:' . $msg);
        }
        $closedColumn = $column;
        $closedColumn['name'] = 'Closed';
        $closedColumn['data'] = '';
        $closedColumn['issues'] = $agileLogic->getClosedIssues($projectId);
        $closedColumn['count'] = count($closedColumn['issues']);
        $columns[] = $closedColumn;

        $userLogic = new UserLogic();
        $data['users'] = $userLogic->getAllNormalUser();
        unset($userLogic);

        list($fetchRet, $issues) = $agileLogic->getBacklogIssues($projectId);
        if ($fetchRet) {
            $data['backlogs'] = $issues;
        } else {
            $this->ajaxFailed('服务器错误', $issues);
        }

        if ($fetchRet) {
            $data['columns'] = $columns;
            $this->ajaxSuccess('success', $data);
        } else {
            $this->ajaxFailed('服务器错误', $msg);
        }
    }

    /**
     * 通过 board_id 获取 Kanban 信息
     * @throws \Exception
     */
    public function fetchBoardById()
    {
        $projectId = null;
        $id = null;
        if (isset($_GET['_target'][2])) {
            $id = (int)$_GET['_target'][2];
        }
        if (isset($_GET['id'])) {
            $id = (int)$_GET['id'];
        }
        if (isset($_GET['project_id'])) {
            $projectId = (int)$_GET['project_id'];
        }
        $model = new AgileBoardModel();
        $board = $model->getById($id);
        if (empty($board)) {
            $this->ajaxFailed('参数错误', '看板数据不存在');
        }
        $data['board'] = $board;
        if (empty($projectId) && !empty($board['project_id'])) {
            $projectId = (int)$board['project_id'];
        }
        if (empty($projectId)) {
            $this->ajaxFailed('参数错误', '项目不存在');
        }

        $model = new AgileBoardColumnModel();
        $columns = $model->getsByBoard($id);
        if (empty($columns)) {
            $this->ajaxFailed('参数错误', '看板没有定义的列');
        }
        foreach ($columns as &$column) {
            $column['issues'] = [];
        }
        $agileLogic = new AgileLogic();
        $userLogic = new UserLogic();
        $data['users'] = $userLogic->getAllNormalUser();
        unset($userLogic);

        list($fetchRet, $issues) = $agileLogic->getBacklogIssues($projectId);
        if ($fetchRet) {
            $data['backlogs'] = $issues;
        } else {
            $this->ajaxFailed('服务器错误:', $issues);
        }

        if ($board['type'] == 'label') {
            list($fetchRet, $msg) = $agileLogic->getBoardColumnByLabel($projectId, $columns);
        } else {
            list($fetchRet, $msg) = $agileLogic->getBoardColumnCommon($projectId, $columns, $board['type']);
        }
        $closedColumn = $column;
        $closedColumn['name'] = 'Closed';
        $closedColumn['data'] = '';
        $closedColumn['issues'] = $agileLogic->getClosedIssues($projectId);
        $closedColumn['count'] = count($closedColumn['issues']);
        $columns[] = $closedColumn;
        if ($fetchRet) {
            $data['columns'] = $columns;
            $this->ajaxSuccess('success', $columns);
        } else {
            $this->ajaxFailed('服务器错误:', $msg);
        }
    }
}
