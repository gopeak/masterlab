<?php

/**
 * Created by PhpStorm.
 * User: sven
 * Date: 2017/7/7 0007
 * Time: 下午 3:56
 */

namespace main\app\classes;

use main\app\model\issue\IssueStatusModel;
use main\app\model\issue\IssueModel;
use main\app\model\agile\SprintModel;

class AgileLogic
{
    const BACKLOG_VALUE = 0;

    public function getBacklogs($projectId)
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


    public function getBoardBySprint($sprintId)
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
            $field = 'id,pkey,issue_num,project_id,reporter,assignee,issue_type,summary,priority,
            resolve,status,created,updated';
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

    public function getLabelIssues($projectId, $isfilterBacklog, $isfilterClosed)
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
            $field = 'id,pkey,issue_num,project_id,reporter,assignee,issue_type,summary,priority,
            resolve,status,created,updated';
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

    public function getTypeIssues($projectId, $isfilterBacklog, $isfilterClosed)
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
            $field = 'id,pkey,issue_num,project_id,reporter,assignee,issue_type,summary,priority,
            resolve,status,created,updated';
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

    public function getSprints($projectId)
    {
        $params = [];
        $params['project_id'] = intval($projectId);
        $model = new SprintModel();
        $rows = $model->getRows('*', $params, null, 'id', 'DESC');
        return $rows;
    }
}
