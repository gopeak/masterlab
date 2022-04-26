<?php

/**
 * Created by PhpStorm.
 * User: sven
 * Date: 2017/7/7 0007
 * Time: 下午 3:56
 */

namespace main\app\classes;

use main\app\model\agile\SprintModel;
use main\app\model\issue\ExtraWorkerDayModel;
use main\app\model\issue\HolidayModel;
use main\app\model\issue\IssueModel;
use main\app\model\issue\IssuePriorityModel;
use main\app\model\issue\IssueResolveModel;
use main\app\model\issue\IssueStatusModel;
use main\app\model\project\ProjectGanttSettingModel;
use main\app\model\project\ProjectModel;
use main\app\model\project\ProjectModuleModel;


/**
 * 甘特图逻辑类
 * Class IssueLogic
 * @package main\app\classes
 */
class ProjectGantt
{

    public static  $maxWeight = 100000 * 10000;

    public static $offset = 100000;


    /**
     * 初始化甘特图设置
     * @param $projectId
     * @throws \Exception
     */
    public function initGanttSetting($projectId)
    {
        $projectGanttModel = new ProjectGanttSettingModel();
        $setting = $projectGanttModel->getByProject($projectId);
        if (empty($setting)) {
            $sprintModel = new SprintModel();
            $activeSprint = $sprintModel->getActive($projectId);
            $addArr = [];
            $addArr['source_type'] = 'project';
            if (!empty($activeSprint)) {
                $addArr['source_type'] = 'active_sprint';
            }
            $addArr['is_display_backlog'] = '1';
            $addArr['hide_issue_types'] = '';
            $addArr['work_dates'] = '[1,2,3,4,5]';

            $projectGanttModel->insertByProjectId($addArr, $projectId);
        }
    }

    /**
     * @param $row
     * @return array
     */
    public static function formatRowByIssue($row, $sprint = [], $sprintDuration)
    {
        $item = [];
        $item['id'] = $row['id'];
        $item['level'] = (int)$row['level'];
        $item['gant_sprint_weight'] = (int)$row['gant_sprint_weight'];
        $item['code'] = '#' . $row['issue_num'];
        $item['name'] = $row['summary'];
        $item['sprint_info'] = $sprint;
        $item['progress'] = (int)$row['progress'];
        $item['progressByWorklog'] = false;
        $item['relevance'] = (int)$row['weight'];
        $item['type'] = $row['issue_type'];
        $item['typeId'] = $row['issue_type'];
        $item['description'] = isset($row['description']) ? $row['description']:'';
        $item['status'] = 'STATUS_DONE'; //$row['status'];
        $item['depends'] = $row['depends'];
        $item['canWrite'] = true;
        $item['start_date'] = $row['start_date'];
        $item['start'] = strtotime($row['start_date']);
        $item['end'] = strtotime($row['due_date']);
        $item['due_date'] = $row['due_date'];
        $item['startIsMilestone'] = false;
        $item['endIsMilestone'] = false;
        $item['collapsed'] = false;
        $item['assigs'] = $row['assignee'];// explode(',', $row['assistants']);
        $item['hasChild'] = (bool)$row['have_children'];
        $item['master_id'] = $row['master_id'];
        $item['have_children'] = $row['have_children'];

        $isUseSprintTime = false;
        $startTime = strtotime($row['start_date']);
        if (!$startTime || $startTime < strtotime('1970-01-01')) {
            $isUseSprintTime = true;
            $startTime = time();
            if (!empty(@$sprint['start'])) {
                $startTime = $sprint['start'];
            }
        }
        $item['start'] = $startTime * 1000;
        $item['duration'] = '';
        $dueTime = strtotime($row['due_date']);
        if (!$dueTime || $dueTime < strtotime('1970-01-01')) {
            $isUseSprintTime = true;
            $dueTime = time();
            if (!empty(@$sprint['end'])) {
                $dueTime = $sprint['end'];
            }
        }
        $item['end'] = $dueTime * 1000;

        $item['duration'] = $row['duration'];
        // 如果使用迭代的开始和截止日期
        if($isUseSprintTime){
            $item['duration'] =   $sprintDuration;
        }

        return $item;
    }

    public static function reFormatIssueDate($item, $issue, $sprint)
    {
        $startTime = strtotime($issue['start_date']);
        if (!$startTime || $startTime < strtotime('1970-01-01')) {
            $startTime = time();
            if (!empty(@$sprint['start'])) {
                $startTime = $sprint['start'];
            }
        }
        $item['start'] = $startTime * 1000;
        $item['duration'] = '';
        $dueTime = strtotime($issue['due_date']);
        if (!$dueTime || $dueTime < strtotime('1970-01-01')) {
            $dueTime = time();
            if (!empty(@$sprint['end'])) {
                $dueTime = $sprint['end'];
            }
        }
        $item['end'] = $dueTime * 1000;

        $item['duration'] = floor((($dueTime + 86400) - $startTime) / 86400);
        return $item;
    }
    /**
     * @param $sprint
     * @return array
     */
    public static function formatRowBySprint($sprint)
    {
        $item = [];
        $item['id'] = intval('-' . $sprint['id']);
        $item['level'] = 0;
        $item['code'] = '#sprint' . $sprint['id'];
        if (empty($sprint['id'])) {
            $item['code'] = '#' . 'backlog';
        }
        $item['name'] = $sprint['name'];
        $item['sprint_info'] = $sprint;
        $item['progress'] = 0;
        $item['progressByWorklog'] = false;
        $item['relevance'] = (int)$sprint['order_weight'];
        $item['type'] = 'sprint';
        $item['typeId'] = '1';
        $item['description'] = $sprint['description'];
        $item['status'] = 'STATUS_ACTIVE';
        $item['depends'] = '';
        $item['canWrite'] = true;
        $item['start'] = strtotime($sprint['start_date']) * 1000;
        $item['end'] = strtotime($sprint['end_date']) * 1000;
        $item['startIsMilestone'] = false;
        $item['endIsMilestone'] = false;
        $item['collapsed'] = false;
        $item['assigs'] = '';
        $item['hasChild'] = true;
        $item['master_id'] = '';
        $item['have_children'] = 1;

        $startTime = strtotime($sprint['start_date']);
        if (!$startTime) {
            $startTime = time();
        }
        $item['start'] = $startTime * 1000;
        $item['duration'] = '';
        $dueTime = strtotime($sprint['end_date']);
        if (!$dueTime) {
            $dueTime = time();
        }
        $item['end'] = $dueTime * 1000;
        $item['duration'] = floor((($dueTime + 86400) - $startTime) / 86400);
        return $item;
    }


    /**
     * @param $children
     * @return array
     * @throws \Exception
     */
    public function sortChildrenByWeight($children)
    {
        $tmp = [];
        $i = 0;
        $count = count($children);
        $first = current($children);

        foreach ($children as $k => $row) {
            $i++;
            $weight = intval($row['gant_sprint_weight']);
            if (empty($weight)) {
                $key = $i;
            } else {
                $key = $count + $weight;
            }
            if(isset($tmp[$key])){
                $key = $key + $count;
            }
            $tmp[$key] = $row;
        }
        //print_r($tmp);
        krsort($tmp);
        if (intval($first['gant_sprint_weight']) == 0) {
            $w = 100000 * count($tmp);
            $issueModel = IssueModel::getInstance();
            foreach ($tmp as $k => $row) {
                //$issueModel->updateItemById($row['id'], ['gant_sprint_weight' => $w]);
                $w = $w - 100000;
            }
        }
        return $tmp;
    }

    /**
     * 递归构建JqueryGantt的数据结构
     * @param $rows
     * @param $levelRow
     * @param $level
     * @throws \Exception
     */
    public function recurIssue(&$rows, &$levelRow, $level, $sprint, $sprintDuration)
    {
        $level++;
        $levelRow['children'] = [];
        if($levelRow['id']==168){
            //print_r($rows);
            //print_r($sprint);
        }

        foreach ($rows as $k => $row) {
            if ($row['master_id'] == intval($levelRow['id'])) {
                $row['level'] = $level;
                $levelRow['children'][] = self::formatRowByIssue($row, $sprint, $sprintDuration);
                unset($rows[$k]);
            }
        }
        if($levelRow['id']==168){
            // print_r($rows);
            // print_r($levelRow);
        }

        // 注意递归调用必须加个判断，否则会无限循环
        if (count($levelRow['children']) > 0) {
            $levelRow['children'] = $this->sortChildrenByWeight($levelRow['children']);
            foreach ($levelRow['children'] as &$child) {
                $this->recurIssue($rows, $child, $level, $sprint, $sprintDuration);
            }
        } else {
            return;
        }
    }

    /**
     * 递归构建JqueryGantt的树形数据结构
     * @param $rows
     * @param $levelRow
     * @param $level
     */
    public function recurTreeIssue(&$finalArr, &$children, &$sprintIssueArr)
    {
        if(!empty($children)){
            foreach ($children as $k => $row) {
                $item = $row;
                unset($row['children']);
                $finalArr [] = $row;
                $sprintIssueArr[] = $row;
                if (count($item['children']) > 0) {
                    $this->recurTreeIssue($finalArr, $item['children'], $sprintIssueArr);
                }
            }
        }
    }

    /**
     * 按迭代分解的甘特图
     * @param $projectId
     * @param string $isDisplayBacklog
     * @return array
     * @throws \Exception
     */
    public function getIssuesGroupBySprint($projectId, $isDisplayBacklog='0')
    {
        $projectId = (int)$projectId;
        $issueModel = IssueModel::getInstance();
        $orderBy = "Order by gant_sprint_weight desc , start_date asc";

        $table = $issueModel->getTable();

        $sprintModel = new SprintModel();
        $sprints = $sprintModel->getItemsByProject($projectId);

        if($isDisplayBacklog=='1'){
            $sprints[] = ['id' => '0', 'name' => '待办事项', 'order_weight' => 0, 'description' => '', 'start_date' => '', 'end_date' => '', 'status' => '1'];
        }

        $ganttSetting = (new ProjectGanttSettingModel())->getByProject($projectId);
        $workDates = json_decode($ganttSetting['work_dates'], true);

        $finalArr = [];
        $sprintRows = [];
        foreach ($sprints as $sprint) {
            // 正常的迭代才会计算
            if(empty($sprint)){
                continue;
            }
            if ($sprint['status'] != '1') {
                continue;
            }
            $finalArr[] = self::formatRowBySprint($sprint);
            $sprintId = $sprint['id'];
            $condition = "project_id={$projectId} AND sprint={$sprintId}  AND gant_hide=0  {$orderBy}";
            $sql = "select * from {$table} where {$condition}";
            // echo $sql;
            $sprintRows[$sprint['id']]  = $issueModel->db->fetchAll($sql);
            $sprintIssueArr = [];
            // dump($sprintRows[$sprint['id']], true);exit;
            // 计算迭代的用时
            $holidays = (new HolidayModel())->getDays($projectId);
            $extraWorkerDays = (new ExtraWorkerDayModel())->getDays($projectId);
            $sprintDuration = getWorkingDays($sprint['start_date'], $sprint['end_date'], $workDates, $holidays, $extraWorkerDays);
            $treeArr = [];
            if (!empty($sprintRows[$sprint['id']])) {
                $sprintIssueArrs = $sprintRows[$sprint['id']];
                foreach ($sprintRows[$sprint['id']] as $k => &$row) {
                    $row['master_id'] = (int)$row['master_id'];
                    $row['have_children'] = (int)$row['have_children'];
                    $row['level__'] = 1;
                    $row['level'] = 1;
                    $row['children'] = [];
                    $item = self::formatRowByIssue($row, $sprint, $sprintDuration);
                    unset($sprintRows[$sprint['id']][$k]);
                    if ($row['master_id'] == 0 && $row['have_children'] > 0) {
                        unset($sprintIssueArrs[$k]);
                        $level = 1;
                        $this->recurIssue($sprintIssueArrs, $item, $level, $sprint, $sprintDuration);
                        //print_r($item);
                        $treeArr[] = $item;
                    }else{
                        if($row['master_id'] == 0){
                            $treeArr[] = $item;
                        }
                    }
                }
            }
            //dump($treeArr, true);exit;
            foreach ($treeArr as $item) {
                if(!isset($item['children']) &&  intval($item['have_children'])<=0){
                    $finalArr[] = $item;
                    $sprintIssueArr[] = $item;
                }else{
                    $tmp = $item;
                    unset($tmp['children']);
                    $finalArr[] = $tmp;
                    $sprintIssueArr[] = $tmp;
                    $this->recurTreeIssue($finalArr, $item['children'], $sprintIssueArr);
                }
            }
           //print_r($sprintIssueArr);
            // 更新排序权重值
            $this->updateProjectSprintWeight($sprintIssueArr);
        }
        return $finalArr;
    }

    /**
     * 初始化和更新排序值
     * @param $issues
     * @throws \Exception
     */
    public function updateProjectSprintWeight($issues)
    {
        $fieldWeight = 'gant_sprint_weight';
        $issueModel = new IssueModel();
        if (!empty($issues)) {
            // 初始化排序值,每个迭代最多会创建1万个事项
            $maxWeight = self::$maxWeight;
            $offset = self::$offset;
            $firstIssue = current($issues);
            if(intval($firstIssue[$fieldWeight])!=$maxWeight){
                foreach ($issues as  $issue) {
                    $issueModel->updateItemById($issue['id'], [$fieldWeight => $maxWeight]);
                    //print_r([$issue['id'], [$fieldWeight => $maxWeight]]);
                    $maxWeight = $maxWeight - $offset;
                }
            }else{
                foreach ($issues as $k=> &$issue) {
                    if($issue['id']!=$firstIssue['id']){
                        if(empty($issue[$fieldWeight])){
                            $prevIssueWeight = (int)$issues[$k-1][$fieldWeight];
                            if($prevIssueWeight>($offset*2)){
                                $currentIssueWeight = $prevIssueWeight-$offset;
                            }else{
                                $currentIssueWeight = intval($prevIssueWeight/2);
                            }
                            list($ret) = $issueModel->updateItemById($issue['id'], [$fieldWeight => $currentIssueWeight]);
                            //print_r([$issue['id'], [$fieldWeight => $currentIssueWeight]]);
                            if($ret){
                                $issue[$fieldWeight] = $currentIssueWeight;
                            }
                        }
                    }
                }
            }
        }
    }

    /**
     * @param $projectId
     * @param string $isDisplayBacklog
     * @return array
     * @throws \Exception
     */
    public function getIssuesGroupByActiveSprint($projectId, $isDisplayBacklog='0')
    {
        $projectId = (int)$projectId;
        $issueModel = IssueModel::getInstance();

        $orderBy = "Order by gant_sprint_weight desc , start_date asc";
        $table = $issueModel->getTable();


        $sprintModel = new SprintModel();
        $sprint = $sprintModel->getActive($projectId);
        $sprints = [$sprint];

        if($isDisplayBacklog=='1'){
            $sprints[] = ['id' => '0', 'name' => '待办事项', 'order_weight' => 0, 'description' => '', 'start_date' => '', 'end_date' => '', 'status' => '1'];
        }

        $ganttSetting = (new ProjectGanttSettingModel())->getByProject($projectId);
        $workDates = json_decode($ganttSetting['work_dates'], true);

        $finalArr = [];
        $sprintRows = [];
        foreach ($sprints as $sprint) {
            if(empty($sprint)){
                continue;
            }
            if ($sprint['status'] != '1') {
                continue;
            }

            $finalArr[] = self::formatRowBySprint($sprint);
            $sprintId = $sprint['id'];
            $condition = "project_id={$projectId} AND sprint={$sprintId}   AND gant_hide=0   {$orderBy}";
            $fields = "id,issue_num,issue_type,status,summary,assignee,have_children,master_id,level,depends,start_date,due_date,duration,progress,weight,gant_sprint_weight";
            $sql = "select {$fields} from {$table} where {$condition}";
            $sprintRows[$sprint['id']] = $rows = $issueModel->db->fetchAll($sql);
            $sprintIssueArr = [];
            // 计算迭代的用时
            $holidays = (new HolidayModel())->getDays($projectId);
            $extraWorkerDays = (new ExtraWorkerDayModel())->getDays($projectId);
            $sprintDuration = getWorkingDays($sprint['start_date'], $sprint['end_date'], $workDates, $holidays, $extraWorkerDays);

            $treeArr = [];
            if (!empty($sprintRows[$sprint['id']])) {
                $sprintIssueArr = $sprintRows[$sprint['id']];
                $sprintIssueArrs = $sprintRows[$sprint['id']];
                foreach ($sprintRows[$sprint['id']] as $k => &$row) {
                    $row['master_id'] = (int)$row['master_id'];
                    $row['have_children'] = (int)$row['have_children'];
                    $row['level__'] = 1;
                    $row['level'] = 1;
                    $row['children'] = [];
                    $item = self::formatRowByIssue($row, $sprint, $sprintDuration);
                    unset($sprintRows[$sprint['id']][$k]);
                    if ($row['master_id'] == 0 && $row['have_children'] > 0) {
                        unset($sprintIssueArrs[$k]);
                        $level = 1;
                        $this->recurIssue($sprintIssueArrs, $item, $level, $sprint, $sprintDuration);
                        //print_r($item);
                        $treeArr[] = $item;
                    }else{
                        if($row['master_id'] == 0){
                            $treeArr[] = $item;
                        }
                    }
                }
            }
            foreach ($treeArr as $item) {
                if (isset($item['children']) && count($item['children']) > 0) {
                    $tmp = $item;
                    unset($tmp['children']);
                    $finalArr[] = $tmp;
                    $sprintIssueArr[] = $tmp;
                    $this->recurTreeIssue($finalArr, $item['children'], $sprintIssueArr);
                } else {
                    $finalArr[] = $item;
                    $sprintIssueArr[] = $item;
                }
            }
            // 更新排序权重值
            $this->updateProjectSprintWeight($sprintIssueArr);
        }
        return $finalArr;
    }

    private function filterIssues($finalArr)
    {
        $filteredArr = [];
        if(!empty($finalArr)){
            foreach ($finalArr as $item) {
                if($item['gant_hide']=='1'){
                    $filteredArr[] = $item;
                }
            }
        }
    }

    public function batchUpdateGanttLevel()
    {
        $issueModel = new IssueModel();

        $sql = "select id from {$issueModel->getTable()} where master_id=0 AND have_children!=0";
        $level1Rows = $issueModel->db->fetchAll($sql);
        $idArr = [];
        foreach ($level1Rows as $level1Row) {
            $idArr[] = $level1Row['id'];
        }

        if (!empty($idArr)) {
            $idArrStr = implode(',', $idArr);
            $sql = "update  {$issueModel->getTable()} set level=1 where id in( $idArrStr)";
            $issueModel->db->exec($sql);
        }
        $this->batchUpdateGanttLevel2(1);
        $this->batchUpdateGanttLevel2(2);
        $this->batchUpdateGanttLevel2(3);
    }

    public function batchUpdateGanttLevel2($level)
    {
        $issueModel = new IssueModel();

        $sql = "select id from {$issueModel->getTable()} where  level={$level} AND have_children!=0";
        $level1Rows = $issueModel->db->fetchAll($sql);
        $idArr = [];
        foreach ($level1Rows as $level1Row) {
            $idArr[] = $level1Row['id'];
        }
        //print_r($idArr);
        if (!empty($idArr)) {
            $idArrStr = implode(',', $idArr);
            $newLevel = $level + 1;
            $sql = "update  {$issueModel->getTable()} set level={$newLevel} where master_id in( $idArrStr)";
            $issueModel->db->exec($sql);
        }
    }


    public function getBeHiddenIssuesByPage($projectId, $page = 1, $pageSize = 20)
    {
        $projectId = (int)$projectId;
        $issueModel = IssueModel::getInstance();
        $statusModel = new IssueStatusModel();
        $issueResolveModel = new IssueResolveModel();
        $closedId = $statusModel->getIdByKey('closed');
        $resolveId = $issueResolveModel->getIdByKey('done');

        $start = $pageSize * ($page - 1);
        $limit = " limit {$start}, " . $pageSize;

        $condition =
            "project_id={$projectId} AND gant_hide=1 AND ( status !=$closedId AND  resolve!=$resolveId ) Order by start_date asc ";

        $count = $issueModel->getFieldBySql("SELECT count(*) as cc FROM {$issueModel->getTable()} WHERE {$condition}");

        $condition .= $limit;
        $sql = "SELECT * FROM {$issueModel->getTable()} WHERE {$condition}";
        //echo $sql;
        $rows = $issueModel->db->fetchAll($sql);

        if (!empty($rows)) {
            $fieldLogic = new FieldLogic();
            $sprints = $fieldLogic->getSprintMapByProjectID($projectId);
            $modules = $fieldLogic->getModuleMapByProjectID($projectId);

            foreach ($rows as &$row) {
                $row['format_sprint_name'] = @$sprints[$row['sprint']];
                $row['format_module_name'] = @$modules[$row['module']];
                $row['format_create_time'] = date('Y-m-d H:i', $row['created']);
            }
            unset($row);
            return [$rows, $count];
        } else {
            return [[], 0];
        }




    }
}
