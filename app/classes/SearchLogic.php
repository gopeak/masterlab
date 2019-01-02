<?php

/**
 * Created by PhpStorm.
 * User: sven
 * Date: 2017/7/7 0007
 * Time: 下午 3:56
 */

namespace main\app\classes;

use main\app\model\issue\IssueModel;
use main\app\model\project\ProjectModel;
use main\app\model\user\UserModel;

/**
 * 全文搜索逻辑类
 * Class SearchLogic
 * @package main\app\classes
 */
class SearchLogic
{

    public static $mysqlVersion = 0;

    /**
     *
     * @param $keyword
     * @param int $page
     * @param int $pageSize
     * @return array
     */
    public static function getIssueBySphinx($keyword, $page = 1, $pageSize = 50)
    {
        require_once APP_PATH . '../lib/SphinxClient.php';
        $mailConfig = getConfigVar('sphinx');
        $host = $mailConfig['server']['host'] ;
        $port = $mailConfig['server']['port'] ;
        $s = new \SphinxClient;
        $s->setServer($host, $port);

        $start = $pageSize * ($page - 1);
        $s->setMaxQueryTime(30);
        $s->SetLimits($start, $pageSize);
        $queryRet = $s->Query($keyword, 'issue');
        $err = $s->GetLastError();
        $matches = !empty($queryRet['matches']) ? $queryRet['matches'] : [];
        $s->close();
        return [$err, $queryRet, $matches];
    }

    /**
     * 通过id从数据库查询数据
     * @param $issueIdArr
     * @return array
     * @throws \Exception
     */
    public static function getIssueByDb($issueIdArr)
    {
        if (empty($issueIdArr)) {
            return [];
        }
        $issueModel = new IssueModel();
        $issueIdStr = implode(',', $issueIdArr);
        $table = $issueModel->getTable();

        $sql = "SELECT * FROM {$table} WHERE id in({$issueIdStr}) ";
        //var_dump($sql);
        $rows = $issueModel->db->getRows($sql);
        return $rows;
    }

    /**
     * 直接从项目表中查询数据
     * @param int $keyword
     * @param int $page
     * @param int $pageSize
     * @return array
     * @throws \Exception
     */
    public static function getProjectByKeyword($keyword = 0, $page = 1, $pageSize = 50)
    {
        $start = $pageSize * ($page - 1);
        $limitSql = "   limit $start, " . $pageSize;

        $model = new ProjectModel();
        $table = $model->getTable();
        $field = "*";
        if (self::$mysqlVersion < 5.70) {
            // 使用LOCATE模糊搜索
            $where = "WHERE   locate(:keyword,name) > 0  OR  locate(:keyword,`key`) > 0 ";
        } else {
            // 使用全文索引
            $where =" WHERE MATCH (`name`) AGAINST (:keyword IN NATURAL LANGUAGE MODE) ";
        }

        $params['keyword'] = $keyword;

        $sql = "SELECT {$field} FROM {$table} " . $where . $limitSql;
        //echo $keyword;
        //echo $sql;
        $projects = $model->db->getRows($sql, $params);
        return $projects;
    }

    /**
     * 获取项目搜索的总数
     * @param $keyword
     * @return int
     * @throws \Exception
     */
    public static function getProjectCountByKeyword($keyword)
    {
        $model = new ProjectModel();
        $table = $model->getTable();
        // var_export(self::$mysqlVersion);
        if (self::$mysqlVersion < 5.70) {
            // 使用LOCATE模糊搜索
            $where = "WHERE locate(:keyword,name) > 0  OR  locate(:keyword,`key`) > 0 ";
        } else {
            // 使用全文索引
            $where =" WHERE MATCH (`name`) AGAINST (:keyword IN NATURAL LANGUAGE MODE) ";
        }
        $params['keyword'] = $keyword;

        $sqlCount = "SELECT count(*)  as cc  FROM {$table}  " . $where;
        // echo $sqlCount;
        $count = $model->db->getOne($sqlCount, $params);

        return (int)$count;
    }

    /**
     * Mysql5.7以上版本使用内置的全文索引插件Ngram获取记录
     * @param int $keyword
     * @param int $page
     * @param int $pageSize
     * @return array
     * @throws \Exception
     */
    public static function getIssueByKeywordWithNgram($keyword = 0, $page = 1, $pageSize = 50)
    {
        $start = $pageSize * ($page - 1);
        $limitSql = "   limit $start, " . $pageSize;

        $issueModel = new IssueModel();
        $table = $issueModel->getTable();
        if (self::$mysqlVersion < 5.70) {
            // 使用LOCATE模糊搜索
            $where = "WHERE locate(:keyword,`summary`) > 0  ";
        } else {
            // 使用全文索引
            $where =" WHERE MATCH (`summary`) AGAINST (:keyword IN NATURAL LANGUAGE MODE) ";
        }

        $params['keyword'] = $keyword;
        $sql = "SELECT * FROM {$table}  {$where} {$limitSql}";
        //var_dump($sql);
        $rows = $issueModel->db->getRows($sql, $params);
        return $rows;
    }

    /**
     * Mysql5.7以上版本使用内置的全文索引插件Ngram获取总数
     * @param $keyword
     * @return int
     * @throws \Exception
     */
    public static function getIssueCountByKeywordWithNgram($keyword)
    {
        $model = new IssueModel();
        $table = $model->getTable();

        if (self::$mysqlVersion < 5.70) {
            // 使用LOCATE模糊搜索
            $where = "WHERE locate(:keyword,`summary`) > 0  ";
        } else {
            // 使用全文索引
            $where =" WHERE MATCH (`summary`) AGAINST (:keyword IN NATURAL LANGUAGE MODE) ";
        }
        $params['keyword'] = $keyword;

        $params['keyword'] = $keyword;
        $sqlCount = "SELECT count(*)  as cc  FROM {$table}  " . $where;
        $count = $model->db->getOne($sqlCount, $params);
        return (int)$count;
    }

    /**
     * 用户查询
     * @param int $keyword
     * @param int $page
     * @param int $pageSize
     * @return array
     * @throws \Exception
     */
    public static function getUserByKeyword($keyword = 0, $page = 1, $pageSize = 50)
    {
        $start = $pageSize * ($page - 1);
        $limitSql = "   limit $start, " . $pageSize;

        $model = new UserModel();
        $table = $model->getTable();
        $normalStatus = UserModel::STATUS_NORMAL;
        $field = "uid,username,display_name,email,create_time,update_time,avatar";
        $where = "WHERE status={$normalStatus} AND (locate( :email,email) > 0 || locate( :username,username) > 0  || locate( :display_name,display_name) > 0 )  ";
        $params['email'] = $keyword;
        $params['username'] = $keyword;
        $params['display_name'] = $keyword;

        $sql = "SELECT {$field} FROM {$table}  " . $where . $limitSql;
        $users = $model->db->getRows($sql, $params);
        foreach ($users as &$item) {
            $item = UserLogic::format($item);
        }
        return $users;
    }


    /**
     * 获取用户搜索的总数
     * @param $keyword
     * @return int
     * @throws \Exception
     */
    public static function getUserCountByKeyword($keyword)
    {
        $model = new UserModel();
        $table = $model->getTable();
        $normalStatus = UserModel::STATUS_NORMAL;
        $where = "WHERE status={$normalStatus} AND (locate( :email,email) > 0 || locate( :username,username) > 0  || locate( :display_name,display_name) > 0 )  ";
        $params['email'] = $keyword;
        $params['username'] = $keyword;
        $params['display_name'] = $keyword;
        $sqlCount = "SELECT count(*)  as cc  FROM {$table}  " . $where;
        $count = $model->db->getOne($sqlCount, $params);

        return (int)$count;
    }
}
