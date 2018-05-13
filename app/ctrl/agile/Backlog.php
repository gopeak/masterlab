<?php

namespace main\app\ctrl\agile;

use main\app\ctrl\BaseUserCtrl;
use main\app\classes\AgileLogic;
use main\app\classes\UserLogic;
use main\app\classes\RewriteUrl;
use main\app\model\project\ProjectModel;
use main\app\model\project\ProjectVersionModel;
use main\app\model\project\ProjectModuleModel;
use main\app\model\issue\IssuePriorityModel;
use main\app\model\issue\IssueTypeModel;
use main\app\model\issue\IssueStatusModel;
use main\app\model\issue\IssueResolveModel;


class Backlog extends BaseUserCtrl
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
        $data['title'] = 'Backlog';
        $data['nav_links_active'] = 'backlog';
        $data['sub_nav_active'] = 'all';
        $data['query_str'] = http_build_query($_GET);
        $data = RewriteUrl::setProjectData($data);

        $this->render('gitlab/agile/backlog.php', $data);
    }

    /**
     *  fetch backlog
     */
    public function fetchAll()
    {
        $projectId = null;
        if (isset($_GET['_target'][3])) {
            $projectId = (int)$_GET['_target'][3];
        }
        if (isset($_GET['id'])) {
            $projectId = (int)$_GET['id'];
        }
        if (empty($projectId)) {
            $this->ajaxFailed('failed,params_error');
        }
        $issueLogic = new AgileLogic();
        list($fetchRet,$data['backlogs'],$backlogCount) = $issueLogic->getBacklogs($projectId);
        $data['sprints'] = $issueLogic->getSprints($projectId);

        $projectVersionModel = new ProjectVersionModel();
        $data['versions'] = $projectVersionModel->getByProject($projectId);

        $model = new IssuePriorityModel();
        $data['priority'] = $model->getAll();
        unset($model);

        $issueTypeModel = new IssueTypeModel();
        $data['issue_types'] = $issueTypeModel->getAll();
        unset($issueTypeModel);

        $model = new IssueStatusModel();
        $data['issue_status'] = $model->getAll();
        unset($model);

        $model = new IssueResolveModel();
        $data['issue_resolve'] = $model->getAll();
        unset($model);

        $userLogic = new UserLogic();
        $data['users'] = $userLogic->getAllNormalUser();
        unset($userLogic);

        $projectModel = new ProjectModel();
        $data['projects'] = $projectModel->getAll();
        unset($projectModel);

        $projectModuleModel = new ProjectModuleModel();
        $data['issue_module'] = $projectModuleModel->getAll();
        unset($projectModuleModel);

        $this->ajaxSuccess('success', $data);
    }
}
