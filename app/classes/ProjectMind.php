<?php

/**
 * Created by PhpStorm.
 * User: sven
 * Date: 2017/7/7 0007
 * Time: 下午 3:56
 */

namespace main\app\classes;

use main\app\ctrl\admin\IssueType;
use main\app\model\agile\SprintModel;
use main\app\model\issue\IssueModel;
use main\app\model\issue\IssuePriorityModel;
use main\app\model\issue\IssueResolveModel;
use main\app\model\issue\IssueStatusModel;
use main\app\model\issue\IssueTypeModel;
use main\app\model\project\ProjectGanttSettingModel;
use main\app\model\project\ProjectLabelModel;
use main\app\model\project\ProjectModel;
use main\app\model\project\ProjectModuleModel;
use main\app\model\project\ProjectVersionModel;


/**
 * 思维导图业务逻辑类
 * Class IssueLogic
 * @package main\app\classes
 */
class ProjectMind
{

    /**
     * 初始化甘特图设置
     * @param $projectId
     * @throws \Exception
     */
    public function initMindSetting($projectId)
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
            $projectGanttModel->insertByProjectId($addArr, $projectId);
        }
    }

    /**
     * @param $row
     * @return array
     */
    public static function formatRowByIssue($row, $sprint = [])
    {
        $item = [];
        $item['id'] = $row['id'];
        $item['level'] = (int)$row['level'];
        $item['gant_proj_sprint_weight'] = (int)$row['gant_proj_sprint_weight'];
        $item['code'] = '#' . $row['issue_num'];
        $item['name'] = $row['summary'];
        $item['progress'] = (int)$row['progress'];
        $item['progressByWorklog'] = false;
        $item['relevance'] = (int)$row['weight'];
        $item['type'] = $row['issue_type'];
        $item['typeId'] = $row['issue_type'];
        $item['description'] = $row['description'];
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
        $startTime = strtotime($row['start_date']);
        if (!$startTime || $startTime < strtotime('1970-01-01')) {
            $startTime = time();
            if (!empty(@$sprint['start'])) {
                $startTime = $sprint['start'];
            }
        }
        $item['start'] = $startTime * 1000;
        $item['duration'] = '';
        $dueTime = strtotime($row['due_date']);
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
            $weight = intval($row['mind_sprint_weight']);
            if (empty($weight)) {
                $key = $i;
            } else {
                $key = $count + $weight;
            }
            $tmp[$key] = $row;
        }
        krsort($tmp);
        if (intval($first['mind_sprint_weight']) == 0) {
            $w = 100000 * count($tmp);
            $issueModel = IssueModel::getInstance();
            foreach ($tmp as $k => $row) {
                $issueModel->updateItemById($row['id'], ['mind_sprint_weight' => $w]);
                $w = $w - 100000;
            }
        }
        return $tmp;
    }

    /**
     * 递归构建MyMind的数据结构
     * @param $issues
     * @param $current
     * @param $level
     */
    public function recurIssue(&$issues, &$levelRow, $level)
    {
        $level++;
        $levelRow['children'] = [];
        foreach ($issues as $k => $issue) {
            if ($issue['master_id'] == $levelRow['id']) {
                $tmp = [];
                $tmp['level'] = $level;
                $tmp['id'] = 'issue_' . $issue['id'];
                $tmp['text'] = $issue['summary'];
                $tmp['children'] = [];
                $levelRow['children'][] = $tmp;
                unset($issues[$k]);
            }
        }
        // 注意递归调用必须加个判断，否则会无限循环
        if (count($levelRow['children']) > 0) {
            // $children = $this->sortChildrenByWeight($children);
            foreach ($levelRow['children'] as &$item) {
                $this->recurIssue($issues, $item, $level);
            }
        } else {
            return;
        }
    }

    /**
     * get mind second data
     * @param $projectId
     * @param $groupByField
     * @return array
     * @throws \Exception
     */
    public function getSecondArr($projectId, $groupByField)
    {
        $secondArr = [];
        if ($groupByField == 'sprint') {
            $sprintModel = new SprintModel();
            $sprints = $sprintModel->getItemsByProject($projectId);
            $sprints[] = ['id' => '0', 'name' => '待办事项', 'order_weight' => 0, 'description' => '', 'start_date' => '', 'end_date' => '', 'status' => '1'];
            foreach ($sprints as $sprint) {
                if ($sprint['status'] != '1') {
                    continue;
                }
                $item = [];
                $item['origin_id'] = $sprint['id'];
                $item['id'] = 'sprint_' . $sprint['id'];
                $item['type'] = $groupByField;
                $item['text'] = $sprint['name'];
                $item['side'] = 'left';
                $item['layout'] = 'tree-left';
                $item['color'] = '#e33';
                $item['children'] = [];
                $secondArr[] = $item;
            }
        }
        if ($groupByField == 'module') {
            $model = new ProjectModuleModel();
            $modules = $model->getByProject($projectId);
            foreach ($modules as $module) {
                $item = [];
                $item['origin_id'] = $module['id'];
                $item['id'] = 'module_' . $module['id'];
                $item['type'] = $groupByField;
                $item['text'] = $module['name'];
                $item['side'] = 'right';
                $item['color'] = '#e33';
                $item['children'] = [];
                $secondArr[] = $item;
            }
        }
        if ($groupByField == 'issue_type') {
            $model = new IssueTypeModel();
            $issueTypes = $model->getAllItem(false);
            foreach ($issueTypes as $issueType) {
                $item = [];
                $item['origin_id'] = $issueType['_key'];
                $item['id'] = 'issue_type_' . $issueType['_key'];
                $item['type'] = $groupByField;
                $item['text'] = $issueType['name'];
                $item['side'] = 'right';
                $item['color'] = '#e33';
                $item['children'] = [];
                $secondArr[] = $item;
            }
        }
        if ($groupByField == 'priority') {
            $model = new IssuePriorityModel();
            $issuePriorityArr = $model->getAllItem(false);
            foreach ($issuePriorityArr as $priority) {
                $item = [];
                $item['origin_id'] = $priority['_key'];
                $item['id'] = 'issue_status_' . $priority['_key'];
                $item['type'] = $groupByField;
                $item['text'] = $priority['name'];
                $item['side'] = 'right';
                $item['color'] = '#e33';
                $item['children'] = [];
                $secondArr[] = $item;
            }
        }
        if ($groupByField == 'status') {
            $model = new IssueStatusModel();
            $issueStatusArr = $model->getAllItem(false);
            foreach ($issueStatusArr as $issueStatus) {
                $item = [];
                $item['origin_id'] = $issueStatus['_key'];
                $item['id'] = 'issue_status_' . $issueStatus['_key'];
                $item['type'] = $groupByField;
                $item['text'] = $issueStatus['name'];
                $item['side'] = 'right';
                $item['color'] = '#e33';
                $item['children'] = [];
                $secondArr[] = $item;
            }
        }
        if ($groupByField == 'resolve') {
            $model = new IssueResolveModel();
            $issueResolveArr = $model->getAllItem(false);
            foreach ($issueResolveArr as $issueResolve) {
                $item = [];
                $item['origin_id'] = $issueResolve['_key'];
                $item['id'] = 'issue_resolve_' . $issueResolve['_key'];
                $item['type'] = $groupByField;
                $item['text'] = $issueResolve['name'];
                $item['side'] = 'right';
                $item['color'] = '#e33';
                $item['children'] = [];
                $secondArr[] = $item;
            }
        }
        if ($groupByField == 'label') {
            $model = new ProjectLabelModel();
            $labelArr = $model->getByProject($projectId);
            foreach ($labelArr as $label) {
                $item = [];
                $item['origin_id'] = $label['id'];
                $item['id'] = 'issue_label_' . $label['id'];
                $item['type'] = $groupByField;
                $item['text'] = $label['title'];
                $item['side'] = 'right';
                $item['color'] = '#e33';
                $item['children'] = [];
                $secondArr[] = $item;
            }
        }
        if ($groupByField == 'version') {
            $model = new ProjectVersionModel();
            $versionArr = $model->getByProject($projectId);
            foreach ($versionArr as $version) {
                $item = [];
                $item['origin_id'] = $version['id'];
                $item['id'] = 'issue_version_' . $version['id'];
                $item['type'] = $groupByField;
                $item['text'] = $version['title'];
                $item['side'] = 'right';
                $item['color'] = '#e33';
                $item['children'] = [];
                $secondArr[] = $item;
            }
        }

        return $secondArr;
    }


    public function getMindIssuesByProject($projectId, $groupByField, $addFilterSql, $filterClosed = false)
    {
        $projectId = (int)$projectId;
        $issueModel = IssueModel::getInstance();
        $statusModel = new IssueStatusModel();
        $issueResolveModel = new IssueResolveModel();
        $closedId = $statusModel->getIdByKey('closed');
        $resolveId = $issueResolveModel->getIdByKey('done');

        $condition = "project_id={$projectId} {$addFilterSql} ";
        if ($filterClosed) {
            $condition .= "  AND ( status !=$closedId AND  resolve!=$resolveId ) Order by id desc";
        }
        $condition .= "  Order by id desc";
        $field = '`id`,`pkey`,`issue_num`,`project_id`,`issue_type`,`assignee`,`summary`,`priority`,`resolve`,`status`,
        `created`,`updated`,`module`,`sprint`,`assistants`,`master_id`,have_children,`progress` ';
        $sql = "select {$field} from {$issueModel->getTable()} where {$condition}";
        //echo $sql;
        $issues = $issueModel->db->getRows($sql);
        //print_r($issues);
        $finalArr = $this->getSecondArr($projectId, $groupByField);
        //print_r($finalArr);
        foreach ($finalArr as &$arr) {
            if (@$arr['type'] == 'label') {

            } else {
                foreach ($issues as $k => $issue) {
                    // $haveChildren = (int)$issue['have_children'];
                    $masterId = (int)$issue['master_id'];
                    if ($issue[$arr['type']] == $arr['origin_id'] && $masterId <= 0) {
                        $tmp = [];
                        $tmp['id'] = 'issue_' . $issue['id'];
                        $tmp['text'] = $issue['summary'];
                        $tmp['children'] = [];
                        $level = 1;
                        $this->recurIssue($issues, $tmp, $level);
                        $arr['children'][] = $tmp;
                        unset($issues[$k]);
                    }
                }
            }
        }
        foreach ($finalArr as &$arr) {
            $arr['collapsed'] = 0;
            if (count($arr['children']) > 5) {
                $arr['collapsed'] = 1;
            }
        }
        return $finalArr;
    }
}
