<?php

/**
 * Created by PhpStorm.
 * User: sven
 * Date: 2017/7/7 0007
 * Time: 下午 3:56
 */

namespace main\app\classes;

use main\app\model\agile\SprintModel;
use main\app\model\issue\IssuePriorityModel;
use main\app\model\issue\IssueResolveModel;
use main\app\model\issue\IssueStatusModel;
use main\app\model\issue\IssueFilterModel;
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

    static $unDoneStatusIdArr = [];


    public static $avlSortFields = [
        'id'=>'创建时间',
        'updated'=>'更新时间',
        'priority'=>'优先级',
        'module'=>'模  块',
        'issue_type'=>'类  型',
        'sprint'=>'迭代',
        'weight'=>'权重',
        'assignee'=>'经办人',
        'status'=>'状态',
        'resolve'=>'解决结果',
        'due_date'=>'截止日期',
    ];

    public static $defaultSortField =  'id';

    public static $defaultSortBy =  'desc';

    /**
     * 通过筛选获得事项列表
     * @param int $page
     * @param int $pageSize
     * @return array
     * @throws \Exception
     */
    public function getList($page = 1, $pageSize = 50)
    {
        // sys_filter=1&fav_filter=2&project=2&reporter=2&title=fdsfdsfsd&assignee=2&created_start=232131&update_start=43432&sort_by=&32323&mod=123&reporter=12&priority=2&status=23&resolution=2
        $params = [];
        $sql = " WHERE 1";
        $sysFilter = null;
        $favFilter = null;
        if (isset($_GET['sys_filter'])) {
            $sysFilter = $_GET['sys_filter'];
        }
        if (isset($_GET['fav_filter'])) {
            $favFilterId = $_GET['fav_filter'];
            $filterModel = IssueFilterModel::getInstance();
            $favFilter = $filterModel->getRowById($favFilterId)['filter'];
            parse_str($favFilter, $filterParamArr);
            if (!empty($filterParamArr)) {
                foreach ($filterParamArr as $key => $item) {
                    $_GET[$key] = $item;
                }
            }
        }

        // 项目筛选
        $projectId = null;
        if (isset($_GET['project']) && !empty($_GET['project'])) {
            $projectId = (int)$_GET['project'];
            $sql .= " AND project_id=:project";
            $params['project'] = $projectId;
        } else {
            // 如果没有指定某一项目，则获取用户参与的项目
            $userJoinProjectIdArr = PermissionLogic::getUserRelationProjectIdArr(UserAuth::getId());
            if (!empty($userJoinProjectIdArr)) {
                $projectIdStr = implode(',', $userJoinProjectIdArr);
                $sql .= " AND  project_id IN ({$projectIdStr}) ";
            }
        }

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
        if ($sysFilter == 'assignee_mine') {
            $assigneeUid = UserAuth::getInstance()->getId();
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
            if (!empty($search)) {
                $versionSql = 'select version() as vv';
                $issueModel = new IssueModel();
                $versionStr = $issueModel->db->getOne($versionSql);
                $versionNum = floatval($versionStr);
                if (strpos($versionStr, 'MariaDB') !== false) {
                    $versionNum = 0;
                }
                if ($versionNum < 5.70) {
                    // 使用LOCATE模糊搜索
                    if (strlen($search) < 10) {
                        $sql .= " AND ( LOCATE(:summary,`summary`)>0  OR pkey=:pkey)";
                        $params['pkey'] = $search;
                        $params['summary'] = $search;
                    } else {
                        $sql .= " AND  LOCATE(:summary,`summary`)>0  ";
                        $params['summary'] = $search;
                    }
                } else {
                    // 使用全文索引
                    $sql .= " AND MATCH (`summary`) AGAINST (:summary IN NATURAL LANGUAGE MODE) ";
                    $params['summary'] = $search;
                }
            }
        }

        // 所属迭代
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

        // 所属模块
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

        // 状态
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

        if ($statusId !== null) {
            $sql .= " AND status=:status";
            $params['status'] = $statusId;
        }
        // 我未解决的
        if ($sysFilter == 'my_unsolved') {
            $params['assignee'] = UserAuth::getInstance()->getId();
            $statusKeyArr = ['open', 'in_progress', 'reopen', 'in_review', 'delay'];
            $statusIdArr = IssueStatusModel::getInstance()->getIdArrByKeys($statusKeyArr);
            $statusKeyStr = implode(',', $statusIdArr);
            unset($statusKeyArr, $statusIdArr);
            $sql .= " AND assignee=:assignee AND status in ({$statusKeyStr})";
        }
        // 未解决的
        if ($sysFilter == 'unsolved') {
            $statusKeyArr = ['open', 'in_progress', 'reopen', 'in_review', 'delay'];
            $statusIdArr = IssueStatusModel::getInstance()->getIdArrByKeys($statusKeyArr);
            $statusKeyStr = implode(',', $statusIdArr);
            unset($statusKeyArr, $statusIdArr);
            $sql .= " AND status in ({$statusKeyStr})";
        }

        // 完成的
        if ($sysFilter == 'done' || $sysFilter == 'recently_resolve') {
            $statusKeyArr = ['resolved', 'closed'];
            $statusIdArr = IssueStatusModel::getInstance()->getIdArrByKeys($statusKeyArr);
            $statusKeyStr = implode(',', $statusIdArr);
            unset($statusKeyArr, $statusIdArr);
            $sql .= " AND status in ({$statusKeyStr})";
        }

        // 当前迭代未解决的
        if ($sysFilter == 'active_sprint_unsolved' && !empty($projectId)) {
            $statusKeyArr = ['open', 'in_progress', 'reopen', 'in_review', 'delay'];
            $statusIdArr = IssueStatusModel::getInstance()->getIdArrByKeys($statusKeyArr);
            $statusKeyStr = implode(',', $statusIdArr);
            unset($statusKeyArr, $statusIdArr);
            $sql .= " AND status in ({$statusKeyStr})";
            $sprintModel = new SprintModel();
            $activeSprint = $sprintModel->getActive($projectId);
            $sql .= " AND sprint=:sprint";
            $params['sprint'] = $activeSprint['id'];
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
        if (isset($_GET['sort_by']) && !empty($_GET['sort_by'])) {
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
        $_SESSION['issue_filter_where'] = $sql;
        $_SESSION['issue_filter_params'] = $params;
        $_SESSION['issue_filter_order_by'] = $order;
        $_SESSION['issue_filter_sql_time'] = time();
        try {
            /* 配合导出功能, 改为全字段查询
            $field = 'id,issue_num,project_id,reporter,assignee,issue_type,summary,module,priority,resolve,
            status,created,updated,sprint,master_id,have_children,start_date,due_date';
            */
            $field = '*';
            // 获取总数
            $sqlCount = "SELECT count(*) as cc FROM  {$table} " . $sql;
            // echo $sqlCount;
            // print_r($params);
            $count = $model->db->getOne($sqlCount, $params);

            $sql = "SELECT {$field} FROM  {$table} " . $sql;

            $sql .= ' ' . $order . $limit;
            //print_r($params);
            //echo $sql;die;

            $arr = $model->db->getRows($sql, $params);
            $idArr = [];
            foreach ($arr as &$item) {
                self::formatIssue($item);
                $idArr[] = $item['id'];
            }
            $_SESSION['filter_id_arr'] = $idArr;
            // var_dump( $arr, $count);
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
     * @throws \Exception
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
        $fields = 'id,issue_num,project_id,reporter,assignee,issue_type,summary,priority,resolve,
            status,created,updated,sprint,master_id,start_date,due_date';
        $rows = $model->getRows($fields, $conditions, $appendSql);
        foreach ($rows as &$row) {
            self::formatIssue($row);
        }
        $count = $model->getOne('count(*) as cc', $conditions);
        return [$rows, $count];
    }

    /**
     * @param int $userId
     * @param int $page
     * @param int $pageSize
     * @return array
     * @throws \Exception
     */
    public static function getsByUnResolveAssignee($userId = 0, $page = 1, $pageSize = 10)
    {
        $conditions = [];
        if (!empty($userId)) {
            $conditions['assignee'] = $userId;
        }
        $start = $pageSize * ($page - 1);
        $appendSql = " 1 AND " . self::getUnDoneSql() . "  Order by id desc  limit $start, " . $pageSize;

        $model = new IssueModel();
        $fields = 'id,issue_num,project_id,reporter,assignee,issue_type,summary,priority,resolve,
            status,created,updated,sprint,master_id,start_date,due_date';
        $rows = $model->getRows($fields, $conditions, $appendSql);
        foreach ($rows as &$row) {
            self::formatIssue($row);
        }
        $count = $model->getOne('count(*) as cc', $conditions);
        return [$rows, $count];
    }

    /**
     * 获取某一用户的分配事项数量
     * @param $userId
     * @return int
     * @throws \Exception
     */
    public static function getCountByAssignee($userId)
    {
        if (empty($userId)) {
            return 0;
        }
        $conditions = [];
        $conditions['assignee'] = $userId;
        $model = new IssueModel();
        $count = $model->getOne('count(*) as cc', $conditions);
        return intval($count);
    }

    /**
     * 获取迭代的事项数量
     * @param $sprintId
     * @return int
     * @throws \Exception
     */
    public static function getCountBySprint($sprintId)
    {
        if (empty($sprintId)) {
            return 0;
        }
        $conditions = [];
        $conditions['sprint'] = $sprintId;
        $model = new IssueModel();
        $count = $model->getOne('count(*) as cc', $conditions);
        return intval($count);
    }

    /**
     * 实时搜索事项
     * @param $issueId
     * @param null $search
     * @param int $limit
     * @return array
     * @throws \Exception
     */
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
     * @throws \Exception
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
     * @throws \Exception
     */
    public static function getClosedCount($projectId)
    {
        if (empty($projectId)) {
            return [];
        }
        $resolveModel = new IssueResolveModel();
        $closedResolveId = $resolveModel->getIdByKey('done');
        $model = new IssueModel();
        $table = $model->getTable();
        $sql = "SELECT count(*) as count FROM {$table}  WHERE project_id ={$projectId}  AND resolve ='$closedResolveId' ";
        // echo $sql;
        $count = $model->db->getOne($sql);
        return intval($count);
    }

    /**
     * 获取某一迭代的已关闭的事项数量
     * @param $sprintId
     * @return array|int
     * @throws \Exception
     */
    public static function getSprintClosedCount($sprintId)
    {
        if (empty($sprintId)) {
            return [];
        }
        $resolveModel = new IssueResolveModel();
        $closedResolveId = $resolveModel->getIdByKey('done');
        $model = new IssueModel();
        $table = $model->getTable();
        $sql = "SELECT count(*) as count FROM {$table}  WHERE sprint ={$sprintId}  AND resolve ='$closedResolveId' ";
        // echo $sql;
        $count = $model->db->getOne($sql);
        return intval($count);
    }

    /**
     * 获取状态未完成的sql
     * @return string
     * @throws \Exception
     */
    public static function getUnDoneSql()
    {
        $statusModel = new IssueStatusModel();
        $noDoneStatusIdArr = [];
        $noDoneStatusIdArr[] = $statusModel->getIdByKey('closed');
        $noDoneStatusIdArr[] = $statusModel->getIdByKey('resolved');
        $noDoneStatusIdStr = implode(',', $noDoneStatusIdArr);
        $appendSql = "  status NOT IN({$noDoneStatusIdStr}) ";
        return $appendSql;
    }

    /**
     * 获取状态完成的sql
     * @return string
     */
    public static function getDoneSql()
    {
        $statusModel = IssueStatusModel::getInstance();
        $noDoneStatusIdArr = [];
        $noDoneStatusIdArr[] = $statusModel->getIdByKey('closed');
        $noDoneStatusIdArr[] = $statusModel->getIdByKey('resolved');
        $noDoneStatusIdStr = implode(',', $noDoneStatusIdArr);
        $appendSql = "  `status`  IN({$noDoneStatusIdStr}) ";
        return $appendSql;
    }

    /**
     * 获取解决结果完成的sql
     * @return string
     */
    public static function getDoneSqlByResolve()
    {
        $resolveModel = IssueResolveModel::getInstance();
        $noDoneStatusIdArr = [];
        $noDoneStatusIdArr[] = $resolveModel->getIdByKey('fixed');
        $noDoneStatusIdArr[] = $resolveModel->getIdByKey('done');
        $noDoneStatusIdStr = implode(',', $noDoneStatusIdArr);
        $appendSql = "  `resolve`  IN({$noDoneStatusIdStr}) ";
        return $appendSql;
    }

    /**
     * @return string
     */
    public static function getUnDoneSqlByResolve()
    {
        $resolveModel = IssueResolveModel::getInstance();
        $noDoneStatusIdArr = [];
        $noDoneStatusIdArr[] = $resolveModel->getIdByKey('fixed');
        $noDoneStatusIdArr[] = $resolveModel->getIdByKey('done');
        $noDoneStatusIdStr = implode(',', $noDoneStatusIdArr);
        $appendSql = "  `resolve` NOT IN({$noDoneStatusIdStr}) ";
        return $appendSql;
    }

    /**
     * 获取未解决问题的数量
     * @param $projectId
     * @return int
     */
    public static function getNoDoneCount($projectId)
    {
        if (empty($projectId)) {
            return 0;
        }
        $appendSql = self::getUnDoneSql();
        $model = IssueModel::getInstance();
        $table = $model->getTable();
        $sql = "SELECT count(*) as count FROM {$table}  WHERE project_id ={$projectId} AND {$appendSql} ";
        // echo $sql;
        $count = $model->db->getOne($sql);
        return intval($count);
    }

    /**
     * 迭代未完成事项数
     * @param $sprintId
     * @return int
     */
    public static function getSprintNoDoneCount($sprintId)
    {
        if (empty($sprintId)) {
            return 0;
        }
        $appendSql = self::getUnDoneSql();
        $model = IssueModel::getInstance();
        $table = $model->getTable();
        $sql = "SELECT count(*) as count FROM {$table}  WHERE sprint ={$sprintId} AND {$appendSql} ";
        //  echo $sql;
        $count = $model->db->getOne($sql);
        return intval($count);
    }

    /**
     * 获取完成的问题的数量
     * @param $projectId
     * @return int
     */
    public static function getDoneCount($projectId)
    {
        if (empty($projectId)) {
            return 0;
        }
        $appendSql = self::getDoneSql();
        $model = IssueModel::getInstance();
        $table = $model->getTable();
        $sql = "SELECT count(*) as count FROM {$table}  WHERE project_id ={$projectId} AND {$appendSql} ";
        // echo $sql;
        $count = $model->db->getOne($sql);
        return intval($count);
    }

    /**
     * 获取迭代的完成的事项数量
     * @param $sprintId
     * @return int
     */
    public static function getSprintDoneCount($sprintId)
    {
        if (empty($sprintId)) {
            return 0;
        }
        $appendSql = self::getDoneSql();
        $model = IssueModel::getInstance();
        $table = $model->getTable();
        $sql = "SELECT count(*) as count FROM {$table}  WHERE sprint ={$sprintId} AND {$appendSql} ";
        // echo $sql;
        $count = $model->db->getOne($sql);
        return intval($count);
    }

    /**
     * 获取完成数（通过解决结果）
     * @param $projectId
     * @return int
     */
    public static function getDoneCountByResolve($projectId)
    {
        if (empty($projectId)) {
            return 0;
        }
        $appendSql = self::getDoneSqlByResolve();
        $model = IssueModel::getInstance();
        $table = $model->getTable();
        $sql = "SELECT count(*) as count FROM {$table}  WHERE project_id ={$projectId} AND {$appendSql} ";
        // echo $sql;
        $count = $model->db->getOne($sql);
        return intval($count);
    }

    /**
     * 获取迭代解决结果:完成的数量
     * @param $sprintId
     * @return int
     */
    public static function getSprintDoneCountByResolve($sprintId)
    {
        if (empty($sprintId)) {
            return 0;
        }
        $appendSql = self::getDoneSqlByResolve();
        $model = IssueModel::getInstance();
        $table = $model->getTable();
        $sql = "SELECT count(*) as count FROM {$table}  WHERE sprint ={$sprintId} AND {$appendSql} ";
        // echo $sql;
        $count = $model->db->getOne($sql);
        return intval($count);
    }

    /**
     * 获取完成的权重值
     * @param $projectId
     * @return int
     */
    public static function getDonePoints($projectId)
    {
        if (empty($projectId)) {
            return 0;
        }
        $appendSql = self::getDoneSql();
        $model = IssueModel::getInstance();
        $table = $model->getTable();
        $sql = "SELECT sum(`weight`) as cc FROM {$table}  WHERE project_id ={$projectId} AND {$appendSql} ";
        // echo $sql;
        $count = $model->db->getOne($sql);
        return intval($count);
    }

    /**
     * 获取迭代的完成的权重总数
     * @param $sprintId
     * @return int
     */
    public static function getSprintDonePoints($sprintId)
    {
        if (empty($projectId)) {
            return 0;
        }
        $appendSql = self::getDoneSql();
        $model = IssueModel::getInstance();
        $table = $model->getTable();
        $sql = "SELECT sum(`weight`) as cc FROM {$table}  WHERE sprint ={$sprintId} AND {$appendSql} ";
        // echo $sql;
        $count = $model->db->getOne($sql);
        return intval($count);
    }

    /**
     * 获取未完成数（通过解决结果）
     * @param $projectId
     * @return int
     */
    public static function getNoDoneCountByResolve($projectId)
    {
        if (empty($projectId)) {
            return 0;
        }
        $appendSql = self::getUnDoneSqlByResolve();
        $model = IssueModel::getInstance();
        $table = $model->getTable();
        $sql = "SELECT count(*) as count FROM {$table}  WHERE project_id ={$projectId} AND {$appendSql} ";
        // echo $sql;
        $count = $model->db->getOne($sql);
        return intval($count);
    }

    /**
     * 获取迭代解决结果未完成的事项汇总
     * @param $sprintId
     * @return int
     */
    public static function getSprintNoDoneCountByResolve($sprintId)
    {
        if (empty($sprintId)) {
            return 0;
        }
        $appendSql = self::getUnDoneSqlByResolve();
        $model = IssueModel::getInstance();
        $table = $model->getTable();
        $sql = "SELECT count(*) as count FROM {$table}  WHERE sprint ={$sprintId} AND {$appendSql} ";
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
        $model = IssueModel::getInstance();
        $table = $model->getTable();
        $appendSql = self::getUnDoneSql();
        $sql = "SELECT count(*) as count FROM {$table}  WHERE  {$appendSql} ";
        // echo $sql;
        $count = $model->db->getOne($sql);
        return intval($count);
    }

    /**
     * 获取通过字段的数据
     * @param $projectId
     * @param $field
     * @param bool $unDone 是否只包含未解决问题的数量
     * @return array
     */
    public static function getFieldStat($projectId, $field, $unDone = false)
    {
        if (empty($projectId)) {
            return [];
        }
        $model = IssueModel::getInstance();
        $table = $model->getTable();
        $noDoneStatusSql = '';
        if ($unDone) {
            $noDoneStatusSql = " AND " . self::getUnDoneSql();
        }
        $sql = "SELECT {$field} as id,count(*) as count FROM {$table} 
                          WHERE project_id ={$projectId} {$noDoneStatusSql} GROUP BY {$field} ";
        // echo $sql;
        $rows = $model->db->getRows($sql);
        return $rows;
    }

    /**
     * 获取迭代的状态
     * @param $sprintId
     * @param $field
     * @param bool $unDone
     * @return array
     */
    public static function getSprintFieldStat($sprintId, $field, $unDone = false)
    {
        if (empty($sprintId)) {
            return [];
        }
        $model = IssueModel::getInstance();
        $table = $model->getTable();
        $noDoneStatusSql = '';
        if ($unDone) {
            $noDoneStatusSql = " AND " . self::getUnDoneSql();
        }
        $sql = "SELECT {$field} as id,count(*) as count FROM {$table} 
                          WHERE sprint ={$sprintId} {$noDoneStatusSql} GROUP BY {$field} ";
        // echo $sql;
        $rows = $model->db->getRows($sql);
        return $rows;
    }

    /**
     * 获取按优先级的数据
     * @param int $projectId
     * @param bool $unDone 是否只包含未解决问题的数量
     * @return array
     */
    public static function getPriorityStat($projectId, $unDone = false)
    {
        return self::getFieldStat($projectId, 'priority', $unDone);
    }

    /**
     * 获取迭代的按优先级的数据
     * @param $sprintId
     * @param bool $unDone
     * @return array
     */
    public static function getSprintPriorityStat($sprintId, $unDone = false)
    {
        return self::getSprintFieldStat($sprintId, 'priority', $unDone);
    }

    /**
     * 获取按状态的未解决问题的数量
     * @param $projectId
     * @param $unDone bool 是否只包含未解决问题的数量
     * @return array
     */
    public static function getStatusStat($projectId, $unDone = false)
    {
        return self::getFieldStat($projectId, 'status', $unDone);
    }

    /**
     * 获取迭代的按状态的未解决问题的数量
     * @param $sprintId
     * @param $unDone bool 是否只包含未解决问题的数量
     * @return array
     */
    public static function getSprintStatusStat($sprintId, $unDone = false)
    {
        return self::getSprintFieldStat($sprintId, 'status', $unDone);
    }

    /**
     * 获取按事项类型的未解决问题的数量
     * @param $projectId
     * @param $unDone bool 是否只包含未解决问题的数量
     * @return array
     */
    public static function getTypeStat($projectId, $unDone = false)
    {
        return self::getFieldStat($projectId, 'issue_type', $unDone);
    }

    /**
     * 获取迭代按事项类型的未解决问题的数量
     * @param $sprintId
     * @param $unDone bool 是否只包含未解决问题的数量
     * @return array
     */
    public static function getSprintTypeStat($sprintId, $unDone = false)
    {
        return self::getSprintFieldStat($sprintId, 'issue_type', $unDone);
    }


    /**
     * 获取迭代中各用户的权重值
     * @param $sprintId
     * @return array
     * @throws \Exception
     */
    public static function getSprintWeightStat($sprintId)
    {
        if (empty($sprintId)) {
            return [];
        }

        $model = new IssueModel();
        $table = $model->getTable();
        $sql = "SELECT assignee as user_id,sum(weight) as count FROM {$table} 
                          WHERE sprint ={$sprintId}   GROUP BY assignee ";
        // echo $sql;
        $rows = $model->db->getRows($sql);
        foreach ($rows as $k => $row) {
            if (empty($row['user_id'])) {
                unset($rows[$k]);
            }
        }
        sort($rows);
        return $rows;
    }

    /**
     * 获取项目中各用户的权重值
     * @param $projectId
     * @return array
     * @throws \Exception
     */
    public static function getWeightStat($projectId)
    {
        if (empty($projectId)) {
            return [];
        }

        $model = new IssueModel();
        $table = $model->getTable();
        $sql = "SELECT assignee as user_id,sum(weight) as count FROM {$table} 
                          WHERE project_id ={$projectId}   GROUP BY assignee ";
        // echo $sql;
        $rows = $model->db->getRows($sql);
        foreach ($rows as $k => $row) {
            if (empty($row['user_id'])) {
                unset($rows[$k]);
            }
        }
        sort($rows);
        return $rows;
    }

    /**
     * 获取按事项类型的未解决问题的数量
     * @param $projectId
     * @param $unDone bool 是否只包含未解决问题的数量
     * @return array
     * @throws \Exception
     */
    public static function getAssigneeStat($projectId, $unDone = false)
    {
        if (empty($projectId)) {
            return [];
        }
        $noDoneStatusSql = '';
        if ($unDone) {
            $noDoneStatusSql = " AND " . self::getUnDoneSql();
        }
        $model = new IssueModel();
        $table = $model->getTable();
        $sql = "SELECT assignee as user_id,count(*) as count FROM {$table} 
                          WHERE project_id ={$projectId} {$noDoneStatusSql}  GROUP BY assignee ";
        // echo $sql;
        $rows = $model->db->getRows($sql);
        foreach ($rows as $k => $row) {
            if (empty($row['user_id'])) {
                unset($rows[$k]);
            }
        }
        sort($rows);
        return $rows;
    }

    /**
     * 获取迭代按事项类型的未解决问题的数量
     * @param $sprintId
     * @param $unDone bool 是否只包含未解决问题的数量
     * @return array
     * @throws \Exception
     */
    public static function getSprintAssigneeStat($sprintId, $unDone = false)
    {
        if (empty($sprintId)) {
            return [];
        }
        $noDoneStatusSql = '';
        if ($unDone) {
            $noDoneStatusSql = " AND " . self::getUnDoneSql();
        }
        $model = new IssueModel();
        $table = $model->getTable();
        $sql = "SELECT assignee as user_id,count(*) as count FROM {$table} 
                          WHERE sprint ={$sprintId} {$noDoneStatusSql}  GROUP BY assignee ";
        // echo $sql;
        $rows = $model->db->getRows($sql);
        foreach ($rows as $k => $row) {
            if (empty($row['user_id'])) {
                unset($rows[$k]);
            }
        }
        sort($rows);
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
     * @throws \Exception
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
            $noDoneStatusSql = self::getUnDoneSql();
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
     * @return array
     * @throws \Exception
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
            $noDoneStatusSql = self::getUnDoneSql();
        }
        $params = [];
        $params['sprint'] = $sprintId;

        $sql = "SELECT {$field} as id,count(*) as count FROM {$table} 
                          WHERE sprint =:sprint  {$noDoneStatusSql}  GROUP BY {$field} ";
        // echo $sql;
        $rows = $model->db->getRows($sql, $params);
        return $rows;
    }

    /**
     * @param $field
     * @param $projectId
     * @param null $withinDate
     * @return array
     * @throws \Exception
     */
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
            $withinTime = time() - (3600 * 24 * $withinDate);
            $withinFormatDate = date('Y-m-d', $withinTime);
            $withinDateSql = " AND  date>='{$withinFormatDate}'";
        }

        $sql = "SELECT {$field} as label,{$table}.* FROM {$table} 
                          WHERE project_id =:project_id  {$withinDateSql}   ";
        if ($field != 'date') {
            $sql = "SELECT 
                      {$field} as label,
                      max(count_done) as count_done,
                      max(count_no_done) as count_no_done,
                      max(count_done_by_resolve) as count_done_by_resolve, 
                      max(count_no_done_by_resolve) as count_no_done_by_resolve,
                      max(today_done_points) as today_done_points,
                      max(today_done_number) as today_done_number 
                    FROM {$table} 
                    WHERE project_id =:project_id    {$withinDateSql}  GROUP BY {$field} ";
        }
        //echo $sql;
        //print_r($params);
        $rows = $model->db->getRows($sql, $params);
        //print_r($rows);
        return $rows;
    }

    /**
     * 获取迭代的柱状图表数据
     * @param $field
     * @param $sprintId
     * @return array
     * @throws \Exception
     */
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
        if ($field != 'date') {
            $sql = "SELECT 
                      {$field} as label,
                      max(count_done) as count_done,
                      max(count_no_done) as count_no_done,
                      max(count_done_by_resolve) as count_done_by_resolve, 
                      max(count_no_done_by_resolve) as count_no_done_by_resolve,
                      max(today_done_points) as today_done_points,
                      max(today_done_number) as today_done_number 
                    FROM {$table} 
                    WHERE sprint_id =:sprint_id    GROUP BY {$field} ";
        }
        //echo $sql;
        $rows = $model->db->getRows($sql, $params);
        return $rows;
    }

    /**
     * 格式化事项
     * @param $issue
     */
    public static function formatIssue(&$issue)
    {
        if (empty(self::$unDoneStatusIdArr)) {
            $statusKeyArr = ['open', 'in_progress', 'reopen', 'in_review', 'delay'];
            $statusIdArr = IssueStatusModel::getInstance()->getIdArrByKeys($statusKeyArr);
            self::$unDoneStatusIdArr = $statusIdArr;
        }
        $issue['warning_delay'] = 0;
        $issue['postponed'] = 0;
        if (in_array($issue['status'], self::$unDoneStatusIdArr) && $issue['due_date'] != '0000-00-00' && !empty($issue['due_date'])) {
            $tomorrowTime = strtotime($issue['due_date'] . ' 23:59:59') + 1;
            if (time() > $tomorrowTime) {
                $issue['postponed'] = 1;
            } else {
                if (time() > ($tomorrowTime - 3600 * 24)) {
                    $issue['warning_delay'] = 1;
                }
            }
        }

        if (isset($issue['created'])) {
            $issue['created_text'] = format_unix_time($issue['created']);
            $issue['created_full'] = format_unix_time($issue['created'], 0, 'full_datetime_format');
        }

        if (isset($issue['updated'])) {
            $issue['updated_text'] = format_unix_time($issue['updated']);
            $issue['updated_full'] = format_unix_time($issue['updated'], 0, 'full_datetime_format');
        }
        if (empty($issue['start_date'])) {
            $issue['start_date'] = '';
        }
        if (empty($issue['due_date'])) {
            $issue['due_date'] = '';
        }
        if (isset($issue['assistants'])) {
            $issue['assistants_arr'] = [];
            $assistantsStr = $issue['assistants'];
            if (!empty($assistantsStr) && is_string($assistantsStr)) {
                $issue['assistants_arr'] = explode(',', $assistantsStr);
            }
        }

        if (empty($issue['have_children'])) {
            $issue['have_children'] = '0';
        }

        if (isset($issue['start_date']) && $issue['start_date'] == '0000-00-00') {
            $issue['start_date'] = '';
        }
        if (isset($issue['due_date']) && $issue['due_date'] == '0000-00-00') {
            $issue['due_date'] = '';
        }

        if (isset($issue['resolve_date']) && $issue['resolve_date'] == '0000-00-00') {
            $issue['resolve_date'] = '';
        }
    }
}
