<?php

/**
 * Created by PhpStorm.
 * User: sven
 * Date: 2017/7/7 0007
 * Time: 下午 3:56
 */

namespace main\app\classes;

use main\app\model\agile\AgileBoardModel;
use main\app\model\issue\IssueResolveModel;
use main\app\model\issue\IssueStatusModel;
use main\app\model\issue\IssueTypeModel;
use main\app\model\issue\IssueModel;
use main\app\model\issue\IssueLabelDataModel;
use main\app\model\agile\SprintModel;
use main\app\model\project\ProjectLabelModel;
use main\app\model\project\ProjectModuleModel;
use main\app\model\project\ProjectFlagModel;

class AgileLogic
{
    const BACKLOG_VALUE = 0;

    const ACTIVE_SPRINT_BOARD_ID = 1;

    const ORDER_WEIGHT_OFFSET = 100000;

    public function getSprints($projectId)
    {
        $model = new SprintModel();
        $rows = $model->getItemsByProject($projectId);
        return $rows;
    }

    /**
     *
     * @param $projectId
     * @return array
     */
    public function getBoardsByProject($projectId)
    {
        $boards = [];
        // 首先获取活动的Sprint
        $model = new AgileBoardModel();
        $activeSprintBoard = $model->getById(self::ACTIVE_SPRINT_BOARD_ID);
        $boards[] = &$activeSprintBoard;
        // 其次获取其他Sprint
        $sprintModel = new SprintModel();
        $sprints = $sprintModel->getItemsByProject($projectId);
        foreach ($sprints as $sprint) {
            if ($sprint['active'] == '1') {
                $activeSprintBoard['name'] = $sprint['name'] . '(进行中)';
                $activeSprintBoard['type'] = 'sprint';
                continue;
            }
            $board = $activeSprintBoard;
            $board['id'] = self::ACTIVE_SPRINT_BOARD_ID;
            $board['name'] = $sprint['name'];
            $board['type'] = 'sprint';
            $board['project_id'] = $projectId;
            $boards[] = $board;
        }

        // 最后项目自定义的 board
        $customBoards = $model->getsByProject($projectId);
        foreach ($customBoards as $customBoard) {
            $customBoard['type'] = 'custom_board';
        }
        $boards = $boards + $customBoards;
        return $boards;
    }

    /**
     * 获取 backlog 事项
     * @param $projectId
     * @return array
     * @throws \Exception
     */
    public function getBacklogIssues($projectId)
    {
        $params = [];
        $sql = " WHERE sprint=" . self::BACKLOG_VALUE;

        // 所属项目
        $sql .= " AND project_id=:project_id";
        $params['project_id'] = $projectId;
        // sprint = 0
        $sql .= " AND sprint=:backlog_value";
        $params['backlog_value'] = self::BACKLOG_VALUE;

        // 非关闭状态
        $issueStatusModel = new IssueStatusModel();
        $closedStatusId = $issueStatusModel->getIdByKey('closed');
        $sql .= " AND status!=:status_id";
        $params['status_id'] = $closedStatusId;

        $model = new IssueModel();
        $table = $model->getTable();
        try {
            $field = '*';
            $order = " Order By backlog_weight DESC , priority ASC,id DESC";
            $sql = "SELECT {$field} FROM  {$table} " . $sql;
            $sql .= ' ' . $order;
            //echo $sql;die;
            $issues = $model->db->getRows($sql, $params);
            $this->updateBacklogOrderWeight($projectId, $issues);
            return [true, $issues];
        } catch (\PDOException $e) {
            return [false, $e->getMessage()];
        }
    }

    /**
     * 注意:对backlog的事项进行排序将带来性能问题,当没有完全更新失败时，要记录失败次数,当次数太多时不再进行排序，并写入错误日志
     * @param $projectId
     * @param $issues
     * @return array
     * @throws \PDOException
     * @throws \Exception
     */
    public function updateBacklogOrderWeight($projectId, $issues)
    {
        if (empty($issues)) {
            return [false, "issues_is_empty:"];
        }
        $issuesWeightArr = [];
        $count = count($issues) + 1;
        $weight = $count * self::ORDER_WEIGHT_OFFSET;
        foreach ($issues as $issue) {
            $weight = intval($weight - self::ORDER_WEIGHT_OFFSET);
            $issueid = (int)$issue['id'];
            $issuesWeightArr[$issueid] = $weight;
        }
        unset($issues);
        $issuesWeightJson = json_encode($issuesWeightArr);
        $issueModel = new IssueModel();
        $model = new ProjectFlagModel();
        $flagName = 'backlog_weight';
        $dbIssueWeightJson = $model->getValueByFlag($projectId, $flagName);
        if (empty($dbIssueWeightJson) || $issuesWeightJson != $dbIssueWeightJson) {
            try {
                $model->db->beginTransaction();
                foreach ($issuesWeightArr as $key => $weight) {
                    list($updateRet) = $issueModel->updateById($key, [$flagName => $weight]);
                    if (!$updateRet) {
                        $model->db->rollBack();
                        return [false, $key . " update {$flagName} => {$weight} failed"];
                    }
                }
                $info = [];
                $info['project_id'] = $projectId;
                $info['flag'] = $flagName;
                $info['value'] = $issuesWeightJson;
                $info['update_time'] = time();
                $model->replace($info);
                $model->db->commit();
                return [true, $issuesWeightJson];
            } catch (\PDOException $exception) {
                $model->db->rollBack();
                return [false, "server_error:" . $exception->getMessage()];
            }
        } else {
            return [true, 'not update'];
        }
    }

    public function updateSprintIssuesOrderWeight($projectId, $sprintId, $issues)
    {
        if (empty($issues)) {
            return [false, "issues_is_empty:"];
        }
        $issuesWeightArr = [];
        $count = count($issues) + 1;
        $weight = $count * self::ORDER_WEIGHT_OFFSET;
        foreach ($issues as $issue) {
            $weight = intval($weight - self::ORDER_WEIGHT_OFFSET);
            $issueid = (int)$issue['id'];
            $issuesWeightArr[$issueid] = $weight;
        }
        unset($issues);
        $issuesWeightJson = json_encode($issuesWeightArr);
        $issueModel = new IssueModel();
        $model = new ProjectFlagModel();
        $flagName = 'sprint_weight';
        $dbIssueWeightJson = $model->getValueByFlag($projectId, $flagName);
        if (empty($dbIssueWeightJson) || $issuesWeightJson != $dbIssueWeightJson) {
            try {
                $model->db->beginTransaction();
                foreach ($issuesWeightArr as $key => $weight) {
                    list($updateRet) = $issueModel->updateById($key, [$flagName => $weight]);
                    if (!$updateRet) {
                        $model->db->rollBack();
                        return [false, $key . " update {$flagName} => {$weight} failed"];
                    }
                }
                $info = [];
                $info['project_id'] = $projectId;
                $info['flag'] = 'sprint_'.$sprintId.'_weight';
                $info['value'] = $issuesWeightJson;
                $info['update_time'] = time();
                $model->replace($info);
                $model->db->commit();
                return [true, $issuesWeightJson];
            } catch (\PDOException $exception) {
                $model->db->rollBack();
                return [false, "server_error:" . $exception->getMessage()];
            }
        } else {
            return [true, 'not update'];
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

            $closedStatusId = (int)IssueStatusModel::getInstance()->getIdByKey('closed');
            $sql .= " AND status!=:status_id";
            $params['status_id'] = $closedStatusId;

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

    public function getNotBacklogSprintIssues($sprintId)
    {
        $params = [];
        $sql = " WHERE sprint=:sprint_id";
        $params['sprint_id'] = $sprintId;

        $closedId = (int)IssueStatusModel::getInstance()->getIdByKey('closed');
        $sql .= " AND status!=:status";
        $params['status'] = $closedId;

        $model = new IssueModel();
        $table = $model->getTable();

        $field = '*';
        $order = " Order By id DESC";
        $sql = "SELECT {$field} FROM  {$table} " . $sql . ' ' . $order;
        // echo $sql;die;
        $issues = $model->db->getRows($sql, $params);
        foreach ($issues as &$issue) {
            IssueFilterLogic::formatIssue($issue);
        }
        return [];
    }

    /**
     * @todo 分页
     * @param $projectId
     * @return array
     */
    public function getClosedIssues($projectId)
    {
        $model = new IssueModel();
        $table = $model->getTable();

        $params = [];
        $sql = " WHERE 1 ";

        // 所属项目
        $sql .= " AND project_id=:project_id";
        $params['project_id'] = $projectId;

        // $sql .= " AND sprint!=:backlog_value";
        // $params['backlog_value'] = self::BACKLOG_VALUE;

        $closedId = (int)IssueStatusModel::getInstance()->getIdByKey('closed');
        $sql .= " AND status=:status";
        $params['status'] = $closedId;

        $field = '*';
        $order = " Order By priority Asc,id DESC";
        $sql = "SELECT {$field} FROM  {$table} " . $sql . ' ' . $order;
        //echo $sql;die;
        $issues = $model->db->getRows($sql, $params);
        foreach ($issues as &$issue) {
            IssueFilterLogic::formatIssue($issue);
        }
        return $issues;
    }

    public function getClosedIssuesBySprint($sprintId)
    {
        try {
            $model = new IssueModel();
            $table = $model->getTable();

            $params = [];
            $sql = " WHERE 1 ";

            $sql .= " AND sprint=:backlog_value";
            $params['backlog_value'] = $sprintId;

            $closedId = (int)IssueStatusModel::getInstance()->getIdByKey('closed');
            $sql .= " AND status=:status";
            $params['status'] = $closedId;

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
        $issueModel = new IssueModel();
        $issueTable = $issueModel->getTable();
        $issueLabelDataModel = new IssueLabelDataModel();
        $issueLabelDataTable = $issueLabelDataModel->getTable();

        $field = 'm.*,GROUP_CONCAT(ld.label_id) as label_data';
        $leftJoinTable = "{$issueLabelDataTable} ld  LEFT JOIN {$issueTable} m  ON m.id=ld.issue_id ";

        $params = [];
        $sql = " WHERE ld.project_id=:project_id";
        $params['project_id'] = $projectId;

        $sql .= " AND m.sprint!=:backlog_value";
        $params['backlog_value'] = self::BACKLOG_VALUE;

        $closedId = (int)IssueStatusModel::getInstance()->getIdByKey('closed');
        $sql .= " AND m.status!=:status";
        $params['status'] = $closedId;

        $order = " Order By id DESC";
        $sql = "SELECT {$field} FROM  {$leftJoinTable} " . $sql . ' ' . $order;
        //SELECT m.summary,GROUP_CONCAT(ld.label_id)  FROM  {$issueLabelDataTable} ld  LEFT JOIN {$issueTable} m  ON m.id=ld.issue_id
        //echo $sql;die;
        $issues = $issueModel->db->getRows($sql, $params);
        foreach ($issues as $key => &$issue) {
            if (empty($issue['id'])) {
                unset($issues[$key]);
            } else {
                IssueFilterLogic::formatIssue($issue);
            }
        }
        return $issues;
    }

    public function getSprintIssues($sprintId, $projectId)
    {
        $model = new IssueModel();
        $params = [];
        $params['sprint'] = intval($sprintId);
        $field = '*';
        $orderSql = " 1 Order By sprint_weight DESC, priority ASC,id DESC";
        $issues = $model->getRows($field, $params, $orderSql);
        $this->updateSprintIssuesOrderWeight($projectId, $sprintId, $issues);
        foreach ($issues as &$issue) {
            IssueFilterLogic::formatIssue($issue);
        }
        return $issues;
    }

    public function getBoardColumnBySprint($sprintId, & $columns)
    {
        try {
            $model = new IssueStatusModel();
            $allStatus = $model->getAll();
            $configsKeyForId = [];
            foreach ($allStatus as $s) {
                $index = $s['_key'];
                $configsKeyForId[$index] = (int)$s['id'];
            }
            unset($allStatus);

            $field = 'status';
            $fetchRet = $this->getNotBacklogSprintIssues($sprintId);
            //var_dump($getRet);
            if (empty($fetchRet)) {
                return [true, 'fetch empty issues', []];
            }
            list(, $issues) = $fetchRet;

            foreach ($columns as & $column) {
                $column['count'] = 0;
                $columnDataArr = json_decode($column['data'], true);
                if (empty($columnDataArr)) {
                    continue;
                }

                $tmp = [];
                foreach ($columnDataArr as $item) {
                    $item = trimStr($item);
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
                    //var_dump($fieldValue);
                    if (in_array($fieldValue, $tmp)) {
                        IssueFilterLogic::formatIssue($issue);
                        $column['issues'][] = $issue;
                        unset($issues[$key]);
                    }
                }
                $column['count'] = count($column['issues']);
            }
            unset($issues);
            return [true, 'ok'];
        } catch (\PDOException $e) {
            return [false, $e->getMessage()];
        }
    }

    public function getBoardColumnByLabel($projectId, &$columns)
    {
        try {
            $model = new ProjectLabelModel();
            $issueLabels = $model->getsByProject($projectId);
            if (empty($issueLabels)) {
                return [false, 'project labels is empty'];
            }
            $configsKeyForId = [];
            foreach ($issueLabels as $k => $label) {
                $index = (int)$k;
                $configsKeyForId[$index] = [];
            }
            unset($label);

            $field = 'label_data';
            list($fetchRet, $issues) = $this->getNotBacklogIssues($projectId);
            if (empty($issues) || !$fetchRet) {
                return [true, 'fetch empty issues'];
            }

            foreach ($columns as & $column) {
                $column['count'] = 0;
                $columnDataArr = json_decode($column['data'], true);
                $tmp = [];
                foreach ($columnDataArr as $item) {
                    $item = trimStr($item);
                    if (isset($configsKeyForId[$item])) {
                        $tmp[] = (int)$configsKeyForId[$item];
                    }
                }
                unset($columnDataArr);
                $column['issues'] = [];
                foreach ($issues as $issue) {
                    if (!isset($issue[$field])) {
                        continue;
                    }
                    $fieldValueArr = explode(',', $issue[$field]);
                    if (empty($fieldValueArr) || !is_array($fieldValueArr)) {
                        continue;
                    }
                    foreach ($tmp as $value) {
                        if (in_array($value, $fieldValueArr)) {
                            IssueFilterLogic::formatIssue($issue);
                            $column['issues'][] = $issue;
                            break;
                        }
                    }
                }
                $column['count'] = count($column['issues']);
            }
            unset($issues);
            return [true, 'ok'];
        } catch (\PDOException $e) {
            return [false, $e->getMessage()];
        }
    }

    public function getBoardColumnCommon($projectId, $columns, $field)
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
                return [false, 'issue_config_is_empty'];
            }

            list($fetchRet, $issues) = $this->getNotBacklogIssues($projectId);
            if (empty($issues) || !$fetchRet) {
                return [true, 'fetch empty issues'];
            }
            foreach ($columns as & $column) {
                $column['count'] = 0;
                $columnDataArr = json_decode($column['data'], true);
                $tmp = [];
                foreach ($columnDataArr as $item) {
                    $item = trimStr($item);
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
                $column['count'] = count($column['issues']);
            }
            unset($issues);
            return [true, 'ok'];
        } catch (\PDOException $e) {
            return [false, $e->getMessage()];
        }
    }
}
