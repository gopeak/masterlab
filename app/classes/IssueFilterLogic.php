<?php

/**
 * Created by PhpStorm.
 * User: sven
 * Date: 2017/7/7 0007
 * Time: 下午 3:56
 */

namespace main\app\classes;

use main\app\model\issue\IssuePriorityModel;
use main\app\model\issue\IssueResolveModel;
use main\app\model\issue\IssueStatusModel;
use main\app\model\project\ProjectModuleModel;
use main\app\model\project\ReportProjectIssueModel;
use main\app\model\project\ReportSprintIssueModel;
use main\app\model\user\UserModel;
use main\app\model\issue\IssueModel;

/**
 * Class IssueFilterLogic 事项过滤器
 * @package main\app\classes
 */
class IssueFilterLogic
{
    /**
     * 通过筛选获得事项列表
     * @param int $page
     * @param int $pageSize
     * @return array
     */
    public function getList($page = 1, $pageSize = 50)
    {
        // sys_filter=1&fav_filter=2&project=2&reporter=2&title=fdsfdsfsd&assignee=2&created_start=232131&update_start=43432&sort_by=&32323&mod=123&reporter=12&priority=2&status=23&resolution=2
        $params = [];
        $sql = " WHERE 1";
        $sysFilter = null;
        // $favFilter = null;
        if (isset($_GET['sys_filter'])) {
            $sysFilter = $_GET['sys_filter'];
        }
        if (isset($_GET['fav_filter'])) {
            //$favFilter = (int)$_GET['fav_filter'];
        }

        if (isset($_GET['project']) && !empty($_GET['project'])) {
            $projectId = (int)$_GET['project'];
            $sql .= " AND project_id=:project";
            $params['project'] = $projectId;
        }

        $assigneeUid = null;
        if (isset($_GET['assignee_username'])) {
            $userModel = new UserModel();
            $row = $userModel->getByUsername($_GET['assignee_username']);
            if (isset($row['uid'])) {
                $assigneeUid = $row['uid'];
            }
            unset($row);
        }
        if (isset($_GET['assignee'])) {
            $assigneeUid = (int)$_GET['assignee'];
        }
        if ($sysFilter == 'assignee_mine') {
            $assigneeUid = UserAuth::getInstance()->getId();
        }
        if ($assigneeUid !== null) {
            $sql .= " AND assignee=:assignee";
            $params['assignee'] = $assigneeUid;
        }

        // 谁创建的
        $reporterUid = null;
        if (isset($_GET['author'])) {
            $userModel = new UserModel();
            $row = $userModel->getByUsername($_GET['author']);
            if (isset($row['uid'])) {
                $reporterUid = $row['uid'];
            }
            unset($row);
        }
        if (isset($_GET['reporter_uid'])) {
            $reporterUid = (int)$_GET['reporter_uid'];
        }
        if ($sysFilter == 'my_report') {
            $reporterUid = UserAuth::getInstance()->getId();
        }
        if ($reporterUid !== null) {
            $sql .= " AND reporter=:reporter";
            $params['reporter'] = $reporterUid;
        }

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

        // 所属模块
        $moduleId = null;
        if (isset($_GET['module'])) {
            $projectModuleModel = new ProjectModuleModel();
            $row = $projectModuleModel->getByName($_GET['module']);
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

        // 优先级
        $priorityId = null;
        if (isset($_GET['priority'])) {
            $model = new IssuePriorityModel();
            $row = $model->getByName($_GET['priority']);
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
        if (isset($_GET['resolve'])) {
            $model = new IssueResolveModel();
            $row = $model->getByName($_GET['resolve']);
            if (isset($row['id'])) {
                $resolveId = $row['id'];
            }
            unset($row);
        }
        if (isset($_GET['resolve_id'])) {
            $resolveId = (int)$_GET['resolve_id'];
        }
        if ($resolveId !== null) {
            $sql .= " AND resolve=:resolve";
            $params['resolve'] = $resolveId;
        }

        // 状态
        $statusId = null;
        if (isset($_GET['status'])) {
            $model = new IssueStatusModel();
            $row = $model->getByName($_GET['status']);
            if (isset($row['id'])) {
                $statusId = $row['id'];
            }
            unset($row);
        }
        if (isset($_GET['status_id'])) {
            $statusId = (int)$_GET['status_id'];
        }
        if ($sysFilter == 'open') {
            $statusId = '1';
        }
        if ($statusId !== null) {
            $sql .= " AND status=:status";
            $params['status'] = $statusId;
        }

        if (isset($_GET['created_start'])) {
            $createdStartTime = (int)$_GET['created_start'];
            $sql .= " AND created>=:created_start";
            $params['created_start'] = $createdStartTime;
        }

        if (isset($_GET['created_end'])) {
            $createdEndTime = (int)$_GET['created_end'];
            $sql .= " AND created<:created_end";
            $params['created_end'] = $createdEndTime;
        }

        if (isset($_GET['updated_start'])) {
            $updatedStartTime = (int)$_GET['updated_start'];
            $sql .= " AND updated>=:updated_start";
            $params['updated_start'] = $updatedStartTime;
        }

        if (isset($_GET['updated_end'])) {
            $updatedEndTime = (int)$_GET['updated_end'];
            $sql .= " AND updated<=:updated_end";
            $params['updated_end'] = $updatedEndTime;
        }

        $orderBy = 'id';
        if (isset($_GET['sort_field'])) {
            $orderBy = $_GET['sort_field'];
        }
        $sortBy = 'DESC';
        if (isset($_GET['sort_by'])) {
            $sortBy = $_GET['sort_by'];
        }
        if ($sysFilter == 'recently_create') {
            $orderBy = 'created';
            $sortBy = 'DESC';
        }
        if ($sysFilter == 'recently_resolve') {
            $orderBy = 'resolve_date';
            $sortBy = 'DESC';
        }
        if ($sysFilter == 'update_recently') {
            $orderBy = 'updated';
            $sortBy = 'DESC';
        }

        $start = $pageSize * ($page - 1);
        $limit = " limit $start, " . $pageSize;
        $order = empty($orderBy) ? '' : " Order By  $orderBy  $sortBy";

        $model = new IssueModel();
        $table = $model->getTable();
        try {
            $field = 'id,project_id,reporter,assignee,issue_type,summary,priority,resolve,
            status,created,updated,sprint,master_id,have_children';
            // 获取总数
            $sqlCount = "SELECT count(*) as cc FROM  {$table} " . $sql;
            $count = $model->db->getOne($sqlCount, $params);

            $sql = "SELECT {$field} FROM  {$table} " . $sql;
            $sql .= ' ' . $order . $limit;
            //print_r($params);
            //echo $sql;die;

            $arr = $model->db->getRows($sql, $params);
            foreach ($arr as &$item) {
                self::formatIssue($item);
            }
            return [true, $arr, $count];
        } catch (\PDOException $e) {
            return [false, $e->getMessage(), 0];
        }
    }

    /**
     * @param int $userId
     * @param int $page
     * @param int $pageSize
     * @return array
     */
    public static function getsByAssignee($userId = 0, $page = 1, $pageSize = 10)
    {
        $conditions = [];
        if (!empty($userId)) {
            $conditions['assignee'] = $userId;
        }
        $start = $pageSize * ($page - 1);
        $appendSql = " 1 Order by id desc  limit $start, " . $pageSize;

        $model = new IssueModel();
        $fields = 'id,project_id,reporter,assignee,issue_type,summary,priority,resolve,
            status,created,updated,sprint,master_id';
        $rows = $model->getRows($fields, $conditions, $appendSql);
        foreach ($rows as &$row) {
            self::formatIssue($row);
        }
        $count = $model->getOne('count(*) as cc', $conditions);
        return [$rows, $count];
    }

    public function selectFilter($issueId, $search = null, $limit = 10)
    {
        $model = new IssueModel();
        $table = $model->getTable();
        $issueModel = new IssueModel();
        $projectId = $issueModel->getById($issueId)['project_id'];

        $fields = " id, summary as name ,issue_num as username, id as avatar ";

        $sql = "Select {$fields} From {$table} Where project_id=:project_id  AND id!=:issue_id ";
        $params = [];
        $params['project_id'] = $projectId;
        $params['issue_id'] = $issueId;

        if (!empty($search)) {
            $params['search'] = $search;
            $params['search_id'] = $search;
            $sql .= " AND  ( locate(:search,summary)>0 || issue_num=:search_id )";
        }

        if (!empty($limit)) {
            $limit = intval($limit);
            $sql .= " Order by id DESC limit $limit ";
        }
        // echo $sql;
        $rows = $model->db->getRows($sql, $params);
        unset($model);

        return $rows;
    }

    /**
     * 获取所有问题的数量
     * @param $projectId
     * @return array
     */
    public static function getCount($projectId)
    {
        if (empty($projectId)) {
            return [];
        }
        $model = new IssueModel();
        $table = $model->getTable();
        $sql = "SELECT count(*) as count FROM {$table}  WHERE project_id ={$projectId}  ";
        // echo $sql;
        $count = $model->db->getOne($sql);
        return intval($count);
    }

    /**
     * 获取所有问题的数量
     * @param $projectId
     * @return array
     */
    public static function getClosedCount($projectId)
    {
        if (empty($projectId)) {
            return [];
        }
        $resolveModel = new IssueResolveModel();
        $closedResolveId = $resolveModel->getIdByKey('closed');
        $model = new IssueModel();
        $table = $model->getTable();
        $sql = "SELECT count(*) as count FROM {$table}  WHERE project_id ={$projectId}  AND resolve ='$closedResolveId' ";
        // echo $sql;
        $count = $model->db->getOne($sql);
        return intval($count);
    }

    /**
     * 获取未解决问题的数量
     * @param $projectId
     * @return array
     */
    public static function getNoDoneCount($projectId)
    {
        if (empty($projectId)) {
            return [];
        }
        $statusModel = new IssueStatusModel();
        $noDoneStatusIdArr = [];
        $noDoneStatusIdArr[] = $statusModel->getIdByKey('done');
        $noDoneStatusIdArr[] = $statusModel->getIdByKey('closed');
        $noDoneStatusIdArr[] = $statusModel->getIdByKey('resolved');
        $noDoneStatusIdStr = implode(',', $noDoneStatusIdArr);
        $model = new IssueModel();
        $table = $model->getTable();
        $sql = "SELECT count(*) as count FROM {$table}  WHERE project_id ={$projectId} AND STATUS NOT IN({$noDoneStatusIdStr}) ";
        // echo $sql;
        $count = $model->db->getOne($sql);
        return intval($count);
    }

    /**
     * 获取未完成的事项总数
     * @return int
     */
    public static function getAllNoDoneCount()
    {
        $statusModel = new IssueStatusModel();
        $noDoneStatusIdArr = [];
        $noDoneStatusIdArr[] = $statusModel->getIdByKey('done');
        $noDoneStatusIdArr[] = $statusModel->getIdByKey('closed');
        $noDoneStatusIdArr[] = $statusModel->getIdByKey('resolved');
        $noDoneStatusIdStr = implode(',', $noDoneStatusIdArr);
        $model = new IssueModel();
        $table = $model->getTable();
        $sql = "SELECT count(*) as count FROM {$table}  WHERE  STATUS NOT IN({$noDoneStatusIdStr}) ";
        // echo $sql;
        $count = $model->db->getOne($sql);
        return intval($count);
    }
    /**
     * 获取按优先级的未解决问题的数量
     * @param $projectId
     * @return array
     */
    public static function getPriorityStat($projectId)
    {
        if (empty($projectId)) {
            return [];
        }
        $statusModel = new IssueStatusModel();
        $noDoneStatusIdArr = [];
        $noDoneStatusIdArr[] = $statusModel->getIdByKey('done');
        $noDoneStatusIdArr[] = $statusModel->getIdByKey('closed');
        $noDoneStatusIdArr[] = $statusModel->getIdByKey('resolved');
        $noDoneStatusIdStr = implode(',', $noDoneStatusIdArr);
        $model = new IssueModel();
        $table = $model->getTable();
        $sql = "SELECT priority as id,count(*) as count FROM {$table} 
                          WHERE project_id ={$projectId} AND status NOT IN({$noDoneStatusIdStr})  GROUP BY priority ";
        // echo $sql;
        $rows = $model->db->getRows($sql);
        return $rows;
    }

    /**
     * 获取按状态的未解决问题的数量
     * @param $projectId
     * @return array
     */
    public static function getStatusStat($projectId)
    {
        if (empty($projectId)) {
            return [];
        }
        $statusModel = new IssueStatusModel();
        $noDoneStatusIdArr = [];
        $noDoneStatusIdArr[] = $statusModel->getIdByKey('done');
        $noDoneStatusIdArr[] = $statusModel->getIdByKey('closed');
        $noDoneStatusIdArr[] = $statusModel->getIdByKey('resolved');
        $noDoneStatusIdStr = implode(',', $noDoneStatusIdArr);
        $model = new IssueModel();
        $table = $model->getTable();
        $sql = "SELECT status as id,count(*) as count FROM {$table} 
                          WHERE project_id ={$projectId} AND status NOT IN({$noDoneStatusIdStr}) GROUP BY status ";
        // echo $sql;
        $rows = $model->db->getRows($sql);
        return $rows;
    }

    /**
     * 获取按事项类型的未解决问题的数量
     * @param $projectId
     * @return array
     */
    public static function getTypeStat($projectId)
    {
        if (empty($projectId)) {
            return [];
        }
        $statusModel = new IssueStatusModel();
        $noDoneStatusIdArr = [];
        $noDoneStatusIdArr[] = $statusModel->getIdByKey('done');
        $noDoneStatusIdArr[] = $statusModel->getIdByKey('closed');
        $noDoneStatusIdArr[] = $statusModel->getIdByKey('resolved');
        $noDoneStatusIdStr = implode(',', $noDoneStatusIdArr);
        $model = new IssueModel();
        $table = $model->getTable();
        $sql = "SELECT issue_type as id,count(*) as count FROM {$table} 
                          WHERE project_id ={$projectId} AND status NOT IN({$noDoneStatusIdStr})  GROUP BY issue_type ";
        // echo $sql;
        $rows = $model->db->getRows($sql);
        return $rows;
    }

    /**
     * 获取按事项类型的未解决问题的数量
     * @param $projectId
     * @return array
     */
    public static function getAssigneeStat($projectId)
    {
        if (empty($projectId)) {
            return [];
        }
        $statusModel = new IssueStatusModel();
        $noDoneStatusIdArr = [];
        $noDoneStatusIdArr[] = $statusModel->getIdByKey('done');
        $noDoneStatusIdArr[] = $statusModel->getIdByKey('closed');
        $noDoneStatusIdArr[] = $statusModel->getIdByKey('resolved');
        $noDoneStatusIdStr = implode(',', $noDoneStatusIdArr);
        $model = new IssueModel();
        $table = $model->getTable();
        $sql = "SELECT assignee as user_id,count(*) as count FROM {$table} 
                          WHERE project_id ={$projectId} AND status NOT IN({$noDoneStatusIdStr})  GROUP BY assignee ";
        // echo $sql;
        $rows = $model->db->getRows($sql);
        return $rows;
    }


    /**
     * 获取项目的饼状图数据
     * @param $field
     * @param $projectId
     * @param bool $noDoneStatus
     * @param null $startDate
     * @param null $endDate
     * @return array
     */
    public static function getProjectChartPie($field, $projectId, $noDoneStatus = false, $startDate = null, $endDate = null)
    {
        if (empty($projectId)) {
            return [];
        }
        $model = new IssueModel();
        $table = $model->getTable();
        $noDoneStatusSql = '';
        if ($noDoneStatus) {
            $statusModel = new IssueStatusModel();
            $noDoneStatusIdArr = [];
            $noDoneStatusIdArr[] = $statusModel->getIdByKey('done');
            $noDoneStatusIdArr[] = $statusModel->getIdByKey('closed');
            $noDoneStatusIdArr[] = $statusModel->getIdByKey('resolved');
            $noDoneStatusIdStr = implode(',', $noDoneStatusIdArr);
            $noDoneStatusSql = "AND status NOT IN({$noDoneStatusIdStr})";
        }
        $params = [];
        $params['project_id'] = $projectId;
        $startDateSql = "";
        if ($startDate) {
            $startDateSql = " AND  created>=:created_start";
            $params['created_start'] = strtotime($startDate);
        }

        $endDateSql = "";
        if ($endDate) {
            $endDateSql = " AND  created<=:created_end";
            $params['created_end'] = strtotime($endDate);
        }

        $sql = "SELECT {$field} as id,count(*) as count FROM {$table} 
                          WHERE project_id =:project_id  {$startDateSql} {$endDateSql} {$noDoneStatusSql}  GROUP BY {$field} ";
        //echo $sql;
        //echo($startDate.'--'.$endDate);
        //print_r($params);
        $rows = $model->db->getRows($sql, $params);
        return $rows;
    }


    /**
     * 获取某个迭代的实时饼状图数据
     * @param $field
     * @param $sprintId
     * @param bool $noDoneStatus
     * @param null $startDate
     * @param null $endDate
     * @return array
     */
    public static function getSprintIssueChartPieData($field, $sprintId, $noDoneStatus = false)
    {
        if (empty($sprintId)) {
            return [];
        }
        $model = new IssueModel();
        $table = $model->getTable();
        $noDoneStatusSql = '';
        if ($noDoneStatus) {
            $statusModel = new IssueStatusModel();
            $noDoneStatusIdArr = [];
            $noDoneStatusIdArr[] = $statusModel->getIdByKey('done');
            $noDoneStatusIdArr[] = $statusModel->getIdByKey('closed');
            $noDoneStatusIdArr[] = $statusModel->getIdByKey('resolved');
            $noDoneStatusIdStr = implode(',', $noDoneStatusIdArr);
            $noDoneStatusSql = "AND status NOT IN({$noDoneStatusIdStr})";
        }
        $params = [];
        $params['sprint'] = $sprintId;

        $sql = "SELECT {$field} as id,count(*) as count FROM {$table} 
                          WHERE sprint =:sprint  {$noDoneStatusSql}  GROUP BY {$field} ";
        // echo $sql;
        $rows = $model->db->getRows($sql, $params);
        return $rows;
    }

    public static function getProjectChartBar($field, $projectId, $withinDate = null)
    {
        if (empty($projectId)) {
            return [];
        }
        $model = new ReportProjectIssueModel();
        $table = $model->getTable();

        $params = [];
        $params['project_id'] = $projectId;

        $withinDateSql = "";
        if ($withinDate) {
            $withinTime = time() - (3600 * 24 * 30);
            $withinFormatDate = date('Y-m-d', $withinTime);
            $withinDateSql = " AND  date>={$withinFormatDate}";
        }

        $sql = "SELECT {$field} as label,{$table}.* FROM {$table} 
                          WHERE project_id =:project_id  {$withinDateSql}   ";
        if($field!='date'){
            $sql = "SELECT 
                      {$field} as label,
                      sum(count_done) as count_done,
                      sum(count_no_done) as count_no_done,
                      sum(count_done_by_resolve) as count_done_by_resolve, 
                      sum(count_no_done_by_resolve) as count_no_done_by_resolve,
                      sum(today_done_points) as today_done_points,
                      sum(today_done_number) as today_done_number 
                    FROM {$table} 
                    WHERE project_id =:project_id    {$withinDateSql}  GROUP BY {$field} ";
        }
        // echo $sql;
        $rows = $model->db->getRows($sql, $params);
        return $rows;
    }

    public static function getSprintChartBar($field, $sprintId)
    {
        if (empty($sprintId)) {
            return [];
        }
        $model = new ReportSprintIssueModel();
        $table = $model->getTable();

        $params = [];
        $params['sprint_id'] = $sprintId;

        $sql = "SELECT {$field} as label,{$table}.* FROM {$table} 
                          WHERE sprint_id =:sprint_id    ";
        if($field!='date'){
            $sql = "SELECT 
                      {$field} as label,
                      sum(count_done) as count_done,
                      sum(count_no_done) as count_no_done,
                      sum(count_done_by_resolve) as count_done_by_resolve, 
                      sum(count_no_done_by_resolve) as count_no_done_by_resolve,
                      sum(today_done_points) as today_done_points,
                      sum(today_done_number) as today_done_number 
                    FROM {$table} 
                    WHERE sprint_id =:sprint_id    GROUP BY {$field} ";
        }
        // echo $sql;
        $rows = $model->db->getRows($sql, $params);
        return $rows;
    }



    /**
     * 获取某个迭代的汇总数据
     * @param $field
     * @param $sprintId
     * @param null $withinDate
     * @return array
     */
    public static function getSprintReport($field, $sprintId)
    {
        if (empty($sprintId)) {
            return [];
        }
        $model = new ReportSprintIssueModel();
        $table = $model->getTable();
        $params = [];
        $params['sprint_id'] = $sprintId;
        $sql = "SELECT {$field} as label,{$table}.* FROM {$table} 
                          WHERE sprint_id =:sprint_id   ";
        if($field!='date'){
            $sql = "SELECT 
                      {$field} as label,
                      sum(count_done) as count_done,
                      sum(count_no_done) as count_no_done,
                      sum(count_done_by_resolve) as count_done_by_resolve, 
                      sum(count_no_done_by_resolve) as count_no_done_by_resolve,
                      sum(today_done_points) as today_done_points,
                      sum(today_done_number) as today_done_number 
                    FROM {$table} 
                    WHERE sprint_id =:sprint_id  GROUP BY {$field} ";
        }
        // echo $sql;
        $rows = $model->db->getRows($sql, $params);
        return $rows;
    }

    /**
     * 格式化事项
     * @param $issue
     */
    public static function formatIssue(&$issue)
    {
        $issue['created_text'] = format_unix_time($issue['created']);
        $issue['updated_text'] = format_unix_time($issue['updated']);
        $issue['assistants_arr'] = [];
        if (!empty($issue['assistants'])) {
            $issue['assistants_arr'] = explode(',', $issue['assistants']);
        }
        if (empty($issue['have_children'])) {
            $issue['have_children'] = '0';
        }
    }
}
