<?php
/**
 * Created by PhpStorm.
 */

namespace main\app\ctrl\issue;

use main\app\classes\IssueFilterLogic;
use main\app\classes\IssueFavFilterLogic;
use main\app\classes\IssueTypeLogic;
use main\app\classes\RewriteUrl;
use \main\app\classes\UploadLogic;
use main\app\classes\ProjectLogic;
use main\app\classes\UserLogic;
use main\app\ctrl\BaseUserCtrl;
use main\app\model\issue\IssueFileAttachmentModel;
use main\app\model\issue\IssueFilterModel;
use main\app\model\issue\ProjectLabelModel;
use main\app\model\issue\IssueResolveModel;
use main\app\model\issue\IssuePriorityModel;
use main\app\model\project\ProjectModel;
use main\app\model\project\ProjectVersionModel;
use main\app\model\project\ProjectModuleModel;
use main\app\model\issue\IssueModel;
use main\app\model\issue\IssueLabelDataModel;
use main\app\model\issue\IssueFixVersionModel;
use main\app\model\issue\IssueTypeModel;
use main\app\model\issue\IssueStatusModel;
use main\app\model\issue\IssueUiModel;
use main\app\model\issue\IssueUiTabModel;
use main\app\model\field\FieldTypeModel;
use main\app\model\field\FieldModel;
use main\app\model\user\UserModel;

/**
 * 问题
 */
class Main extends BaseUserCtrl
{

    public function index()
    {
        $data = [];
        $data['title'] = '问题';
        $data['nav_links_active'] = 'issues';
        $data['sub_nav_active'] = 'all';
        $data['query_str'] = http_build_query($_GET);
        $data['sys_filter'] = isset($_GET['sys_filter']) ? $_GET['sys_filter'] : '';
        $data['active_id'] = isset($_GET['active_id']) ? $_GET['active_id'] : '';
        $data = RewriteUrl::setProjectData($data);

        $fanFilter = null;
        if (isset($_GET['fav_filter'])) {
            $favFilterId = (int)$_GET['fav_filter'];
            $favFilterModel = new IssueFilterModel();
            $fav = $favFilterModel->getItemById($favFilterId);
            if (isset($fav['filter']) && !empty($fav['filter'])) {
                $fav['filter'] = str_replace([':', ' '], ['=', '&'], $fav['filter']);
                $filter = $fav['filter'] . '&active_id=' . $favFilterId;
                header('location:/issue/main?' . $filter);
                die;
            }
        }
        // 用户的过滤器
        $IssueFavFilterLogic = new IssueFavFilterLogic();
        list($data['firstFilters'], $data['hideFilters']) = $IssueFavFilterLogic->getCurUserFavFilter();

        $this->render('gitlab/issue/issue_gitlab.php', $data);
    }

    public function gitlab()
    {
        $data = [];
        $data['title'] = '问题';
        $data['nav_links_active'] = 'issues';
        $data['sub_nav_active'] = 'all';
        $this->render('gitlab/issue/issue_gitlab.php', $data);
    }

    public function patch()
    {
        header('Content-Type:application/json');
        $issueId = null;
        if (isset($_GET['_target'][3])) {
            $issueId = (int)$_GET['_target'][3];
        }
        if (isset($_GET['id'])) {
            $issueId = (int)$_GET['id'];
        }
        $assigneeId = null;

        $_PUT = array();

        $contents = file_get_contents('php://input');
        parse_str($contents, $_PUT);
        if (isset($_PUT['issue']['assignee_id'])) {
            $assigneeId = (int)$_PUT['issue']['assignee_id'];
            if (empty($issueId) || empty($assigneeId)) {
                $ret = new \stdClass();
                echo json_encode($ret);
                die;
            }

            $issueModel = new IssueModel();
            $issue = $issueModel->getById($issueId);

            $userModel = new UserModel();
            $assignee = $userModel->getByUid($assigneeId);
            UserLogic::format_avatar_user($assignee);
            $updateInfo = [];
            $updateInfo['assignee'] = $assigneeId;
            list($ret, $msg) = $issueModel->updateById($issueId, $updateInfo);
            if ($ret) {
                $resp = [];
                $userInfo = [];
                $userInfo['avatar_url'] = $assignee['avatar'];
                $userInfo['name'] = $assignee['display_name'];
                $userInfo['username'] = $assignee['username'];
                $resp['assignee'] = $userInfo;
                $resp['assignee_id'] = $assigneeId;
                $resp['author_id'] = $issue['creator'];
                $resp['title'] = $issue['summary'];
                echo json_encode($resp);
                die;
            }
        }
        $ret = new \stdClass();
        echo json_encode($ret);
        die;
    }

    public function detailStatic()
    {
        $this->render('gitlab/issue/view.html', $data = []);
    }

    /**
     * 上传接口
     */
    public function upload()
    {
        $uuid = '';
        if (isset($_REQUEST['qquuid'])) {
            $uuid = $_REQUEST['qquuid'];
        }

        $originName = '';
        if (isset($_REQUEST['qqfilename'])) {
            $originName = $_REQUEST['qqfilename'];
        }

        $fileSize = 0;
        if (isset($_REQUEST['qqtotalfilesize'])) {
            $fileSize = (int)$_REQUEST['qqtotalfilesize'];
        }


        $uploadLogic = new UploadLogic();
        $ret = $uploadLogic->move('qqfile', 'all', $uuid, $originName, $fileSize);
        header('Content-type: application/json; charset=UTF-8');

        $resp = [];
        if ($ret['error'] == 0) {
            $resp['success'] = true;
            $resp['error'] = '';
            $resp['url'] = $ret['url'];
            $resp['filename'] = $ret['filename'];
        } else {
            $resp['success'] = false;
            $resp['error'] = $resp['message'];
            $resp['error_code'] = $resp['error'];
            $resp['url'] = $ret['url'];
            $resp['filename'] = $ret['filename'];
        }
        echo json_encode($resp);
        exit;
    }

    /**
     * 删除文件api
     */
    public function uploadDelete()
    {
        // @todo 只有上传者和管理员才有权限删除
        $uuid = '';
        if (isset($_GET['_target'][3])) {
            $uuid = $_GET['_target'][3];
        }
        if (isset($_GET['uuid'])) {
            $uuid = $_GET['uuid'];
        }
        if ($uuid != '') {
            $model = new IssueFileAttachmentModel();
            $file = $model->getByUuid($uuid);
            if (!isset($file['uuid'])) {
                $this->ajaxFailed('uuid_not_found', []);
            }
            $ret = $model->deleteByUuid($uuid);
            if ($ret > 0) {
                unlink(PUBLIC_PATH . '' . $file['file_name']);
                $this->ajaxSuccess('success', $ret);
            }
        } else {
            $this->ajaxFailed('param_error', []);
        }
    }

    /**
     * issue 搜索查询
     */
    public function filter()
    {
        $issueFilterLogic = new IssueFilterLogic();

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

        $pageSize = 20;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $page = max(1, $page);
        if (isset($_GET['page'])) {
            $page = max(1, intval($_GET['page']));
        }
        list($ret, $data['issues'], $total) = $issueFilterLogic->getIssuesByFilter($page, $pageSize);
        if ($ret) {
            foreach ($data['issues'] as &$issue) {
                //$issue['created_text'] = format_unix_time($issue['created']);
                //$issue['updated_text'] = format_unix_time($issue['created']);
                IssueFilterLogic::formatIssue($issue);
            }
            $data['total'] = $total;
            $data['pages'] = ceil($total / $pageSize);
            $data['page_size'] = $pageSize;
            $data['page'] = $page;
            $this->ajaxSuccess('success', $data);
        } else {
            $this->ajaxFailed('failed', $data['issues']);
        }
    }

    public function getFavFilter()
    {
        $IssueFavFilterLogic = new IssueFavFilterLogic();
        $arr['filters'] = $IssueFavFilterLogic->getCurUserFavFilter();
        $this->ajaxSuccess('success', $arr);
    }


    public function saveFilter($name = '', $filter = '', $description = '', $shared = '')
    {
        $IssueFavFilterLogic = new IssueFavFilterLogic();
        if (empty($name)) {
            $this->ajaxFailed('param_error:name_is_null');
        }
        if (empty($filter)) {
            $this->ajaxFailed('param_error:filter_is_null');
        }
        list($ret, $msg) = $IssueFavFilterLogic->saveFilter($name, $filter, $description, $shared);
        if ($ret) {
            $this->ajaxSuccess('success', $msg);
        } else {
            $this->ajaxFailed('failed', [], $msg);
        }
    }

    public function fetchIssueType()
    {
        $projectId = isset($_GET['project_id']) ? (int)$_GET['project_id'] : null;
        $logic = new IssueTypeLogic();
        $data['issue_types'] = $logic->getIssueType($projectId);
        $this->ajaxSuccess('success', $data);
    }

    public function fetchUiConfig($issueTypeId, $type = 'create')
    {
        $issueTypeId = isset($_GET['issue_type_id']) ? (int)$_GET['issue_type_id'] : null;
        $type = isset($_GET['type']) ? safeStr($_GET['type']) : 'create';
        $projectId = isset($_GET['project_id']) ? (int)$_GET['project_id'] : 0;

        $model = new IssueUiModel();
        $data['configs'] = $model->getsByUiType($projectId, $issueTypeId, $type);

        $model = new FieldModel();
        $fields = $model->getAll(false);
        if ($fields) {
            foreach ($fields as &$v) {
                $v['options'] = json_decode($v['options']);
            }
        }
        $data['fields'] = $fields;
        $model = new FieldTypeModel();
        $data['field_types'] = $model->getAll(false);

        // 如果提交项目id则返回该项目相关的 issue_type
        $data['issue_types'] = [];
        if (!empty($projectId) && $projectId != '') {
            $logic = new IssueTypeLogic();
            $data['issue_types'] = $logic->getIssueType($projectId);
        }

        $issueUiTabModel = new IssueUiTabModel();
        $data['tabs'] = $issueUiTabModel->getItemsByIssueTypeIdType($projectId, $issueTypeId, $type);

        $this->ajaxSuccess('success', $data);
    }

    public function fetchIssueEdit($issue_id = '')
    {
        $uiType = 'edit';
        $issueId = isset($_GET['issue_id']) ? (int)$_GET['issue_id'] : null;
        $issueModel = new IssueModel();
        $issue = $issueModel->getById($issueId);

        if (empty($issue)) {
            $this->ajaxFailed('failed', [], 'issue_id is error');
        }
        $issueTypeId = (int)$issue['issue_type_id'];
        $projectId = (int)$issue['project_id'];

        $model = new IssueUiModel();
        $data['configs'] = $model->getsByUiType($projectId, $issueTypeId, $uiType);

        $model = new FieldModel();
        $fields = $model->getAll(false);

        if ($fields) {
            foreach ($fields as $field) {
                $v['options'] = json_decode($field['options']);
            }
        }

        $data['fields'] = $fields;

        $model = new FieldTypeModel();
        $data['field_types'] = $model->getAll(false);

        $model = new ProjectModuleModel();
        $data['project_module'] = $model->getByProject($projectId);

        $model = new ProjectVersionModel();
        $data['project_version'] = $model->getByProject($projectId);

        $model = new ProjectLabelModel();
        $data['issue_labels'] = $model->getAll(false);

        $model = new IssueResolveModel();
        $data['issue_resolve'] = $model->getAll();

        $model = new IssuePriorityModel();
        $data['priority'] = $model->getAll(false);

        // 当前问题应用的标签id
        $model = new IssueLabelDataModel();
        $issueLabelData = $model->getItemsByIssueId($issueId);
        $issueLabelDataIds = [];
        foreach ($issueLabelData as $label) {
            $labelId = $label['label_id'];
            $issueLabelDataIds[] = $labelId;
        }
        $issue['labels'] = $issueLabelDataIds;

        // 当前问题应用的标签id
        $model = new IssueFixVersionModel();
        $issueFixVersion = $model->getItemsByIssueId($issueId);
        $issueFixVersionIds = [];
        foreach ($issueFixVersion as $version) {
            $issueFixVersionIds[] = $version['version_id'];
        }
        $issue['fix_version'] = $issueFixVersionIds;

        // 如果提交项目id则返回该项目相关的 issue_type
        $data['issue_types'] = [];
        if (!empty($projectId) && $projectId != '') {
            $logic = new IssueTypeLogic();
            $data['issue_types'] = $logic->getIssueType($projectId);
        }

        $model = new IssueFileAttachmentModel();
        $attachmentDatas = $model->getsByIssueId($issueId);
        $issue['attachment'] = [];
        foreach ($attachmentDatas as $f) {
            $file = [];
            $file['thumbnailUrl'] = ROOT_URL . $f['file_name'];
            $file['size'] = $f['file_size'];
            $file['name'] = $f['origin_name'];
            $file['uuid'] = $f['uuid'];
            $issue['attachment'][] = $file;
        }
        unset($attachmentDatas);

        $model = new IssueUiTabModel($issueId);
        $data['tabs'] = $model->getItemsByIssueTypeIdType($issueTypeId, $uiType);

        $data['issue'] = $issue;
        $this->ajaxSuccess('success', $data);
    }


    public function activity()
    {
        $data = [];
        $data['title'] = 'Activity';
        $data['nav_links_active'] = 'home';
        $data['scrolling_tabs'] = 'activity';

        $this->render('gitlab/project/activity.php', $data);
    }

    public function cycleAnalytics()
    {
        $data = [];
        $data['title'] = 'Activity';
        $data['nav_links_active'] = 'home';
        $data['scrolling_tabs'] = 'cycle_analytics';

        $this->render('gitlab/project/cycle_analytics.php', $data);
    }

    /**
     * 添加 issue
     */
    public function add($params = [])
    {
        // @todo 判断权限:全局权限和项目角色

        $uid = $this->getCurrentUid();

        if (!isset($params['summary']) || empty(trimStr($params['summary']))) {
            $this->ajaxFailed('param_error:summary_is_null');
        }
        if (!isset($params['issue_type_id']) || empty(trimStr($params['issue_type_id']))) {
            $this->ajaxFailed('param_error:issue_type_id_is_null');
        }
        $info = [];
        $info['summary'] = $params['summary'];
        $info['creator'] = $uid;

        // 所属项目
        $projectId = (int)$params['project_id'];
        $model = new ProjectModel();
        $project = $model->getById($projectId);
        if (!isset($project['id'])) {
            $this->ajaxFailed('param_error:project_not_found');
        }
        unset($project);
        $info['project_id'] = $projectId;

        // issue 类型
        $issueTypeId = (int)$params['issue_type_id'];
        $model = new IssueTypeModel();
        $issueTypes = $model->getAll();
        if (!isset($issueTypes[$issueTypeId])) {
            $this->ajaxFailed('param_error:issue_type_id_not_found');
        }
        unset($issueTypes);
        $info['issue_type_id'] = $issueTypeId;

        $info = $info + $this->getFormInfo($params);

        $model = new IssueModel();
        list($ret, $issueId) = $model->insert($info);
        if (!$ret) {
            $this->ajaxFailed('add_failed,error:' . $issueId);
        }

        $this->updateIssueChildData($issueId);

        $this->ajaxSuccess('add_success');
    }


    public function getFormInfo($params = [])
    {
        $info = [];
        $info['summary'] = $params['summary'];

        // 优先级
        if (isset($params['priority'])) {
            $priorityId = (int)$params['priority'];
            $model = new IssuePriorityModel();
            $issuePriority = $model->getAll();
            if (!isset($issuePriority[$priorityId])) {
                $this->ajaxFailed('param_error:priority_not_found');
            }
            unset($issuePriority);
            $info['priority'] = $priorityId;
        }

        // 解决结果
        if (isset($params['resolve']) && !empty($params['resolve'])) {
            $resolveId = (int)$params['resolve'];
            $model = new IssueResolveModel();
            $issueResolves = $model->getAll();
            if (!isset($issueResolves[$resolveId])) {
                $this->ajaxFailed('param_error:resolve_not_found');
            }
            unset($issueResolves);
            $info['resolve'] = $resolveId;
        }

        // 负责人
        if (isset($params['assignee']) && !empty($params['assignee'])) {
            $assigneeUid = (int)$params['assignee'];
            $model = new UserModel();
            $user = $model->getByUid($assigneeUid);
            if (!isset($user['uid'])) {
                $this->ajaxFailed('param_error:assignee_not_found');
            }
            unset($user);
            $info['assignee'] = $assigneeUid;
        }

        // 报告人
        if (isset($params['reporter']) && !empty($params['reporter'])) {
            $reporterUid = (int)$params['reporter'];
            $model = new UserModel();
            $user = $model->getByUid($reporterUid);
            if (!isset($user['uid'])) {
                $this->ajaxFailed('param_error:reporter_not_found');
            }
            unset($user);
            $info['reporter'] = $assigneeUid;
        }

        if (isset($params['description'])) {
            $info['description'] = $params['description'];
        }

        if (isset($params['module'])) {
            $info['module'] = $params['module'];
        }

        if (isset($params['environment'])) {
            $info['environment'] = $params['environment'];
        }

        if (isset($params['start_date'])) {
            $info['start_date'] = $params['start_date'];
        }

        if (isset($params['due_date'])) {
            $info['due_date'] = $params['due_date'];
        }

        if (isset($params['milestone'])) {
            $info['milestone'] = (int)$params['milestone'];
        }
        return $info;
    }

    public function updateIssueChildData($issueId, $params)
    {
        if (isset($params['attachment'])) {
            $attachments = json_decode($params['attachment'], true);
            $model = new IssueFileAttachmentModel();
            foreach ($attachments as $file) {
                $uuid = $file['uuid'];
                $model->update(['uuid' => $uuid], ['issue_id' => $issueId]);
            }
        }

        if (isset($params['fix_version'])) {
            $fixVersions = $params['fix_version'];
            $model = new IssueFixVersionModel();
            foreach ($fixVersions as $versionId) {
                $versionInfo = [];
                $versionInfo['version_id'] = $versionId;
                $versionInfo['issue_id'] = $issueId;
                $model->insert($versionInfo);
            }
        }

        if (isset($params['labels'])) {
            $labels = $params['labels'];
            $model = new IssueLabelDataModel();
            foreach ($labels as $labelId) {
                $labelInfo = [];
                $labelInfo['label_id'] = $labelId;
                $labelInfo['issue_id'] = $issueId;
                $model->insert($labelInfo);
            }
        }
    }

    public function update($params)
    {
        // @todo 判断权限:全局权限和项目角色
        $issueId = null;
        if (!isset($_REQUEST['issue_id'])) {
            $this->ajaxFailed('param_error:issue_id_is_null');
        }
        $issueId = (int)$_REQUEST['issue_id'];

        $issueModel = new IssueModel();
        $issue = $issueModel->getById($issueId);

        $uid = $this->getCurrentUid();

        $info = [];
        if (isset($params['summary'])) {
            $info['summary'] = $params['summary'];
        }

        $info = $info + $this->getFormInfo($params);

        $noModified = true;
        foreach ($info as $k => $v) {
            if ($v != $issue[$k]) {
                $noModified = false;
            }
        }
        if ($noModified) {
            $this->ajaxSuccess('success');
        }

        if (!empty($info)) {
            $info['modifier'] = $uid;
        }

        list($ret, $affectedRows) = $issueModel->updateById($issueId, $info);
        if (!$ret) {
            $this->ajaxFailed('update_failed,error:' . $issueId);
        }

        $this->updateIssueChildData($issueId, $params);

        $this->ajaxSuccess('success');
    }


    public function delete($project_id)
    {
    }
}
