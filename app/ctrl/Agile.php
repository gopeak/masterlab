<?php

namespace main\app\ctrl;

use main\app\classes\AgileLogic;
use main\app\classes\UserLogic;
use main\app\classes\RewriteUrl;
use main\app\model\agile\SprintModel;
use main\app\model\issue\IssueModel;
use main\app\model\project\ProjectModel;
use main\app\model\project\ProjectModuleModel;
use main\app\model\issue\IssuePriorityModel;
use main\app\model\issue\IssueTypeModel;
use main\app\model\issue\IssueStatusModel;
use main\app\model\issue\IssueResolveModel;

class Agile extends BaseUserCtrl
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * index
     */
    public function backlog()
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
    public function fetchAllBacklogIssues()
    {
        $projectId = null;
        if (isset($_GET['_target'][2])) {
            $projectId = (int)$_GET['_target'][2];
        }
        if (isset($_GET['id'])) {
            $projectId = (int)$_GET['id'];
        }
        if (empty($projectId)) {
            $this->ajaxFailed('failed,params_error');
        }
        $issueLogic = new AgileLogic();
        list($fetchRet, $issues) = $issueLogic->getBacklogs($projectId);
        if ($fetchRet) {
            $data['backlogs'] = $issues;
        } else {
            $this->ajaxFailed('server_error:' . $issues);
        }
        $data['sprints'] = $issueLogic->getSprints($projectId);

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


    /**
     *  fetch sprint's issues
     */
    public function fetchSprintIssues()
    {
        $sprintId = null;
        if (isset($_GET['_target'][2])) {
            $sprintId = (int)$_GET['_target'][2];
        }
        if (isset($_GET['id'])) {
            $sprintId = (int)$_GET['id'];
        }
        if (empty($sprintId)) {
            $this->ajaxFailed('failed,params_error');
        }
        $sprintModel = new SprintModel();
        $sprint = $sprintModel->getItemById($sprintId);
        if (empty($sprint)) {
            $sprint = new \stdClass();
        }
        $data['sprint'] = $sprint;
        $issueLogic = new AgileLogic();
        list($fetchRet, $issues) = $issueLogic->getSprintIssues($sprintId);
        if ($fetchRet) {
            $data['issues'] = $issues;
            $this->ajaxSuccess('success', $data);
        } else {
            $this->ajaxFailed('server_error:' . $issues);
        }
    }

    /**
     *  fetch sprint's issues
     */
    public function fetchBoardBySprint()
    {
        $sprintId = null;
        if (isset($_GET['_target'][2])) {
            $sprintId = (int)$_GET['_target'][2];
        }
        if (isset($_GET['id'])) {
            $sprintId = (int)$_GET['id'];
        }
        if (empty($sprintId)) {
            $this->ajaxFailed('failed,params_error');
        }
        $sprintModel = new SprintModel();
        $sprint = $sprintModel->getItemById($sprintId);
        if (empty($sprint)) {
            $sprint = new \stdClass();
        }
        $data['sprint'] = $sprint;
        $issueLogic = new AgileLogic();
        list($fetchRet, $issues) = $issueLogic->getBoardBySprint($sprintId);
        if ($fetchRet) {
            $data['issues'] = $issues;
            $this->ajaxSuccess('success', $data);
        } else {
            $this->ajaxFailed('server_error:' . $issues);
        }
    }

    public function fetchBoardByLabel()
    {
        $projectId = null;
        if (isset($_GET['_target'][2])) {
            $projectId = (int)$_GET['_target'][2];
        }
        if (isset($_GET['project_id'])) {
            $projectId = (int)$_GET['project_id'];
        }
        if (empty($projectId)) {
            $this->ajaxFailed('failed,params_error');
        }
        $isfilterBacklog = true;
        if (isset($_GET['is_filter_backlog'])) {
            $isfilterBacklog = (bool)$_GET['is_filter_backlog'];
        }
        $isfilterClosed = true;
        if (isset($_GET['is_filter_closed'])) {
            $isfilterClosed = (bool)$_GET['is_filter_closed'];
        }

        $issueLogic = new AgileLogic();
        list($fetchRet, $issues) = $issueLogic->getLabelIssues($projectId, $isfilterBacklog, $isfilterClosed);
        if ($fetchRet) {
            $data['issues'] = $issues;
            $this->ajaxSuccess('success', $data);
        } else {
            $this->ajaxFailed('server_error:' . $issues);
        }
    }

    /**
     * move issue to sprint
     */
    public function issueMoveToSprint()
    {
        $issueId = null;
        if (isset($_GET['_target'][2])) {
            $issueId = (int)$_GET['_target'][2];
        }
        if (isset($_GET['issue_id'])) {
            $issueId = (int)$_GET['issue_id'];
        }
        $sprintId = null;
        if (isset($_GET['_target'][3])) {
            $sprintId = (int)$_GET['_target'][3];
        }
        if (isset($_GET['sprint_id'])) {
            $sprintId = (int)$_GET['sprint_id'];
        }
        if (empty($issueId) || empty($sprintId)) {
            $this->ajaxFailed('failed,params_error');
        }
        $issueModel = new IssueModel();
        $issue = $issueModel->getById($issueId);
        if (!isset($issue['id'])) {
            $this->ajaxFailed('param_error', 'Issue not exists');
        }

        $sprintModel = new SprintModel();
        $sprint = $sprintModel->getItemById($sprintId);
        if (!isset($sprint['id'])) {
            $this->ajaxFailed('param_error', 'Sprint not exists');
        }

        if ($issue['project_id'] != $sprint['project_id']) {
            $this->ajaxFailed('failed', 'No same project');
        }

        list($updateRet, $msg) = $issueModel->updateById($issueId, ['sprint' => $sprintId]);
        if ($updateRet) {
            $this->ajaxSuccess('success');
        } else {
            $this->ajaxFailed('server_error:' . $msg);
        }
    }

    /**
     * remove issue from sprint
     */
    public function removeIssueFromSprint()
    {
        $issueId = null;
        if (isset($_GET['_target'][3])) {
            $issueId = (int)$_GET['_target'][3];
        }
        if (isset($_GET['issue_id'])) {
            $issueId = (int)$_GET['issue_id'];
        }
        if (empty($issueId)) {
            $this->ajaxFailed('failed,params_error');
        }
        $issueModel = new IssueModel();
        list($updateRet, $msg) = $issueModel->updateById($issueId, ['sprint' => AgileLogic::BACKLOG_VALUE]);
        if ($updateRet) {
            $this->ajaxSuccess('success');
        } else {
            $this->ajaxFailed('server_error:' . $msg);
        }
    }
}
