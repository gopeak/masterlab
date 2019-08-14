<?php

/**
 * Created by PhpStorm.
 * User: sven
 * Date: 2017/7/7 0007
 * Time: 下午 3:56
 */

namespace main\app\classes;

use main\app\model\agile\SprintModel;
use main\app\model\issue\IssueModel;
use main\app\model\issue\IssuePriorityModel;
use main\app\model\issue\IssueResolveModel;
use main\app\model\issue\IssueStatusModel;
use main\app\model\project\ProjectModel;
use main\app\model\project\ProjectModuleModel;


/**
 * 甘特图逻辑类
 * Class IssueLogic
 * @package main\app\classes
 */
class ProjectGantt
{

    public static function formatRowByIssue($row)
    {
        $item = [];
        $item['id'] = $row['id'];
        $item['level'] = (int)$row['level'];
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
        if (!$startTime) {
            $startTime = time();
        }
        $item['start'] = $startTime * 1000;
        $item['duration'] = '';
        $dueTime = strtotime($row['due_date']);
        if (!$dueTime) {
            $dueTime = time();
        }
        $item['end'] = $dueTime * 1000;

        $item['duration'] = floor((($dueTime + 86400) - $startTime) / 86400);
        return $item;
    }

    public static function formatRowBySprint($sprint)
    {
        $item = [];
        $item['id'] = intval('-' . $sprint['id']);
        $item['level'] = 0;
        $item['code'] = '#sprint' . $sprint['id'];
        $item['name'] = $sprint['name'];
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

    public static function formatRowByModule($module)
    {
        $item = [];
        $item['id'] = intval('-' . $module['id']);
        $item['level'] = 0;
        $item['code'] = '#module' . $module['id'];
        $item['name'] = $module['name'];
        $item['progress'] = 0;
        $item['progressByWorklog'] = false;
        $item['relevance'] = (int)$module['order_weight'];
        $item['type'] = 'module';
        $item['typeId'] = '2';
        $item['description'] = $module['description'];
        $item['status'] = 'STATUS_ACTIVE';
        $item['depends'] = '';
        $item['canWrite'] = true;
        $item['start'] = '';
        $item['duration'] = 1;//'';
        $item['end'] = '';
        $item['startIsMilestone'] = false;
        $item['endIsMilestone'] = false;
        $item['collapsed'] = false;
        $item['assigs'] = '';
        $item['hasChild'] = true;
        $item['master_id'] = '';
        $item['have_children'] = 1;
        return $item;
    }

    /**
     * 递归构建JqueryGantt的数据结构
     * @param $rows
     * @param $levelRow
     * @param $level
     */
    public function recurIssue(&$rows, &$levelRow, $level)
    {
        $level++;
        $levelRow['children'] = [];
        foreach ($rows as $k => $row) {
            if ($row['master_id'] == $levelRow['id']) {
                $row['level'] = $level;
                $levelRow['children'][] = self::formatRowByIssue($row);
                unset($rows[$k]);
            }
        }
        // 注意递归调用必须加个判断，否则会无限循环
        if (count($levelRow['children']) > 0) {
            foreach ($levelRow['children'] as &$item) {
                $this->recurIssue($rows, $item, $level);
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
    public function recurTreeIssue(&$finalArr, &$children)
    {
        foreach ($children as $k => $row) {
            $item = $row;
            unset($row['children']);
            $finalArr [] = $row;
            if (count($item['children']) > 0) {
                $this->recurTreeIssue($finalArr, $item['children']);
            }
        }
    }


    /**
     * 按迭代分解的甘特图
     * @param $projectId
     * @param string $type
     * @return array
     * @throws \Exception
     */
    public function getIssuesGroupBySprint($projectId)
    {
        $projectId = (int)$projectId;
        $issueModel = new IssueModel();
        $statusModel = new IssueStatusModel();
        $issueResolveModel = new IssueResolveModel();
        $closedId = $statusModel->getIdByKey('closed');
        $resolveId = $issueResolveModel->getIdByKey('done');

        $condition = "project_id={$projectId} AND ( status !=$closedId AND  resolve!=$resolveId ) Order by start_date asc";
        $sql = "select * from {$issueModel->getTable()} where {$condition}";
        //echo $sql;
        $rows = $issueModel->db->getRows($sql);

        $sprintModel = new SprintModel();
        $sprints = $sprintModel->getItemsByProject($projectId);
        $sprints[] = ['id' => '0', 'name' => '待办事项', 'order_weight' => 0, 'description' => '', 'start_date' => '', 'end_date' => '', 'status' => '1'];
        $finalArr = [];
        $sprintRows = [];
        foreach ($sprints as $sprint) {
            // 正常的迭代才会计算
            if ($sprint['status'] != '1') {
                continue;
            }
            $finalArr[] = self::formatRowBySprint($sprint);
            foreach ($rows as $k => &$row) {
                if ($row['sprint'] == $sprint['id']) {
                    $sprintRows[$sprint['id']][] = $row;
                }
            }

            $otherArr = [];
            if (!empty($sprintRows[$sprint['id']])) {
                foreach ($sprintRows[$sprint['id']] as $k => &$row) {
                    if ($row['master_id'] == '0' && intval($row['have_children']) <= 0) {
                        $row['level'] = 1;
                        $otherArr[$row['id']] = self::formatRowByIssue($row);
                    }
                }
            }


            $treeArr = [];
            if (!empty($sprintRows[$sprint['id']])) {
                foreach ($sprintRows[$sprint['id']] as $k => &$row) {
                    if ($row['master_id'] == '0' && intval($row['have_children']) > 0) {
                        $row['level__'] = 1;
                        $row['level'] = 1;
                        $row['child'] = [];
                        $item = self::formatRowByIssue($row);
                        unset($sprintRows[$sprint['id']][$k]);
                        $level = 1;
                        //print_r($item);
                        $this->recurIssue($sprintRows[$sprint['id']], $item, $level);
                        $treeArr[] = $item;
                    }
                }
            }

            foreach ($otherArr as $item) {
                $treeArr[] = $item;
            }

            foreach ($treeArr as $item) {
                if (isset($item['children']) && count($item['children']) > 0) {
                    $tmp = $item;
                    unset($tmp['children']);
                    $finalArr[] = $tmp;
                    $this->recurTreeIssue($finalArr, $item['children']);
                } else {
                    $finalArr[] = $item;
                }
            }
        }
        return $finalArr;
    }

    /**
     * 按模块分解的甘特图
     * @param $projectId
     * @return array
     * @throws \Exception
     */
    public function getIssuesGroupByModule($projectId)
    {
        $projectId = (int)$projectId;
        $issueModel = new IssueModel();
        $statusModel = new IssueStatusModel();
        $issueResolveModel = new IssueResolveModel();
        $closedId = $statusModel->getIdByKey('closed');
        $resolveId = $issueResolveModel->getIdByKey('done');
        $condition = "project_id={$projectId} AND ( status !=$closedId AND  resolve!=$resolveId ) Order by start_date asc";
        $sql = "select * from {$issueModel->getTable()} where {$condition}";
        //echo $sql;
        $rows = $issueModel->db->getRows($sql);

        $moduleModel = new ProjectModuleModel();
        $modules = $moduleModel->getByProject($projectId);
        $modules[] = ['id' => -1, 'name' => '默认', 'order_weight' => 0, 'description' => '', 'start_date' => '', 'end_date' => '', 'status' => '1'];
        $finalArr = [];
        $moduleRows = [];
        $moduleIdArr = [];
        foreach ($modules as $module) {
            $moduleIdArr[] = $module['id'];
        }
        foreach ($modules as $module) {

            $finalArr[] = self::formatRowByModule($module);
            foreach ($rows as $k => &$row) {
                $row['description'] = '';
                if (!in_array($row['module'], $moduleIdArr)) {
                    $row['module'] = -1;
                }
                if ($row['module'] == $module['id']) {
                    $moduleRows[$module['id']][] = $row;
                }
            }
            // print_r($moduleRows[$module['id']]);
            $otherArr = [];
            if (!empty($moduleRows[$module['id']])) {
                foreach ($moduleRows[$module['id']] as $k => &$row) {
                    if ($row['master_id'] == '0' && intval($row['have_children']) <= 0) {
                        $row['level'] = 1;
                        $otherArr[$row['id']] = self::formatRowByIssue($row);
                    }
                }
            }

            $treeArr = [];
            if (!empty($moduleRows[$module['id']])) {
                foreach ($moduleRows[$module['id']] as $k => &$row) {
                    if ($row['master_id'] == '0' && intval($row['have_children']) > 0) {
                        $row['level__'] = 1;
                        $row['level'] = 1;
                        $row['child'] = [];
                        $item = self::formatRowByIssue($row);
                        unset($moduleRows[$module['id']][$k]);
                        $level = 1;
                        //print_r($item);
                        $this->recurIssue($moduleRows[$module['id']], $item, $level);
                        $treeArr[] = $item;
                    }
                }
            }

            foreach ($otherArr as $item) {
                $treeArr[] = $item;
            }

            foreach ($treeArr as $item) {
                if (isset($item['children']) && count($item['children']) > 0) {
                    $tmp = $item;
                    unset($tmp['children']);
                    $finalArr[] = $tmp;
                    $this->recurTreeIssue($finalArr, $item['children']);
                } else {
                    $finalArr[] = $item;
                }
            }
        }
        // print_r($moduleRows);
        return $finalArr;
    }


    public function batchUpdateGanttLevel()
    {
        $issueModel = new IssueModel();

        $sql = "select id from {$issueModel->getTable()} where master_id=0 AND have_children!=0";
        $level1Rows = $issueModel->db->getRows($sql);
        $idArr = [];
        foreach ($level1Rows as $level1Row) {
            $idArr[] = $level1Row['id'];
        }

        if (!empty($idArr)) {
            $idArrStr = implode(',', $idArr);
            $sql = "update  {$issueModel->getTable()} set level=1 where id in( $idArrStr)";
            $issueModel->db->query($sql);
        }
        $this->batchUpdateGanttLevel2(1);
        $this->batchUpdateGanttLevel2(2);
        $this->batchUpdateGanttLevel2(3);
    }

    public function batchUpdateGanttLevel2($level)
    {
        $issueModel = new IssueModel();

        $sql = "select id from {$issueModel->getTable()} where  level={$level} AND have_children!=0";
        $level1Rows = $issueModel->db->getRows($sql);
        $idArr = [];
        foreach ($level1Rows as $level1Row) {
            $idArr[] = $level1Row['id'];
        }
        print_r($idArr);
        if (!empty($idArr)) {
            $idArrStr = implode(',', $idArr);
            $newLevel = $level + 1;
            $sql = "update  {$issueModel->getTable()} set level={$newLevel} where master_id in( $idArrStr)";
            $issueModel->db->query($sql);
        }
    }
}
