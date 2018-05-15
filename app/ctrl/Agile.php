<?php

namespace main\app\ctrl;

use main\app\classes\AgileLogic;
use main\app\classes\UserLogic;
use main\app\classes\RewriteUrl;
use main\app\model\agile\SprintModel;
use main\app\model\agile\AgileBoardCustomModel;
use main\app\model\agile\AgileBoardCustomColumn;
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
    public function fetchBacklogIssues()
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
        list($fetchRet, $issues) = $issueLogic->getBacklogIssues($projectId);
        if ($fetchRet) {
            $data['backlogs'] = $issues;
        } else {
            $this->ajaxFailed('server_error:' . $issues);
        }
        $data['sprints'] = $issueLogic->getSprints($projectId);

        $model = new IssuePriorityModel();
        $data['priority'] = $model->getAll();

        $issueTypeModel = new IssueTypeModel();
        $data['issue_types'] = $issueTypeModel->getAll();

        $model = new IssueStatusModel();
        $data['issue_status'] = $model->getAll();

        $model = new IssueResolveModel();
        $data['issue_resolve'] = $model->getAll();

        $userLogic = new UserLogic();
        $data['users'] = $userLogic->getAllNormalUser();
        unset($userLogic);

        $projectModel = new ProjectModel();
        $data['projects'] = $projectModel->getAll();

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
        list($fetchRet, $issues) = $issueLogic->getBoardColumnBySprint($sprintId);
        if ($fetchRet) {
            $data['issues'] = $issues;
            $this->ajaxSuccess('success', $data);
        } else {
            $this->ajaxFailed('server_error:' . $issues);
        }
    }

    public function fetchBoardById()
    {
        $id = null;
        if (isset($_GET['_target'][2])) {
            $id = (int)$_GET['_target'][2];
        }
        if (isset($_GET['id'])) {
            $id = (int)$_GET['id'];
        }
        $model = new AgileBoardCustomModel();
        $board = $model->getById($id);
        if (empty($board)) {
            $this->ajaxFailed('board_no_found');
        }
        $projectId = null;
        if (isset($board['project_id'])) {
            $projectId = (int)$board['project_id'];
        }
        if (empty($projectId)) {
            $this->ajaxFailed('params_error,project_id no found');
        }
        $isfilterBacklog = true;
        if (isset($board['is_filter_backlog'])) {
            $isfilterBacklog = (bool)$board['is_filter_backlog'];
        }
        $isfilterClosed = true;
        if (isset($board['is_filter_closed'])) {
            $isfilterClosed = (bool)$board['is_filter_closed'];
        }

        $model = new AgileBoardCustomColumn();
        $columns = $model->getsByBoard($id);

        $issueLogic = new AgileLogic();

        switch ($board['type']) {
            case 'label':
                list($fetchRet, $issues) = $issueLogic->getBoardColumnByLabel($projectId, $columns);
                break;
            default:
                list($fetchRet, $issues) = $issueLogic->getLabelIssues($projectId, $columns);
                break;
        }

        list($fetchRet, $issues) = $issueLogic->getLabelIssues($projectId, $columns);

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
