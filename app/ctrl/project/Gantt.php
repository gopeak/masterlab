<?php
/**
 * Created by PhpStorm.
 */

namespace main\app\ctrl\project;

use main\app\classes\IssueFilterLogic;
use main\app\classes\ConfigLogic;
use main\app\classes\UserAuth;
use main\app\classes\PermissionLogic;
use main\app\classes\UserLogic;
use main\app\ctrl\BaseUserCtrl;
use main\app\model\agile\SprintModel;
use main\app\classes\RewriteUrl;
use main\app\classes\ProjectGantt;
use main\app\model\issue\ExtraWorkerDayModel;
use main\app\model\issue\HolidayModel;
use main\app\model\issue\IssueModel;
use main\app\model\issue\IssueResolveModel;
use main\app\model\issue\IssueStatusModel;
use main\app\model\issue\IssueTypeModel;
use main\app\model\project\ProjectGanttSettingModel;
use main\app\model\project\ProjectRoleModel;

/**
 * 甘特图
 */
class Gantt extends BaseUserCtrl
{

    /**
     * Stat constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct();
        parent::addGVar('top_menu_active', 'project');
        parent::addGVar('sub_nav_active', 'project');
    }

    public function pageComputeLevel()
    {
        $class = new ProjectGantt();
        $class->batchUpdateGanttLevel();
        echo 'ok';
    }

    /**
     * @throws \Exception
     */
    public function pageIndex()
    {
        $data = [];
        $data['title'] = '项目甘特图';
        $data['nav_links_active'] = 'gantt';
        $data = RewriteUrl::setProjectData($data);
        // 权限判断
        if (!empty($data['project_id'])) {
            if (!$this->isAdmin && !PermissionLogic::checkUserHaveProjectItem(UserAuth::getId(), $data['project_id'])) {
                $this->warn('提 示', '您没有权限访问该项目,请联系管理员申请加入该项目');
                die;
            }
        }
        $projectId = $data['project_id'];
        $data['current_uid'] = UserAuth::getId();
        $userLogic = new UserLogic();
        $projectUsers = $userLogic->getUsersAndRoleByProjectId($projectId);

        foreach ($projectUsers as &$user) {
            $user = UserLogic::format($user);
        }
        $data['project_users'] = $projectUsers;

        $projectRolemodel = new ProjectRoleModel();
        $data['roles'] = $projectRolemodel->getsByProject($projectId);

        $projectGanttModel = new ProjectGanttSettingModel();
        $setting = $projectGanttModel->getByProject($projectId);
        $class = new ProjectGantt();
        if (empty($setting)) {
            $class->initGanttSetting($projectId);
        }

        // 迭代数据
        $data['sprints'] = [];
        $data['active_sprint'] = [];
        if (!empty($data['project_id'])) {
            $sprintModel = new SprintModel();
            $data['sprints'] = $sprintModel->getItemsByProject($projectId);
            $data['active_sprint'] = $sprintModel->getActive($projectId);
        }

        $holidays = (new HolidayModel())->getDays($projectId);
        $data['holidays'] = $holidays;

        $extraHolidays = (new ExtraWorkerDayModel())->getDays($projectId);
        $data['extra_holidays'] = $extraHolidays;

        $workDates = null;
        if (isset($setting['work_dates'])) {
            $workDates = json_decode($setting['work_dates'], true);
        }
        if (is_null($workDates)) {
            $workDates = [1, 2, 3, 4, 5];
        }
        $data['work_dates'] = $workDates;

        ConfigLogic::getAllConfigs($data);

        $this->render('gitlab/project/gantt.php', $data);
    }

    public function fetchSetting()
    {
        $projectId = null;
        if (isset($_GET['_target'][3])) {
            $projectId = (int)$_GET['_target'][3];
        }
        if (isset($_GET['project_id'])) {
            $projectId = (int)$_GET['project_id'];
        }
        if (empty($projectId)) {
            $this->ajaxFailed('参数错误', '项目id不能为空');
        }

        $projectGanttModel = new ProjectGanttSettingModel();
        $ganttSetting = $projectGanttModel->getByProject($projectId);
        $class = new ProjectGantt();
        if (empty($ganttSetting)) {
            // 再次获取一次
            $ganttSetting = $projectGanttModel->getByProject($projectId);
            if (empty($ganttSetting)) {
                $class->initGanttSetting($projectId);
                $ganttSetting = $projectGanttModel->getByProject($projectId);
            }
        }
        $sourceType = 'project';
        $sourceArr = ['project', 'active_sprint', 'module'];
        if (in_array($ganttSetting['source_type'], $sourceArr)) {
            $sourceType = $sourceType = $ganttSetting['source_type'];
        }

        $isDisplayBacklog = '0';
        if (isset($ganttSetting['is_display_backlog'])) {
            $isDisplayBacklog = $ganttSetting['is_display_backlog'];
        }
        // is_check_date
        $isCheckDate = '0';
        if (isset($ganttSetting['is_check_date'])) {
            $isCheckDate = $ganttSetting['is_check_date'];
        }
        $hideIssueTypes = [];
        if (isset($ganttSetting['hide_issue_types'])) {
            $hideIssueTypes = explode(',', $ganttSetting['hide_issue_types']);
        }
        $workDates = [];
        if (isset($ganttSetting['work_dates'])) {
            $workDates = json_decode($ganttSetting['work_dates'], true);
            if (is_null($workDates)) {
                $workDates = [1, 2, 3, 4, 5];
            }
        }

        $data = [];
        $data['source_type'] = $sourceType;
        $data['is_display_backlog'] = $isDisplayBacklog;
        $data['is_check_date'] = $isCheckDate;
        $data['hide_issue_types'] = $hideIssueTypes;
        $data['work_dates'] = $workDates;

        $holidays = (new HolidayModel())->getDays($projectId);
        $data['holidays'] = $holidays;

        $extraHolidays = (new ExtraWorkerDayModel())->getDays($projectId);
        $data['extra_holidays'] = $extraHolidays;

        $this->ajaxSuccess('获取成功', $data);
    }

    /**
     * 保存甘特图有设置
     * @throws \Exception
     */
    public function saveSetting()
    {
        $projectId = null;
        if (isset($_GET['_target'][3])) {
            $projectId = (int)$_GET['_target'][3];
        }
        if (isset($_GET['project_id'])) {
            $projectId = (int)$_GET['project_id'];
        }
        if (empty($projectId)) {
            $this->ajaxFailed('参数错误', '项目id不能为空');
        }
        if (!$this->isAdmin && !PermissionLogic::checkUserHaveProjectItem(UserAuth::getId(), $projectId)) {
            $this->ajaxFailed('您没有权限访问该项目,请联系管理员申请加入该项目');
        }
        $projectGanttModel = new ProjectGanttSettingModel();
        $sourceType = 'project';
        $sourceArr = ['project', 'active_sprint', 'module'];
        if (isset($_POST['source_type'])) {
            if (in_array($_POST['source_type'], $sourceArr)) {
                $sourceType = $_POST['source_type'];
            }
        }
        $updateInfo['source_type'] = $sourceType;
        // 是否显示待办的事项
        $isDisplayBacklog = '0';
        if (isset($_POST['is_display_backlog']) && $_POST['is_display_backlog'] == '1') {
            $isDisplayBacklog = '1';
        }
        if (isset($ganttSetting['is_display_backlog'])) {
            $updateInfo['is_display_backlog'] = $isDisplayBacklog;
        }
        // 是否检查日期
        $isCheckDate = '0';
        if (isset($_POST['is_check_date']) && $_POST['is_check_date'] == '1') {
            $isCheckDate = '1';
        }
        $ganttSetting = $projectGanttModel->getByProject($projectId);
        if (isset($ganttSetting['is_check_date'])) {
            $updateInfo['is_check_date'] = $isCheckDate;
        }

        // 隐藏的事项类型
        if (isset($_POST['hide_issue_types'])) {
            $hideIssueTypes = $_POST['hide_issue_types'];
            if (is_array($hideIssueTypes)) {
                $hideIssueTypes = implode(',', $hideIssueTypes);
            } else {
                $hideIssueTypes = strval($hideIssueTypes);
            }
            $updateInfo['hide_issue_types'] = $hideIssueTypes;
        }
        if (isset($_POST['work_dates'])) {
            $workDates = $_POST['work_dates'];
            if (is_array($workDates)) {
                $workDates = array_map('intval', $workDates);
                $workDatesJson = json_encode($workDates);
            } else {
                $this->ajaxFailed('提示', '参数错误, 参数"上班日"应该为数组类型');
            }
            $updateInfo['work_dates'] = $workDatesJson;
        }

        list($ret, $msg) = $projectGanttModel->updateByProjectId($updateInfo, $projectId);
        if ($ret) {
            $model = new HolidayModel();
            $model->deleteByProject($projectId);
            $holidaysArr = json_decode($_POST['holiday_dates'], true);
            foreach ($holidaysArr as $date) {
                $arr = [];
                $arr['project_id'] = $projectId;
                $arr['day'] = $date;
                $model->insert($arr);
            }

            $model = new ExtraWorkerDayModel();
            $model->deleteByProject($projectId);
            $holidaysArr = json_decode($_POST['extra_holiday_dates'], true);
            foreach ($holidaysArr as $date) {
                $arr = [];
                $arr['project_id'] = $projectId;
                $arr['day'] = $date;
                $model->insert($arr);
            }

            $this->ajaxSuccess('操作成功', $sourceType);
        } else {
            $this->ajaxFailed('服务器执行错误', $msg);
        }

    }

    /**
     * 获取项目的事项数据
     * @throws \Exception
     */
    public function fetchProjectIssues()
    {
        $projectId = null;
        if (isset($_GET['_target'][3])) {
            $projectId = (int)$_GET['_target'][3];
        }
        if (isset($_GET['project_id'])) {
            $projectId = (int)$_GET['project_id'];
        }
        if (empty($projectId)) {
            $this->ajaxFailed('参数错误', '项目id不能为空');
        }
        $data['current_uid'] = UserAuth::getId();

        $model = new ProjectRoleModel();
        $data['project_roles'] = $model->getsByProject($projectId);
        $roles = [];
        foreach ($data['project_roles'] as $project_role) {
            $roles[] = ['id' => $project_role['id'], 'name' => $project_role['name']];
        }
        $userLogic = new UserLogic();
        $projectUsers = $userLogic->getUsersAndRoleByProjectId($projectId);
        $resources = [];
        foreach ($projectUsers as &$user) {
            $user = UserLogic::format($user);
            $resource = [];
            $resource['id'] = $user['uid'];
            $resource['name'] = $user['display_name'];
            $resource['resourceId'] = $user['uid'];
            $resource['roleId'] = '';
            $resources[] = $resource;
        }
        $data['project_users'] = $projectUsers;

        $projectGanttModel = new ProjectGanttSettingModel();
        $ganttSetting = $projectGanttModel->getByProject($projectId);
        $class = new ProjectGantt();
        if (empty($ganttSetting)) {
            $class->initGanttSetting($projectId);
            $ganttSetting = $projectGanttModel->getByProject($projectId);
        }
        $sourceType = 'project';
        $sourceArr = ['project', 'active_sprint', 'module'];
        if (in_array($ganttSetting['source_type'], $sourceArr)) {
            $sourceType = $ganttSetting['source_type'];
        }
        $isDisplayBacklog = '1';
        if (isset($ganttSetting['is_display_backlog'])) {
            $isDisplayBacklog = $ganttSetting['is_display_backlog'];
        }
        $sprintModel = new SprintModel();
        if ($sprintModel->getCountByProject($projectId) <= 0) {
            $isDisplayBacklog = '1';
        }
        $issues = [];
        if ($sourceType == 'project') {
            $issues = $class->getIssuesGroupBySprint($projectId, $isDisplayBacklog);
        }
        if ($sourceType == 'active_sprint') {
            $issues = $class->getIssuesGroupByActiveSprint($projectId, $isDisplayBacklog);
        }
        $userLogic = new UserLogic();
        $users = $userLogic->getAllNormalUser();

        $hideIssueTypeKeyArr = [];
        if (!empty($ganttSetting['hide_issue_types'])) {
            $hideIssueTypeKeyArr = explode(',', $ganttSetting['hide_issue_types']);
        }
        $issueTypeModel = new IssueTypeModel();
        $issueTypeIdArr = $issueTypeModel->getAllItem(true);
        $isCheckDate = '0';
        if (isset($ganttSetting['is_check_date'])) {
            $isCheckDate = $ganttSetting['is_check_date'];
        }
        $filteredArr = [];
        $unDateIssuesArr = [];
        $unDateSprintsArr = [];
        foreach ($issues as &$task) {
            $assigs = [];
            if (isset($users[$task['assigs']]['display_name'])) {
                $tmp = [];
                $tmp['id'] = $task['assigs'];
                $tmp['name'] = @$users[$task['assigs']]['display_name'];
                $tmp['resourceId'] = $task['assigs'];
                $tmp['roleId'] = '';
                $assigs[] = $tmp;
            }
            $task['assigs'] = $assigs;
            $task['filtered'] = '0';
            // 只有事项的才进行过滤
            if ($task['type'] != 'sprint') {
                $issueTypeKey = isset($issueTypeIdArr[$task['typeId']]) ? $issueTypeIdArr[$task['typeId']]['_key'] : null;
                if (empty($task['gant_hide']) && !in_array($issueTypeKey, $hideIssueTypeKeyArr)) {
                    $filteredArr[] = $task;
                } else {
                    $task['filtered'] = '1';
                }
            } else {
                $filteredArr[] = $task;
            }
            if ($isCheckDate == '1'  && $task['filtered'] == '0'  ) {
                $row = $task;
                $name = $row['name'];
                if (mb_strlen($name) > 16) {
                    $name = mb_substr($name, 0, 16) . '...';
                }
                $row['name'] = $name;
                if (intval($task['id']) > 0 ) {
                    if(empty($task['start_date'])|| $task['start_date'] == '0000-00-00'|| empty($task['due_date']) || $task['due_date'] == '0000-00-00'){
                        if ($row['start_date'] == '0000-00-00') {
                            $row['start_date'] = '';
                        }
                        if ($row['due_date'] == '0000-00-00') {
                            $row['due_date'] = '';
                        }
                        $unDateIssuesArr[] = $row;
                    }
                } else {
                    $sprint = $task['sprint_info'];
                    if(!empty($sprint['id'])){
                        if(empty($sprint['start_date'])|| $sprint['start_date'] == '0000-00-00'|| empty($sprint['end_date']) || $sprint['end_date'] == '0000-00-00'){
                            if (@$row['start_date'] == '0000-00-00') {
                                $row['start_date'] = '';
                            }
                            if (@$row['end_date'] == '0000-00-00') {
                                $row['end_date'] = '';
                            }
                            $row['id'] = abs($row['id']);
                            $unDateSprintsArr[] = $row;
                        }
                    }
                }
            }
        }
        unset($users);
        unset($task);
        $data['tasks'] = $filteredArr;
        $data['unDateTasks'] = $unDateIssuesArr;
        $data['unDateSprints'] = $unDateSprintsArr;
        $data['selectedRow'] = 2;
        $data['deletedTaskIds'] = [];
        $data['resources'] = $resources;
        $data['roles'] = $roles;
        $data['canWrite'] = true;
        //print_r($this->projectPermArr);
        if (!isset($this->projectPermArr[PermissionLogic::ADMIN_GANTT]) || $this->projectPermArr[PermissionLogic::ADMIN_GANTT] != 1) {
            $data['canWrite'] = false;
        }
        $data['canDelete'] = true;
        $data['canWriteOnParent'] = true;
        $data['canAdd'] = true;
        $this->ajaxSuccess('ok', $data);
    }


    /**
     * 获取被隐藏的事项列表
     * @throws \Exception
     */
    public function fetchGanttBeHiddenIssueList()
    {
        $projectId = null;
        if (isset($_GET['_target'][3])) {
            $projectId = (int)$_GET['_target'][3];
        }
        if (isset($_GET['project_id'])) {
            $projectId = (int)$_GET['project_id'];
        }
        if (empty($projectId)) {
            $this->ajaxFailed('参数错误', '项目ID不能为空');
        }

        $page = 1;
        $pageSize = 20;
        if (isset($_GET['page'])) {
            $page = max(1, (int)$_GET['page']);
        }

        $data['current_uid'] = UserAuth::getId();

        $data['tasks'] = [];

        $class = new ProjectGantt();
        list($rows, $total) = $class->getBeHiddenIssuesByPage($projectId, $page, $pageSize);

        $data['total'] = $total;
        $data['pages'] = ceil($total / $pageSize);
        $data['page_size'] = $pageSize;
        $data['page'] = $page;
        $data['tasks'] = $rows;

        $this->ajaxSuccess('ok', $data);
    }

    /**
     * 甘特图 恢复已隐藏的事项
     * @throws \Exception
     */
    public function recoverGanttBeHiddenIssue()
    {
        $projectId = null;
        if (isset($_GET['_target'][3])) {
            $projectId = (int)$_GET['_target'][3];
        }
        if (isset($_GET['project_id'])) {
            $projectId = (int)$_GET['project_id'];
        }
        if (empty($projectId)) {
            $this->ajaxFailed('参数错误', '项目ID不能为空');
        }

        $issueId = null;
        if (isset($_GET['issue_id'])) {
            $issueId = (int)$_GET['issue_id'];
        }
        if (empty($issueId)) {
            $this->ajaxFailed('参数错误', '缺少ID');
        }
        $data = [];
        $issueModel = new IssueModel();
        $issueModel->updateItemById($issueId, ['gant_hide' => 0]);

        $this->ajaxSuccess('已恢复显示该事项', $data);
    }

    /**
     * 向上移动事项处理
     * @throws \Exception
     */
    public function moveUpIssue()
    {
        $currentId = null;
        if (isset($_POST['current_id'])) {
            $currentId = (int)$_POST['current_id'];
        }
        $targetId = null;
        if (isset($_POST['target_id'])) {
            $targetId = (int)$_POST['target_id'];
        }
        if (!$currentId || !$targetId) {
            $this->ajaxFailed('参数错误', $_POST);
        }
        $fieldWeight = 'gant_sprint_weight';
        $fields = "id,sprint,summary ,{$fieldWeight},have_children";
        $issueModel = new IssueModel();
        $currentIsuse = $issueModel->getRow($fields, ['id' => $currentId]);
        $targetIssue = $issueModel->getRow($fields, ['id' => $targetId]);
        $projectId = $currentIsuse['project_id'];
        if (!$this->isAdmin && !PermissionLogic::checkUserHaveProjectItem(UserAuth::getId(), $projectId)) {
            $this->ajaxFailed('您没有权限访问该项目,请联系管理员申请加入该项目');
        }
        if (!isset($currentIsuse[$fieldWeight]) || !isset($targetIssue[$fieldWeight])) {
            $this->ajaxFailed('参数错误,找不到事项信息', $_POST);
        }
        $currentWeight = (int)$currentIsuse[$fieldWeight];
        $targetWeight = (int)$targetIssue[$fieldWeight];
        $currentIsuse['have_children'] = (int)$currentIsuse['have_children'];
        $targetIssue['have_children'] = (int)$targetIssue['have_children'];
        // 如果两个事项都没有子任务，则交换排序权重值
        if ($currentIsuse['have_children'] == 0 && $targetIssue['have_children'] == 0) {
            if ($currentWeight == $targetWeight) {
                $targetWeight = max(0, $targetWeight - ProjectGantt::$offset);
            }
            $tmp = $targetWeight;
            $targetWeight = $currentWeight;
            $currentWeight = $tmp;

            // 执行更新操作
            $currentArr = [$fieldWeight => $currentWeight];
            $issueModel->updateItemById($currentId, $currentArr);
            $targetArr = [$fieldWeight => $targetWeight];
            $issueModel->updateItemById($targetId, $targetArr);
        } else {
            //  否则，先取出当前事项及子任务，再取出目标事项及子任务，最后这两个数组合并在重新计算排序值
            $sortArr = [];
            $sortArr[] = $currentIsuse;
            // 取出当前事项子任务
            $table = $issueModel->getTable();
            $sprintId = $currentIsuse['sprint'];
            $currentId = $currentIsuse['id'];
            $sql = "Select {$fields} From {$table} Where  master_id={$currentId}   AND `sprint` = {$sprintId} Order by {$fieldWeight} DESC ,start_date asc";
            $currentChildrenArr = $issueModel->db->fetchAll($sql);
            if ($currentChildrenArr && is_array($currentChildrenArr)) {
                foreach ($currentChildrenArr as $item) {
                    $sortArr[] = $item;
                }
            }
            // 取出目标事项子任务
            $sortArr[] = $targetIssue;
            $sprintId = $targetIssue['sprint'];
            $sql = "Select {$fields} From {$table} Where `$fieldWeight` >$currentWeight AND `$fieldWeight`<$targetWeight   AND `sprint` = {$sprintId} Order by {$fieldWeight} DESC ";
            $targetChildrenArr = $issueModel->db->fetchAll($sql);
            if ($targetChildrenArr && is_array($targetChildrenArr)) {
                foreach ($targetChildrenArr as $item) {
                    $sortArr[] = $item;
                }
            }
            $sql = "Select {$fields} From {$table} Where  master_id={$currentId}   AND `sprint` = {$sprintId} Order by {$fieldWeight} ASC    limit 1";
            $minWeight = max(0, (int)$issueModel->getFieldBySql($sql));

            $count = count($sortArr);
            $maxWeight = $targetWeight;
            $decWeight = intval(($targetWeight - $minWeight) / $count);
            // 重新更新权重值
            foreach ($sortArr as &$midRow) {
                $updateArr = [$fieldWeight => $maxWeight];
                $midRow[$fieldWeight] = $maxWeight;
                $issueModel->updateItemById($midRow['id'], $updateArr);
                $maxWeight = intval($maxWeight - $decWeight);
            }
            //print_r($sortArr);
        }
        $this->ajaxSuccess('上移成功');
    }

    /**
     * 下移事项处理
     * @throws \Exception
     */
    public function moveDownIssue()
    {
        $currentId = null;
        if (isset($_POST['current_id'])) {
            $currentId = (int)$_POST['current_id'];
        }
        $targetId = null;
        if (isset($_POST['target_id'])) {
            $targetId = (int)$_POST['target_id'];
        }
        if (!$currentId || !$targetId) {
            $this->ajaxFailed('参数错误', $_POST);
        }
        $fieldWeight = 'gant_sprint_weight';
        $fields = "id,sprint,summary ,{$fieldWeight},have_children";
        $issueModel = new IssueModel();
        $currentIsuse = $issueModel->getRow($fields, ['id' => $currentId]);
        $targetIssue = $issueModel->getRow($fields, ['id' => $targetId]);
        $projectId = $currentIsuse['project_id'];
        if (!$this->isAdmin && !PermissionLogic::checkUserHaveProjectItem(UserAuth::getId(), $projectId)) {
            $this->ajaxFailed('您没有权限访问该项目,请联系管理员申请加入该项目');
        }
        if (!isset($currentIsuse[$fieldWeight]) || !isset($targetIssue[$fieldWeight])) {
            $this->ajaxFailed('参数错误,找不到事项信息', $_POST);
        }
        $currentWeight = (int)$currentIsuse[$fieldWeight];
        $targetWeight = (int)$targetIssue[$fieldWeight];
        $currentIsuse['have_children'] = (int)$currentIsuse['have_children'];
        $targetIssue['have_children'] = (int)$targetIssue['have_children'];
        // 如果两个事项都没有子任务，则交换排序权重值
        if ($currentIsuse['have_children'] == 0 && $targetIssue['have_children'] == 0) {
            if ($currentWeight == $targetWeight) {
                $currentWeight = max(0, $currentWeight - ProjectGantt::$offset);
            }
            $tmp = $currentWeight;
            $currentWeight = $targetWeight;
            $targetWeight = $tmp;
            // 执行更新操作
            $currentArr = [$fieldWeight => $currentWeight];
            $issueModel->updateItemById($currentId, $currentArr);
            $targetArr = [$fieldWeight => $targetWeight];
            $issueModel->updateItemById($targetId, $targetArr);
        } else {
            //  否则，先取出目标事项及子任务，再取出当前事项及子任务，最后这两个数组合并在重新计算排序值
            $sortArr = [];
            $sortArr[] = $targetIssue;
            // 取出目标事项及子任务
            $table = $issueModel->getTable();
            $sprintId = $targetIssue['sprint'];
            $targetId = $targetIssue['id'];
            $sql = "Select {$fields} From {$table} Where  master_id={$targetId}   AND `sprint` = {$sprintId} Order by {$fieldWeight} DESC ,start_date asc";
            $targetChildrenArr = $issueModel->db->fetchAll($sql);
            if ($targetChildrenArr && is_array($targetChildrenArr)) {
                foreach ($targetChildrenArr as $item) {
                    $sortArr[] = $item;
                }
            }
            // print_r($targetChildrenArr);
            // 取出当前事项及子任务
            $sortArr[] = $currentIsuse;
            $sprintId = $currentIsuse['sprint'];
            $sql = "Select {$fields} From {$table} Where `$fieldWeight` >$targetWeight AND `$fieldWeight`<$currentWeight   AND `sprint` = {$sprintId} Order by {$fieldWeight} DESC ";
            $currentChildrenArr = $issueModel->db->fetchAll($sql);
            if ($currentChildrenArr && is_array($currentChildrenArr)) {
                foreach ($currentChildrenArr as $item) {
                    $sortArr[] = $item;
                }
            }
            // print_r($currentChildrenArr);
            // 获取最小的权重值
            $sql = "Select {$fields} From {$table} Where  master_id={$targetId}   AND `sprint` = {$sprintId} Order by {$fieldWeight} ASC    limit 1";
            $minWeight = max(0, (int)$issueModel->getFieldBySql($sql));
            $count = count($sortArr);
            $maxWeight = $currentWeight;
            $decWeight = intval(($currentWeight - $minWeight) / $count);
            // print_r($decWeight);
            // print_r($sortArr);
            // 重新更新权重值
            foreach ($sortArr as &$midRow) {
                $updateArr = [$fieldWeight => $maxWeight];
                $midRow[$fieldWeight] = $maxWeight;
                $issueModel->updateItemById($midRow['id'], $updateArr);
                $maxWeight = intval($maxWeight - $decWeight);
            }
            //print_r($sortArr);
        }
        $this->ajaxSuccess('下移成功');
    }

    /**
     * @throws \Exception
     */
    public function saveUnDateData()
    {
        $issueIdArr = [];
        if (isset($_POST['issue_id_arr'])) {
            $issueIdArr = $_POST['issue_id_arr'];
        }
        $startDateArr = [];
        if (isset($_POST['issue_start_date_arr'])) {
            $startDateArr = $_POST['issue_start_date_arr'];
        }
        $dueDateArr = [];
        if (isset($_POST['issue_due_date_arr'])) {
            $dueDateArr = $_POST['issue_due_date_arr'];
        }
        $sprintIdArr = [];
        if (isset($_POST['sprint_id_arr'])) {
            $sprintIdArr = $_POST['sprint_id_arr'];
        }
        $sprintStartDateArr = [];
        if (isset($_POST['sprint_start_date_arr'])) {
            $sprintStartDateArr = $_POST['sprint_start_date_arr'];
        }
        $sprintDueDateArr = [];
        if (isset($_POST['sprint_due_date_arr'])) {
            $sprintDueDateArr = $_POST['sprint_due_date_arr'];
        }
        $projectId = null;
        if (isset($_POST['project_id'])) {
            $projectId = $_POST['project_id'];
        }
        if (empty($projectId)) {
            $this->ajaxFailed('提示','参数错误,提交的项目id为空', $_POST);
        }
        $updatePerm = PermissionLogic::check($projectId, UserAuth::getId(), PermissionLogic::EDIT_ISSUES);
        if (!$updatePerm) {
            $this->ajaxFailed('提示','当前项目中您没有权限进行此操作,需要编辑事项权限');
        }
        if (!$this->isAdmin && !PermissionLogic::checkUserHaveProjectItem(UserAuth::getId(), $projectId)) {
            $this->ajaxFailed('提示','您没有权限访问该项目,请联系管理员申请加入该项目');
        }
        $holidays = (new HolidayModel())->getDays($projectId);
        $extraWorkerDays = (new ExtraWorkerDayModel())->getDays($projectId);
        $ganttSetting = (new ProjectGanttSettingModel())->getByProject($projectId);
        if (empty($ganttSetting)) {
            $workDates = null;
        } else {
            $workDates = json_decode($ganttSetting['work_dates'], true);
        }
        $issueModel = new IssueModel();
        $updatedArr = [];
        $errTaskArr = [];
        $errSprintArr = [];
        try {
            $issueModel->beginTransaction();
            if (!empty($issueIdArr)) {
                foreach ($issueIdArr as $k => $issueId) {
                    $issue = $issueModel->getById($issueId);
                    if (empty($issue)) {
                        continue;
                    }
                    if($issue['start_date']=='0000-00-00'){
                        $issue['start_date'] = '';
                    }
                    if($issue['due_date']=='0000-00-00'){
                        $issue['due_date'] = '';
                    }
                    $updateArr = [];
                    if (isset($startDateArr[$k])) {
                        $startDate = $startDateArr[$k];
                        if ($issue['start_date'] != $startDate && $startDate != '') {
                            $issue['start_date'] = $updateArr['start_date'] = $startDate;
                        }
                    }
                    if (isset($dueDateArr[$k])) {
                        $endDate = $dueDateArr[$k];
                        if ($endDate != '') {
                            $issue['due_date'] = $updateArr['due_date'] = $endDate;
                        }
                    }
                    if (strtotime($issue['due_date']) < strtotime($issue['start_date'])) {
                        $errTaskArr[] = $issue;
                        continue;
                    }
                    $newDuration = getWorkingDays($issue['start_date'], $issue['due_date'], $workDates, $holidays, $extraWorkerDays);
                    if ($newDuration != $issue['duration']) {
                        $updateArr['duration'] = $newDuration;
                    }
                    if (!empty($updateArr)) {
                        $updatedArr['task-' . $issueId] = $updateArr;
                        $issueModel->updateItemById($issueId, $updateArr);
                    }
                }
            }
            $sprintModel = new SprintModel();
           // print_r($sprintIdArr);
            if (!empty($sprintIdArr)) {
                foreach ($sprintIdArr as $k => $sprintId) {
                    $sprint = $sprintModel->getById($sprintId);
                    if (empty($sprint)) {
                        continue;
                    }
                    if($sprint['start_date']=='0000-00-00'){
                        $sprint['start_date'] = '';
                    }
                    if($sprint['end_date']=='0000-00-00'){
                        $sprint['end_date'] = '';
                    }
                    $updateArr = [];
                    if (isset($sprintStartDateArr[$k])) {
                        $startDate = $sprintStartDateArr[$k];
                        if ($startDate != '') {
                            $sprint['start_date'] = $updateArr['start_date'] = $startDate;
                        }
                    }
                    if (isset($sprintDueDateArr[$k])) {
                        $endDate = $sprintDueDateArr[$k];
                        if ( $endDate != '') {
                            $sprint['end_date'] = $updateArr['end_date'] = $endDate;
                        }
                    }
                    if (strtotime($sprint['end_date']) < strtotime($sprint['start_date'])) {
                        $errSprintArr[] = $sprint;
                        continue;
                    }
                    if (!empty($updateArr)) {
                        $updatedArr['sprint-' . $sprintId] = $updateArr;
                        $sprintModel->updateById($sprintId, $updateArr);
                    }
                }
            }
            if(!empty($errSprintArr) || !empty($errTaskArr)){
                $issueModel->rollBack();
                $errSprintStr = '迭代:';
                foreach ($errSprintArr as $errSprint){
                    $errSprintStr.="{$errSprint['name']},";
                }
                if($errSprintStr!='迭代:'){
                    $errSprintStr.="截止日期不能小于开始日期";
                    $this->ajaxFailed('提示',$errSprintStr);
                }
                $errTaskStr = '事项id:';
                foreach ($errTaskArr as $errTask){
                    $errTaskStr.="{$errTask['id']},";
                }
                if($errTaskStr!='事项:'){
                    $errTaskStr.="截止日期不能小于开始日期";
                    $this->ajaxFailed('提示',$errTaskStr);
                }
            }
            $issueModel->commit();
        } catch (\Exception $e) {
            $issueModel->rollBack();
            $this->ajaxFailed('提示','服务器执行错误:'.$e->getMessage());
        }
        $this->ajaxSuccess('保存成功', $updatedArr);
    }

    /**
     *
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Exception
     */
    public function updateIssueDate()
    {
        $issueId = null;
        if (isset($_POST['issue_id'])) {
            $issueId = (int)$_POST['issue_id'];
        }
        $startDate = '';
        if (isset($_POST['start_date'])) {
            $startDate = $_POST['start_date'];
        }
        $endDate = '';
        if (isset($_POST['due_date'])) {
            $endDate = $_POST['due_date'];
        }
        $duration = null;
        if (isset($_POST['duration'])) {
            $duration = $_POST['duration'];
        }
        if (!$issueId) {
            $this->ajaxFailed('参数错误', $_POST);
        }
        if (intval($issueId) <= 0) {
            $this->ajaxSuccess("事项id {$issueId} 无效");
        }
        $issueModel = new IssueModel();
        $issue = $issueModel->getById($issueId);
        if (empty($issue)) {
            $this->ajaxSuccess("事项id {$issueId} 无效");
        }

        $projectId = $issue['project_id'];
        $updatePerm = PermissionLogic::check($projectId, UserAuth::getId(), PermissionLogic::EDIT_ISSUES);
        if (!$updatePerm) {
            $this->ajaxFailed('当前项目中您没有权限进行此操作,需要编辑事项权限');
        }
        if (!$this->isAdmin && !PermissionLogic::checkUserHaveProjectItem(UserAuth::getId(), $projectId)) {
            $this->ajaxFailed('您没有权限访问该项目,请联系管理员申请加入该项目');
        }
        $updateArr = [];
        if ($issue['start_date'] != $startDate) {
            $updateArr['start_date'] = $startDate;
        }
        if ($issue['due_date'] != $endDate) {
            $updateArr['due_date'] = $endDate;
        }
        if ($duration != null) {
            $updateArr['duration'] = $duration;
        } else {
            $holidays = (new HolidayModel())->getDays($issue['project_id']);
            $extraWorkerDays = (new ExtraWorkerDayModel())->getDays($issue['project_id']);
            $ganttSetting = (new ProjectGanttSettingModel())->getByProject($issue['project_id']);
            if (empty($ganttSetting)) {
                $workDates = null;
            } else {
                $workDates = json_decode($ganttSetting['work_dates'], true);
            }
            $updateArr['duration'] = getWorkingDays($updateArr['start_date'], $updateArr['due_date'], $workDates, $holidays, $extraWorkerDays);
        }

        if (!empty($updateArr)) {
            list($ret, $msg) = $issueModel->updateItemById($issueId, $updateArr);
            if (!$ret) {
                $this->ajaxFailed('操作失败,数据库执行失败：' . $msg);
            }
        }
        $this->ajaxSuccess('同步成功');
    }

    /**
     * 向左移动事项
     * @throws \Exception
     */
    public function outdent()
    {
        $issueId = null;
        if (isset($_POST['issue_id'])) {
            $issueId = (int)$_POST['issue_id'];
        }

        $masterId = '0';
        if (isset($_POST['old_master_id'])) {
            $masterId = (int)$_POST['old_master_id'];
        }

        $children = [];
        if (isset($_POST['children'])) {
            $children = $_POST['children'];
        }

        if (!$issueId) {
            $this->ajaxFailed('参数错误', $_POST);
        }
        $issueModel = new IssueModel();
        $issue = $issueModel->getById($issueId);
        $projectId = $issue['project_id'];
        if (!$this->isAdmin && !PermissionLogic::checkUserHaveProjectItem(UserAuth::getId(), $projectId)) {
            $this->ajaxFailed('您没有权限访问该项目,请联系管理员申请加入该项目');
        }
        $level = 0;
        if ($masterId != '0') {
            $masterIssue = $issueModel->getById($masterId);
            if (!empty($masterIssue) && isset($masterIssue['master_id'])) {
                $masterId = $masterIssue['master_id'];
                $level = (int)$masterIssue['level'];
            }
        }

        $currentInfo = [];
        $currentInfo['level'] = $level;
        $currentInfo['master_id'] = $masterId;
        list($ret, $msg) = $issueModel->updateItemById($issueId, $currentInfo);
        if (!$ret) {
            $this->ajaxFailed('操作失败,数据库执行失败：' . $msg);
        }
        if ($masterId != '0') {
            $issueModel->inc('have_children', $masterId, 'id');
        }

        if (!empty($children)) {
            foreach ($children as $childId) {
                $childLevel = max(1, intval($level - 1));
                $issueModel->updateItemById($childId, ['level' => $childLevel, 'master_id' => $issueId]);
                $issueModel->inc('have_children', $issueId, 'id');
            }
        }
        if (!empty($issue['master_id']) && $issue['master_id'] != '0') {
            $issueModel->dec('have_children', $issue['master_id'], 'id');
        }
        $this->ajaxSuccess('向左同步成功', []);
    }

    /**
     * 向右移动事项
     * @throws \Exception
     */
    public function indent()
    {
        $issueId = null;
        if (isset($_POST['issue_id'])) {
            $issueId = (int)$_POST['issue_id'];
        }

        $masterId = '0';
        if (isset($_POST['master_id'])) {
            $masterId = (int)$_POST['master_id'];
        }
        $children = [];
        if (isset($_POST['children'])) {
            $children = $_POST['children'];
        }

        if (!$issueId) {
            $this->ajaxFailed('参数错误', $_POST);
        }
        $issueModel = new IssueModel();
        $issue = $issueModel->getById($issueId);
        if (!isset($issue['id'])) {
            $this->ajaxFailed('参数错误', $_POST);
        }
        $projectId = $issue['project_id'];
        if (!$this->isAdmin && !PermissionLogic::checkUserHaveProjectItem(UserAuth::getId(), $projectId)) {
            $this->ajaxFailed('您没有权限访问该项目,请联系管理员申请加入该项目');
        }
        $currentInfo = [];
        $currentInfo['level'] = max(0, (int)$issue['level'] - 1);
        $currentInfo['master_id'] = $masterId;
        list($ret, $msg) = $issueModel->updateItemById($issueId, $currentInfo);
        if ($ret) {
            if (!empty($children)) {
                foreach ($children as $childId) {
                    $issueModel->dec('level', $childId, 'id');
                }
            }
            if ($masterId != '0') {
                $issueModel->inc('have_children', $masterId, 'id');
            }
            if (!empty($issue['master_id']) && $issue['master_id'] != '0') {
                $issueModel->dec('have_children', $issue['master_id'], 'id');
            }
        } else {
            $this->ajaxFailed($msg);
        }

        $this->ajaxSuccess('向右同步成功', $_POST);
    }

    /**
     * 计算百分比
     * @param $rows
     * @param $count
     */
    private function percent(&$rows, $count)
    {
        foreach ($rows as &$row) {
            if ($count <= 0) {
                $row['percent'] = 0;
            } else {
                $row['percent'] = floor(intval($row['count']) / $count * 100);
            }
        }
    }
}
