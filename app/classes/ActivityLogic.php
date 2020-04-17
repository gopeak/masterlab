<?php

/**
 * Created by PhpStorm.
 * User: sven
 * Date: 2017/7/7 0007
 * Time: 下午 3:56
 */

namespace main\app\classes;

use main\app\model\ActivityModel;
use \Doctrine\DBAL\ParameterType;

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
        $rows = $model->db->fetchAll($sql, ['user_id' => $userId]);
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
        //$haveAdminPerm = PermissionGlobal::check(UserAuth::getId(), PermissionGlobal::ADMINISTRATOR);
        $haveAdminPerm = PermissionGlobal::isGlobalUser(UserAuth::getId());
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
        $rows = $model->db->fetchAll($sqlRows, $conditions);
        foreach ($rows as &$row) {
            self::formatActivity($row);
        }
        $sqlCount = "select count(*) as cc from " . $model->getTable() . "  " . $filterProjectSql;
        $count = $model->getFieldBySql($sqlCount, $conditions);
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
        $count = $model->getField('count(*) as cc', $conditions);
        return [$rows, $count];
    }

    /**
     * 项目的活动动态
     * @param int $projectId
     * @param int $page
     * @param int $pageSize
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public static function filterByProject($projectId = 0,  $page = 1, $pageSize = 50)
    {
        $start = $pageSize * ($page - 1);
        $model = new ActivityModel();
        $table = $model->getTable();
        $queryBuilder = $model->db->createQueryBuilder();
        $queryBuilder->select('*')->from($table)->where('project_id =:project_id')->setParameter('project_id', intval($projectId),ParameterType::INTEGER);

        if (isset($_GET['user_id'])  && !empty($_GET['user_id'])) {
            $queryBuilder->andWhere('user_id =:user_id')->setParameter('user_id', intval($_GET['user_id']),ParameterType::INTEGER);
        }
        if (isset($_GET['type']) && !empty($_GET['type'])) {
            $queryBuilder->andWhere('type =:type')->setParameter('type', trimStr($_GET['type']),ParameterType::STRING);
        }
        if (isset($_GET['start_datetime']) && !empty($_GET['start_datetime']) ) {
            $queryBuilder->andWhere('time >=:start_time')->setParameter('start_time', strtotime($_GET['start_datetime']),ParameterType::INTEGER);
        }
        if (isset($_GET['end_datetime'])  && !empty($_GET['end_datetime'])) {
            $queryBuilder->andWhere('time <=:end_time')->setParameter('end_time', strtotime($_GET['end_datetime']),ParameterType::INTEGER);
        }

        $count = (int)$queryBuilder->select('count(*) as cc')->execute()->fetchColumn();

        $queryBuilder->select('*');
        $orderBy = 'id';
        if (isset($_GET['sort_field'])) {
            $orderBy = trimStr($_GET['sort_field']);
        }
        $sortBy = 'DESC';
        if (isset($_GET['sort_by'])) {
            $sortBy = trimStr($_GET['sort_by']);
        }

        $queryBuilder->orderBy($orderBy, $sortBy)->setFirstResult($start)->setMaxResults($pageSize);
       // echo $queryBuilder->getSQL();
        $rows =  $queryBuilder->execute()->fetchAll();
        foreach ($rows as &$row) {
            self::formatActivity($row);
        }

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
        $rows = $model->db->fetchAll($sql, $conditions);
        foreach ($rows as &$row) {
            self::formatActivity($row);
        }
        $sqlCount = "SELECT  count(*) as cc  FROM {$model->getTable()}  WHERE `obj_id` = :obj_id AND `type` =:type ";
        $count = $model->getFieldBySql($sqlCount, $conditions);
        return [$rows, $count];
    }

}
