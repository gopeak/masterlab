<?php
/**
 * Created by PhpStorm.
 */

namespace main\app\ctrl\issue;

use main\app\classes\IssueStatusLogic;
use \main\app\classes\UploadLogic;
use main\app\classes\UserAuth;
use main\app\classes\UserLogic;
use main\app\ctrl\BaseUserCtrl;
use main\app\model\issue\IssueFileAttachmentModel;
use main\app\model\issue\IssueLabelModel;
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
use main\app\model\TimelineModel;
use main\app\model\user\UserModel;

/**
 * 问题
 */
class Detail extends BaseUserCtrl
{


    public function patch()
    {
        header('Content-Type:application/json');
        $issueId = null;
        if( isset($_GET['_target'][3]) ){
            $issueId = (int) $_GET['_target'][3];
        }
        if( isset($_GET['id']) ){
            $issueId = (int) $_GET['id'];
        }
        $assigneeId = null;

        $_PUT = array();

        $contents = file_get_contents('php://input');
        parse_str($contents,$_PUT);
        if( isset($_PUT['issue']['assignee_id'])){

            $assigneeId = (int) $_PUT['issue']['assignee_id'];
            if( empty($issueId) || empty($assigneeId)){
                $ret = new \stdClass();
                echo json_encode($ret);die;
            }

            $issueModel = new IssueModel();
            $issue = $issueModel->getById($issueId);

            $userModel = new UserModel();
            $assignee = $userModel->getByUid($assigneeId);
            UserLogic::format_avatar_user($assignee);
            $updateInfo = [];
            $updateInfo['assignee'] = $assigneeId;
            list( $ret, $msg ) = $issueModel->updateById( $issueId, $updateInfo);
            if( $ret ){
                $resp = [];
                $userInfo = [];
                $userInfo['avatar_url'] = $assignee['avatar'];
                $userInfo['name'] = $assignee['display_name'];
                $userInfo['username'] = $assignee['username'];
                $resp['assignee'] = $userInfo;
                $resp['assignee_id'] = $assigneeId;
                $resp['author_id'] = $issue['creator'];
                $resp['title'] = $issue['summary'];
                echo json_encode($resp);die;
            }

        }
        $ret = new \stdClass();
        echo json_encode($ret);die;

    }

    public function index()
    {
        $data = [];
        $data['title'] = '问题详情';
        $data['nav_links_active'] = 'issues';
        $data['sub_nav_active'] = 'all';
        $data['query_str'] = http_build_query($_GET);
        $data['sys_filter'] = isset($_GET['sys_filter']) ? $_GET['sys_filter'] : '';
        $data['active_id'] = isset($_GET['active_id']) ? $_GET['active_id'] : '';

        $data['project_id'] = '10003';
        $data['project_name'] = 'ismond_crm';

        $issueId = '';
        if( isset($_GET['_target'][3]) ){
            $issueId = $_GET['_target'][3];
        }
        if( isset($_GET['id']) ){
            $issueId = $_GET['id'];
        }
        $data['issue_id'] = $issueId;

        if(empty($issueId)){
            $this->error('failed', 'Issue id is empty');
        }

        $issueModel = new IssueModel();
        $issue = $issueModel->getById($issueId);
        if(empty($issue)){
            $this->error('failed', 'Issue data is empty');
        }

        $projectId = (int)$issue['project_id'];
        $model = new ProjectModel();
        $data['project'] = $model->getById($projectId);


        $issue['created_text'] = format_unix_time($issue['created']);
        $issue['updated_text'] = format_unix_time($issue['updated']);

        $userModel = new UserModel();
        $issue['assignee_info'] = $userModel->getByUid($issue['assignee']);
        UserLogic::format_avatar_user($issue['assignee_info']);
        $issue['reporter_info'] = $userModel->getByUid($issue['reporter']);
        UserLogic::format_avatar_user($issue['reporter_info']);
        $issue['modifier_info'] = $userModel->getByUid($issue['modifier']);
        UserLogic::format_avatar_user($issue['modifier_info']);
        $issue['creator_info']  = $userModel->getByUid($issue['creator']);
        UserLogic::format_avatar_user($issue['creator_info']);

        $uid = UserAuth::getInstance()->getId();
        $data['user'] = $userModel->getByUid($uid);

        $data['issue'] = $issue;

        $this->render('gitlab/issue/detail.php', $data);
    }
    public function detailStatic()
    {

        $this->render('gitlab/issue/view.html', $data=[]);
    }

    /**
     *
     */
    public function editormd_upload()
    {


        $uuid = '';
        if( isset($_REQUEST['guid']) ){
            $uuid = $_REQUEST['guid'];
        }

        $originName = '';
        if( isset($_FILES['editormd-image-file']['name']) ){
            $originName = $_FILES['editormd-image-file']['name'];
        }

        $fileSize = 0;
        if( isset($_FILES['editormd-image-file']['size']) ){
            $fileSize = (int)$_FILES['editormd-image-file']['size'];
        }


        $uploadLogic = new UploadLogic();
        $ret = $uploadLogic->move('editormd-image-file', 'image' ,$uuid, $originName ,$fileSize);
        header('Content-type: application/json; charset=UTF-8');

        $resp = [];
        if($ret['error']==0){
            $resp['success'] = 1;
            $resp['message'] = '';
            $resp['url'] = $ret['url'];
            $resp['filename'] = $ret['filename'];
        }else{
            $resp['success'] = 0;
            $resp['message'] = $resp['message'];
            $resp['error_code'] = $resp['error'];
            $resp['url'] = $ret['url'];
            $resp['filename'] = $ret['filename'];
        }
        echo json_encode($resp);
        exit;
    }

    public function get()
    {
        $issueId = '';
        if( isset($_GET['_target'][3]) ){
            $issueId = $_GET['_target'][3];
        }
        if( isset($_GET['id']) ){
            $issueId = $_GET['id'];
        }
        $data['issue_id'] = $issueId;

        $uiType = 'view';
        $issueModel = new IssueModel();
        $issue = $issueModel->getById($issueId);

        if(empty($issue)){
            $this->ajaxFailed('failed', [], 'issue_id is error');
        }
        $issueTypeId = (int)$issue['issue_type_id'];
        $projectId = (int)$issue['project_id'];
        $model = new ProjectModel();
        $data['project'] = $model->getById($projectId);

        $model = new ProjectModuleModel();
        $module = $model->getById($issue['module']);
        $issue['module_name'] = isset($module['name']) ? $module['name']:'';
        unset( $module );

        $model = new ProjectVersionModel();
        $projectVersions = $model->getByProjectPrimaryKey($projectId);

        // 修复版本
        $model = new IssueFixVersionModel();
        $issueFixVersion = $model->getItemsByIssueId( $issueId );
        $issue['fix_version_names'] = [];
        foreach($issueFixVersion as $version){
            $versionId = $version['version_id'];
            $issue['fix_version_names'][] = isset($projectVersions[$versionId]) ? $projectVersions[$versionId] :null;
        }
        unset($issueFixVersion,$projectVersions);

        // issue 类型
        $issueTypeModel = new IssueTypeModel();
        $issueTypes = $issueTypeModel->getAll(true);
        $issue['issue_type_info'] = new \stdClass();
        if( isset($issueTypes[$issueTypeId]) ){
            $issue['issue_type_info'] = $issueTypes[$issueTypeId];
        }
        unset($issueTypes);

        $model = new IssueResolveModel();
        $issueResolve = $model->getAll();
        $resolveId = $issue['resolve'];
        $issue['resolve_info'] = new \stdClass();
        if( isset($issueResolve[$resolveId]) ){
            $issue['resolve_info'] = $issueResolve[$resolveId];
        }

        $model = new IssueStatusModel();
        $issueStatus = $model->getAll();
        $statusId = $issue['status'];
        $issue['status_info'] = new \stdClass();
        if( isset($issueStatus[$statusId]) ){
            $issue['status_info'] = $issueStatus[$statusId];
        }

        $model = new IssuePriorityModel();
        $priority= $model->getAll();
        $priorityId = $issue['priority'];
        $issue['priority_info'] = new \stdClass();
        if( isset($priority[$priorityId]) ){
            $issue['priority_info'] = $priority[$priorityId];
        }

        // 当前问题应用的标签id
        $model = new IssueLabelModel();
        $issueLabels = $model->getAll();
        $model = new IssueLabelDataModel();
        $issueLabelData = $model->getItemsByIssueId( $issueId );
        $issue['labels_names'] = [];
        foreach($issueLabelData as $label){
            $labelId = $label['label_id'];
            $issue['labels_names'][] = isset($issueLabels[$labelId]) ? $issueLabels[$labelId] :null;
        }
        $issue['labels'] = $issueLabelData;
        unset($issueLabels);

        $model = new IssueFileAttachmentModel();
        $attachmentDatas = $model->getsByIssueId($issueId);
        $issue['attachment'] = [];
        foreach ( $attachmentDatas as $f ){
            $file = [];
            $file['thumbnailUrl'] = ROOT_URL.$f['file_name'];
            $file['size'] = $f['file_size'];
            $file['name'] = $f['origin_name'];
            $file['uuid'] = $f['uuid'];
            $issue['attachment'][] = $file;
        }
        unset( $attachmentDatas );

        $issue['created_text'] = format_unix_time($issue['created']);
        $issue['updated_text'] = format_unix_time($issue['updated']);

        $userModel = new UserModel();
        $issue['assignee_info'] = $userModel->getByUid($issue['assignee']);
        UserLogic::format_avatar_user($issue['assignee_info']);
        $issue['reporter_info'] = $userModel->getByUid($issue['reporter']);
        UserLogic::format_avatar_user($issue['reporter_info']);
        $issue['modifier_info'] = $userModel->getByUid($issue['modifier']);
        UserLogic::format_avatar_user($issue['modifier_info']);
        $issue['creator_info']  = $userModel->getByUid($issue['creator']);
        UserLogic::format_avatar_user($issue['creator_info']);

        $userLogic = new UserLogic();
        $data['users'] = $userLogic->getAllNormalUser();

        $data['issue'] = $issue;
        $this->ajaxSuccess('success', $data);
    }


    public function fetchTimeline($issue_id=null){

        $issueId = null;
        if( isset($_GET['_target'][3]) ){
            $issueId = $_GET['_target'][3];
        }
        if(isset($_REQUEST['issue_id'])){
            $issueId = (int) $_REQUEST['issue_id'];
        }

        $timelineModel = new TimelineModel();
        $rows = $timelineModel->getItemsByIssueId($issueId);

        foreach($rows as &$row ){
            $row['time_text'] = format_unix_time($row['time']);
        }
        $data = [];
        $data['timelines'] = $rows;
        $this->ajaxSuccess('success',$data);
    }

    public function addTimeline(){
        $issueId = null;
        if(isset($_POST['issue_id'])){
            $issueId = (int) $_POST['issue_id'];
        }

        $content = null;
        if(isset($_POST['content'])){
            $content =  htmlspecialchars($_POST['content']);
        }

        $content_html = '';
        if(isset($_POST['content_html'])){
            $content_html = htmlspecialchars($_POST['content_html']);
        }

        if( $issueId==null || $content==null ){
            $this->ajaxFailed('param_is_null',[]);
        }

        $reopen = false;
        if(isset($_POST['reopen']) && $_POST['reopen']=='1'){
            $reopen = true;
        }

        $info = [];
        $info['uid'] = UserAuth::getInstance()->getId();
        $info['issue_id'] = $issueId;
        $info['content']  = $content;
        $info['content_html']  = $content_html;
        $info['time']     = time();
        $info['type']     = 'issue';
        $info['action']   = 'commented';
        if( $reopen ){
            $info['action']   = 'commented+reopened';
        }

        $timelineModel = new TimelineModel();
        list( $ret,$insertId ) = $timelineModel->insert($info);
        if( $ret ){
            if( $reopen ){
                $issueModel = new IssueModel();
                $issueModel->updateById($issueId,['status'=>'4']);
            }
            $this->ajaxSuccess('success');
        }else{
            $this->ajaxFailed('failed');
        }

    }



}