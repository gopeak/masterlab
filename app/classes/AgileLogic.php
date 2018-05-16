<?php

/**
 * Created by PhpStorm.
 * User: sven
 * Date: 2017/7/7 0007
 * Time: 下午 3:56
 */

namespace main\app\classes;

use main\app\model\issue\IssueLabelModel;
use main\app\model\issue\IssueResolveModel;
use main\app\model\issue\IssueStatusModel;
use main\app\model\issue\IssueTypeModel;
use main\app\model\issue\IssueModel;
use main\app\model\agile\SprintModel;
use main\app\model\project\ProjectModuleModel;

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

    public function getNotBacklogIssues($projectId)
    {
        try {
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
            foreach ($issues as &$issue) {
                IssueFilterLogic::formatIssue($issue);
            }
            return [true, $issues];
        } catch (\PDOException $e) {
            return [false, $e->getMessage()];
        }
    }

    public function getClosedIssues($projectId)
    {
        try {
            $model = new IssueModel();
            $table = $model->getTable();

            $params = [];
            $sql = " WHERE 1 ";

            // 所属项目
            $sql .= " AND project_id=:project_id";
            $params['project_id'] = $projectId;

            $sql .= " AND sprint!=:backlog_value";
            $params['backlog_value'] = self::BACKLOG_VALUE;

            $closedStatusId = (int)IssueStatusModel::getInstance()->getIdByKey('closed');
            $sql .= " AND status=:status_id";
            $params['status_id'] = $closedStatusId;

            $field = '*';
            $order = " Order By priority Asc,id DESC";
            $sql = "SELECT {$field} FROM  {$table} " . $sql . ' ' . $order;
            //echo $sql;die;
            $issues = $model->db->getRows($sql, $params);
            foreach ($issues as &$issue) {
                IssueFilterLogic::formatIssue($issue);
            }
            return $issues;
        } catch (\PDOException $e) {
            return [];
        }
    }


    public function getNotBacklogLabelIssues($projectId)
    {
        try {
            $issueModel = new IssueModel();
            $issueTable = $issueModel->getTable();
            $issueLabelDataModel = new IssueLabelDataModel();
            $issueLabelDataTable = $issueLabelDataModel->getTable();

            $params = [];
            $sql = " WHERE 1 ";

            // 所属项目
            $sql .= " AND project_id=:project_id";
            $params['project_id'] = $projectId;

            $sql .= " AND sprint!=:backlog_value";
            $params['backlog_value'] = self::BACKLOG_VALUE;

            $field = 'm.*,GROUP_CONCAT(ld.label_id) as label_data';
            $leftJoinTable = "{$issueLabelDataTable} ld  LEFT JOIN {$issueTable} m  ON m.id=ld.issue_id ";

            $order = " Order By priority Asc,id DESC";
            $sql = "SELECT {$field} FROM  {$leftJoinTable} " . $sql . ' ' . $order;
            //SELECT m.summary,GROUP_CONCAT(ld.label_id)  FROM  {$issueLabelDataTable} ld  LEFT JOIN {$issueTable} m  ON m.id=ld.issue_id
            //echo $sql;die;
            $issues = $issueModel->db->getRows($sql, $params);
            foreach ($issues as &$issue) {
                IssueFilterLogic::formatIssue($issue);
            }
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

    public function getBoardColumnByLabel($projectId, &$columns)
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

    public function getBoardColumnByType($projectId, &$columns)
    {
        return $this->getBoardColumnCommon($projectId, $columns, 'type');
    }

    public function getBoardColumnByModule($projectId, $columns)
    {
        return $this->getBoardColumnCommon($projectId, $columns, 'module');
    }

    public function getBoardColumnByStatus($projectId, $columns)
    {
        return $this->getBoardColumnCommon($projectId, $columns, 'status');
    }

    public function getBoardColumnByResolve($projectId, $columns)
    {
        return $this->getBoardColumnCommon($projectId, $columns, 'resolve');
    }

    private function getBoardColumnCommon($projectId, $columns, $field)
    {
        try {
            $model = null;

            switch ($field) {
                case 'status':
                    $model = IssueStatusModel::getInstance();
                    break;
                case 'resolve':
                    $model = IssueResolveModel::getInstance();
                    break;
                case 'issue_type':
                    $model = IssueTypeModel::getInstance();
                    break;
                case 'module':
                    $model = ProjectModuleModel::getInstance();
                    break;
            }
            if (empty($model)) {
                return [false, 'type_is_error'];
            }
            if (!method_exists($model, 'getAll')) {
                return [false, 'type_getAll_not_found'];
            }

            $configs = $model->getAll(true);
            $configsKeyForId = [];
            if ($field == 'module') {
                foreach ($configs as $k => $row) {
                    $index = $row['id'];
                    $configsKeyForId[$index] = $k;
                }
            } else {
                foreach ($configs as $k => $row) {
                    $index = $row['key'];
                    $configsKeyForId[$index] = $k;
                }
            }

            unset($row);
            if (empty($configsKeyForId)) {
                return [false, 'issue_config_is_empty', []];
            }

            list($fetchRet, $issues) = $this->getNotBacklogIssues($projectId);
            if (empty($issues) || !$fetchRet) {
                foreach ($columns as & $column) {
                    $column['issues'] = [];
                }
                return [true, 'fetch empty issues'];
            }

            foreach ($columns as & $column) {
                $columnDataArr = json_decode($column['data'], true);
                $tmp = [];
                foreach ($columnDataArr as $item) {
                    if (isset($configsKeyForId[$item])) {
                        $tmp[] = (int)$configsKeyForId[$item];
                    }
                }
                unset($columnDataArr);
                $column['issues'] = [];
                foreach ($issues as $key => $issue) {
                    if (!isset($issue[$field])) {
                        continue;
                    }
                    $fieldValue = (int)$issue[$field];
                    if (in_array($fieldValue, $tmp)) {
                        IssueFilterLogic::formatIssue($issue);
                        $column['issues'][] = $issue;
                        unset($issues[$key]);
                    }
                }
            }

            $closedColumn = $column;
            $closedColumn['name'] = 'Closed';
            $closedColumn['data'] = '';
            $closedColumn['issues'] = self::getClosedIssues($issues);
            unset($issues);
            $columns[] = $closedColumn;
            return [true, 'ok'];
        } catch (\PDOException $e) {
            return [false, $e->getMessage()];
        }
    }
}
