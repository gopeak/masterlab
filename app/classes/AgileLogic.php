<?php

/**
 * Created by PhpStorm.
 * User: sven
 * Date: 2017/7/7 0007
 * Time: 下午 3:56
 */

namespace main\app\classes;

use main\app\model\agile\AgileBoardColumnModel;
use main\app\model\agile\AgileBoardModel;
use main\app\model\issue\IssueResolveModel;
use main\app\model\issue\IssueStatusModel;
use main\app\model\issue\IssueTypeModel;
use main\app\model\issue\IssueModel;
use main\app\model\issue\IssueLabelDataModel;
use main\app\model\issue\IssuePriorityModel;
use main\app\model\agile\SprintModel;
use main\app\model\project\ProjectLabelModel;
use main\app\model\project\ProjectModuleModel;
use main\app\model\project\ProjectFlagModel;
use main\app\model\user\UserModel;

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

    public function getSprintCount($projectId)
    {
        $model = new SprintModel();
        $rows = $model->getItemsByProject($projectId);
        return $rows;
    }

    /**
     * @param $projectId
     * @return array
     * @throws \Exception
     */
    public function getBoardsByProject($projectId)
    {
        $boards = [];
        $model = new AgileBoardModel();
        $allBoard = $model->getByRangeAll($projectId);
        if (!empty($allBoard)) {
            $boards[] = $allBoard;
        }
        $sprintModel = new SprintModel();
        $hideSprints = $sprintModel->getRows("*", ['project_id' => $projectId, 'status' => '3']);
        $hideSprintIdArr = array_column($hideSprints, 'id');

        $otherBoards = $model->getsByAll($projectId);
        foreach ($otherBoards as $otherBoard) {
            if ($otherBoard['sprint_id']!=0 && in_array($otherBoard['sprint_id'], $hideSprintIdArr)) {
                continue;
            }
            $boards[] = $otherBoard;
        }
        return $boards;
    }

    /**
     * @param $projectId
     * @return bool
     * @throws \Doctrine\DBAL\DBALException
     */
    public function refreshSprintToBoard($projectId)
    {
        $agileBoardModel = new AgileBoardModel();
        $sprintBoards = $agileBoardModel->getsByRangeSprint($projectId);
        $insertSprintIdArr = array_column($sprintBoards, 'sprint_id');
        $agileBoardColumnModel = new AgileBoardColumnModel();
        $sprints = $this->getSprints($projectId);
        $weight = 99999;
        foreach ($sprints as $sprint) {
            $weight--;
            if (in_array($sprint['id'], $insertSprintIdArr)) {
                continue;
            }
            $board = [];
            $board['name'] = $sprint['name'];
            if ($sprint['active'] == '1') {
                $board['name'] .= "(进行中)";
            }
            $board['project_id'] = $projectId;
            $board['sprint_id'] = $sprint['id'];
            $board['type'] = 'sprint';
            $board['is_filter_backlog'] = '1';
            $board['is_filter_closed'] = '1';
            $board['weight'] = $weight;
            $board['range_type'] = 'sprint';
            $board['range_data'] = $sprint['id'];
            $board['is_system'] = '1';
            list($ret, $insertId) = $agileBoardModel->insert($board);
            if ($ret) {
                $initColumnArr = [
                    ['name' => '准 备', 'board_id' => $insertId, 'weight' => 3, 'data' => '{"status":["open","reopen","in_review","delay"],"resolve":[],"label":[],"assignee":[],"reporter":[]}'],
                    ['name' => '进行中', 'board_id' => $insertId, 'weight' => 2, 'data' => '{"status":["in_progress"],"resolve":[],"label":[],"assignee":[],"reporter":[]}'],
                    ['name' => '已完成', 'board_id' => $insertId, 'weight' => 1, 'data' => '{"status":["closed","done"],"resolve":[],"label":[],"assignee":[],"reporter":[]}']
                ];
                $agileBoardColumnModel->deleteByBoardId($insertId);
                foreach ($initColumnArr as $column) {
                    $agileBoardColumnModel->insert($column);
                }
            }
        }
        return true;
    }

    public function getBoardsByProjectV2($projectId)
    {
        $boards = [];
        $agileBoardModel = new AgileBoardModel();
        $defaultBoards = $agileBoardModel->getsBySystem($projectId);
        foreach ($defaultBoards as $board) {
            if ($board['range_type'] == 'current_sprint' || $board['name'] == '进行中的迭代') {
                continue;
            }
            $boards[] = $board;
        }
        $userBoards = $agileBoardModel->getsByUserCreate($projectId);
        foreach ($userBoards as $userBoard) {
            $boards[] = $userBoard;
        }
        $i = 0;
        foreach ($boards as &$board) {
            $i++;
            $board['i'] = $i;
        }
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
            $issues = $model->db->fetchAll($sql, $params);
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
                // print_r($info);
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

    /**
     * 更新迭代事项的排序
     * @param $projectId
     * @param $sprintId
     * @param $issues
     * @return array
     * @throws \Exception
     */
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
                $info['flag'] = 'sprint_' . $sprintId . '_weight';
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

    /**
     * 获取项目的非待办事项
     * @param $projectId
     * @return array
     */
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
            $issues = $model->db->fetchAll($sql, $params);
            foreach ($issues as &$issue) {
                IssueFilterLogic::formatIssue($issue);
            }
            return [true, $issues];
        } catch (\PDOException $e) {
            return [false, $e->getMessage()];
        }
    }

    /**
     * 处理查询的sql和参数
     * @param $sql
     * @param $params
     */
    public function getSearchSqlParam(&$sql, &$params)
    {
        $assigneeUid = null;
        if (isset($_GET[urlencode('经办人')])) {
            $userModel = new UserModel();
            $row = $userModel->getByUsername(urldecode($_GET[urlencode('经办人')]));
            if (isset($row['uid'])) {
                $assigneeUid = $row['uid'];
            }
            unset($row);
        }
        if (isset($_GET['assignee'])) {
            $assigneeUid = (int)$_GET['assignee'];
        }
        if ($assigneeUid !== null) {
            $sql .= " AND assignee=:assignee";
            $params['assignee'] = $assigneeUid;
        }

        // 谁创建的
        $reporterUid = null;
        if (isset($_GET[urlencode('报告人')])) {
            $userModel = new UserModel();
            $row = $userModel->getByUsername(urldecode($_GET[urlencode('报告人')]));
            if (isset($row['uid'])) {
                $reporterUid = $row['uid'];
            }
            unset($row);
        }
        if (isset($_GET['reporter_uid'])) {
            $reporterUid = (int)$_GET['reporter_uid'];
        }
        if ($reporterUid !== null) {
            $sql .= " AND reporter=:reporter";
            $params['reporter'] = $reporterUid;
        }

        // @todo 修改为全文索引
        // 模糊搜索
        if (isset($_GET['search'])) {
            $search = urldecode($_GET['search']);
            if (strlen($search) < 10) {
                $sql .= " AND ( LOCATE(:summary,`summary`)>0  OR pkey=:pkey)";
                $params['pkey'] = $search;
                $params['summary'] = $search;
            } else {
                $sql .= " AND  LOCATE(:summary,`summary`)>0  ";
                $params['summary'] = $search;
            }
        }

        // 优先级
        $priorityId = null;
        if (isset($_GET[urlencode('优先级')])) {
            $model = new IssuePriorityModel();
            $row = $model->getByName(urldecode($_GET[urlencode('优先级')]));
            if (isset($row['id'])) {
                $priorityId = $row['id'];
            }
            unset($row);
        }
        if (isset($_GET['priority_id'])) {
            $priorityId = (int)$_GET['priority_id'];
        }
        if ($priorityId !== null) {
            $sql .= " AND priority=:priority";
            $params['priority'] = $priorityId;
        }

        // 解决结果
        $resolveId = null;
        if (isset($_GET[urlencode('解决结果')])) {
            $resolveId = IssueResolveModel::getInstance()->getIdByName(urldecode($_GET[urlencode('解决结果')]));
            unset($row);
        }
        if (isset($_GET['resolve_id'])) {
            $resolveId = (int)$_GET['resolve_id'];
        }
        if ($resolveId !== null) {
            $sql .= " AND resolve=:resolve";
            $params['resolve'] = $resolveId;
        }
    }

    /**
     * 获取某一次迭代的非待办事项
     * @param $sprintId
     * @return array
     */
    public function getNotBacklogSprintIssues($sprintId)
    {
        $params = [];
        $sql = " WHERE sprint=:sprint_id";
        $params['sprint_id'] = $sprintId;

        $closedId = (int)IssueStatusModel::getInstance()->getIdByKey('closed');
        $sql .= " AND status!=:status";
        $params['status'] = $closedId;

        $this->getSearchSqlParam($sql, $params);

        $model = new IssueModel();
        $table = $model->getTable();

        $field = '*';
        $order = " Order By id DESC";
        $sql = "SELECT {$field} FROM  {$table} " . $sql . ' ' . $order;
        //echo $sql;
        //print_r($params);
        $issues = $model->db->fetchAll($sql, $params);
        foreach ($issues as &$issue) {
            IssueFilterLogic::formatIssue($issue);
        }
        return $issues;
    }

    /**
     * @param $projectId
     * @return array
     * @todo 分页
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
        $issues = $model->db->fetchAll($sql, $params);
        foreach ($issues as &$issue) {
            IssueFilterLogic::formatIssue($issue);
        }
        return $issues;
    }

    /**
     * 获取某一次迭代的关闭事项
     * @param $sprintId
     * @return array
     */
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
            $issues = $model->db->fetchAll($sql, $params);
            foreach ($issues as &$issue) {
                IssueFilterLogic::formatIssue($issue);
            }
            return $issues;
        } catch (\PDOException $e) {
            return [];
        }
    }

    /**
     * 获取某一项目的标签事项
     * @param $projectId
     * @return array
     */
    public function getNotBacklogLabelIssues($projectId)
    {
        try {
            $issueModel = new IssueModel();
            $issueTable = $issueModel->getTable();
            $issueLabelDataModel = new IssueLabelDataModel();
            $issueLabelDataTable = $issueLabelDataModel->getTable();

            $field = 'm.*,GROUP_CONCAT(DISTINCT ld.label_id) as label_data';
            $leftJoinTable = " {$issueTable} m  LEFT JOIN {$issueLabelDataTable} ld   ON m.id=ld.issue_id ";

            $params = [];
            $sql = " WHERE m.project_id=:project_id";
            $params['project_id'] = $projectId;

            $sql .= " AND m.sprint!=:backlog_value";
            $params['backlog_value'] = self::BACKLOG_VALUE;

            $closedId = (int)IssueStatusModel::getInstance()->getIdByKey('closed');
            $sql .= " AND m.status!=:status";
            $params['status'] = $closedId;

            $order = " Order By id DESC";
            $sql = "SELECT {$field} FROM  {$leftJoinTable} " . $sql . '  GROUP BY m.id  ' . $order . "";
            //echo $sql;
            //print_r($params);
            $issues = $issueModel->db->fetchAll($sql, $params);
            foreach ($issues as $key => &$issue) {
                if (empty($issue['id'])) {
                    unset($issues[$key]);
                } else {
                    IssueFilterLogic::formatIssue($issue);
                }
            }
            return $issues;
        } catch (\PDOException $e) {
            return [];
        }
    }

    /**
     * 获取迭代的事项
     * @param $sprintId
     * @param $projectId
     * @param null $sortField
     * @param null $sortBy
     * @return array
     * @throws \Exception
     */
    public function getSprintIssues($sprintId, $projectId, $sortField = null, $sortBy = 'desc')
    {
        $model = new IssueModel();
        $params = [];
        $params['sprint'] = intval($sprintId);
        $field = '*';
        $orderSql = " 1 Order By sprint_weight DESC, priority ASC,id DESC";
        if (!empty($sortField)) {
            $orderSql = " 1 Order By {$sortField} {$sortBy}";
        }
        // var_dump($orderSql);die;
        $issues = $model->getRows($field, $params, $orderSql);
        $this->updateSprintIssuesOrderWeight($projectId, $sprintId, $issues);
        foreach ($issues as &$issue) {
            IssueFilterLogic::formatIssue($issue);
        }
        return $issues;
    }


    /**
     * 获取看板的泳道数据
     * @param $projectId
     * @param $board
     * @param $columns
     * @return array
     * @throws \Exception
     */
    public function getBoardColumnCommon($projectId, $board, &$columns)
    {
        try {
            $issueModel = new IssueModel();
            $issueStatusModel = IssueStatusModel::getInstance();
            $issueResolveModel = IssueResolveModel::getInstance();
            $issueLabelDataModel = IssueLabelDataModel::getInstance();
            $model = new SprintModel();
            $activeSprint = $model->getActive($projectId);
            $activeSprintId = null;
            if ($activeSprint) {
                $activeSprintId = $activeSprint['id'];
            }

            $statusKeyArr = [];
            foreach ($issueStatusModel->getAll(false) as $item) {
                $statusKeyArr[$item['_key']] = $item['id'];
            }
            $resolveKeyArr = [];
            foreach ($issueResolveModel->getAll(false) as $item) {
                $resolveKeyArr[$item['_key']] = $item['id'];
            }
            foreach ($columns as &$column) {
                $column['count'] = 0;
                $column['issues'] = [];
                $filterDataArr = json_decode($column['data'], true);
                $params = [];
                $sql = " WHERE  (  ";
                $filtered = false;
                foreach ($filterDataArr as $type => $itemArr) {
                    if ($type == 'status' && !empty($itemArr)) {
                        $filtered = true;
                        $idArr = self::getIdArrByKeys($statusKeyArr, $itemArr);
                        // 按状态搜索事项
                        $statusId = null;
                        if (isset($_GET[urlencode('状态')])) {
                            $model = new IssueStatusModel();
                            $row = $model->getByName(urldecode($_GET[urlencode('状态')]));
                            if (isset($row['id'])) {
                                $statusId = $row['id'];
                            }
                            unset($row);
                        }
                        if (isset($_GET['status_id'])) {
                            $statusId = (int)$_GET['status_id'];
                        }
                        if (empty($statusId)) {
                            $sql .= "  `status` in ( :status ) ";
                            $params['status'] = implode(',', $idArr);
                        } else if (in_array($statusId, $idArr)) {
                            $sql .= "  `status`=:status";
                            $params['status'] = $statusId;
                        } else if (!in_array($statusId, $idArr)) {
                            $sql .= "  `status`=:status";
                            $params['status'] = 0;
                        } else {
                            $sql .= "  `status` in (:status) ";
                            $params['status'] = implode(',', $idArr);
                        }
                    }
                    if ($type == 'resolve' && !empty($itemArr)) {
                        $filtered = true;
                        $or = trimStr($sql) == "WHERE (" ? '' : 'OR ';
                        $sql .= $or . "   `resolve` in (:resolve) ";
                        $idArr = self::getIdArrByKeys($resolveKeyArr, $itemArr);
                        $params['resolve'] = implode(',', $idArr);
                    }
                    if ($type == 'assignee' && !empty($itemArr)) {
                        $filtered = true;
                        $or = trimStr($sql) == "WHERE (" ? '' : 'OR ';
                        $sql .= $or . "   `assignee` in (:assignee) ";
                        $params['assignee'] = implode(',', $itemArr);
                    }
                    if ($type == 'reporter' && !empty($itemArr)) {
                        $filtered = true;
                        $or = trimStr($sql) == "WHERE (" ? '' : 'OR ';
                        $sql .= $or . "   `reporter` in (:reporter) ";
                        $params['reporter'] = implode(',', $itemArr);
                    }
                    if ($type == 'label' && !empty($itemArr)) {
                        $filtered = true;
                        $issueIdArr = $issueLabelDataModel->getIssueIdArrByIds($itemArr);
                        $issueIdStr = implode(',', $issueIdArr);
                        $or = trimStr($sql) == "WHERE (" ? '' : 'OR ';
                        $sql .= $or . "  `id`  in (:label_issue_ids) ";
                        $params['label_issue_ids'] = $issueIdStr;
                    }
                }
                if (!$filtered) {
                    continue;
                }
                $sql .= "  ) AND project_id=:project_id ";
                $params['project_id'] = $projectId;

                if (isset($_GET['keyword']) && !empty($_GET['keyword'])) {
                    $sql .= " AND  LOCATE(:summary,`summary`)>0  ";
                    $params['summary'] = $_GET['keyword'];
                }
                if ($board['range_type'] == 'sprints') {
                    $rangeDataArr = json_decode($board['range_data'], true);
                    $sql .= " AND   sprint  in (:sprints) ";
                    $params['sprints'] = implode(',', $rangeDataArr);
                }
                if ($board['range_type'] == 'sprint') {
                    $sql .= " AND   sprint =:sprint_id ";
                    $params['sprint_id'] = $board['sprint_id'];
                }
                if ($board['range_type'] == 'modules') {
                    $rangeDataArr = json_decode($board['range_data'], true);
                    $sql .= " AND   module in  ( :modules ) ";
                    $params['modules'] = implode(',', $rangeDataArr);
                }
                if ($board['range_type'] == 'issue_types') {
                    $rangeDataArr = json_decode($board['range_data'], true);
                    $sql .= " AND   issue_type in ( :issue_types ) ";
                    $params['issue_types'] = implode(',', $rangeDataArr);
                }
                if ($board['range_due_date'] != '') {
                    $sql .= " AND  `due_date` between :start and :end ";
                    list($start, $end) = explode(' - ', $board['range_due_date']);
                    $params['start'] = $start;
                    $params['end'] = $end;
                }
                // 按经办人搜索事项
                $assigneeUid = null;
                if (isset($_GET[urlencode('经办人')])) {
                    $userModel = new UserModel();
                    $row = $userModel->getByUsername(urldecode($_GET[urlencode('经办人')]));
                    if (isset($row['uid'])) {
                        $assigneeUid = $row['uid'];
                    }
                    unset($row);
                }
                if (isset($_GET['assignee'])) {
                    $assigneeUid = (int)$_GET['assignee'];
                }
                if ($assigneeUid !== null) {
                    $sql .= " AND assignee=:assignee";
                    $params['assignee'] = $assigneeUid;
                }
                // 按报告人搜索事项
                $reporterUid = null;
                if (isset($_GET[urlencode('报告人')])) {
                    $userModel = new UserModel();
                    $row = $userModel->getByUsername(urldecode($_GET[urlencode('报告人')]));
                    if (isset($row['uid'])) {
                        $reporterUid = $row['uid'];
                    }
                    unset($row);
                }
                if (isset($_GET['reporter_uid'])) {
                    $reporterUid = (int)$_GET['reporter_uid'];
                }
                if ($reporterUid !== null) {
                    $sql .= " AND reporter=:reporter";
                    $params['reporter'] = $reporterUid;
                }
                // 按模块搜索事项
                $moduleId = null;
                if (isset($_GET[urlencode('模块')])) {
                    $projectModuleModel = new ProjectModuleModel();
                    $moduleName = urldecode($_GET[urlencode('模块')]);
                    $row = $projectModuleModel->getByProjectAndName($projectId, $moduleName);
                    if (isset($row['id'])) {
                        $moduleId = $row['id'];
                    }
                    unset($row);
                }
                if (isset($_GET['module_id'])) {
                    $moduleId = (int)$_GET['module_id'];
                }
                if (!empty($moduleId)) {
                    $sql .= " AND module=:module";
                    $params['module'] = $moduleId;
                }
                // 按迭代搜索事项
                $sprintId = null;
                if (isset($_GET[urlencode('迭代')])) {
                    $sprintModel = new SprintModel();
                    $sprintName = urldecode($_GET[urlencode('迭代')]);
                    $row = $sprintModel->getByProjectAndName($projectId, $sprintName);
                    //print_r($row);
                    if (isset($row['id'])) {
                        $sprintId = $row['id'];
                    }
                    unset($row);
                }
                if (isset($_GET['sprint_id'])) {
                    $sprintId = (int)$_GET['sprint_id'];
                }
                if (!empty($sprintId)) {
                    $sql .= " AND sprint=:sprint";
                    $params['sprint'] = $sprintId;
                }
                // 按优先级搜索事项
                $priorityId = null;
                if (isset($_GET[urlencode('优先级')])) {
                    $model = new IssuePriorityModel();
                    $row = $model->getByName(urldecode($_GET[urlencode('优先级')]));
                    if (isset($row['id'])) {
                        $priorityId = $row['id'];
                    }
                    unset($row);
                }
                if (isset($_GET['priority_id'])) {
                    $priorityId = (int)$_GET['priority_id'];
                }
                if ($priorityId !== null) {
                    $sql .= " AND priority=:priority";
                    $params['priority'] = $priorityId;
                }
                // 按解决结果搜索事项
                $resolveId = null;
                if (isset($_GET[urlencode('解决结果')])) {
                    $resolveId = IssueResolveModel::getInstance()->getIdByName(urldecode($_GET[urlencode('解决结果')]));
                    unset($row);
                }
                if (isset($_GET['resolve_id'])) {
                    $resolveId = (int)$_GET['resolve_id'];
                }
                if ($resolveId !== null) {
                    $sql .= " AND resolve=:resolve";
                    $params['resolve'] = $resolveId;
                }

                $orderBy = 'id';
                $sortBy = 'DESC';
                $order = empty($orderBy) ? '' : " Order By  $orderBy  $sortBy";
                // print_r($params);
                // echo $sql;die;
                $table = $issueModel->getTable();
                // 获取总数
                $sqlCount = "SELECT count(*) as cc FROM  {$table} " . $sql;
                $count = $issueModel->getFieldBySql($sqlCount, $params);
                $column['count'] = $count;

                $fields = '*';
                $sql = "SELECT {$fields} FROM  {$table} " . $sql;
                $sql .= ' ' . $order;
                //print_r($params);
                //echo $sql;die;
                $issueModel->removeInSqlParams($sql, $params);
                $arr = $issueModel->db->fetchAll($sql, $params);
                //print_r($arr);
                $column['issues'] = $arr;
            }
            return [true, 'ok'];
        } catch (\PDOException $e) {
            return [false, $e->getMessage()];
        }
    }

    /**
     * 通过key获取id数组
     * @param $arr
     * @param $key
     * @param $keyArr
     * @return array
     */
    public static function getIdArrByKeys($arr, $keyArr)
    {
        $idArr = [];
        if (empty($keyArr) || empty($arr)) {
            return $idArr;
        }

        foreach ($keyArr as $value) {
            if (isset($arr[$value])) {
                $idArr[] = $arr[$value];
            }
        }
        return $idArr;
    }

    /**
     * 获取某项目下所有sprint的ID和name的map，ID为indexKey
     * 用于ID与可视化名字的映射
     * @return array
     * @throws \Exception
     */
    public function getAllProjectSprintNameAndId($projectId)
    {
        $originalRes = $this->getSprints($projectId);
        $map = array_column($originalRes, 'name', 'id');
        return $map;
    }
}
