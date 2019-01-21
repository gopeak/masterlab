<?php

/**
 * Created by PhpStorm.
 * User: sven
 * Date: 2017/7/7 0007
 * Time: 下午 3:56
 */

namespace main\app\classes;

use main\app\model\issue\IssueFilterModel;
use main\app\model\user\UserModel;
use main\app\model\issue\IssueModel;

class IssueFavFilterLogic
{
    public $displayNum = 8;

    public function getCurUserFavFilterByProject($projectId = null)
    {
        $filterModel = IssueFilterModel::getInstance();
        $table = $filterModel->getTable();
        $params['currentUid'] = UserAuth::getInstance()->getId();
        $addSql = '';
        if (!empty($projectId)) {
            $addSql = " AND projectid='{$projectId}'";
        }
        $sql = "SELECT * FROM  {$table}  WHERE author=:currentUid {$addSql} Order By id desc ";

        $arr = $filterModel->db->getRows($sql, $params);
        foreach ($arr as &$f) {
            $f['md5'] = md5($f['filter']);
        }
        return $arr;
    }


    /**
     * @return array
     */
    public function getCurUserFavFilter()
    {
        $filterModel = IssueFilterModel::getInstance();
        $table = $filterModel->getTable();
        $params['currentUid'] = UserAuth::getInstance()->getId();
        $sql = "SELECT * FROM  {$table}  WHERE author=:currentUid OR share_scope='all' Order By id desc ";

        $arr = $filterModel->db->getRows($sql, $params);
        $i = 0;
        $firstFilters = [];
        $hideFilters = [];
        foreach ($arr as $f) {
            $v = $f;
            $v['md5'] = md5($v['filter']);
            $i++;
            if ($i < $this->displayNum) {
                $firstFilters[] = $v;
            } else {
                $hideFilters[] = $v;
            }
        }
        unset($filterModel, $arr);
        return [$firstFilters, $hideFilters];
    }

    /**
     * @param $name
     * @param $filter
     * @param string $description
     * @param string $shared
     * @param null $projectId
     * @return array
     * @throws \Exception
     */
    public function saveFilter($name, $filter, $description = '', $shared = '', $projectId=null)
    {
        $filterModel = IssueFilterModel::getInstance();
        $info = [];
        $info['author'] = UserAuth::getInstance()->getId();
        $info['name'] = $name;
        $info['projectid'] = $projectId;
        $info['filter'] = $filter;
        $info['description'] = urldecode($description);
        $info['share_scope'] = $shared;
        return $filterModel->insert($info);
    }
}
