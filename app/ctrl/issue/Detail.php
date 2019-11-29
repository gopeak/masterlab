<?php
/**
 * Created by PhpStorm.
 */

namespace main\app\ctrl\issue;

use main\app\classes\NotifyLogic;
use main\app\classes\RewriteUrl;
use \main\app\classes\UploadLogic;
use main\app\classes\UserAuth;
use main\app\classes\UserLogic;
use main\app\classes\WorkflowLogic;
use main\app\classes\IssueFilterLogic;
use main\app\classes\IssueLogic;
use main\app\classes\ConfigLogic;
use main\app\classes\PermissionLogic;
use main\app\ctrl\BaseUserCtrl;
use main\app\model\ActivityModel;
use main\app\model\issue\IssueFileAttachmentModel;
use main\app\model\issue\IssueResolveModel;
use main\app\model\issue\IssuePriorityModel;
use main\app\model\issue\IssueFollowModel;
use main\app\model\project\ProjectModel;
use main\app\model\project\ProjectVersionModel;
use main\app\model\project\ProjectModuleModel;
use main\app\model\project\ProjectLabelModel;
use main\app\model\issue\IssueModel;
use main\app\model\issue\IssueLabelDataModel;
use main\app\model\issue\IssueFixVersionModel;
use main\app\model\issue\IssueEffectVersionModel;
use main\app\model\issue\IssueTypeModel;
use main\app\model\issue\IssueStatusModel;
use main\app\model\TimelineModel;
use main\app\model\user\UserModel;
use main\app\model\agile\SprintModel;

/**
 * 事项
 */
class Detail extends BaseUserCtrl
{
    /**
     * Detail constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct();
        parent::addGVar('top_menu_active', 'issue');
    }

    /**
     * @throws \Exception
     */
    public function pageIndex()
    {
        $data = [];
        $data['title'] = '事项详情';
        $data['nav_links_active'] = 'issues';
        $data['sub_nav_active'] = 'all';
        $data['query_str'] = http_build_query($_GET);
        $data['sys_filter'] = isset($_GET['sys_filter']) ? $_GET['sys_filter'] : '';
        $data['active_id'] = isset($_GET['active_id']) ? $_GET['active_id'] : '';

        $issueId = '';
        if (isset($_GET['_target'][3])) {
            $issueId = $_GET['_target'][3];
        }
        if (isset($_GET['id'])) {
            $issueId = $_GET['id'];
        }
        $data['issue_id'] = $issueId;

        if (empty($issueId)) {
            $this->error('failed', 'Issue id is empty');
            die;
        }

        $issueModel = new IssueModel();
        $issue = $issueModel->getById($issueId);
        if (empty($issue)) {
            $this->error('failed', 'Issue data is empty');
            die;
        }
        $this->projectPermArr = PermissionLogic::getUserHaveProjectPermissions(UserAuth::getId(), $issue['project_id'], $this->isAdmin);
        $data['projectPermArr'] = $this->projectPermArr;

        $_GET['project_id'] = $data['project_id'] = $projectId = (int)$issue['project_id'];
        $model = new ProjectModel();
        $data['project'] = $model->getById($projectId);
        $data['project_name'] = $data['project']['name'];

        $issue['created_text'] = format_unix_time($issue['created']);
        $issue['updated_text'] = format_unix_time($issue['updated']);

        $userModel = new UserModel();
        $issue['assignee_info'] = $userModel->getByUid($issue['assignee']);
        UserLogic::formatAvatarUser($issue['assignee_info']);
        $issue['reporter_info'] = $userModel->getByUid($issue['reporter']);
        UserLogic::formatAvatarUser($issue['reporter_info']);
        $issue['modifier_info'] = $userModel->getByUid($issue['modifier']);
        UserLogic::formatAvatarUser($issue['modifier_info']);
        $issue['creator_info'] = $userModel->getByUid($issue['creator']);
        UserLogic::formatAvatarUser($issue['creator_info']);

        $data['issue'] = $issue;
        $data = RewriteUrl::setProjectData($data);

        $issueLogic = new IssueLogic();
        $data['description_templates'] = $issueLogic->getDescriptionTemplates();

        ConfigLogic::getAllConfigs($data);

        $data['project_root_url'] = ROOT_URL . $data['project']['org_path'] . '/' . $data['project']['key'];

        $data['sprints'] = [];
        $data['active_sprint'] = [];
        if (!empty($data['project_id'])) {
            $sprintModel = new SprintModel();
            $data['sprints'] = $sprintModel->getItemsByProject($data['project_id']);
            $data['active_sprint'] = $sprintModel->getActive($data['project_id']);
        }

        $this->render('gitlab/issue/detail.php', $data);
    }

    /**
     * 处理 editormd 文件上传
     * @throws \Exception
     */
    public function editormdUpload()
    {
        $uuid = '';
        if (isset($_REQUEST['guid'])) {
            $uuid = $_REQUEST['guid'];
        }

        $originName = '';
        if (isset($_FILES['editormd-image-file']['name'])) {
            $originName = $_FILES['editormd-image-file']['name'];
        }

        $fileSize = 0;
        if (isset($_FILES['editormd-image-file']['size'])) {
            $fileSize = (int)$_FILES['editormd-image-file']['size'];
        }

        $uploadLogic = new UploadLogic();
        $ret = $uploadLogic->move('editormd-image-file', 'image', $uuid, $originName, $fileSize);
        header('Content-type: application/json; charset=UTF-8');

        $resp = [];
        if ($ret['error'] == 0) {
            $resp['success'] = 1;
            $resp['message'] = '';
            $resp['url'] = $ret['url'];
            $resp['filename'] = $ret['filename'];
            $resp['origin_name'] = $ret['filename'];
            $resp['insert_id'] = $ret['insert_id'];
            $resp['uuid'] = $ret['uuid'];
        } else {
            $resp['success'] = 0;
            $resp['message'] = $ret['message'];
            $resp['error_code'] = $resp['error'];
            $resp['url'] = $ret['url'];
            $resp['filename'] = $ret['filename'];
            $resp['origin_name'] = $ret['filename'];
            $resp['insert_id'] = $ret['insert_id'];
            $resp['uuid'] = $ret['uuid'];
        }
        echo json_encode($resp);
        exit;
    }

    /**
     * 获取事项信息
     * @throws \Exception
     */
    public function get()
    {
        $issueId = '';
        if (isset($_GET['_target'][3])) {
            $issueId = $_GET['_target'][3];
        }
        if (isset($_GET['id'])) {
            $issueId = $_GET['id'];
        }
        if (empty($issueId)) {
            $this->ajaxFailed('参数错误', '事项id不能为空');
        }
        $data['issue_id'] = $issueId;

        $issueModel = new IssueModel();
        $issue = $issueModel->getById($issueId);

        if (empty($issue)) {
            $this->ajaxFailed('failed', [], 'issue_id is error');
        }
        $issueTypeId = (int)$issue['issue_type'];
        $projectId = (int)$issue['project_id'];
        $model = new ProjectModel();
        $data['project'] = $model->getById($projectId);

        $model = new ProjectModuleModel();
        $module = $model->getById($issue['module']);
        $issue['module_name'] = isset($module['name']) ? $module['name'] : '';
        unset($module);

        $model = new SprintModel();
        $sprint = $model->getById($issue['sprint']);
        $issue['sprint_info'] = isset($sprint['name']) ? $sprint : new \stdClass();
        unset($sprint);

        $model = new ProjectVersionModel();
        $projectVersions = $model->getByProjectPrimaryKey($projectId);

        // 修复版本
        $model = new IssueFixVersionModel();
        $issueFixVersion = $model->getItemsByIssueId($issueId);
        $issue['fix_version_names'] = [];
        foreach ($issueFixVersion as $version) {
            $versionId = $version['version_id'];
            $issue['fix_version_names'][] = isset($projectVersions[$versionId]) ? $projectVersions[$versionId] : null;
        }
        unset($issueFixVersion);

        // 影响版本
        $model = new IssueEffectVersionModel();
        $issueEffectVersion = $model->getItemsByIssueId($issueId);
        $issue['effect_version_names'] = [];
        //print_r($projectVersions);
        foreach ($issueEffectVersion as $version) {
            $versionId = $version['version_id'];
            $issue['effect_version_names'][] = isset($projectVersions[$versionId]) ? $projectVersions[$versionId] : null;
        }
        unset($issueEffectVersion, $projectVersions);

        // issue 类型
        $issueTypeModel = new IssueTypeModel();
        $issueTypes = $issueTypeModel->getAll(true);
        $issue['issue_type_info'] = new \stdClass();
        if (isset($issueTypes[$issueTypeId])) {
            $issue['issue_type_info'] = $issueTypes[$issueTypeId];
        }
        unset($issueTypes);

        $model = new IssueResolveModel();
        $issueResolve = $model->getAll();
        $resolveId = $issue['resolve'];
        $issue['resolve_info'] = new \stdClass();
        if (isset($issueResolve[$resolveId])) {
            $issue['resolve_info'] = $issueResolve[$resolveId];
        }

        $model = new IssueStatusModel();
        $issueStatus = $model->getAll();
        $statusId = $issue['status'];
        $issue['status_info'] = new \stdClass();
        if (isset($issueStatus[$statusId])) {
            $issue['status_info'] = $issueStatus[$statusId];
        }

        $model = new IssuePriorityModel();
        $priority = $model->getAll();
        $priorityId = $issue['priority'];
        $issue['priority_info'] = new \stdClass();
        if (isset($priority[$priorityId])) {
            $issue['priority_info'] = $priority[$priorityId];
        }

        // 当前事项应用的标签id
        $model = new ProjectLabelModel();
        $issueLabels = $model->getAll();
        $model = new IssueLabelDataModel();
        $issueLabelData = $model->getItemsByIssueId($issueId);
        $issue['labels_names'] = [];
        foreach ($issueLabelData as $label) {
            $labelId = $label['label_id'];
            $issue['labels_names'][] = isset($issueLabels[$labelId]) ? $issueLabels[$labelId] : null;
        }
        $issue['labels'] = $issueLabelData;
        unset($issueLabels);

        $model = new IssueFileAttachmentModel();
        $attachmentDatas = $model->getsByIssueId($issueId);
        $issue['attachment'] = [];
        foreach ($attachmentDatas as $f) {
            $file = [];
            $file['thumbnailUrl'] = ATTACHMENT_URL . $f['file_name'];
            $file['size'] = $f['file_size'];
            $file['name'] = $f['origin_name'];
            $file['uuid'] = $f['uuid'];
            $issue['attachment'][] = $file;
        }
        unset($attachmentDatas);

        IssueFilterLogic::formatIssue($issue);

        $userModel = new UserModel();
        $issue['assignee_info'] = $userModel->getByUid($issue['assignee']);
        UserLogic::formatAvatarUser($issue['assignee_info']);
        if (empty($issue['assignee_info'])) {
            $issue['assignee_info'] = new \stdClass();
        }

        $issue['reporter_info'] = $userModel->getByUid($issue['reporter']);
        UserLogic::formatAvatarUser($issue['reporter_info']);
        if (empty($issue['reporter_info'])) {
            $issue['reporter_info'] = new \stdClass();
        }

        $issue['modifier_info'] = $userModel->getByUid($issue['modifier']);
        UserLogic::formatAvatarUser($issue['modifier_info']);
        if (empty($issue['modifier_info'])) {
            $issue['modifier_info'] = new \stdClass();
        }

        $issue['creator_info'] = $userModel->getByUid($issue['creator']);
        UserLogic::formatAvatarUser($issue['creator_info']);
        if (empty($issue['creator_info'])) {
            $issue['creator_info'] = new \stdClass();
        }

        $issue['master_info'] = new \stdClass();
        if (!empty($issue['master_id'])) {
            $masterInfo = $issueModel->getById($issue['master_id']);
            if (!empty($masterInfo)) {
                $masterInfo['show_title'] = mb_substr(ucfirst($masterInfo['summary']), 0, 20, 'utf-8');
                $issue['master_info'] = $masterInfo;
            }
        }

        $wfLogic = new WorkflowLogic();
        $issue['allow_update_status'] = $wfLogic->getStatusByIssue($issue);

        $issueResolveModel = new IssueResolveModel();
        $allResolveArr = $issueResolveModel->getAll(true);
        if (isset($allResolveArr[$issue['resolve']])) {
            unset($allResolveArr[$issue['resolve']]);
        }
        sort($allResolveArr);
        $issue['allow_update_resolves'] = $allResolveArr;

        // 当前用户是否关注
        $followModel = new IssueFollowModel();
        $followRow = $followModel->getItemsByIssueUserId($issueId, UserAuth::getId());
        $issue['followed'] = empty($followRow) ? '0' : '1';
        unset($followModel);

        // 自定义字段
        $issueLogic = new IssueLogic();
        $issue['custom_field_values'] = $issueLogic->getCustomFieldValue($issueId);

        // 子任务
        $issue['child_issues'] = $issueLogic->getChildIssue($issueId);
        //IssueFilterLogic::formatIssue($issue);
        $data['issue'] = $issue;

        //下一个 上一个事项
        $data['next_issue_id'] = 0;
        $data['prev_issue_id'] = 0;
        list($ret, $nextId) = $issueLogic->getNextIssueId($issueId, $issueModel);
        if($ret){
            $data['next_issue_id'] = (int)$nextId;
        }
        list($ret, $prevId) = $issueLogic->getPrevIssueId($issueId, $issueModel);
        //var_export($prevId);
        if($ret){
            $data['prev_issue_id'] = (int)$prevId;
        }
        $this->ajaxSuccess('success', $data);
    }


    /**
     * 获取事项的评论信息
     * @throws \Exception
     */
    public function fetchTimeline()
    {
        $issueId = null;
        if (isset($_GET['_target'][3])) {
            $issueId = $_GET['_target'][3];
        }
        if (isset($_REQUEST['issue_id'])) {
            $issueId = (int)$_REQUEST['issue_id'];
        }
        if (empty($issueId)) {
            $this->ajaxFailed('参数错误', '事项id不能为空');
        }

        $timelineModel = new TimelineModel();
        $rows = $timelineModel->getItemsByIssueId($issueId);

        foreach ($rows as &$row) {
            $row['time_text'] = format_unix_time($row['time']);
        }
        $data = [];
        $data['timelines'] = $rows;
        $this->ajaxSuccess('success', $data);
    }

    /**
     * 新增一条事项的评论
     * @throws \Exception
     */
    public function addTimeline()
    {
        $issueId = null;
        if (isset($_POST['issue_id'])) {
            $issueId = (int)$_POST['issue_id'];
        }

        $content = null;
        if (isset($_POST['content'])) {
            $content = htmlspecialchars($_POST['content']);
        }

        $contentHtml = '';
        if (isset($_POST['content_html'])) {
            $contentHtml = ($_POST['content_html']);
        }

        if ($issueId == null || $content == null) {
            $this->ajaxFailed('param_is_null', []);
        }

        $reopen = false;
        if (isset($_POST['reopen']) && $_POST['reopen'] == '1') {
            $reopen = true;
        }
        $issue = IssueModel::getInstance($issueId)->getById($issueId);
        $perm = PermissionLogic::check($issue['project_id'], UserAuth::getId(), PermissionLogic::ADD_COMMENTS);
        if (!$perm) {
            $this->ajaxFailed('当前项目中您没有权限进行此操作,需要评论权限');
        }

        $info = [];
        $info['uid'] = UserAuth::getInstance()->getId();
        $info['issue_id'] = $issueId;
        $info['content'] = $content;
        $info['content_html'] = $contentHtml;
        $info['time'] = time();
        $info['type'] = 'issue';
        $info['action'] = 'commented';
        if ($reopen) {
            $info['action'] = 'commented+reopened';
        }

        $timelineModel = new TimelineModel();
        list($ret, $insertId) = $timelineModel->insert($info);
        if ($ret) {
            if ($reopen) {
                $issueModel = new IssueModel();
                $reopenStatusId = IssueStatusModel::getInstance()->getIdByKey('reopen');
                $issueModel->updateById($issueId, ['status' => $reopenStatusId]);
            }

            // 更新评论数
            $issueLogic = new IssueLogic();
            $issueLogic->updateCommentsCount($issueId);

            // 活动记录
            $currentUid = $this->getCurrentUid();
            $issue = IssueModel::getInstance()->getById($issueId);
            $activityModel = new ActivityModel();
            $activityInfo = [];
            $activityInfo['action'] = '为' . $issue['summary'] . '添加了评论 ';
            $activityInfo['type'] = ActivityModel::TYPE_ISSUE_COMMIT;
            $activityInfo['obj_id'] = $issueId;
            $activityInfo['title'] = $content;
            $activityModel->insertItem($currentUid, $issue['project_id'], $activityInfo);

            // email
            $notifyLogic = new NotifyLogic();
            $notifyLogic->send(NotifyLogic::NOTIFY_FLAG_ISSUE_COMMENT_CREATE, $issue['project_id'], $issueId, $contentHtml);

            $this->ajaxSuccess('success', $insertId);
        } else {
            $this->ajaxFailed('failed:' . $insertId);
        }
    }

    /**
     * 更新评论
     * @throws \Exception
     */
    public function updateTimeline()
    {
        $id = null;
        if (isset($_POST['id'])) {
            $id = (int)$_POST['id'];
        }

        $content = null;
        if (isset($_POST['content'])) {
            $content = htmlspecialchars($_POST['content']);
        }

        $contentHtml = '';
        if (isset($_POST['content_html'])) {
            $contentHtml = ($_POST['content_html']);
        }

        if ($id == null || $content == null) {
            $this->ajaxFailed('param_is_null', []);
        }

        $model = new TimelineModel();
        $timeline = $model->getRowById($id);

        $perm = false;
        if ($timeline['uid'] != UserAuth::getInstance()->getId()) {
            // nothing to do
        } else {
            $perm = true;
        }

        $issueId = $timeline['issue_id'];
        $issue = IssueModel::getInstance()->getById($issueId);
        if ($this->isAdmin || PermissionLogic::check($issue['project_id'], UserAuth::getId(), PermissionLogic::MANAGE_COMMENTS)) {
            $perm = true;
        }
        if (!$perm) {
            $this->ajaxFailed('您没有权限更新此评论', []);
        }
        $info = [];
        $info['content'] = $content;
        $info['content_html'] = $contentHtml;
        $info['action'] = 'commented';
        list($ret, $msg) = $model->updateById($id, $info);
        if ($ret) {
            $info = [];
            $info['uid'] = UserAuth::getInstance()->getId();
            $info['issue_id'] = $timeline['issue_id'];
            $info['content'] = 'updated comment';
            $info['contentHtml'] = $contentHtml;
            $info['time'] = time();
            $info['type'] = 'issue';
            $info['action'] = 'updated_comment';
            $model->insert($info);
            // 活动记录
            $currentUid = $this->getCurrentUid();
            $issue = IssueModel::getInstance()->getById($timeline['issue_id']);
            $activityModel = new ActivityModel();
            $activityInfo = [];
            $activityInfo['action'] = '更新了评论 ' . $content . ' 为 ';
            $activityInfo['type'] = ActivityModel::TYPE_ISSUE_COMMIT;
            $activityInfo['obj_id'] = $id;
            $activityInfo['title'] = $timeline['content'];
            $activityModel->insertItem($currentUid, $issue['project_id'], $activityInfo);

            $this->ajaxSuccess('success');
        } else {
            $this->ajaxFailed('服务器错误', '更新数据失败:' . $msg);
        }
    }


    /**
     * 删除评论
     * @throws \Exception
     */
    public function deleteTimeline()
    {
        $id = null;
        if (isset($_REQUEST['id'])) {
            $id = (int)$_REQUEST['id'];
        }

        if ($id == null) {
            $this->ajaxFailed('param_is_null', []);
        }

        $timelineModel = new TimelineModel();
        $timeline = $timelineModel->getRowById($id);

        $perm = false;
        if (!isset($timeline['uid']) || $timeline['uid'] != UserAuth::getInstance()->getId()) {
            // nothing to do
        } else {
            $perm = true;
        }

        $issueId = $timeline['issue_id'];
        $issue = IssueModel::getInstance()->getById($issueId);
        if ($this->isAdmin || PermissionLogic::check($issue['project_id'], UserAuth::getId(), PermissionLogic::MANAGE_COMMENTS)) {
            $perm = true;
        }
        if (!$perm) {
            $this->ajaxFailed('您没有权限删除此评论', []);
        }

        $timelineModel = new TimelineModel();
        $ret = $timelineModel->deleteById($id);
        if ($ret) {
            // 更新评论数
            $issueLogic = new IssueLogic();
            $issueLogic->updateCommentsCount($issueId);

            // 活动记录
            $currentUid = $this->getCurrentUid();
            $issue = IssueModel::getInstance()->getById($timeline['issue_id']);
            $activityModel = new ActivityModel();
            $activityInfo = [];
            $activityInfo['action'] = '删除了评论 ' . $timeline['content'];
            $activityInfo['type'] = ActivityModel::TYPE_ISSUE_COMMIT;
            $activityInfo['obj_id'] = $id;
            $activityInfo['title'] = '';
            $activityModel->insertItem($currentUid, $issue['project_id'], $activityInfo);

            // email
            $notifyLogic = new NotifyLogic();
            $notifyLogic->send(NotifyLogic::NOTIFY_FLAG_ISSUE_COMMENT_REMOVE, $issue['project_id'], $issueId);

            $this->ajaxSuccess('success');
        } else {
            $this->ajaxFailed('failed,server_error');
        }
    }
}
