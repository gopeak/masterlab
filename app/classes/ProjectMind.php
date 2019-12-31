<?php

/**
 * Created by PhpStorm.
 * User: sven
 * Date: 2017/7/7 0007
 * Time: 下午 3:56
 */

namespace main\app\classes;

use function foo\func;
use main\app\ctrl\admin\IssueType;
use main\app\model\agile\SprintModel;
use main\app\model\issue\IssueModel;
use main\app\model\issue\IssuePriorityModel;
use main\app\model\issue\IssueResolveModel;
use main\app\model\issue\IssueStatusModel;
use main\app\model\issue\IssueTypeModel;
use main\app\model\project\MindProjectAttributeModel;
use main\app\model\project\ProjectMindSettingModel;
use main\app\model\project\MindIssueAttributeModel;
use main\app\model\project\ProjectLabelModel;
use main\app\model\project\ProjectModel;
use main\app\model\project\ProjectModuleModel;
use main\app\model\project\ProjectVersionModel;
use main\app\model\user\UserModel;


/**
 * 思维导图业务逻辑类
 * Class IssueLogic
 * @package main\app\classes
 */
class ProjectMind
{

    public static $initSettingArr = [
        'fold_count' => 5,
        'default_source' => 'sprint',
        'default_source_id' => '0',
        'is_display_label' => 1,

    ];

    /**
     * 初始化思维导图设置
     * @param $projectId
     * @throws \Exception
     */
    public function initMindSetting($projectId)
    {
        $projectGanttModel = new ProjectMindSettingModel();
        try {
            foreach (self::$initSettingArr as $key => $item) {
                $arr = [];
                $arr['project_id'] = $projectId;
                $arr['setting_key'] = $key;
                $arr['setting_value'] = $item;
                $projectGanttModel->replaceByProjectId($arr, $projectId);
                return [true, ''];
            }
        } catch (\PDOException $e) {
            return [false, $e->getMessage()];
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
     * @param $projectId
     * @param $groupByField
     * @return array
     * @throws \Exception
     */
    public function getSecondFormats($projectId, $groupByField)
    {
        static $secondFormatArr;
        $model = new MindProjectAttributeModel();
        if (!isset($secondFormatArr[$projectId])) {
            $secondFormatArr[$projectId] = $model->getByProject($projectId);
        }
        $arr = [];
        foreach ($secondFormatArr[$projectId] as $format) {
            if ($format['group_by'] == $groupByField) {
                $arr[] = $format;
            }
        }
        return $arr;
    }

    /**
     * @param $formats
     * @param $groupById
     * @return array|mixed
     */
    public function getFormatByGroupId($formats, $groupById)
    {
        foreach ($formats as $format) {
            if ($format['group_by_id'] == $groupById) {
                return $format;
            }
        }
        return [];
    }

    /**
     * @param $projectId
     * @param $source
     * @param $groupByField
     * @return mixed
     * @throws \Exception
     */
    public function getIssueFormats($projectId, $source, $groupByField)
    {
        static $issueFormatArr;
        $model = new MindIssueAttributeModel();
        $key = $source . '-' . $groupByField;
        if (!isset($issueFormatArr[$key])) {
            $issueFormatArr[$key] = $model->getByProjectSourceGroupBy($projectId, $source, $groupByField);
        }
        return $issueFormatArr[$key];
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
        $formats = $this->getSecondFormats($projectId, $groupByField);
        $itemFormatDnc = function ($groupByField, $groupById, $text, $format) {
            if (empty($format)) {
                $format['side'] = 'left';
                $format['layout'] = 'tree-left';
                $format['color'] = '#e33';
                $format['side'] = 'left';
                $format['icon'] = '';
                $format['font_family'] = '宋体, SimSun;';
                $format['font_size'] = 12;
                $format['font_bold'] = 0;
                $format['font_italic'] = 0;
                $format['bg_color'] = '';
                $format['text_color'] = '';
            }
            $item = [];
            $item['origin_id'] = $groupById;
            $item['id'] = $groupByField . '_' . $groupById;
            $item['type'] = $groupByField;
            $item['text'] = $text;
            $item['side'] = $format['side'];
            $item['layout'] = $format['layout'];
            $item['color'] = $format['color'];
            $item['font_family'] = $format['font_family'];
            $item['font_size'] = $format['font_size'];
            $item['font_bold'] = $format['font_bold'];
            $item['font_italic'] = $format['font_italic'];
            $item['bg_color'] = $format['bg_color'];
            $item['text_color'] = $format['text_color'];
            $item['children'] = [];

            return $item;
        };
        $secondArr = [];
        if ($groupByField == 'sprint') {
            $sprintModel = new SprintModel();
            $sprints = $sprintModel->getItemsByProject($projectId);
            $sprints[] = ['id' => '0', 'name' => '待办事项', 'order_weight' => 0, 'description' => '', 'start_date' => '', 'end_date' => '', 'status' => '1'];
            foreach ($sprints as $sprint) {
                if ($sprint['status'] != '1') {
                    continue;
                }
                $groupById = $sprint['id'];
                $text = $sprint['name'];
                $format = $this->getFormatByGroupId($formats, $groupById);
                $item = $itemFormatDnc($groupByField, $groupById, $text, $format);
                $secondArr[] = $item;
            }
        }
        if ($groupByField == 'module') {
            $model = new ProjectModuleModel();
            $modules = $model->getByProject($projectId);
            foreach ($modules as $module) {
                $groupById = $module['id'];
                $text = $module['name'];
                $format = $this->getFormatByGroupId($formats, $groupById);
                $item = $itemFormatDnc($groupByField, $groupById, $text, $format);
                $secondArr[] = $item;
            }
        }
        if ($groupByField == 'issue_type') {
            $model = new IssueTypeModel();
            $issueTypes = $model->getAllItem(false);
            foreach ($issueTypes as $issueType) {
                $groupById = $issueType['id'];
                $text = $issueType['name'];
                $format = $this->getFormatByGroupId($formats, $groupById);
                $item = $itemFormatDnc($groupByField, $groupById, $text, $format);
                $secondArr[] = $item;
            }
        }
        if ($groupByField == 'priority') {
            $model = new IssuePriorityModel();
            $issuePriorityArr = $model->getAllItem(false);
            foreach ($issuePriorityArr as $priority) {
                $groupById = $priority['id'];
                $text = $priority['name'];
                $format = $this->getFormatByGroupId($formats, $groupById);
                $item = $itemFormatDnc($groupByField, $groupById, $text, $format);
                $secondArr[] = $item;
            }
        }
        if ($groupByField == 'status') {
            $model = new IssueStatusModel();
            $issueStatusArr = $model->getAllItem(false);
            foreach ($issueStatusArr as $issueStatus) {
                $groupById = $issueStatus['id'];
                $text = $issueStatus['name'];
                $format = $this->getFormatByGroupId($formats, $groupById);
                $item = $itemFormatDnc($groupByField, $groupById, $text, $format);
                $secondArr[] = $item;
            }
        }
        if ($groupByField == 'resolve') {
            $model = new IssueResolveModel();
            $issueResolveArr = $model->getAllItem(false);
            foreach ($issueResolveArr as $issueResolve) {
                $groupById = $issueResolve['id'];
                $text = $issueResolve['name'];
                $format = $this->getFormatByGroupId($formats, $groupById);
                $item = $itemFormatDnc($groupByField, $groupById, $text, $format);
                $secondArr[] = $item;
            }
        }
        if ($groupByField == 'assignee') {
            $userLogic = new UserLogic();
            $projectUsers = $userLogic->getUsersAndRoleByProjectId($projectId);
            foreach ($projectUsers as $user) {
                $groupById = $user['uid'];
                $text = $user['display_name'];
                $format = $this->getFormatByGroupId($formats, $groupById);
                $item = $itemFormatDnc($groupByField, $groupById, $text, $format);
                $secondArr[] = $item;
            }
        }
        return $secondArr;
    }

    /**
     * 获取整个项目的思维导图数据结构
     * @param $projectId
     * @param $groupByField
     * @param $addFilterSql
     * @param bool $filterClosed
     * @return array
     * @throws \Exception
     */
    public function getMindIssues($projectId, $sprintId, $groupByField, $addFilterSql, $filterClosed = false)
    {
        $projectId = (int)$projectId;
        $issueModel = IssueModel::getInstance();
        $statusModel = new IssueStatusModel();
        $issueResolveModel = new IssueResolveModel();
        $closedId = $statusModel->getIdByKey('closed');
        $resolveId = $issueResolveModel->getIdByKey('done');

        $condition = "project_id={$projectId} ";
        $source = 'all';
        if (!is_null($sprintId)) {
            $condition .= "  AND sprint={$sprintId} ";
            $source = $sprintId;
        }
        if (!empty($addFilterSql)) {
            $condition .= "  AND {$addFilterSql} ";
        }
        if ($filterClosed) {
            $condition .= "  AND ( status !=$closedId AND  resolve!=$resolveId ) Order by id desc";
        }
        $condition .= "  Order by id desc";
        $field = '`id`,`pkey`,`issue_num`,`project_id`,`issue_type`,`assignee`,`summary`,`priority`,`resolve`,`status`,
        `created`,`updated`,`module`,`sprint`,`assistants`,`master_id`,have_children,`progress`,weight,start_date, due_date';
        $sql = "select {$field} from {$issueModel->getTable()} where {$condition}";
        $issues = $issueModel->db->getRows($sql);
        //print_r($issues);
        $finalArr = $this->getSecondArr($projectId, $groupByField);
        // print_r($finalArr);
        $formats = $this->getIssueFormats($projectId, $source, $groupByField);
        //var_dump($projectId, $source, $groupByField);
        //print_r($formats);
        $itemFormatDnc = function ($issueId, $text, $format) {
            if (empty($format)) {
                $format['side'] = 'left';
                $format['layout'] = 'tree-left';
                $format['color'] = '#e33';
                $format['side'] = 'left';
                $format['icon'] = '';
                $format['font_family'] = '宋体, SimSun;';
                $format['font_size'] = 12;
                $format['font_bold'] = 0;
                $format['font_italic'] = 0;
                $format['bg_color'] = '';
                $format['text_color'] = '';
            }
            $item = [];
            $item['origin_id'] = $issueId;
            $item['id'] = 'issue_' . $issueId;
            $item['type'] = 'issue';
            $item['text'] = $text;
            $item['side'] = $format['side'];
            $item['layout'] = $format['layout'];
            $item['color'] = $format['color'];
            $item['font_family'] = $format['font_family'];
            $item['font_size'] = $format['font_size'];
            $item['font_bold'] = $format['font_bold'];
            $item['font_italic'] = $format['font_italic'];
            $item['bg_color'] = $format['bg_color'];
            $item['text_color'] = $format['text_color'];
            $item['children'] = [];

            return $item;
        };
        $issueTypeModel = new IssueTypeModel();
        $issueTypeArr = $issueTypeModel->getAllItem();
        foreach ($finalArr as &$arr) {
            foreach ($issues as $k => $issue) {
                // $haveChildren = (int)$issue['have_children'];
                $masterId = (int)$issue['master_id'];
                if ($issue[$arr['type']] == $arr['origin_id'] && $masterId <= 0) {
                    $format = [];
                    if (isset($formats[$issue['id']])) {
                        $format = $formats[$issue['id']];
                    }
                    $tmp = $itemFormatDnc($issue['id'],$issue['summary'],$format);
                    $tmp['value'] = $issue['weight'];
                    $tmp['issue_type'] = $issue['issue_type'];
                    $tmp['issue_type_fa'] = isset($issueTypeArr[$issue['issue_type']]) ? $issueTypeArr[$issue['issue_type']]['font_awesome']:'';
                    $tmp['issue_priority'] = $issue['priority'];
                    $tmp['issue_status'] = $issue['status'];
                    $tmp['issue_progress'] = $issue['progress'];
                    $tmp['issue_resolve'] = $issue['resolve'];
                    $tmp['issue_assignee'] = $issue['assignee'];
                    $tmp['issue_start_date'] = $issue['start_date'];
                    $tmp['issue_due_date'] = $issue['due_date'];
                    $tmp['issue_assistants'] = $issue['assistants'];
                    $tmp['children'] = [];
                    $level = 1;
                    $this->recurIssue($issues, $tmp, $level);
                    $arr['children'][] = $tmp;
                    unset($issues[$k]);
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
