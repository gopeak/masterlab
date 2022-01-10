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
use main\app\event\CommonPlacedEvent;
use main\app\event\Events;
use main\app\model\CacheKeyModel;
use main\app\model\ActivityModel;
use main\app\model\agile\SprintModel;
use main\app\model\agile\AgileBoardModel;
use main\app\model\agile\AgileBoardColumnModel;
use main\app\model\field\FieldCustomValueModel;
use main\app\model\field\FieldModel;
use main\app\model\issue\IssueLabelDataModel;
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
        $data['default_sort_field'] = 'weight';
        $data['default_sort_by'] = 'desc';

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
        $data['nav_links_active'] = 'sprint';
        $data['sub_nav_active'] = 'all';
        $data['is_sprint'] = true;
        $data['query_str'] = http_build_query($_GET);
        $data['avl_sort_fields'] = IssueFilterLogic::$avlSortFields;
        $data['sort_field'] = isset($_GET['sort_field']) ? $_GET['sort_field'] : '';
        $data['sort_by'] = isset($_GET['sort_by']) ? $_GET['sort_by'] : '';
        $data['default_sort_by'] = 'desc';
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
        $agileLogic->refreshSprintToBoard($data['project_id']);
        $data['boards'] = $agileLogic->getBoardsByProjectV2($data['project_id']);

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
        $data['active_sprint'] = [];
        if (!empty($data['project_id'])) {
            $data['active_sprint'] = $activeSprint;
        }
        $data['sprints'] = $agileLogic->getSprints($data['project_id']);

        $issueLogic = new IssueLogic();
        $data['description_templates'] = $issueLogic->getDescriptionTemplates();

        ConfigLogic::getAllConfigs($data);
        $data['perm_kanban'] = false;
        if (!empty($data['project_id']) || !empty($this->isAdmin)) {
            $data['perm_kanban'] = PermissionLogic::check($data['project_id'], UserAuth::getId(), PermissionLogic::MANAGE_KANBAN);
        }
        $projectFlagModel = new ProjectFlagModel();
        $boardDefaultId = (int)$projectFlagModel->getValueByFlag($data['project_id'], 'board_default_id');
        if(isset($_GET['boards_select'])){
            $boardDefaultId = (int)$_GET['boards_select'];
        }
        $agileBoardModel = new AgileBoardModel();
        $boardDefault = $agileBoardModel->getById($boardDefaultId);
        if(empty($boardDefaultId) || empty($boardDefault)){
            $boardDefaultId = $data['boards'][0]['id'] ?? 1;
        }
        $data['board_default_id'] = $boardDefaultId;
        $data['keyword'] = $_GET['keyword'] ?? '';

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
        $sprints = $sprintModel->getItemsByProject($projectId);
        $newArr = [];
        // 过滤已经归档的迭代
        foreach ($sprints as $sprint) {
            if (isset($_GET['no_packed']) && $sprint['status'] == '3') {
            } else {
                $newArr[] = $sprint;
            }
        }
        $data['sprints'] = $newArr;
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
        if (isset($_GET['sprint_id'])) {
            $sprintId = (int)$_GET['sprint_id'];
        }
        if (empty($sprintId)) {
            $this->ajaxFailed('参数错误', '迭代id不能为空');
        }
        $sprintModel = new SprintModel();
        $sprint = $sprintModel->getRowById($sprintId);
        $this->ajaxSuccess('ok', $sprint);
    }

    public function saveBoardSetting()
    {
        $projectId = null;
        if (isset($_POST['project_id'])) {
            $projectId = (int)$_POST['project_id'];
        }
        if (empty($projectId)) {
            $this->ajaxFailed('参数错误', '项目id不能为空');
        }

        $boardId = null;
        if (isset($_POST['id'])) {
            $boardId = (int)$_POST['id'];
        }

        $info = [];
        if (!isset($_POST['name']) || empty($_POST['name'])) {
            $err['name'] = '看板名称不能为空';
            $this->ajaxFailed('参数错误', $err, parent::AJAX_FAILED_TYPE_FORM_ERROR);
        }
        $info['name'] = $_POST['name'];
        if (isset($_POST['range_type'])) {
            $info['range_type'] = $_POST['range_type'];
            if (isset($_POST['range_data'])) {
                if (empty($_POST['range_data'])) {
                    $_POST['range_data'] = [];
                }
                $info['range_data'] = json_encode($_POST['range_data']);
            }
        }
        if (isset($_POST['range_due_date'])) {
            $info['range_due_date'] = $_POST['range_due_date'];
        }
        if (isset($_POST['weight'])) {
            $info['weight'] = (int)$_POST['weight'];
        }
        if (isset($_POST['is_filter_backlog'])) {
            $info['is_filter_backlog'] = $_POST['is_filter_backlog'];
        }
        if (isset($_POST['is_filter_closed'])) {
            $info['is_filter_closed'] = (int)$_POST['is_filter_closed'];
        }
        $columnsArr = json_decode($_POST['columns'], true);
        $boardModel = new AgileBoardModel();
        $columnModel = new AgileBoardColumnModel();
        if (empty($boardId)) {
            $info['project_id'] = $_POST['project_id'];
            // 新增
            list($ret, $insertId) = $boardModel->insertItem($info);
            if (!$ret) {
                $this->ajaxFailed('服务器错误', "新增看板错误:" . $insertId);
            }
            $boardId = $insertId;
            $actionType = '新增';
        } else {
            // 更新
            list($ret, $msg) = $boardModel->updateItem($boardId, $info);
            if (!$ret) {
                $this->ajaxFailed('服务器错误', "更新看板错误:" . $msg);
            }
            $actionType = '更新';
        }
        // 更新泳道数据
        $columnModel->deleteByBoardId($boardId);
        $count = count($columnsArr);
        foreach ($columnsArr as $index => $item) {
            $arr = [];
            $arr['board_id'] = $boardId;
            $arr['name'] = $item['name'];
            $arr['weight'] = abs($index - $count);
            $arr['data'] = json_encode($item['data']);
            $columnModel->insertItem($arr);
        }
        // 更新活动记录
        $activityModel = new ActivityModel();
        $activityInfo = [];
        $activityInfo['action'] = $actionType . '了看板:' . $info['name'];
        $activityInfo['type'] = ActivityModel::TYPE_AGILE;
        $activityInfo['obj_id'] = $boardId;
        $activityInfo['title'] = $info['name'];
        $activityModel->insertItem(UserAuth::getId(), $projectId, $activityInfo);

        $this->ajaxSuccess('操作成功', $_POST);
    }

    /**
     * @throws \Exception
     */
    public function setBoardDefault()
    {
        $projectId = null;
        if (isset($_POST['project_id'])) {
            $projectId = (int)$_POST['project_id'];
        }
        if (empty($projectId)) {
            $this->ajaxFailed('参数错误', '项目id不能为空');
        }

        $boardId = null;
        if (isset($_POST['id'])) {
            $boardId = (int)$_POST['id'];
        }
        if (empty($boardId)) {
            $err['id'] = '看板id不能为空';
            $this->ajaxFailed('参数错误', $err, parent::AJAX_FAILED_TYPE_FORM_ERROR);
        }
        $projectFlagModel = new ProjectFlagModel();
        $projectFlagModel->add($projectId,'board_default_id', $boardId);

        $this->ajaxSuccess('操作成功', $_POST);
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
        if (isset($_POST['params']['end_date'])) {
            $info['end_date'] = $_POST['params']['end_date'];
        }
        $sprintModel = new SprintModel();
        list($ret, $msg) = $sprintModel->insertItem($info);
        if ($ret) {

            // email
            $notifyLogic = new NotifyLogic();
            $notifyLogic->send(NotifyLogic::NOTIFY_FLAG_SPRINT_CREATE, $projectId, $msg);

            $info['id'] = $msg;
            $event = new CommonPlacedEvent($this, $info);
            $this->dispatcher->dispatch($event, Events::onSprintCreate);
            $this->ajaxSuccess('提示', '操作成功');
        } else {
            $this->ajaxFailed('提示', '服务器错误:' . $msg);
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
        if (isset($_POST['sprint_id'])) {
            $sprintId = (int)$_POST['sprint_id'];
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
        if (isset($_POST['params']['status'])) {
            $info['status'] = (int)$_POST['params']['status'];
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
            $this->ajaxSuccess('提示', '操作成功');
            return;
        }
        list($ret, $msg) = $sprintModel->updateItem($sprintId, $info);
        if ($ret) {

            $info['id'] = $sprintId;
            $event = new CommonPlacedEvent($this, ['pre_data' => $sprint, 'cur_data' => $info]);
            $this->dispatcher->dispatch($event, Events::onSprintUpdate);

            // email
            $notifyLogic = new NotifyLogic();
            $notifyLogic->send(NotifyLogic::NOTIFY_FLAG_SPRINT_UPDATE, $sprint['project_id'], $sprintId);

            $this->ajaxSuccess('提示', '操作成功');
        } else {
            $this->ajaxFailed('提示', '服务器错误:' . $msg);
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
        if (isset($_POST['sprint_id'])) {
            $sprintId = (int)$_POST['sprint_id'];
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

            $event = new CommonPlacedEvent($this, $sprint);
            $this->dispatcher->dispatch($event, Events::onSprintDelete);
            $this->ajaxSuccess('提示', '操作成功');
        } else {
            $this->ajaxFailed('提示', '数据库删除迭代失败');
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
            $event = new CommonPlacedEvent($this, ['issue_id' => $issueId, 'sprint' => $sprint]);
            $this->dispatcher->dispatch($event, Events::onIssueJoinSprint);
            $this->ajaxSuccess('提示', '操作成功');
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
        list($upRet, $msg) = $sprintModel->updateById($sprintId, ['active' => '1']);
        if ($upRet) {
            $event = new CommonPlacedEvent($this, $sprint);
            $this->dispatcher->dispatch($event, Events::onSprintSetActive);
            $this->ajaxSuccess('提示', '操作成功');
        } else {
            $this->ajaxFailed('提示', 'server_error:' . $msg);
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
        $updateArr = [];
        $updateArr['sprint'] = AgileLogic::BACKLOG_VALUE;
        $updateArr['backlog_weight'] = '0';
        // 判断是否为已关闭事项
        $issueStatus = $model->getField('status', ['id' => $issueId]);
        $statusClosedId = IssueStatusModel::getInstance()->getIdByKey('closed');

        if ($issueStatus == $statusClosedId) {
            $updateArr['status'] = IssueStatusModel::getInstance()->getIdByKey('open');
        }
        list($ret, $msg) = $model->updateById($issueId, $updateArr);
        if ($ret) {
            $event = new CommonPlacedEvent($this, ['issue_id' => $issueId, $updateArr]);
            $this->dispatcher->dispatch($event, Events::onIssueJoinBacklog);
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
            $event = new CommonPlacedEvent($this, ['issue_id' => $issueId, ['resolve' => $resolveClosedId, 'status' => $statusClosedId]]);
            $this->dispatcher->dispatch($event, Events::onIssueJoinClose);
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
        if (isset($_GET['sort_by']) && in_array($_GET['sort_by'], ['desc', 'asc'])) {
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
     * @throws \Exception
     */
    public function fetchBoardsByProject()
    {
        $projectId = null;
        if (isset($_GET['project_id'])) {
            $projectId = (int)$_GET['project_id'];
        }
        if (empty($projectId)) {
            $this->ajaxFailed('参数错误', '项目数据错误');
        }
        $agileLogic = new AgileLogic();
        $boards = $agileLogic->getBoardsByProject($projectId);
        $projectFlagModel = new ProjectFlagModel();
        $boardDefaultId = (int)$projectFlagModel->getValueByFlag($projectId, 'board_default_id');
        $i = 0;
        foreach ($boards as &$board) {
            $i++;
            $board['i'] = $i;
            $board['is_default'] = $boardDefaultId==$board['id'] ? '1' :'0';
        }
        $data['boards'] = $boards;
        $this->ajaxSuccess('success', $data);
    }

    public function fetchBoardInfoById()
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
        if (empty($board['range_data'])) {
            $board['range_data'] = [];
        } else {
            $board['range_data'] = json_decode($board['range_data'], true);
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
        $i = 0;
        foreach ($columns as &$column) {
            $column['i'] = $i;
            $column['data'] = json_decode($column['data'], true);
            $i++;
        }

        $data['board']['columns'] = $columns;
        $this->ajaxSuccess('success', $data);

    }


    /**
     * 通过 board_id 获取 Kanban 信息
     * @throws \Exception
     */
    public function fetchBoardById()
    {
        $projectId = null;
        $id = null;
        $idStr = null;
        $type = "all";
        if (isset($_GET['_target'][2])) {
            $idStr = $_GET['_target'][2];
        }
        if (isset($_GET['id'])) {
            $idStr = $_GET['id'];
        }
        if (strpos($idStr, '@')!==false){
            list($type, $id) = explode("@", $idStr);
        }else{
            $id = $idStr;
        }
        $id = intval($id);
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
        $data['backlogs'] = [];
        if ((int)$board['is_filter_backlog'] == 0) {
            list($fetchRet, $issues) = $agileLogic->getBacklogIssues($projectId);
            if ($fetchRet) {
                $data['backlogs'] = $issues;
            } else {
                $this->ajaxFailed('服务器错误:', $issues);
            }
        }
        list($fetchRet, $msg) = $agileLogic->getBoardColumnCommon($projectId, $board, $columns);
        if ((int)$board['is_filter_closed'] == 0) {
            $closedColumn = $column;
            $closedColumn['name'] = 'Closed';
            $closedColumn['data'] = '';
            $closedColumn['issues'] = $agileLogic->getClosedIssues($projectId);
            $closedColumn['count'] = count($closedColumn['issues']);
            $columns[] = $closedColumn;
        }
        if ($fetchRet) {
            $columns = $this->formatColumnsIssues($columns);
            $data['columns'] = $columns;
            $this->ajaxSuccess('success', $data);
        } else {
            $this->ajaxFailed('服务器错误:', $msg);
        }
    }
    /**
     * @param $columns
     * @throws \Exception
     */
    private function formatColumnsIssues($columns)
    {
        $userLogic = new UserLogic();
        $users = $userLogic->getAllUser();
        // 获取自定义字段值
        $fieldCustomValueModel = new FieldCustomValueModel();
        $fieldsArr = (new FieldModel())->getCustomFields();
        $fieldsArr = array_column($fieldsArr, null, 'id');
        $customFieldIdArr = array_column($fieldsArr, 'id');
        foreach ($columns as &$column) {
            $issueIdArr = array_column($column['issues'], 'id');
            $labelDataRows = (new IssueLabelDataModel())->getsByIssueIdArr($issueIdArr);
            $labelDataArr = [];
            foreach ($labelDataRows as $labelData) {
                $labelDataArr[$labelData['issue_id']][] = $labelData['label_id'];
            }
            $customValuesIssueArr = [];
            if ($fieldsArr) {
                $customValuesArr = $fieldCustomValueModel->getsByIssueIdArr($issueIdArr, $customFieldIdArr);
                foreach ($customValuesArr as $customValue) {
                    $key = $customValue['value_type'] . '_value';
                    $issueId = $customValue['issue_id'];
                    $fieldId = $customValue['custom_field_id'];
                    $fieldArr = $fieldsArr[$fieldId];
                    if (isset($fieldArr['name'])) {
                        $fieldValue = !isset($customValue[$key]) ? $customValue['string_value'] : $customValue[$key];
                        $fieldName = $fieldArr['name'];
                        $customValuesIssueArr[$issueId][$fieldName] = $fieldValue;
                    }
                }
            }
            foreach ($column['issues'] as &$issue) {
                $issueId = $issue['id'];
                if (isset($labelDataArr[$issueId])) {
                    $arr = array_unique($labelDataArr[$issueId]);
                    sort($arr);
                    $issue['label_id_arr'] = $arr;
                } else {
                    $issue['label_id_arr'] = [];
                }
                if (isset($customValuesIssueArr[$issueId])) {
                    $customValueArr = $customValuesIssueArr[$issueId];
                    $issue = array_merge($customValueArr, $issue);
                }
                $emptyObj = new \stdClass();
                $issue['creator_info'] = isset($users[$issue['creator']]) ? $users[$issue['creator']] : $emptyObj;
                $issue['modifier_info'] = isset($users[$issue['modifier']]) ? $users[$issue['modifier']] : $emptyObj;
                $issue['reporter_info'] = isset($users[$issue['reporter']]) ? $users[$issue['reporter']] : $emptyObj;
                $issue['assignee_info'] = isset($users[$issue['assignee']]) ? $users[$issue['assignee']] : $emptyObj;
            }
       }
        return $columns;
    }


    /**
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Exception
     */
    public function deleteBoard()
    {
        $boardId = null;
        if (isset($_GET['_target'][2])) {
            $boardId = (int)$_GET['_target'][2];
        }
        if (isset($_POST['board_id'])) {
            $boardId = (int)$_POST['board_id'];
        }
        if (empty($boardId)) {
            $this->ajaxFailed('参数错误', '看板id不能为空');
        }
        $boardModel = new AgileBoardModel();
        $board = $boardModel->getItemById($boardId);
        if (empty($board)) {
            $this->ajaxFailed('参数错误', '看板数据错误');
        }
        // email
        // $notifyLogic = new NotifyLogic();
        // $notifyLogic->send(NotifyLogic::NOTIFY_FLAG_SPRINT_REMOVE, $board['project_id'], $board);

        $ret = $boardModel->deleteItem($boardId);
        if ($ret) {
            $projectFlagModel = new ProjectFlagModel();
            $boardDefaultId = (int)$projectFlagModel->getValueByFlag($board['project_id'], 'board_default_id');
            if($boardDefaultId==$boardId){
                $projectFlagModel->add($board['project_id'],'board_default_id', 0);
            }
            $activityModel = new ActivityModel();
            $activityInfo = [];
            $activityInfo['action'] = '删除了看板';
            $activityInfo['type'] = ActivityModel::TYPE_AGILE;
            $activityInfo['obj_id'] = $boardId;
            $activityInfo['title'] = $board['name'];
            $activityModel->insertItem(UserAuth::getId(), $board['project_id'], $activityInfo);
            $this->ajaxSuccess('提示', '操作成功');
        } else {
            $this->ajaxFailed('提示', '数据库删除看板失败');
        }
    }
}
