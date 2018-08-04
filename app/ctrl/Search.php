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
     * index
     */
    public function index()
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
        unset($issueTypeModel);

        $model = new IssueStatusModel();
        $data['issue_status'] = $model->getAll();
        unset($model);

        $projectModel = new ProjectModel();
        $data['all_projects'] = $allProjects = $projectModel->getAll();
        unset($projectModel);


        $pageSize = 4;
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
        $projects = [];
        $projectTotal = 0;
        if (!empty($keyword)) {
            $model = new OrgModel();
            $originsMap = $model->getMapIdAndPath();
            // 直接从数据库搜索项目，因为数据量比较小,不适用Sphinx
            $projectTotal = SearchLogic::getProjectCountByKeyword($keyword);

            if ($projectTotal > 0 && isset($_GET['scope']) && empty($_GET['scope'])) {
                $scope = 'project';
            }
            if ($scope == 'project') {
                $projects = SearchLogic::getProjectByKeyword($keyword, $page, $pageSize);
                foreach ($projects as &$item) {
                    $item = ProjectLogic::formatProject($item, $originsMap);
                }
            }
        }

        // 从Sphinx中查询事项ID
        $issueTotal = '0';
        $issues = [];
        $matches = [];
        if (!empty($keyword)) {
            list($err, $queryRet, $matches) = SearchLogic::getIssueBySphinx($keyword, $page, $pageSize);
            if ($err) {
                $this->error('Sphinx服务查询错误', $err);
                return;
            }
        }
        if ($matches) {
            $issueTotal = $queryRet['total'];
            if ($scope == 'issue') {
                $issues = SearchLogic::getIssueByDb(array_keys($matches));
                foreach ($issues as &$issue) {
                    $issue['project'] = null;
                    $issue['org_path'] = 'default';
                    if (isset($allProjects[$issue['project_id']])) {
                        $issue['project'] = $allProjects[$issue['project_id']];
                        $orgId = $issue['project']['id'];
                        $issue['org_path'] = isset($originsMap[$orgId]) ? $originsMap[$orgId] : 'default';
                    }
                }
            }
        }
        // 直接从数据库搜索用户,因为数据量比较小,不适用Sphinx
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

        $this->render('gitlab/search/search.php', $data);
    }
}
