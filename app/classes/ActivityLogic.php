<?php

/**
 * Created by PhpStorm.
 * User: sven
 * Date: 2017/7/7 0007
 * Time: 下午 3:56
 */

namespace main\app\classes;

use main\app\model\ActivityModel;

/**
 * 活动动态逻辑类
 * Class ActivityLogic
 * @package main\app\classes
 */
class ActivityLogic
{

    /**
     * 格式化活动动态
     * @param $row
     */
    public static function formatActivity(&$row)
    {
        if (empty($row)) {
            return;
        }
        if (!isset($row['time'])) {
            return;
        }
        $row['time_text'] = '';
        $row['time_full'] = '';
        $row['time'] = intval($row['time']);
        if (empty($row['time'])) {
            return;
        }
        $row['time_text'] = format_unix_time($row['time']);
        $row['time_full'] = format_unix_time($row['time'], time(), 'full_datetime_format');
    }

    /**
     * @param $userId
     * @return array
     */
    public static function getCalendarHeatmap($userId)
    {
        $model = new ActivityModel();
        $sql = " select `date`, count(*) as count from  main_activity where user_id=:user_id AND `date`>=(curdate()-365)  GROUP BY date  ";
        $rows = $model->db->getRows($sql, ['user_id' => $userId]);
        return $rows;
    }

    /**
     * 获取用户的所见活动动态
     * @param $userId
     * @param int $page
     * @param int $pageSize
     * @return array
     * @throws \Exception
     */
    public static function filterByIndex($userId, $page = 1, $pageSize = 50)
    {
        $model = new ActivityModel();
        $haveAdminPerm = PermissionGlobal::check(UserAuth::getId(), PermissionGlobal::ADMINISTRATOR);
        $sqlRows = "SELECT  *  FROM " . $model->getTable();
        $filterProjectSql = ' WHERE project_id IN (null) ';
        if ($haveAdminPerm) {
            $filterProjectSql = ' ';
        } else {
            $userJoinProjectIdArr = PermissionLogic::getUserRelationProjectIdArr($userId);
            if (!empty($userJoinProjectIdArr)) {
                $userJoinProjectIdStr = implode(',', $userJoinProjectIdArr);
                $filterProjectSql = "WHERE  project_id IN ({$userJoinProjectIdStr}) ";
            }
        }
        $sqlRows .= $filterProjectSql;
        $conditions = [];
        $start = $pageSize * ($page - 1);
        $sqlRows .= " ORDER BY id DESC  limit $start, " . $pageSize;
        $rows = $model->db->getRows($sqlRows, $conditions);
        foreach ($rows as &$row) {
            self::formatActivity($row);
        }
        $sqlCount = "select count(*) as cc from " . $model->getTable() . "  " . $filterProjectSql;
        $count = $model->db->getOne($sqlCount, $conditions);
        return [$rows, $count];
    }

    /**
     * 用户的活动动态
     * @param int $userId
     * @param int $page
     * @param int $pageSize
     * @return array
     */
    public static function filterByUser($userId = 0, $page = 1, $pageSize = 50)
    {
        $conditions = [];
        if (!empty($userId)) {
            $conditions['user_id'] = $userId;
        }
        $start = $pageSize * ($page - 1);
        $appendSql = " 1 Order by id desc  limit $start, " . $pageSize;

        $model = new ActivityModel();
        $fields = " * ";
        $rows = $model->getRows($fields, $conditions, $appendSql);
        foreach ($rows as &$row) {
            self::formatActivity($row);
        }
        $count = $model->getOne('count(*) as cc', $conditions);
        return [$rows, $count];
    }

    /**
     * 项目的活动动态
     * @param int $projectId
     * @param int $page
     * @param int $pageSize
     * @return array
     */
    public static function filterByProject($projectId = 0,  $page = 1, $pageSize = 50)
    {
        $conditions = [];
        if (!empty($projectId)) {
            $conditions['project_id'] = $projectId;
        }
        $start = $pageSize * ($page - 1);
        $appendSql = " 1=1 Order by id desc  limit $start, " . $pageSize;

        $model = new ActivityModel();
        $fields = " * ";
        $rows = $model->getRows($fields, $conditions, $appendSql);
        foreach ($rows as &$row) {
            self::formatActivity($row);
        }
        $count = $model->getOne('count(*) as cc', $conditions);
        return [$rows, $count];
    }

    /**
     * 获取事项的活动日志
     * @param int $issueId
     * @param int $page
     * @param int $pageSize
     * @return array
     */
    public static function filterByIssueId($issueId = 0, $page = 1, $pageSize = 50)
    {
        if (empty($issueId)) {
            return [[], 0];
        }
        $conditions = [];
        $conditions['obj_id'] = $issueId;
        $conditions['type'] = 'issue';
        $start = $pageSize * ($page - 1);
        $model = new ActivityModel();
        $sql = "SELECT  *  FROM {$model->getTable()}  WHERE `obj_id` = :obj_id AND `type` =:type  Order by id desc  limit $start, " . $pageSize;
        $rows = $model->db->getRows($sql, $conditions);
        foreach ($rows as &$row) {
            self::formatActivity($row);
        }
        $sqlCount = "SELECT  count(*) as cc  FROM {$model->getTable()}  WHERE `obj_id` = :obj_id AND `type` =:type ";
        $count = $model->db->getOne($sqlCount, $conditions);
        return [$rows, $count];
    }

}
