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
            $class->initGanttSetting($projectId);
            $ganttSetting = $projectGanttModel->getByProject($projectId);
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

        $data = [];
        $data['source_type'] = $sourceType;
        $data['is_display_backlog'] = $isDisplayBacklog;

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

        $projectGanttModel = new ProjectGanttSettingModel();
        $sourceType = 'project';
        $sourceArr = ['project', 'active_sprint', 'module'];
        if (isset($_POST['source_type'])) {
            if (in_array($_POST['source_type'], $sourceArr)) {
                $sourceType = $_POST['source_type'];
            }
        }
        $updateInfo['source_type'] = $sourceType;

        $isDisplayBacklog = '0';
        if (isset($_POST['is_display_backlog']) && $_POST['is_display_backlog']=='1') {
            $isDisplayBacklog = '1';
        }
        $updateInfo['is_display_backlog'] = $isDisplayBacklog;
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
            $resources[] = ['id' => $user['uid'], 'name' => $user['display_name']];
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
            $sourceType = $sourceType = $ganttSetting['source_type'];
        }
        $isDisplayBacklog = '0';
        if (isset($ganttSetting['is_display_backlog'])) {
            $isDisplayBacklog = $ganttSetting['is_display_backlog'];
        }

        $data['tasks'] = [];
        if ($sourceType == 'project') {
            $data['tasks'] = $class->getIssuesGroupBySprint($projectId,  $isDisplayBacklog);
        }
        if ($sourceType == 'active_sprint') {
            $data['tasks'] = $class->getIssuesGroupByActiveSprint($projectId,  $isDisplayBacklog);
        }
        $userLogic = new UserLogic();
        $users = $userLogic->getAllNormalUser();
        foreach ($data['tasks'] as &$task) {
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
        }
        unset($users);
        $data['selectedRow'] = 2;
        $data['deletedTaskIds'] = [];
        $data['resources'] = $resources;
        $data['roles'] = $roles;
        $data['canWrite'] = true;
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
        $currentIsuse = $issueModel->getRow($fields,['id'=>$currentId]);
        $targetIssue = $issueModel->getRow($fields,['id'=>$targetId]);

        if (!isset($currentIsuse[$fieldWeight]) || !isset($targetIssue[$fieldWeight])) {
            $this->ajaxFailed('参数错误,找不到事项信息', $_POST);
        }
        $currentWeight = (int)$currentIsuse[$fieldWeight];
        $targetWeight = (int)$targetIssue[$fieldWeight];
        $currentIsuse['have_children'] = (int)$currentIsuse['have_children'];
        $targetIssue['have_children'] = (int)$targetIssue['have_children'];
        // 如果两个事项都没有子任务，则交换排序权重值
        if($currentIsuse['have_children']==0 && $targetIssue['have_children']==0){
            if ($currentWeight == $targetWeight) {
                $targetWeight = max(0,$targetWeight-ProjectGantt::$offset);
            }
            $tmp = $targetWeight;
            $currentWeight = $tmp;
            $targetWeight = $currentWeight;
            // 执行更新操作
            $currentArr = [$fieldWeight => $currentWeight];
            $issueModel->updateItemById($currentId, $currentArr);
            $targetArr = [$fieldWeight => $targetWeight];
            $issueModel->updateItemById($targetId, $targetArr);
        }else{
            //  否则，先取出当前事项及子任务，再取出目标事项及子任务，最后这两个数组合并在重新计算排序值
            $sortArr = [];
            $sortArr[] = $currentIsuse;
            // 取出当前事项子任务
            $table = $issueModel->getTable();
            $sprintId = $currentIsuse['sprint'];
            $currentId = $currentIsuse['id'];
            $sql = "Select {$fields} From {$table} Where  master_id={$currentId}   AND `sprint` = {$sprintId} Order by {$fieldWeight} DESC ,start_date asc";
            $currentChildrenArr =  $issueModel->db->getRows( $sql );
            if($currentChildrenArr && is_array($currentChildrenArr)){
                foreach ($currentChildrenArr as $item) {
                    $sortArr[] = $item;
                }
            }
            // 取出目标事项子任务
            $sortArr[] = $targetIssue;
            $sprintId = $targetIssue['sprint'];
            $sql = "Select {$fields} From {$table} Where `$fieldWeight` >$currentWeight AND `$fieldWeight`<$targetWeight   AND `sprint` = {$sprintId} Order by {$fieldWeight} DESC ";
            $targetChildrenArr =  $issueModel->db->getRows( $sql );
            if($targetChildrenArr && is_array($targetChildrenArr)){
                foreach ($targetChildrenArr as $item) {
                    $sortArr[] = $item;
                }
            }
            $sql = "Select {$fields} From {$table} Where  master_id={$currentId}   AND `sprint` = {$sprintId} Order by {$fieldWeight} ASC    limit 1";
            $minWeight = max(0, (int)$issueModel->db->getOne($sql));

            $count = count($sortArr);
            $maxWeight = $targetWeight;
            $decWeight = intval(($targetWeight-$minWeight)/$count);
            // 重新更新权重值
            foreach ($sortArr as &$midRow) {
                $updateArr = [$fieldWeight=>$maxWeight];
                $midRow[$fieldWeight] = $maxWeight;
                $issueModel->updateItemById($midRow['id'], $updateArr);
                $maxWeight = intval($maxWeight-$decWeight);
            }
            //print_r($sortArr);
        }
        $this->ajaxSuccess('上移成功' );
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
        $currentIsuse = $issueModel->getRow($fields,['id'=>$currentId]);
        $targetIssue = $issueModel->getRow($fields,['id'=>$targetId]);

        if (!isset($currentIsuse[$fieldWeight]) || !isset($targetIssue[$fieldWeight])) {
            $this->ajaxFailed('参数错误,找不到事项信息', $_POST);
        }
        $currentWeight = (int)$currentIsuse[$fieldWeight];
        $targetWeight = (int)$targetIssue[$fieldWeight];
        $currentIsuse['have_children'] = (int)$currentIsuse['have_children'];
        $targetIssue['have_children'] = (int)$targetIssue['have_children'];
        // 如果两个事项都没有子任务，则交换排序权重值
        if($currentIsuse['have_children']==0 && $targetIssue['have_children']==0){
            if ($currentWeight == $targetWeight) {
                $currentWeight = max(0,$currentWeight-ProjectGantt::$offset);
            }
            $tmp = $currentWeight;
            $currentWeight = $targetWeight;
            $targetWeight = $tmp;
            // 执行更新操作
            $currentArr = [$fieldWeight => $currentWeight];
            $issueModel->updateItemById($currentId, $currentArr);
            $targetArr = [$fieldWeight => $targetWeight];
            $issueModel->updateItemById($targetId, $targetArr);
        }else{
            //  否则，先取出目标事项及子任务，再取出当前事项及子任务，最后这两个数组合并在重新计算排序值
            $sortArr = [];
            $sortArr[] = $targetIssue;
            // 取出目标事项及子任务
            $table = $issueModel->getTable();
            $sprintId = $targetIssue['sprint'];
            $targetId = $targetIssue['id'];
            $sql = "Select {$fields} From {$table} Where  master_id={$targetId}   AND `sprint` = {$sprintId} Order by {$fieldWeight} DESC ,start_date asc";
            $targetChildrenArr =  $issueModel->db->getRows( $sql );
            if($targetChildrenArr && is_array($targetChildrenArr)){
                foreach ($targetChildrenArr as $item) {
                    $sortArr[] = $item;
                }
            }
            // print_r($targetChildrenArr);
            // 取出当前事项及子任务
            $sortArr[] = $currentIsuse;
            $sprintId = $currentIsuse['sprint'];
            $sql = "Select {$fields} From {$table} Where `$fieldWeight` >$targetWeight AND `$fieldWeight`<$currentWeight   AND `sprint` = {$sprintId} Order by {$fieldWeight} DESC ";
            $currentChildrenArr =  $issueModel->db->getRows( $sql );
            if($currentChildrenArr && is_array($currentChildrenArr)){
                foreach ($currentChildrenArr as $item) {
                    $sortArr[] = $item;
                }
            }
            // print_r($currentChildrenArr);
            // 获取最小的权重值
            $sql = "Select {$fields} From {$table} Where  master_id={$targetId}   AND `sprint` = {$sprintId} Order by {$fieldWeight} ASC    limit 1";
            $minWeight = max(0, (int)$issueModel->db->getOne($sql));
            $count = count($sortArr);
            $maxWeight = $currentWeight;
            $decWeight = intval(($currentWeight-$minWeight)/$count);
            // print_r($decWeight);
            // print_r($sortArr);
            // 重新更新权重值
            foreach ($sortArr as &$midRow) {
                $updateArr = [$fieldWeight=>$maxWeight];
                $midRow[$fieldWeight] = $maxWeight;
                $issueModel->updateItemById($midRow['id'], $updateArr);
                $maxWeight = intval($maxWeight-$decWeight);
            }
            //print_r($sortArr);
        }
        $this->ajaxSuccess('下移成功' );
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

        $nextId = '0';
        if (isset($_POST['next_id'])) {
            $nextId = (int)$_POST['next_id'];
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
        $masterWeight = 0;
        $nextWeight = 0;
        $level = 0;
        $nextMasterId = 0;
        if ($masterId != '0') {
            $masterIssue = $issueModel->getById($masterId);
            if (!empty($masterIssue) && isset($masterIssue['master_id'])) {
                $masterId = $masterIssue['master_id'];
                $level = (int)$masterIssue['level'];
                $masterWeight = $masterIssue['gant_sprint_weight'];
            }
        }
        if ($nextId != '0') {
            $nextIssue = $issueModel->getById($nextId);
            if (!empty($nextIssue)) {
                $nextWeight = $nextIssue['gant_sprint_weight'];
                $nextMasterId = (int)$nextIssue['master_id'];
            }
        }
        $weight = round(($masterWeight - $nextWeight) / 2);

        $currentInfo = [];
        $currentInfo['level'] = $level;
        $currentInfo['master_id'] = $masterId;
        $currentInfo['gant_sprint_weight'] = $weight;
        $issueModel->updateItemById($issueId, $currentInfo);

        if (!empty($children)) {
            foreach ($children as $childId) {
                $issueModel->updateItemById($childId, ['master_id' => $issueId]);
            }
            $issueModel->inc('have_children', $issueId, 'id');
        }
        if (!empty($issue['master_id']) && $issue['master_id'] != '0') {
            $issueModel->dec('have_children', $issue['master_id'], 'id');
        }
        $this->ajaxSuccess('向左移动成功', []);
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
        $nextId = '0';
        if (isset($_POST['next_id'])) {
            $nextId = (int)$_POST['next_id'];
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
        $masterWeight = 0;
        $nextWeight = 0;
        if ($masterId != '0') {
            $masterIssue = $issueModel->getById($masterId);
            if (isset($masterIssue['gant_sprint_weight'])) {
                $masterWeight = $masterIssue['gant_sprint_weight'];
            }
        }
        if ($nextId != '0') {
            $nextIssue = $issueModel->getById($nextId);
            if (isset($nextIssue['gant_sprint_weight'])) {
                $nextWeight = $nextIssue['gant_sprint_weight'];
            }
        }

        $weight = round(($masterWeight - $nextWeight) / 2);

        $currentInfo = [];
        $currentInfo['level'] = max(0, (int)$issue['level'] - 1);
        $currentInfo['master_id'] = $masterId;
        $currentInfo['gant_sprint_weight'] = $weight;
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
        } else {
            $this->ajaxFailed($msg);
        }

        $this->ajaxSuccess('向右移动成功', $_POST);
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
