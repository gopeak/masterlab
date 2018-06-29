<?php

namespace main\app\ctrl;

use main\app\classes\AgileLogic;
use main\app\classes\UserLogic;
use main\app\classes\RewriteUrl;
use main\app\model\agile\SprintModel;
use main\app\model\agile\AgileBoardModel;
use main\app\model\agile\AgileBoardColumnModel;
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
     * index
     */
    public function sprint()
    {
        $data = [];
        $data['title'] = 'Backlog';
        $data['nav_links_active'] = 'sprints';
        $data['sub_nav_active'] = 'all';
        $data['query_str'] = http_build_query($_GET);
        $data = RewriteUrl::setProjectData($data);

        $this->render('gitlab/agile/backlog.php', $data);
    }


    public function board()
    {
        $data = [];
        $data['title'] = 'Backlog';
        $data['nav_links_active'] = 'kanban';
        $data['sub_nav_active'] = 'all';
        $data['query_str'] = http_build_query($_GET);
        $data = RewriteUrl::setProjectData($data);

        $this->render('gitlab/agile/board.php', $data);
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
     *  fetch project's sprints
     */
    public function fetchSprints()
    {
        $projectId = null;
        $issueId = null;
        if (isset($_GET['issue_id'])) {
            $issueId = (int)$_GET['issue_id'];
        }
        if (isset($_GET['project_id'])) {
            $projectId = (int)$_GET['project_id'];
        }
        if ($issueId) {
            $issueModel = new IssueModel();
            $projectId = $issueModel->getById($issueId)['project_id'];
        }
        if (empty($projectId)) {
            $this->ajaxFailed('param_error');
        }
        $sprintModel = new SprintModel();
        $data['sprints'] = $sprintModel->getItemsByProject($projectId);

        $this->ajaxSuccess('success', $data);

    }

    public function joinSprint()
    {
        $sprintId = null;
        $issueId = null;
        if (isset($_POST['issue_id'])) {
            $issueId = (int)$_POST['issue_id'];
        }
        if (isset($_POST['sprint_id'])) {
            $sprintId = (int)$_POST['sprint_id'];
        }

        if (empty($sprintId) || empty($issueId)) {
            $this->ajaxFailed('param_error');
        }
        $model = new IssueModel();
        list($ret, $msg) = $model->updateById($issueId, ['sprint' => $sprintId]);
        if ($ret) {
            $this->ajaxSuccess('success');
        } else {
            $this->ajaxFailed('server_error:' . $msg);
        }
    }

    public function joinBacklog()
    {
        $issueId = null;
        if (isset($_POST['issue_id'])) {
            $issueId = (int)$_POST['issue_id'];
        }

        if (empty($issueId)) {
            $this->ajaxFailed('param_error');
        }
        $model = new IssueModel();
        list($ret, $msg) = $model->updateById($issueId, ['sprint' => AgileLogic::BACKLOG_VALUE]);
        if ($ret) {
            $this->ajaxSuccess('success');
        } else {
            $this->ajaxFailed('server_error:' . $msg);
        }
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
        $agileLogic = new AgileLogic();


        $boardId = '1';
        $agileBoardModel = new AgileBoardModel();
        $board = $agileBoardModel->getById($boardId);
        if (empty($board)) {
            $this->ajaxFailed('board_no_found');
        }
        $data['board'] = $board;

        $agileBoardColumn = new AgileBoardColumnModel();
        $columns = $agileBoardColumn->getsByBoard($boardId);
        if (empty($columns)) {
            $this->ajaxFailed('board_no_column', []);
        }
        foreach ($columns as &$column) {
            $column['issues'] = [];
        }

        list($fetchRet, $msg) = $agileLogic->getBoardColumnBySprint($sprintId, $columns);

        if ($fetchRet) {
            $data['columns'] = $columns;
            $this->ajaxSuccess('success', $columns);
        } else {
            $this->ajaxFailed('server_error:' . $msg);
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
        $model = new AgileBoardModel();
        $board = $model->getById($id);
        if (empty($board)) {
            $this->ajaxFailed('board_no_found');
        }
        $data['board'] = $board;
        $projectId = null;
        if (isset($board['project_id'])) {
            $projectId = (int)$board['project_id'];
        }
        if (empty($projectId)) {
            $this->ajaxFailed('params_error,project_id no found');
        }

        $model = new AgileBoardColumnModel();
        $columns = $model->getsByBoard($id);
        if (empty($columns)) {
            $this->ajaxFailed('board_no_column', []);
        }
        foreach ($columns as &$column) {
            $column['issues'] = [];
        }
        $agileLogic = new AgileLogic();

        if ($board['type'] == 'label') {
            list($fetchRet, $msg) = $agileLogic->getBoardColumnByLabel($projectId, $columns);
        } else {
            list($fetchRet, $msg) = $agileLogic->getBoardColumnCommon($projectId, $columns, $board['type']);
        }

        if ($fetchRet) {
            $data['columns'] = $columns;
            $this->ajaxSuccess('success', $columns);
        } else {
            $this->ajaxFailed('server_error:' . $msg);
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
