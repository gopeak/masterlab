<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/24
 * Time: 0:13
 */

namespace main\app\ctrl;

use main\app\classes\UserAuth;
use main\app\classes\UserLogic;
use main\app\classes\SearchLogic;
use main\app\classes\ProjectLogic;
use main\app\model\issue\IssuePriorityModel;
use main\app\model\project\ProjectModel;
use main\app\model\issue\IssueStatusModel;
use main\app\model\issue\IssueTypeModel;
use main\app\model\OrgModel;

/**
 *
 * Class Search
 * @package main\app\ctrl
 */
class Search extends BaseUserCtrl
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 全局搜索界面
     * @throws \Exception
     */
    public function pageIndex()
    {
        $data = [];
        $data['title'] = '搜 索';
        $data['top_menu_active'] = '';
        $data['nav_links_active'] = '';
        $data['sub_nav_active'] = '';

        $model = new IssuePriorityModel();
        $data['priority'] = $model->getAll();
        unset($model);

        $issueTypeModel = new IssueTypeModel();
        $data['issue_types'] = $issueTypeModel->getAll();

        $model = new IssueStatusModel();
        $data['issue_status'] = $model->getAll();
        unset($model);

        $pageSize = 20;
        $page = 1;
        if (isset($_GET['page'])) {
            $page = max(1, (int)$_GET['page']);
        }

        $scope = 'issue';
        if (isset($_GET['scope'])) {
            $scope = $_GET['scope'];
        }
        if (!in_array($scope, ['issue', 'project', 'user'])) {
            $scope = 'issue';
        }

        $keyword = '';
        if (isset($_GET['keyword'])) {
            $keyword = $_GET['keyword'];
        }

        $versionSql = 'select version() as vv';
        $versionStr = $issueTypeModel->db->getOne($versionSql);
        SearchLogic::$mysqlVersion = floatval($versionStr);
        if (strpos($versionStr, 'MariaDB') !== false) {
            SearchLogic::$mysqlVersion = 0;
        }

        // 搜索项目
        $projects = [];
        $projectTotal = 0;
        //print_r($_GET);
        //print_r($_POST);
        if (!empty($keyword)) {
            // 直接从数据库搜索项目，因为数据量比较小,不适用Sphinx
            $projectTotal = SearchLogic::getProjectCountByKeyword($keyword);
            if ($projectTotal > 0 && isset($_GET['scope']) && empty($_GET['scope'])) {
                $scope = 'project';
            }
            if ($scope == 'project') {
                $projects = SearchLogic::getProjectByKeyword($keyword, $page, $pageSize);
                foreach ($projects as &$item) {
                    $item = ProjectLogic::formatProject($item);
                }
            }
        }

        // 搜索事项
        $projectModel = new ProjectModel();
        $data['all_projects'] = $allProjects = $projectModel->getAll();
        unset($projectModel);

        // 使用全文索引
        $issueTotal = SearchLogic::getIssueCountByKeywordWithNgram($keyword);
        $issues = [];
        if ($scope == 'issue') {
            $issues = SearchLogic::getIssueByKeywordWithNgram($keyword, $page, $pageSize);
            foreach ($issues as &$issue) {
                $issue['project'] = null;
                $issue['org_path'] = 'default';
                if (isset($allProjects[$issue['project_id']])) {
                    $issue['project'] = $allProjects[$issue['project_id']];
                    $issue['org_path'] = $issue['project']['org_path'];
                }
            }
        }

        // 搜索用户直接从数据库搜索用户,因为数据量比较小,不适用Sphinx
        $users = [];
        $userTotal = 0;
        if (!empty($keyword)) {
            $userTotal = SearchLogic::getUserCountByKeyword($keyword);
            if ($scope == 'user') {
                $users = SearchLogic::getUserByKeyword($keyword, $page, $pageSize);
            }
        }
        $data['page'] = $page;
        $data['scope'] = $scope;
        $data['keyword'] = $keyword;

        $data['issues'] = $issues;
        $data['issue_total'] = $issueTotal;
        $data['issue_pages'] = ceil($issueTotal / $pageSize);

        $data['projects'] = $projects;
        $data['project_total'] = $projectTotal;
        $data['project_pages'] = ceil($projectTotal / $pageSize);

        $data['users'] = $users;
        $data['user_total'] = $userTotal;
        $data['user_pages'] = ceil($userTotal / $pageSize);

        if (isset($_GET['data_type']) && ($_GET['data_type'] == 'json')) {
            $this->ajaxSuccess('testForJson', $data);
        }
        $this->render('gitlab/search/search.php', $data);
    }
}

