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

    public static $preDefinedFilter = [
        'assignee_mine' => ['name' => '分配我的', 'description' => '分配我的事项'],
        'my_unsolved' => ['name' => '我未解决', 'description' => '分配我未解决的事项'],
        'my_followed' => ['name' => '我关注的', 'description' => '我关注的事项'],
        'my_assistant_issue' => ['name' => '我协助的', 'description' => '我协助的事项'],
        'my_report' => ['name' => '我报告的', 'description' => '我报告的事项'],
        //'active_sprint_unsolved' => ['name' => '当前迭代未解决的', 'title' => '当前活跃迭代的未解决事项'],
    ];


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

        $arr = $filterModel->db->fetchAll($sql, $params);
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

        $arr = $filterModel->db->fetchAll($sql, $params);
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
    public function saveFilter($name, $filter, $description = '', $shared = '', $projectId = null)
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
