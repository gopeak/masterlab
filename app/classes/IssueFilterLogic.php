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
use main\app\model\user\UserModel;
use main\app\model\issue\IssueModel;

class IssueFilterLogic
{
    public function getIssuesByFilter($page = 1, $pageSize = 50)
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
            //$favFilter = (int)$_GET['fav_filter'];
        }

        if (isset($_GET['project'])) {
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
            $sql .= " AND updated>=:updated_end";
            $params['updated_end'] = $updatedEndTime;
        }

        if (isset($_GET['created_end'])) {
            $createdEndTime = (int)$_GET['created_end'];
            $sql .= " AND created<:created_end";
            $params['created_end'] = $createdEndTime;
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
            $field = 'id,pkey,issue_num,project_id,reporter,assignee,issue_type,summary,priority,resolve,
            status,created,updated';
            // 获取总数
            $sqlCount = "SELECT count(*) as cc FROM  {$table} " . $sql;
            $count = $model->db->getOne($sqlCount, $params);

            $sql = "SELECT {$field} FROM  {$table} " . $sql;
            $sql .= ' ' . $order . $limit;
            //print_r($params);
            //echo $sql;die;

            $arr = $model->db->getRows($sql, $params);
            return [true, $arr, $count];
        } catch (\PDOException $e) {
            return [false, $e->getMessage(), 0];
        }
    }

    public static function formatIssue(&$issue)
    {
        $issue['created_text'] = format_unix_time($issue['created']);
        $issue['updated_text'] = format_unix_time($issue['updated']);
        $issue['assistants_arr'] = [];
        if (!empty($issue['assistants'])) {
            $issue['assistants_arr'] = explode(',', $issue['assistants']);
        }
    }
}
