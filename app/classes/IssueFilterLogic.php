<?php

/**
 * Created by PhpStorm.
 * User: sven
 * Date: 2017/7/7 0007
 * Time: 下午 3:56
 */

namespace main\app\classes;

use main\app\async\email;
use main\app\model\agile\SprintModel;
use main\app\model\issue\IssueLabelDataModel;
use main\app\model\issue\IssuePriorityModel;
use main\app\model\issue\IssueResolveModel;
use main\app\model\issue\IssueStatusModel;
use main\app\model\issue\IssueFilterModel;
use main\app\model\issue\IssueFollowModel;
use main\app\model\issue\IssueTypeModel;
use main\app\model\project\ProjectCatalogLabelModel;
use main\app\model\project\ProjectLabelModel;
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

    public static $unDoneStatusIdArr = [];


    public static $avlSortFields = [
        'id' => '创建时间',
        'updated' => '更新时间',
        'priority' => '优先级',
        'module' => '模  块',
        'issue_type' => '类  型',
        'sprint' => '迭代',
        'weight' => '权重',
        'assignee' => '经办人',
        'status' => '状态',
        'resolve' => '解决结果',
        'due_date' => '截止日期',
    ];

    public static $advFields = [
        'issue_num' => ['title' => '编号', 'opt' => '=,!=,like,<,>,<=,>=', 'type' => 'text', 'source' => ''],
        'summary' => ['title' => '标题', 'opt' => '=,!=,like,like %...%,regexp,regexp ^...$', 'type' => 'text', 'source' => ''],
        'updated' => ['title' => '更新时间', 'opt' => '=,!=,<,>,<=,>=', 'type' => 'datetime', 'source' => ''],
        'priority' => ['title' => '优先级', 'opt' => '=,!=,like', 'type' => 'select', 'source' => 'priority'],
        'module' => ['title' => '模  块', 'opt' => '=,!=,like', 'type' => 'select', 'source' => 'module'],
        'issue_type' => ['title' => '类  型', 'opt' => '=,!=,like', 'type' => 'select', 'source' => 'issueType'],
        'sprint' => ['title' => '迭 代', 'opt' => '=,!=,like', 'type' => 'select', 'source' => 'sprint'],
        'weight' => ['title' => '权重', 'opt' => '=,!=,like,<,>,<=,>=', 'type' => 'text', 'source' => ''],
        'assignee' => ['title' => '经办人', 'opt' => '=,!=,like', 'type' => 'select', 'source' => 'user'],
        'status' => ['title' => '状态', 'opt' => '=,!=,like', 'type' => 'select', 'source' => 'status'],
        'resolve' => ['title' => '解决结果', 'opt' => '=,!=,like', 'type' => 'select', 'source' => 'status'],
        'due_date' => ['title' => '截止日期', 'opt' => '=,!=,<,>,<=,>=', 'type' => 'date', 'source' => ''],
    ];


    public static $defaultSortField = 'id';

    public static $defaultSortBy = 'desc';

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
        if (!empty(trimStr($_GET['project']))) {
            $projectId = (int)trimStr($_GET['project']);
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

                // 使用LOCATE模糊搜索
                if (strlen($search) < 10) {
                    $sql .= " AND ( LOCATE(:summary,`summary`)>0  OR pkey=:pkey)";
                    $params['pkey'] = $search;
                    $params['summary'] = $search;
                } else {
                    $sql .= " AND  LOCATE(:summary,`summary`)>0  ";
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

        // 事项类型
        $typeId = null;
        if (isset($_GET[urlencode('类型')])) {
            $model = new IssueTypeModel();
            $row = $model->getByName(urldecode($_GET[urlencode('类型')]));
            if (isset($row['id'])) {
                $typeId = $row['id'];
            }
            unset($row);
        }
        if (isset($_GET['type_id'])) {
            $typeId = (int)$_GET['type_id'];
        }
        if ($typeId !== null) {
            $sql .= " AND issue_type=:issue_type";
            $params['issue_type'] = $typeId;
        }

        // 所属标签
        if (strpos($sysFilter, 'label_') === 0) {
            list(, $labelId) = explode('label_', $sysFilter);
            $labelIssueIdArr = IssueLabelDataModel::getInstance()->getIssueIdArrById($labelId);
            if ($labelIssueIdArr) {
                $issueIdStr = implode(',', $labelIssueIdArr);
                unset($issueIdArr);
                $sql .= " AND id in ({$issueIdStr})";
            }
        }
        
        // 所属分类
        if (strpos($sysFilter, 'catalog_') === 0) {
            list(, $catalogId) = explode('catalog_', $sysFilter);
            $projectCatalogLabel = (new ProjectCatalogLabelModel())->getById((int)$catalogId);
            if (isset($projectCatalogLabel['label_id_json'])) {
                $labelIdArr = json_decode($projectCatalogLabel['label_id_json']);
                if ($labelIdArr) {
                    $issueIdArr = IssueLabelDataModel::getInstance()->getIssueIdArrByIds($labelIdArr);
                    if ($issueIdArr) {
                        $issueIdStr = implode(',', $issueIdArr);
                        unset($issueIdArr);
                        $sql .= " AND id in ({$issueIdStr})";
                    }
                }
            }
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
        // 我关注的
        if ($sysFilter == 'my_followed') {
            $curUserId = UserAuth::getInstance()->getId();
            $issueFollowModel = new IssueFollowModel();
            $issueFollows = $issueFollowModel->getItemsByUserId($curUserId);

            $followIssueIdArr = [];
            if (!empty($issueFollows)) {
                foreach ($issueFollows as $issueFollow) {
                    $followIssueIdArr[] = $issueFollow['issue_id'];
                }
                $followIssueIdArr = array_unique($followIssueIdArr);
                if (!empty($followIssueIdArr)) {
                    $issueIdStr = implode(',', $followIssueIdArr);
                    $sql .= "  AND id in ({$issueIdStr})";
                }
            } else {
                $sql .= " AND  id in (0) ";
            }
            unset($issueFollowModel, $issueFollows, $followIssueIdArr);
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
            $orderBy = trimStr($_GET['sort_field']);
        }
        $sortBy = 'DESC';
        if (isset($_GET['sort_by']) && !empty($_GET['sort_by'])) {
            $sortBy = trimStr($_GET['sort_by']);
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
            // echo $sql;die;

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
     * 高级查询
     * @param int $page
     * @param int $pageSize
     * @return array
     * @throws \Exception
     */
    public function getAdvQueryList($page = 1, $pageSize = 20)
    {
        // sys_filter=1&fav_filter=2&project=2&reporter=2&title=fdsfdsfsd&assignee=2&created_start=232131&update_start=43432&sort_by=&32323&mod=123&reporter=12&priority=2&status=23&resolution=2
        $paramsField = [];
        $params = [];
        $sql = " WHERE 1";

        // 项目筛选
        $projectId = null;
        if (isset($_GET['project_id']) && !empty($_GET['project_id'])) {
            $projectId = (int)$_GET['project_id'];
            $sql .= " AND project_id=:project_id ";
            $params['project_id'] = $projectId;
        } else {
            // 如果没有指定某一项目，则获取用户参与的项目
            $userJoinProjectIdArr = PermissionLogic::getUserRelationProjectIdArr(UserAuth::getId());
            if (!empty($userJoinProjectIdArr)) {
                $projectIdStr = implode(',', $userJoinProjectIdArr);
                $sql .= " AND  project_id IN ({$projectIdStr}) ";
            }
        }

        $queryJson = null;
        $queryArr = [];
        if (isset($_GET['adv_query_json'])) {
            $queryJson = $_GET['adv_query_json'];
            $queryArr = json_decode($queryJson, true);
        }

        if (!$queryArr) {
            return [false, '查询条件格式错误', 0];
        }
        // 先获取Mysql版本号
        $versionSql = 'select version() as vv';
        $issueModel = new IssueModel();
        $versionStr = $issueModel->db->getOne($versionSql);
        $versionNum = floatval($versionStr);
        if (strpos($versionStr, 'MariaDB') !== false) {
            $versionNum = 0;
        }
        $startBracesNum = 0;
        $endBracesNum = 0;
        $sql .= ' AND ( ';

        $advFields = self::$advFields;

        $i = 0;
        foreach ($queryArr as $item) {
            $i++;

            $field = trimStr($item['field']);
            if (!array_key_exists($field, $advFields)) {
                return [false, [], 0];
            }

            $value = $item['value'];

            if ($field == 'updated' || $field == 'created') {
                $value = strtotime($value);
            }

            $logic = strtoupper($item['logic']);
            if ($i == 1) {
                $logic = '';
            }
            $startBraces = trimStr($item['start_braces']);
            if ($startBraces == '(') {
                $startBracesNum++;
            }
            $endBraces = trimStr($item['end_braces']);
            if ($endBraces == ')') {
                $endBracesNum++;
            }

            $sql .= " {$logic} {$startBraces} ";


            $opt = strtolower(urldecode($item['opt']));
            $fieldOptArr = explode(',', $advFields[$field]['opt']);

            if (!in_array($opt, $fieldOptArr)) {
                // 忽略操作符不在配置数组中的查询条件
                $sql .= " 1=1 ";
                continue;
            }

            switch ($opt) {
                case '=':
                case '!=':
                case '>':
                case '>=':
                case '<=':
                case '<':
                    if (in_array($field, $paramsField)) {
                        $sql .= sprintf(" %s %s :%s_%s ", $field, $opt, $field, $i);
                        $params[$field . '_' . $i] = $value;
                    } else {
                        $sql .= " $field {$opt}:$field ";
                        $params[$field] = $value;
                    }
                    break;
                case 'in':
                case 'not in':
                    if (in_array($field, $paramsField)) {
                        $sql .= sprintf(" %s %s ( :%s_%s ) ", $field, $opt, $field, $i);
                        $params[$field . '_' . $i] = $value;
                    } else {
                        $sql .= " $field  {$opt} ( :$field ) ";
                        $params[$field] = $value;
                    }
                    break;
                case 'like':
                    if (in_array($field, $paramsField)) {
                        $sql .= sprintf(" %s %s :%s_%s ", $field, $opt, $field, $i);
                        $params[$field . '_' . $i] = '%' . $value . '%';
                    } else {
                        $sql .= " $field  {$opt} :$field ";
                        $params[$field] = '%' . $value . '%';
                    }
                    break;
                case 'like %...%':
                    $sql .= "   LOCATE(:$field,$field)>0  ";
                    $params[$field] = $value;
                    break;
                case 'is null':
                case 'is not null':
                    $sql .= "  $field {$opt} ";
                    $params[$field] = $value;
                    break;
                case 'between':
                case 'not between':
                    $sql .= "  $field {$opt} :$field";
                    $params[$field] = $value;
                    break;
                case 'regexp':
                    $value = urldecode($value);
                    $sql .= "  $field {$opt} '$value' ";
                    break;
                case 'regexp ^...$':
                    $sql .= "  $field REGEXP  '^{$value}$' ";
                    break;
                default:
                    if (in_array($field, $paramsField)) {
                        $sql .= sprintf(" %s %s :%s_%s ", $field, $opt, $field, $i);
                        $params[$field . '_' . $i] = $value;
                    } else {
                        $sql .= " $field  {$opt} :$field ";
                        $params[$field] = $value;
                    }
            }
            $sql .= " {$endBraces} ";

            $paramsField[] = $field;
        }
        $sql .= ' ) ';
        if ($startBracesNum != $endBracesNum) {
            return [false, '查询条件的括号 ( ) 条件错误', 0];
        }

        $orderBy = 'id';
        if (isset($_GET['sort_field']) && !empty($_GET['sort_field'])) {
            $orderBy = $_GET['sort_field'];
        }
        $sortBy = 'DESC';
        if (isset($_GET['sort_by']) && !empty($_GET['sort_by'])) {
            $sortBy = $_GET['sort_by'];
        }

        $start = $pageSize * ($page - 1);
        $limit = " limit $start, " . $pageSize;
        $order = empty($orderBy) ? '' : " Order By  $orderBy  $sortBy";

        $model = new IssueModel();
        $table = $model->getTable();

        try {
            // 获取总数
            $sqlCount = "SELECT count(*) as cc FROM  {$table} " . $sql;
            // echo $sqlCount;
            // print_r($params);
            $count = $model->db->getOne($sqlCount, $params);
            $fields = '*';
            $sql = "SELECT {$fields} FROM  {$table} " . $sql;
            $sql .= ' ' . $order . $limit;
            //print_r($params);
            //echo $sql;print_r($params);die;
            $arr = $model->db->getRows($sql, $params);
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
     * 获取未解决的数量
     * @param $userId
     * @param $projectId
     * @return int
     * @throws \Exception
     */
    public static function getUnResolveCountByAssigneeProject($userId, $projectId)
    {
        if (empty($userId)) {
            return 0;
        }
        $params = [];
        $params['assignee'] = $userId;
        $params['project_id'] = $projectId;
        $model = new IssueModel();
        $table = $model->getTable();
        $sql = " SELECT count(*) as cc FROM  {$table}  WHERE  assignee=:assignee AND project_id=:project_id AND  " . self::getUnDoneSql();
        $count = $model->db->getOne($sql, $params);
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
     * 获取非关闭事项
     * @return string
     */
    public static function getNoClosedSql()
    {
        $statusModel = IssueStatusModel::getInstance();
        $noDoneStatusIdArr = [];
        $noDoneStatusIdArr[] = $statusModel->getIdByKey('closed');
        $noDoneStatusIdArr[] = $statusModel->getIdByKey('resolved');
        $noDoneStatusIdStr = implode(',', $noDoneStatusIdArr);
        $appendSql = "  `status` NOT IN({$noDoneStatusIdStr}) ";
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
     * @param int $statusType 包含未解决|已解决|全部事项
     * @return array
     * @throws \Exception
     */
    public static function getFieldStat($projectId, $field, $statusType = GlobalConstant::ISSUE_STATUS_TYPE_ALL)
    {
        if (empty($projectId)) {
            return [];
        }
        $model = IssueModel::getInstance();
        $table = $model->getTable();

        $statusSql = '';
        switch ($statusType) {
            case GlobalConstant::ISSUE_STATUS_TYPE_UNDONE:
                $statusSql = " AND " . self::getUnDoneSql();
                break;
            case GlobalConstant::ISSUE_STATUS_TYPE_DONE:
                $statusSql = " AND " . self::getDoneSql();
                break;
            default:
        }

        $sql = "SELECT {$field} as id,count(*) as count FROM {$table} 
                          WHERE project_id ={$projectId} {$statusSql} GROUP BY {$field} ";
        // echo $sql;
        $rows = $model->db->getRows($sql);
        return $rows;
    }

    /**
     * 获取迭代的状态
     * @param $sprintId
     * @param $field
     * @param int $statusType 包含未解决|已解决|全部事项
     * @return array
     * @throws \Exception
     */
    public static function getSprintFieldStat($sprintId, $field, $statusType = GlobalConstant::ISSUE_STATUS_TYPE_ALL)
    {
        if (empty($sprintId)) {
            return [];
        }
        $model = IssueModel::getInstance();
        $table = $model->getTable();

        $statusSql = '';
        switch ($statusType) {
            case GlobalConstant::ISSUE_STATUS_TYPE_UNDONE:
                $statusSql = " AND " . self::getUnDoneSql();
                break;
            case GlobalConstant::ISSUE_STATUS_TYPE_DONE:
                $statusSql = " AND " . self::getDoneSql();
                break;
            default:
        }

        $sql = "SELECT {$field} as id,count(*) as count FROM {$table} 
                          WHERE sprint ={$sprintId} {$statusSql} GROUP BY {$field} ";
        // echo $sql;
        $rows = $model->db->getRows($sql);
        return $rows;
    }

    /**
     * @param $projectId
     * @param int $statusType 包含未解决|已解决|全部事项
     * @return array
     * @throws \Exception
     */
    public static function getPriorityStat($projectId, $statusType = GlobalConstant::ISSUE_STATUS_TYPE_ALL)
    {
        return self::getFieldStat($projectId, 'priority', $statusType);
    }

    /**
     * 获取迭代的按优先级的数据
     * @param $sprintId
     * @param int $statusType 包含未解决|已解决|全部事项
     * @return array
     * @throws \Exception
     */
    public static function getSprintPriorityStat($sprintId, $statusType = GlobalConstant::ISSUE_STATUS_TYPE_ALL)
    {
        return self::getSprintFieldStat($sprintId, 'priority', $statusType);
    }

    /**
     * 获取按状态的未解决问题的数量
     * @param $projectId
     * @param $unDone bool 是否只包含未解决问题的数量
     * @return array
     */
    public static function getStatusStat($projectId, $unDone = false)
    {
        if ($unDone) {
            return self::getFieldStat($projectId, 'status', GlobalConstant::ISSUE_STATUS_TYPE_UNDONE);
        }
        return self::getFieldStat($projectId, 'status', GlobalConstant::ISSUE_STATUS_TYPE_ALL);
    }

    /**
     * 获取迭代的按状态的未解决问题的数量
     * @param $sprintId
     * @param $unDone bool 是否只包含未解决问题的数量
     * @return array
     */
    public static function getSprintStatusStat($sprintId, $unDone = false)
    {
        if ($unDone) {
            return self::getSprintFieldStat($sprintId, 'status', GlobalConstant::ISSUE_STATUS_TYPE_UNDONE);
        }
        return self::getSprintFieldStat($sprintId, 'status', GlobalConstant::ISSUE_STATUS_TYPE_ALL);

    }

    /**
     * 获取按事项类型的未解决问题的数量
     * @param $projectId
     * @param $unDone bool 是否只包含未解决问题的数量
     * @return array
     */
    public static function getTypeStat($projectId, $unDone = false)
    {
        if ($unDone) {
            return self::getFieldStat($projectId, 'issue_type', GlobalConstant::ISSUE_STATUS_TYPE_UNDONE);
        }
        return self::getFieldStat($projectId, 'issue_type', GlobalConstant::ISSUE_STATUS_TYPE_ALL);
    }

    /**
     * 获取迭代按事项类型的未解决问题的数量
     * @param $sprintId
     * @param $unDone bool 是否只包含未解决问题的数量
     * @return array
     */
    public static function getSprintTypeStat($sprintId, $unDone = false)
    {
        if ($unDone) {
            return self::getSprintFieldStat($sprintId, 'issue_type', GlobalConstant::ISSUE_STATUS_TYPE_UNDONE);
        }
        return self::getSprintFieldStat($sprintId, 'issue_type', GlobalConstant::ISSUE_STATUS_TYPE_ALL);
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
     *
     * 获取按事项类型的事项的数量
     * @param $projectId
     * @param int $statusType 包含未解决|已解决|全部事项
     * @return array
     * @throws \Exception
     */
    public static function getAssigneeStat($projectId, $statusType = GlobalConstant::ISSUE_STATUS_TYPE_ALL)
    {
        if (empty($projectId)) {
            return [];
        }
        $statusSql = '';
        switch ($statusType) {
            case GlobalConstant::ISSUE_STATUS_TYPE_UNDONE:
                $statusSql = " AND i." . self::getUnDoneSql();
                break;
            case GlobalConstant::ISSUE_STATUS_TYPE_DONE:
                $statusSql = " AND i." . self::getDoneSql();
                break;
            default:
        }

        $model = new IssueModel();
        $table = $model->getTable();
        $sql = "SELECT i.assignee as user_id,count(*) as count, u.display_name FROM {$table} i LEFT JOIN user_main u ON i.assignee=u.uid
                          WHERE i.project_id ={$projectId} {$statusSql}  GROUP BY i.assignee ";
        //$sql = "SELECT assignee as user_id,count(*) as count FROM {$table} WHERE project_id ={$projectId} {$statusSql}  GROUP BY assignee ";
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
     * @param int $statusType 包含未解决|已解决|全部事项
     * @return array
     * @throws \Exception
     */
    public static function getSprintAssigneeStat($sprintId, $statusType = GlobalConstant::ISSUE_STATUS_TYPE_ALL)
    {
        if (empty($sprintId)) {
            return [];
        }
        $statusSql = '';
        switch ($statusType) {
            case GlobalConstant::ISSUE_STATUS_TYPE_UNDONE:
                $statusSql = " AND " . self::getUnDoneSql();
                break;
            case GlobalConstant::ISSUE_STATUS_TYPE_DONE:
                $statusSql = " AND " . self::getDoneSql();
                break;
            default:
        }

        $model = new IssueModel();
        $table = $model->getTable();
        $sql = "SELECT assignee as user_id,count(*) as count FROM {$table} 
                          WHERE sprint ={$sprintId} {$statusSql}  GROUP BY assignee ";
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

    public static function getMyFollow($curUserId = 0, $page = 1, $pageSize = 10)
    {
        $start = $pageSize * ($page - 1);
        $appendSql = " Order by id desc  limit {$start}, " . $pageSize;

        $issueFollowModel = new IssueFollowModel();
        $issueFollows = $issueFollowModel->getItemsByUserId($curUserId);
        $followIssueIdArr = [];
        if (!empty($issueFollows)) {
            foreach ($issueFollows as $issueFollow) {
                $followIssueIdArr[] = $issueFollow['issue_id'];
            }
            $followIssueIdArr = array_unique($followIssueIdArr);
            if (!empty($followIssueIdArr)) {
                $issueIdStr = implode(',', $followIssueIdArr);
                $inWhere = " id IN ({$issueIdStr})";

                $model = new IssueModel();
                $table = $model->getTable();

                $fields = 'id,pkey,issue_num,project_id,reporter,assignee,issue_type,summary,priority,resolve,status,created,updated,sprint,master_id,start_date,due_date';

                $sql = "SELECT {$fields} FROM {$table} WHERE {$inWhere} {$appendSql}";
                //echo $sql;
                $rows = $model->db->getRows($sql);
                $count = $model->db->getOne("SELECT count(*) as cc FROM {$table} WHERE {$inWhere}");
                foreach ($rows as &$row) {
                    self::formatIssue($row);
                }

                return [$rows, $count];
            }
            return [[], 0];
        } else {
            return [[], 0];
        }
    }

    /**
     * 格式化事项
     * @param $issue
     * @throws \Exception
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
