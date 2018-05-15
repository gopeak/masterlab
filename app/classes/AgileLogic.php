<?php

/**
 * Created by PhpStorm.
 * User: sven
 * Date: 2017/7/7 0007
 * Time: 下午 3:56
 */

namespace main\app\classes;

use main\app\model\issue\IssueLabelModel;
use main\app\model\issue\IssueStatusModel;
use main\app\model\issue\IssueTypeModel;
use main\app\model\issue\IssueModel;
use main\app\model\agile\SprintModel;

class AgileLogic
{
    const BACKLOG_VALUE = 0;

    private function getStatusIds($statusKeyArr, $statusKeys)
    {
        $ret = [];
        foreach ($statusKeys as $key) {
            if (isset($statusKeyArr[$key])) {
                $ret[] = $statusKeyArr[$key];
            }
        }
        return $ret;
    }

    public function getSprints($projectId)
    {
        $params = [];
        $params['project_id'] = intval($projectId);
        $model = new SprintModel();
        $rows = $model->getRows('*', $params, null, 'id', 'DESC');
        return $rows;
    }

    public function getBacklogIssues($projectId)
    {
        $params = [];
        $sql = " WHERE sprint=" . self::BACKLOG_VALUE;

        // 所属项目
        $sql .= " AND project_id=:project_id";
        $params['project_id'] = $projectId;

        // 非关闭状态
        $issueStatusModel = new IssueStatusModel();
        $closedStatusId = $issueStatusModel->getIdByKey('closed');
        $sql .= " AND status!=:status_id";
        $params['status_id'] = $closedStatusId;

        $model = new IssueModel();
        $table = $model->getTable();
        try {
            $field = 'id,pkey,issue_num,project_id,reporter,assignee,issue_type,summary,priority,
            resolve,status,created,updated';
            $order = " Order By priority Asc,id DESC";
            $sql = "SELECT {$field} FROM  {$table} " . $sql;
            $sql .= ' ' . $order;
            //print_r($params);
            //echo $sql;die;
            $issues = $model->db->getRows($sql, $params);
            return [true, $issues];
        } catch (\PDOException $e) {
            return [false, $e->getMessage()];
        }
    }

    public function getSprintIssues($sprintId)
    {
        try {
            $model = new IssueModel();
            $params = [];
            $params['sprint'] = intval($sprintId);
            $field = '*';
            $orderSql = " Order By priority Asc,id DESC";
            $issues = $model->getRows($field, $params, $orderSql);
            foreach ($issues as &$issue) {
                IssueFilterLogic::formatIssue($issue);
            }

            return [true, $issues];
        } catch (\PDOException $e) {
            return [false, $e->getMessage()];
        }
    }


    public function getBoardColumnBySprint($sprintId)
    {
        $model = new IssueStatusModel();
        $allStatus = $model->getAll();
        $statusKeyArr = [];
        foreach ($allStatus as $s) {
            $statusKeyArr[$s['key']] = (int)$s['id'];
        }
        unset($allStatus);

        $model = new IssueModel();
        try {
            $todo = [];
            $todoStatusKeys = ['open', 'reopen', 'todo', 'delay'];
            $todoStatusIds = $this->getStatusIds($statusKeyArr, $todoStatusKeys);

            $inProgress = [];
            $inProgressStatusKeys = ['in_progress', 'in_review'];
            $inProgressStatusIds = $this->getStatusIds($statusKeyArr, $inProgressStatusKeys);

            $dones = [];
            $doneStatusKeys = ['resolved', 'closed', 'done'];
            $doneStatusIds = $this->getStatusIds($statusKeyArr, $doneStatusKeys);

            $params = [];
            $params['sprint'] = intval($sprintId);
            $field = '*';
            $orderSql = " Order By priority Asc,id DESC";
            $arr = $model->getRows($field, $params, $orderSql);
            foreach ($arr as $item) {
                $status = intval($item['status']);
                if (in_array($status, $todoStatusIds)) {
                    $todo[] = $item;
                }
                if (in_array($status, $inProgressStatusIds)) {
                    $inProgress[] = $item;
                }
                if (in_array($status, $doneStatusIds)) {
                    $dones[] = $item;
                }
            }
            $issues = [];
            $issues['todo'] = $todo;
            $issues['in_progress'] = $inProgress;
            $issues['done'] = $dones;

            return [true, $issues];
        } catch (\PDOException $e) {
            return [false, $e->getMessage()];
        }
    }

    public function getBoardColumnByLabel($projectId, $columns)
    {
        try {
            $model = new IssueLabelModel();
            $issueLabels = $model->getsByProject($projectId);
            if (empty($issueLabels)) {
                return [false, 'project labels is empty', []];
            }
            $labels = [];
            foreach ($issueLabels as $k => $label) {
                $index = (int)$k;
                $labels[$index] = [];
            }
            unset($label);


            $params = [];
            $sql = " WHERE 1 ";

            // 所属项目
            $sql .= " AND project_id=:project_id";
            $params['project_id'] = $projectId;

            $sql .= " AND sprint!=:backlog_value";
            $params['backlog_value'] = self::BACKLOG_VALUE;
            $issueStatusModel = new IssueStatusModel();
            $closedStatusId = (int)$issueStatusModel->getIdByKey('closed');
            $sql .= " AND status!=:status_id";
            $params['status_id'] = $closedStatusId;

            $model = new IssueModel();
            $table = $model->getTable();

            // SELECT m.*,ld.label_id  FROM  issue_main m LEFT JOIN  `issue_label_data` ld ON m.id=ld.issue_id   WHERE m.id=16937;
            $field = '*';
            $order = " Order By priority Asc,id DESC";
            $sql = "SELECT {$field} FROM  {$table} " . $sql . ' ' . $order;
            //echo $sql;die;
            $arr = $model->db->getRows($sql, $params);
            $issues = $labels;
            foreach ($arr as &$item) {
                $issueType = intval($item['issue_type']);
                $issues[$issueType][] = $item;
            }
            return [true, $issues, $issueLabels];
        } catch (\PDOException $e) {
            return [false, $e->getMessage(), []];
        }
    }

    public function getBoardColumnByType($projectId, $columns)
    {

        try {
            $model = new IssueTypeModel();
            $issueTypes = $model->getAll(true);
            $types = [];
            foreach ($issueTypes as $k => $type) {
                $index = $type['key'];
                $types[$index] = $k;
            }
            unset($type);

            $params = [];
            $sql = " WHERE 1 ";

            // 所属项目
            $sql .= " AND project_id=:project_id";
            $params['project_id'] = $projectId;

            $sql .= " AND sprint!=:backlog_value";
            $params['backlog_value'] = self::BACKLOG_VALUE;

            $model = new IssueModel();
            $table = $model->getTable();

            $field = '*';
            $order = " Order By priority Asc,id DESC";
            $sql = "SELECT {$field} FROM  {$table} " . $sql . ' ' . $order;
            //echo $sql;die;
            $issues = $model->db->getRows($sql, $params);

            foreach ($columns as & $column) {
                $columnTypeKeys = json_decode($column['data'], true);
                $tmp = [];
                foreach ($columnTypeKeys as $typeKey) {
                    if (isset($types[$typeKey])) {
                        $tmp[] = (int)$types[$typeKey];
                    }
                }
                unset($columnTypeKeys);
                $column['issues'] = [];
                foreach ($issues as $key => $issue) {
                    $issueType = (int)$issue['issue_type_id'];
                    if (in_array($issueType, $tmp)) {
                        $column['issues'][] = IssueFilterLogic::formatIssue($issue);
                        unset($issues[$key]);
                    }
                }

            }
            return [true, $issues, $issueTypes];
        } catch (\PDOException $e) {
            return [false, $e->getMessage(), []];
        }
    }

    public function getBoardColumnByModule($projectId, $columns)
    {

    }

    public function getBoardColumnByStatus($projectId, $columns)
    {

    }

    public function getBoardColumnByResolve($projectId, $columns)
    {

    }

    public function getBoardColumnCommon($projectId, $columns)
    {

    }

}
