<?php
/**
 * Created by PhpStorm.
 */

namespace main\app\ctrl\issue;

use main\app\classes\IssueFilterLogic;
use main\app\classes\IssueFavFilterLogic;
use main\app\classes\IssueLogic;
use main\app\classes\IssueTypeLogic;
use main\app\classes\NotifyLogic;
use main\app\classes\PermissionGlobal;
use main\app\classes\ProjectGantt;
use main\app\classes\RewriteUrl;
use main\app\classes\SearchLogic;
use \main\app\classes\UploadLogic;
use main\app\classes\UserAuth;
use main\app\classes\UserLogic;
use main\app\classes\WorkflowLogic;
use main\app\classes\ConfigLogic;
use main\app\classes\Settings;
use main\app\ctrl\BaseCtrl;
use main\app\ctrl\BaseUserCtrl;
use main\app\event\CommonPlacedEvent;
use main\app\event\Events;
use main\app\model\agile\SprintModel;
use main\app\model\field\FieldCustomValueModel;
use main\app\model\issue\ExtraWorkerDayModel;
use main\app\model\issue\HolidayModel;
use main\app\model\project\ProjectCatalogLabelModel;
use main\app\model\project\ProjectFlagModel;
use main\app\model\project\ProjectGanttSettingModel;
use main\app\model\project\ProjectLabelModel;
use main\app\model\project\ProjectModel;
use main\app\model\project\ProjectVersionModel;
use main\app\model\project\ProjectModuleModel;
use main\app\model\issue\IssueFileAttachmentModel;
use main\app\model\issue\IssueFilterModel;
use main\app\model\issue\IssueResolveModel;
use main\app\model\issue\IssuePriorityModel;
use main\app\model\issue\IssueDescriptionTemplateModel;
use main\app\model\issue\IssueFollowModel;
use main\app\model\issue\IssueModel;
use main\app\model\issue\IssueLabelDataModel;
use main\app\model\issue\IssueFixVersionModel;
use main\app\model\issue\IssueEffectVersionModel;
use main\app\model\issue\IssueTypeModel;
use main\app\model\issue\IssueStatusModel;
use main\app\model\issue\IssueUiModel;
use main\app\model\issue\IssueUiTabModel;
use main\app\model\issue\IssueRecycleModel;
use main\app\model\field\FieldTypeModel;
use main\app\model\field\FieldModel;
use main\app\model\user\UserIssueLastCreateDataModel;
use main\app\model\user\UserModel;
use main\app\model\SettingModel;
use main\app\model\user\UserSettingModel;
use main\app\classes\PermissionLogic;
use main\app\classes\LogOperatingLogic;
use Endroid\QrCode\QrCode;
use \PhpOffice\PhpSpreadsheet\IOFactory;


/**
 * 事项
 */
class Main extends BaseUserCtrl
{

    /**
     * Main constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct();
        parent::addGVar('top_menu_active', 'project');
        parent::addGVar('sub_nav_active', 'project');
    }

    /**
     * 事项列表页面
     * @throws \Exception
     */
    public function pageIndex()
    {

        $data = [];
        $data['title'] = '事项';
        $data['nav_links_active'] = 'issues';
        $data['sub_nav_active'] = 'all';
        $data['query_str'] = http_build_query($_GET);
        $data['search'] = isset($_GET['search']) ? $_GET['search'] : '';
        $data['sys_filter'] = isset($_GET['sys_filter']) ? $_GET['sys_filter'] : '';
        $data['active_id'] = isset($_GET['active_id']) ? $_GET['active_id'] : '';
        $data['avl_sort_fields'] = IssueFilterLogic::$avlSortFields;
        $data['sort_field'] = isset($_GET['sort_field']) ? $_GET['sort_field'] : IssueFilterLogic::$defaultSortField;
        $data['sort_by'] = isset($_GET['sort_by']) ? $_GET['sort_by'] : IssueFilterLogic::$defaultSortBy;
        $data = RewriteUrl::setProjectData($data);
        $data['issue_main_url'] = ROOT_URL . 'issue/main';
        if (!empty($data['project_id'])) {
            $data['issue_main_url'] = ROOT_URL . substr($data['project_root_url'], 1) . '/issues';
            if (!$this->isAdmin && !PermissionLogic::checkUserHaveProjectItem(UserAuth::getId(), $data['project_id'])) {
                $this->warn('提 示', '您没有权限访问该项目,请联系管理员申请加入该项目');
                die;
            }
        }

        $data['is_adv_filter'] = '0';
        $data['adv_filter_json'] = '[]';

        $data['fav_filter'] = '';
        if (isset($_GET['fav_filter'])) {
            $favFilterId = (int)$_GET['fav_filter'];
            $data['fav_filter'] = $favFilterId;
            $favFilterModel = new IssueFilterModel();
            $fav = $favFilterModel->getItemById($favFilterId);
            if (isset($fav['filter']) && !empty($fav['filter'])) {
                if ($fav['is_adv_query'] == '0') {
                    $fav['filter'] = str_replace([':='], [':'], $fav['filter']);
                    $fav['filter'] = str_replace([':', ' ', '"', ';;'], ['=', '&', '', '&'], $fav['filter']);
                    $fav['filter'] = str_replace(['经办人=@', '报告人=@'], ['经办人=', '报告人='], $fav['filter']);
                    $filter = $fav['filter'] . '&active_id=' . $favFilterId;
                    $issueUrl = 'issue/main';
                    if (!empty($fav['projectid'])) {
                        $model = new ProjectModel();
                        $project = $model->getById($fav['projectid']);
                        if (isset($project['org_path'])) {
                            $issueUrl = $project['org_path'] . '/' . $project['key'];
                        }
                        unset($project);
                    }
                    // @todo 防止传入 fav_filter 参数进入死循环
                    header('location:' . ROOT_URL . $issueUrl . '?' . $filter);
                    die;
                } else {
                    if ($fav['is_adv_query'] == '1') {
                        $data['adv_filter_json'] = $fav['filter'];
                    } else {
                        $data['adv_filter_json'] = [];
                    }
                    if(!empty($fav['adv_query_sort_field'])){
                        $data['sort_field'] = $fav['adv_query_sort_field'];
                    }
                    if(!empty($fav['adv_query_sort_by'])){
                        $data['sort_by'] = $fav['adv_query_sort_by'];
                    }
                    $data['is_adv_filter'] = '1';
                }

            }
        }
        // 用户的过滤器
        $IssueFavFilterLogic = new IssueFavFilterLogic();
        $favFilters = $IssueFavFilterLogic->getCurUserFavFilterByProject($data['project_id']);
        $showFavFilterNumber = 5;
        $showFavFilters = [];
        $otherFavFilters = [];
        if (count($favFilters) > 0) {
            $i = 0;
            foreach ($favFilters as $favFilter) {
                $i++;
                if ($i < $showFavFilterNumber) {
                    $showFavFilters[] = $favFilter;
                } else {
                    $otherFavFilters[] = $favFilter;
                }
            }
        }
        $data['showFavFilters'] = $showFavFilters;
        $data['otherFavFilters'] = $otherFavFilters;
        // 获取当前用户未解决的数量
        $data['unResolveCount'] = IssueFilterLogic::getUnResolveCountByAssigneeProject(UserAuth::getId(), $data['project_id']);
        // 描述模板
        $descTplModel = new IssueDescriptionTemplateModel();
        $data['description_templates'] = $descTplModel->getAll(false);
        // 表格视图的显示字段
        $issueLogic = new IssueLogic();
        $data['display_fields'] = $issueLogic->getUserIssueDisplayFields(UserAuth::getId(), $data['project_id']);
        $uiDisplayFields = IssueLogic::$uiDisplayFields;
        $fieldsArr = FieldModel::getInstance()->getCustomFields();
        $fieldsIdArr = array_column($fieldsArr, 'title', 'name');
        $data['uiDisplayFields'] = array_merge($uiDisplayFields, $fieldsIdArr);

        $displayCustomFieldArr = [];
        foreach ($fieldsArr as $field) {
            if (in_array($field['name'], $data['display_fields'])) {
                $displayCustomFieldArr[] = $field;
            }
        }
        $data['displayCustomFieldArr'] = $displayCustomFieldArr;
        // 高级查询字段
        $data['advFields'] = IssueFilterLogic::$advFields;
        // 事项展示的视图方式
        $data['issue_view'] = SettingModel::getInstance()->getValue('issue_view');
        $userId = UserAuth::getId();
        $userSettingModel = new UserSettingModel($userId);
        $userIssueView = $userSettingModel->getSettingByKey($userId, 'issue_view');
        if (!empty($userIssueView)) {
            $data['issue_view'] = $userIssueView;
        }
        if (empty($data['issue_view'])) {
            $data['issue_view'] = 'list';
        }

        $data['is_all_issues'] = false;
        if ($_GET['_target'][0] == 'issue' && $_GET['_target'][1] == 'main') {
            $data['is_all_issues'] = true;
            $data['display_fields'][] = 'project_id';
        }

        ConfigLogic::getAllConfigs($data);

        // 迭代数据
        $data['sprints'] = [];
        $data['active_sprint'] = [];
        $sprintModel = new SprintModel();
        if (!empty($data['project_id'])) {
            $data['sprints'] = $sprintModel->getItemsByProject($data['project_id']);
            $data['active_sprint'] = $sprintModel->getActive($data['project_id']);
        } else {
            $data['sprints'] = $sprintModel->getAllItems(false);
        }
        $data['project_catalog'] = (new ProjectCatalogLabelModel())->getByProject($data['project_id']);
        $data['last_create_data'] = UserLogic::getLastCreateIssueData($userId, $data['project']);

        $data['ProjectFilterArr'] = IssueFavFilterLogic::fetchProjectFilters($data['project_id']);

        $this->render('gitlab/issue/list.php', $data);
    }

    /**
     * 获取某一事项的子任务列表
     * @throws \Exception
     */
    public function getChildIssue()
    {
        $issueId = null;
        if (isset($_GET['_target'][3])) {
            $issueId = (int)$_GET['_target'][3];
        }
        if (isset($_GET['id'])) {
            $issueId = (int)$_GET['id'];
        }
        if (empty($issueId)) {
            $this->ajaxFailed('参数错误', '事项id不能为空');
        }
        $issueLogic = new IssueLogic();
        $data['issues'] = $issueLogic->getChildIssue($issueId);
        $this->ajaxSuccess('ok', $data);
    }

    public function getDuration()
    {
        $projectId = null;
        if (isset($_GET['project_id'])) {
            $projectId = (int)$_GET['project_id'];
        }
        if (!$projectId) {
            $this->ajaxFailed('提示', '请同时提供project_id参数');
        }
        if (!isset($_GET['start_date']) || !isset($_GET['due_date'])) {
            $this->ajaxFailed('提示', '请同时提供start_date和due_date参数');
        }

        $holidays = (new HolidayModel())->getDays($projectId);
        $extraWorkerDays = (new ExtraWorkerDayModel())->getDays($projectId);
        $startDate = $_GET['start_date'];
        $dueDate = $_GET['due_date'];
        $ganttSetting = (new ProjectGanttSettingModel())->getByProject($projectId);
        $workDates = json_decode($ganttSetting['work_dates'], true);
        $duration = getWorkingDays($startDate, $dueDate, $workDates, $holidays, $extraWorkerDays);

        $this->ajaxSuccess('ok', $duration);
    }

    /**
     * 以patch方式更新事项内容
     * @throws \Exception
     */
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
        if (empty($issueId)) {
            //$this->ajaxFailed('参数错误', '事项id不能为空');
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
            UserLogic::formatAvatarUser($assignee);
            $updateInfo = [];
            $updateInfo['assignee'] = $assigneeId;
            list($ret) = $issueModel->updateById($issueId, $updateInfo);
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

        // email
        $notifyLogic = new NotifyLogic();
        $notifyLogic->send(NotifyLogic::NOTIFY_FLAG_ISSUE_ASSIGN, $issue['project_id'], $issueId);

        $ret = new \stdClass();
        echo json_encode($ret);
        die;
    }

    /**
     * 事项相关的上传文件接口
     * @throws \Exception
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
        $issueId = null;
        if (isset($_REQUEST['issue_id'])) {
            $issueId = (int)$_REQUEST['issue_id'];
        }
        if (isset($_GET['issue_id']) || isset($_GET['project_id'])) {
            // 判断权限上传
            if (!$this->isAdmin && !isset($this->projectPermArr[PermissionLogic::CREATE_ATTACHMENTS])) {
                $resp['success'] = false;
                $resp['error'] = '无权限上传';
                $resp['error_code'] = $resp['error'];
                $resp['url'] = '';
                $resp['filename'] = '';
                $resp['origin_name'] = $originName;
                $resp['insert_id'] = '';
                $resp['uuid'] = $uuid;
                echo json_encode($resp);
                exit;
            }
        }

        $uploadLogic = new UploadLogic($issueId);

        //print_r($_FILES);
        $ret = $uploadLogic->move('qqfile', 'all', $uuid, $originName, $fileSize);
        header('Content-type: application/json; charset=UTF-8');

        $resp = [];
        if ($ret['error'] == 0) {
            $resp['success'] = true;
            $resp['error'] = '';
            $resp['url'] = $ret['url'];
            $resp['filename'] = $ret['filename'];
            $resp['origin_name'] = $ret['filename'];
            $resp['insert_id'] = $ret['insert_id'];
            $resp['uuid'] = $ret['uuid'];

            if (!empty($issueId)) {

                $event = new CommonPlacedEvent($this, $issueId);
                $this->dispatcher->dispatch($event, Events::onIssueUpload);
            }
        } else {
            $resp['success'] = false;
            $resp['error'] = $ret['message'];
            $resp['error_code'] = $ret['error'];
            $resp['url'] = $ret['url'];
            $resp['filename'] = $ret['filename'];
            $resp['origin_name'] = $originName;
            $resp['insert_id'] = '';
            $resp['uuid'] = $uuid;
        }
        echo json_encode($resp);
        exit;
    }

    /**
     * @throws \Exception
     */
    public function fetchMobileAttachment()
    {
        $tmpIssueId = '';
        if (isset($_POST['tmp_issue_id'])) {
            $tmpIssueId = $_POST['tmp_issue_id'];
        }
        if ($tmpIssueId == '') {
            $this->ajaxSuccess('ok', []);
        }
        $model = new IssueFileAttachmentModel();
        $attachmentDataArr = $model->getsByTmpIssueId($tmpIssueId);
        $attachment = [];
        foreach ($attachmentDataArr as $row) {
            $file = [];
            $file['thumbnailUrl'] = ATTACHMENT_URL . $row['file_name'];
            $file['size'] = $row['file_size'];
            $file['name'] = $row['origin_name'];
            $file['originalName'] = $row['origin_name'];
            $file['status'] = "upload successful";
            $file['uuid'] = $row['uuid'];
            $file['id'] = 0;
            $file['file'] = null;
            $attachment[] = $file;
        }

        $this->ajaxSuccess('ok', $attachment);
    }

    /**
     * @throws \Endroid\QrCode\Exception\InvalidPathException
     */
    public function pageQr()
    {
        $issue_id = isset($_GET['issue_id']) ? $_GET['issue_id'] : '';
        $tmp_issue_id = isset($_GET['tmp_issue_id']) ? $_GET['tmp_issue_id'] : '';
        $qr_token = isset($_GET['qr_token']) ? $_GET['qr_token'] : '';
        $url = ROOT_URL . "issue/main/QrMobileUpload?issue_id={$issue_id}&tmp_issue_id={$tmp_issue_id}";
        $qrCode = new QrCode($url);
        header('Content-Type: ' . $qrCode->getContentType());
        $qrCode->setSize(160);
        // Set advanced options
        //$qrCode->setMargin(10);
        //$qrCode->setForegroundColor(['r' => 0, 'g' => 0, 'b' => 0, 'a' => 0]);
        //$qrCode->setBackgroundColor(['r' => 255, 'g' => 255, 'b' => 255, 'a' => 0]);
        // Set advanced options
        $qrCode->setLogoPath(PRE_APP_PATH . 'public/gitlab/images/logo.png');
        $qrCode->setLogoSize(40, 40);
        echo $qrCode->writeString();
    }

    /**
     * 在移动端上传显示的页面
     * @throws \Exception
     */
    public function pageQrMobileUpload()
    {
        $data = [];
        $data['title'] = '移动端上传附件';
        $data['nav_links_active'] = 'issues';
        $data['sub_nav_active'] = 'all';
        $data['query_str'] = http_build_query($_GET);
        $data['tmp_issue_id'] = isset($_GET['tmp_issue_id']) ? $_GET['tmp_issue_id'] : '';
        $data['qr_token'] = isset($_GET['qr_token']) ? $_GET['qr_token'] : '';

        $this->render('gitlab/issue/mobile_upload.php', $data);
    }

    /**
     * 移动端的上传文件接口
     * @throws \Exception
     */
    public function mobileUpload()
    {
        $tmpIssueId = '';
        if (isset($_GET['tmp_issue_id'])) {
            $tmpIssueId = $_GET['tmp_issue_id'];
        }
        $uuid = $tmpIssueId;

        $originName = '';
        if (isset($_FILES['file']['name'])) {
            $originName = $_FILES['file']['name'];
        }

        $fileSize = 0;
        if (isset($_FILES['file']['size'])) {
            $fileSize = (int)$_FILES['file']['size'];
        }
        $issueId = null;
        if (isset($_REQUEST['issue_id'])) {
            $issueId = (int)$_REQUEST['issue_id'];
        }

        $uploadLogic = new UploadLogic($issueId);

        //print_r($_FILES);
        $ret = $uploadLogic->move('file', 'all', $uuid, $originName, $fileSize, $tmpIssueId);
        header('Content-type: application/json; charset=UTF-8');

        $resp = [];
        if ($ret['error'] == 0) {
            $resp['success'] = true;
            $resp['error'] = '';
            $resp['url'] = $ret['url'];
            $resp['filename'] = $ret['filename'];
            $resp['origin_name'] = $ret['filename'];
            $resp['insert_id'] = $ret['insert_id'];
            $resp['uuid'] = $ret['uuid'];


            $event = new CommonPlacedEvent($this, $issueId);
            $this->dispatcher->dispatch($event, Events::onIssueMobileUpload);
        } else {
            $resp['success'] = false;
            $resp['error'] = $resp['message'];
            $resp['error_code'] = $resp['error'];
            $resp['url'] = $ret['url'];
            $resp['filename'] = $ret['filename'];
            $resp['origin_name'] = $originName;
            $resp['insert_id'] = '';
            $resp['uuid'] = $uuid;
        }
        echo json_encode($resp);
        exit;
    }

    /**
     * 删除上传的某一文件
     * @throws \Exception
     */
    public function uploadDelete()
    {
        $id = null;
        if (isset($_GET['_target'][3])) {
            $id = $_GET['_target'][3];
        }
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
        }

        $uuid = '';
        if (isset($_GET['_target'][4])) {
            $uuid = $_GET['_target'][4];
        }
        if (isset($_GET['uuid'])) {
            $uuid = $_GET['uuid'];
        }
        $this->projectPermArr = PermissionLogic::getUserHaveProjectPermissions(UserAuth::getId(), $id, $this->isAdmin);

        if ($uuid != '' || empty($id)) {
            $model = new IssueFileAttachmentModel();
            $file = $model->getByUuid($uuid);
            if (!isset($file['uuid'])) {
                $this->ajaxFailed('参数错误:uuid_not_found');
            }
            // 判断是否有删除权限
            if ($file['author'] != UserAuth::getId()) {
                if (!$this->isAdmin && !isset($this->projectPermArr[PermissionLogic::CREATE_ATTACHMENTS])) {
                    $this->ajaxFailed('提示:您没有权限执行此操作');
                }
            }

            $ret = $model->deleteByUuid($uuid);
            if ($ret > 0) {
                $settings = Settings::getInstance()->attachment();
                // 文件保存目录路径
                $savePath = $settings['attachment_dir'];
                $unlinkRet = @unlink($savePath . '' . $file['file_name']);
                if (!$unlinkRet) {
                    $this->ajaxFailed('服务器错误', "删除文件失败,路径:" . $savePath . '' . $file['file_name']);
                }
                $event = new CommonPlacedEvent($this, $file['issue_id']);
                $this->dispatcher->dispatch($event, Events::onIssueDeleteUpload);
                $this->ajaxSuccess('success', $ret);
            }
        } else {
            $this->ajaxFailed('参数错误', []);
        }
    }

    /**
     * @throws \Exception
     */
    public function autocomplete()
    {
        $issueModel = new IssueModel();
        if(isset($_GET['init'])){
            $issueId = isset($_GET['issue_id']) ? (int)$_GET['issue_id'] : 0;
            $projectId = $issueModel->getFieldById('project_id', $issueId);
            $issues = [];
            if($projectId){
                $issues = $issueModel->getRows('id,summary,created', ['project_id'=>$projectId], null, 'id', 'desc', 50);
                if($issues){
                    $arr = [];
                    foreach ($issues as $issue) {
                        $text = '#'.$issue['id'].' '.$issue['summary'].'   '.format_unix_time($issue['created']);
                        $arr[] = ['id'=>$issue['id'], 'text'=>$text];
                    }
                    $issues = $arr;
                }
            }
            $this->ajaxSuccess('success', $issues);
        }

        $keyword = isset($_GET['query']) ? $_GET['query'] : null;
        if (empty(trimStr($keyword))) {
            $this->ajaxSuccess('none', []);
        }
        $projectId = isset($_GET['project_id']) ? (int)$_GET['project_id'] : 0;
        $limitSql = "   limit 20";

        $table = $issueModel->getTable();
        $where = "WHERE locate(:keyword,`summary`) > 0  AND project_id={$projectId} ";
        $params['keyword'] = $keyword;
        $sql = "SELECT id, summary as `text` FROM {$table}  {$where} {$limitSql}";
        $rows = $issueModel->db->fetchAll($sql, $params);
        $this->ajaxSuccess('success', $rows);
    }


    /**
     * 事项列表查询处理
     * @throws \Exception
     */
    public function filter()
    {
        $issueFilterLogic = new IssueFilterLogic();

        $pageSize = 20;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $page = max(1, $page);
        if (isset($_GET['page'])) {
            $page = max(1, intval($_GET['page']));
        }
        if (isset($_GET['fav_filter'])) {
            $favFilterId = $_GET['fav_filter'];
            $filterModel = IssueFilterModel::getInstance();
            $favArr = $filterModel->getRowById($favFilterId);
            if ($favArr['is_adv_query'] == '1') {
                $_GET['adv_query_json'] = $favArr['filter'];
                $this->advFilter();
                return;
            }

        }
        list($ret, $data['issues'], $total) = $issueFilterLogic->getList($page, $pageSize);
        if ($ret) {
            $this->response($data, $total, $page, $pageSize);
        } else {
            $this->ajaxFailed('failed', $data['issues']);
        }
    }

    /**
     * @param $issues
     * @param $total
     * @throws \Exception
     */
    private function response($data, $total, $page, $pageSize)
    {
        // 获取标签的关联数据
        $issueIdArr = array_column($data['issues'], 'id');
        $labelDataRows = (new IssueLabelDataModel())->getsByIssueIdArr($issueIdArr);
        $labelDataArr = [];
        foreach ($labelDataRows as $labelData) {
            $labelDataArr[$labelData['issue_id']][] = $labelData['label_id'];
        }
        // 获取自定义字段值
        $fieldsArr = (new FieldModel())->getCustomFields();
        if ($fieldsArr) {
            $fieldsArr = array_column($fieldsArr, null, 'id');
            $customFieldIdArr = array_column($fieldsArr, 'id');
            $customValuesArr = (new FieldCustomValueModel())->getsByIssueIdArr($issueIdArr, $customFieldIdArr);
            $customValuesIssueArr = [];
            foreach ($customValuesArr as $customValue) {
                $key = $customValue['value_type'] . '_value';
                $issueId = $customValue['issue_id'];
                $fieldId = $customValue['custom_field_id'];
                $fieldArr = $fieldsArr[$fieldId];
                if (isset($fieldArr['name'])) {
                    $fieldValue = !isset($customValue[$key]) ? $customValue['string_value'] : $customValue[$key];
                    $fieldName = $fieldArr['name'];
                    $customValuesIssueArr[$issueId][$fieldName] = $fieldValue;
                }
            }
        }

        $userLogic = new UserLogic();
        $users = $userLogic->getAllUser();
        foreach ($data['issues'] as &$issue) {
            $issueId = $issue['id'];
            IssueFilterLogic::formatIssue($issue);
            if (isset($labelDataArr[$issueId])) {
                $arr = array_unique($labelDataArr[$issueId]);
                sort($arr);
                $issue['label_id_arr'] = $arr;
            } else {
                $issue['label_id_arr'] = [];
            }
            if (isset($customValuesIssueArr[$issueId])) {
                $customValueArr = $customValuesIssueArr[$issueId];
                $issue = array_merge($customValueArr, $issue);
            }
            $emptyObj = new \stdClass();
            $issue['creator_info'] = isset($users[$issue['creator']]) ? $users[$issue['creator']] : $emptyObj;
            $issue['modifier_info'] = isset($users[$issue['modifier']]) ? $users[$issue['modifier']] : $emptyObj;
            $issue['reporter_info'] = isset($users[$issue['reporter']]) ? $users[$issue['reporter']] : $emptyObj;
            $issue['assignee_info'] = isset($users[$issue['assignee']]) ? $users[$issue['assignee']] : $emptyObj;
        }

        $data['total'] = (int)$total;
        $data['pages'] = ceil($total / $pageSize);
        $data['page_size'] = $pageSize;
        $data['page'] = $page;
        $_SESSION['filter_current_page'] = $page;
        $_SESSION['filter_pages'] = $data['pages'];
        $_SESSION['filter_page_size'] = $pageSize;
        $this->ajaxSuccess('success', $data);

    }

    /**
     * 高级查询
     * @throws \Exception
     */
    public function advFilter()
    {
        $issueFilterLogic = new IssueFilterLogic();

        $pageSize = 20;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $page = max(1, $page);
        if (isset($_GET['page'])) {
            $page = max(1, intval($_GET['page']));
        }

        list($ret, $data['issues'], $total) = $issueFilterLogic->getAdvQueryList($page, $pageSize);
        if ($ret) {
            $this->response($data, $total, $page, $pageSize);
        } else {
            $this->ajaxFailed('failed', $data['issues']);
        }
    }

    /**
     * 获取保存过的过滤器列表
     * @throws \Exception
     */
    public function getFavFilter()
    {
        $IssueFavFilterLogic = new IssueFavFilterLogic();
        $arr['filters'] = $IssueFavFilterLogic->getCurUserFavFilter();
        $this->ajaxSuccess('success', $arr);
    }

    /**
     * 保存过滤器
     * @param string $name
     * @param string $filter
     * @param string $description
     * @param string $shared
     * @throws \Exception
     */
    public function saveFilter($name = '', $filter = '', $description = '', $shared = '')
    {
        $err = [];
        if (empty($name)) {
            $err['name'] = '名称不能为空';
        }
        if (empty($filter)) {
            $err['filter'] = '数据不能为空';
        }
        if (!empty($err)) {
            $this->ajaxFailed('参数错误', $err, BaseCtrl::AJAX_FAILED_TYPE_FORM_ERROR);
        }

        $projectId = null;
        if (isset($_REQUEST['project_id'])) {
            $projectId = (int)$_REQUEST['project_id'];
        }

        $IssueFavFilterLogic = new IssueFavFilterLogic();
        $arr = explode(';;', urldecode($filter));
        foreach ($arr as $k => $arg) {
            if (empty($arg)) {
                unset($arr[$k]);
                continue;
            }
            $tmp = explode(':', $arg);
            if (isset($tmp[1])) {
                $tmp[1] = str_replace([" ", '"'], ["%20", ''], $tmp[1]);
                $arr[$k] = implode(':', $tmp);
            }
        }
        if (isset($_REQUEST['sort_field']) && !empty($_REQUEST['sort_field'])) {
            $arr[] = 'sort_field:' . $_REQUEST['sort_field'];
        }
        if (isset($_REQUEST['sort_by']) && !empty($_REQUEST['sort_by'])) {
            $arr[] = 'sort_by:' . $_REQUEST['sort_by'];
        }
        $shareScope = '';
        if (isset($_REQUEST['is_project_filter']) &&  $_REQUEST['is_project_filter']=="1") {
            $shareScope = 'project';
        }
        //print_r($arr);
        $filter = implode(" ", $arr);
        list($ret, $msg) = $IssueFavFilterLogic->saveFilter($name, $filter, $description, $shareScope, $projectId);
        if ($ret) {
            $info = [];
            $info['name'] = $name;
            $info['filter'] = $filter;
            $info['description'] = $description;
            $info['shared'] = $shared;
            $info['projectId'] = $projectId;
            $event = new CommonPlacedEvent($this, $info);
            $this->dispatcher->dispatch($event, Events::onIssueAddFilter);
            $this->ajaxSuccess('success', $msg);
        } else {
            $this->ajaxFailed('failed', [], $msg);
        }
    }

    /**
     * @throws \Doctrine\DBAL\DBALException
     */
    public function saveAdvFilter()
    {
        $err = [];
        if (@empty($_POST['name'])) {
            $err['name'] = '名称不能为空';
        }
        if (@empty($_POST['filter'])) {
            $err['filter'] = '数据不能为空';
        }
        if (!empty($err)) {
            $this->ajaxFailed('参数错误', $err, BaseCtrl::AJAX_FAILED_TYPE_FORM_ERROR);
        }

        $projectId = null;
        if (isset($_REQUEST['project_id'])) {
            $projectId = (int)$_REQUEST['project_id'];
        }

        $filterModel = IssueFilterModel::getInstance();
        $info = [];
        $info['author'] = UserAuth::getInstance()->getId();
        $info['name'] = $_POST['name'];
        $info['projectid'] = $projectId;
        $info['filter'] = $_POST['filter'];
        $info['is_adv_query'] = '1';
        if(isset($_POST['sort_field'])){
            $info['adv_query_sort_field'] = $_POST['sort_field'];
        }
        if(isset($_POST['sort_by'])){
            $info['adv_query_sort_by'] = $_POST['sort_by'];
        }
        $shareScope = '';
        if (isset($_REQUEST['is_project_filter']) &&  $_REQUEST['is_project_filter']=="1") {
            $shareScope = 'project';
        }
        $info['share_scope'] = $shareScope;
        list($ret, $msg) = $filterModel->insert($info);
        if ($ret) {
            $event = new CommonPlacedEvent($this, $info);
            $this->dispatcher->dispatch($event, Events::onIssueAddAdvFilter);
            $this->ajaxSuccess('提示', '操作成功');
        } else {
            $this->ajaxFailed('提示', $msg);
        }
    }

    /**
     * 获取某一项目的事项类型
     * @throws \Exception
     */
    public function fetchIssueType()
    {
        $projectId = isset($_GET['project_id']) ? (int)$_GET['project_id'] : null;
        $logic = new IssueTypeLogic();
        $data['issue_types'] = $logic->getIssueType($projectId);
        $this->ajaxSuccess('success', $data);
    }

    /**
     * 获取事项的ui信息
     * @throws \Exception
     */
    public function fetchUiConfig()
    {
        $issueTypeId = isset($_GET['issue_type_id']) ? (int)$_GET['issue_type_id'] : null;
        $type = isset($_GET['type']) ? $_GET['type'] : 'create';
        $projectId = isset($_GET['project_id']) ? (int)$_GET['project_id'] : 0;

        $model = new IssueUiModel();
        $data['configs'] = $model->getsByUiType($issueTypeId, $type);

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
        $wfLogic = new WorkflowLogic();
        $data['allow_add_status'] = $wfLogic->getStatusByProjectIssueType($projectId, $issueTypeId);

        $issueUiTabModel = new IssueUiTabModel();
        $data['tabs'] = $issueUiTabModel->getItemsByIssueTypeIdType($issueTypeId, $type);

        $this->ajaxSuccess('success', $data);
    }

    /**
     * 获取某一事项的内容，包括相关事项定义
     * @throws \Exception
     */
    public function fetchIssueEdit()
    {

        $uiType = 'edit';
        $issueId = isset($_GET['issue_id']) ? (int)$_GET['issue_id'] : null;
        $issueModel = new IssueModel();
        $issue = $issueModel->getById($issueId);

        if (empty($issue)) {
            $this->ajaxFailed('failed:issue_id is error');
        }


        $issueTypeId = (int)$issue['issue_type'];
        if (isset($_GET['issue_type'])) {
            $issueTypeId = (int)$_GET['issue_type'];
        }

        $projectId = (int)$issue['project_id'];

        $model = new IssueUiModel();
        $data['configs'] = $model->getsByUiType($issueTypeId, $uiType);

        $model = new FieldModel();
        $fields = $model->getAll(false);
        if ($fields) {
            foreach ($fields as &$field) {
                $field['options'] = json_decode($field['options']);
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

        // 当前事项应用的标签id
        $model = new IssueLabelDataModel();
        $issueLabelData = $model->getItemsByIssueId($issueId);
        $issueLabelDataIds = [];
        foreach ($issueLabelData as $label) {
            $labelId = $label['label_id'];
            $issueLabelDataIds[] = $labelId;
        }
        $issueLabelDataIds = array_unique($issueLabelDataIds);
        sort($issueLabelDataIds);
        $issue['labels'] = $issueLabelDataIds;

        // 当前事项解决版本
        $model = new IssueFixVersionModel();
        $issueFixVersion = $model->getItemsByIssueId($issueId);
        $issueFixVersionIds = [];
        foreach ($issueFixVersion as $version) {
            $issueFixVersionIds[] = (int)$version['version_id'];
        }
        $issue['fix_version'] = $issueFixVersionIds;

        // 当前事项影响版本
        $model = new IssueEffectVersionModel();
        $issueEffectVersion = $model->getItemsByIssueId($issueId);
        $issueFixVersionIds = [];
        foreach ($issueEffectVersion as $version) {
            $issueFixVersionIds[] = (int)$version['version_id'];
        }
        $issue['effect_version'] = $issueFixVersionIds;

        // 如果提交项目id则返回该项目相关的 issue_type
        $data['issue_types'] = [];
        if (!empty($projectId) && $projectId != '') {
            $logic = new IssueTypeLogic();
            $data['issue_types'] = $logic->getIssueType($projectId);
        }

        $model = new IssueFileAttachmentModel();
        $attachmentDataArr = $model->getsByIssueId($issueId);
        $issue['attachment'] = [];
        foreach ($attachmentDataArr as $row) {
            $file = [];
            $file['thumbnailUrl'] = ATTACHMENT_URL . $row['file_name'];
            $file['size'] = $row['file_size'];
            $file['name'] = $row['origin_name'];
            $file['uuid'] = $row['uuid'];
            $issue['attachment'][] = $file;
        }
        unset($attachmentDataArr);

        // 通过状态流获取可以变更的状态
        $logic = new WorkflowLogic();
        $issue['allow_update_status'] = $logic->getStatusByIssue($issue);

        // 自定义字段
        $issueLogic = new IssueLogic();
        $customFieldValues = $issueLogic->getCustomFieldValue($issueId);
        if ($customFieldValues) {
            $customFieldValuesArr = array_column($customFieldValues, 'value', 'field_name');
            if ($customFieldValuesArr) {
                $issue = array_merge($customFieldValuesArr, $issue);
            }
        }


        // tab页面
        $model = new IssueUiTabModel($issueId);
        $data['tabs'] = $model->getItemsByIssueTypeIdType($issueTypeId, $uiType);

        IssueFilterLogic::formatIssue($issue);
        $data['issue'] = $issue;
        $this->ajaxSuccess('success', $data);
    }

    /**
     * 新增某一事项
     * @param array $params
     * @throws \Exception
     */
    public function add($params = [])
    {
        $uid = $this->getCurrentUid();
        //检测当前用户角色权限
        if (!isset($this->projectPermArr[PermissionLogic::CREATE_ISSUES])) {
            $this->ajaxFailed('当前项目中您没有权限进行此操作,需要创建事项权限');
        }
        $err = [];
        if (!isset($params['summary']) || empty(trimStr($params['summary']))) {
            $err['summary'] = '标题不能为空';
        }
        if (!isset($params['issue_type']) || empty(trimStr($params['issue_type']))) {
            $err['issue_type'] = '事项类型不能为空';
        }

        // 分发事件
        $event = new CommonPlacedEvent($this, $params);
        $this->dispatcher->dispatch($event, Events::onIssueCreateBefore);
        // 优先级 , @todo 数据库字段增加一个默认值，管理页面可以修改
        $getDefaultPriorityId = function () {
            return (new IssuePriorityModel())->getIdByKey('normal');
        };
        $priorityId = null;
        if (isset($params['priority'])) {
            $priorityId = (int)$params['priority'];
            $model = new IssuePriorityModel();
            $issuePriority = $model->getById($priorityId);
            if (!$issuePriority) {
                $priorityId = $getDefaultPriorityId();
            }
        } else {
            $priorityId = $getDefaultPriorityId();
        }

        // 事项UI配置判断输入是否为空
        $issueUiModel = new IssueUiModel();
        $fieldModel = new FieldModel();
        $fieldsArr = $fieldModel->getAll();
        $uiConfigs = $issueUiModel->getsByUiType($params['issue_type'], 'create');
        //print_r($uiConfigs);
        // 迭代字段不会判断输入
        $excludeFieldArr = ['sprint', 'priority'];
        foreach ($uiConfigs as $uiConfig) {
            if ($uiConfig['required'] && isset($fieldsArr[$uiConfig['field_id']])) {
                $field = $fieldsArr[$uiConfig['field_id']];
                $fieldName = $field['name'];
                if (in_array($fieldName, $excludeFieldArr)) {
                    continue;
                }
                if (!isset($params[$fieldName])) {
                    $err[$fieldName] = $field['title'] . '不能为空';
                }
                if (isset($params[$fieldName])) {
                    $tmpValue = $params[$fieldName];
                    if(is_string($tmpValue)){
                        $tmpValue = trimStr($tmpValue);
                    }
                    if(empty($tmpValue)){
                        $err[$fieldName] = $field['title'] . '不能为空';
                    }
                }
            }
        }

        if (!empty($err)) {
            $this->ajaxFailed('表单验证失败', $err, BaseCtrl::AJAX_FAILED_TYPE_FORM_ERROR);
        }

        $info = [];
        $info['summary'] = $params['summary'];
        $info['creator'] = $uid;
        $info['reporter'] = $uid;
        $info['created'] = time();
        $info['updated'] = time();

        // 所属项目
        $projectId = (int)$params['project_id'];
        if (!empty($_REQUEST['project_id'])) {
            $projectId = (int)$_REQUEST['project_id'];
        }

        $projectModel = new ProjectModel();
        $project = $projectModel->getById($projectId);
        if (!isset($project['id'])) {
            $this->ajaxFailed('项目参数错误');
        }
        $info['project_id'] = $projectId;

        // issue 类型
        $issueTypeId = (int)$params['issue_type'];
        $model = new IssueTypeModel();
        $issueTypes = $model->getAll();
        if (!isset($issueTypes[$issueTypeId])) {
            $this->ajaxFailed('事项类型参数错误');
        }
        unset($issueTypes);

        $info['issue_type'] = $issueTypeId;
        $info['priority'] = $priorityId;
        $info = $info + $this->getAddFormInfo($params);

        $model = new IssueModel();

        list($ret, $issueId) = $model->insert($info);
        if (!$ret) {
            $this->ajaxFailed('服务器执行错误,原因:' . $issueId);
        }
        $issueUpdateInfo = [];
        $issueUpdateInfo['pkey'] = $project['key'];
        $issueUpdateInfo['issue_num'] = $issueId;
        // print_r($params);
        if (isset($params['master_issue_id'])) {
            $masterId = (int)$params['master_issue_id'];
            $master = $model->getById($masterId);
            if (!empty($master)) {
                $issueLogic = new IssueLogic();
                list($ret, $msg) = $issueLogic->convertChild($issueId, $masterId);
                if($ret){
                    $info['id'] = $issueId;
                    $event = new CommonPlacedEvent($this, ['master' => $master, 'child' => $info]);
                    $this->dispatcher->dispatch($event, Events::onIssueCreateChild);
                }
            }
        }
        $model->updateById($issueId, $issueUpdateInfo);

        unset($project);
        //写入操作日志
        $logData = [];
        $logData['user_name'] = $this->auth->getUser()['username'];
        $logData['real_name'] = $this->auth->getUser()['display_name'];
        $logData['obj_id'] = $issueId;
        $logData['module'] = LogOperatingLogic::MODULE_NAME_ISSUE;
        $logData['page'] = $_SERVER['REQUEST_URI'];
        $logData['action'] = LogOperatingLogic::ACT_ADD;
        $logData['remark'] = '新增事项';
        $logData['pre_data'] = [];
        $logData['cur_data'] = $info;
        LogOperatingLogic::add($uid, $projectId, $logData);

        $issueLogic = new IssueLogic();
        // 协助人
        if (isset($params['assistants'])) {
            $issueLogic->addAssistants($issueId, $params['assistants']);
        }
        // fix version
        if (isset($params['fix_version'])) {
            $model = new IssueFixVersionModel();
            $issueLogic->addChildData($model, $issueId, $params['fix_version'], 'version_id');
        }
        // effect version
        if (isset($params['effect_version'])) {
            $model = new IssueEffectVersionModel();
            $issueLogic->addChildData($model, $issueId, $params['effect_version'], 'version_id');
        }
        // labels
        if (isset($params['labels'])) {
            $model = new IssueLabelDataModel();
            $issueLogic->addChildData($model, $issueId, $params['labels'], 'label_id');
        }
        // FileAttachment
        $this->updateFileAttachment($issueId, $params);
        // 自定义字段值
        // @todo这里表结构有bug需要测试
        $issueLogic->addCustomFieldValue($issueId, $projectId, $params);

        // 记录的最近的数据
        $lastData = [];
        $lastData['issue_type'] = $info['issue_type'];
        $lastData['module'] = isset($info['module']) ? $info['module'] : null;
        $lastData['assignee'] = $info['assignee'];
        $lastData['fix_version'] = null;
        if (isset($params['fix_version']) && is_array($params['fix_version'])) {
            $arr = [];
            foreach ($params['fix_version'] as $fixVersion) {
                if (!empty($fixVersion)) {
                    $arr[] = $fixVersion;
                }
            }
            $lastData['fix_version'] = $arr;
        }
        $lastData['labels'] = null;
        if (isset($params['labels']) && is_array($params['labels'])) {
            $arr = [];
            foreach ($params['labels'] as $label) {
                if (!empty($label)) {
                    $arr[] = $label;
                }
            }
            $lastData['labels'] = $arr;
        }
        $lastDataJson = json_encode($lastData);
        $userIssueLastCreateDataModel = new UserIssueLastCreateDataModel();
        $userIssueLastCreateDataModel->insertData($this->getCurrentUid(), $projectId, $lastDataJson);

        // email
        $notifyLogic = new NotifyLogic();
        $notifyLogic->send(NotifyLogic::NOTIFY_FLAG_ISSUE_CREATE, $projectId, $issueId);

        // 分发事件
        $info['id'] = $issueId;
        $event = new CommonPlacedEvent($this, $info);
        $this->dispatcher->dispatch($event, Events::onIssueCreateAfter);
        $this->ajaxSuccess('添加成功', $issueId);
    }

    private function getGanttInfo(&$params, &$info)
    {
        if (isset($params['start_date'])) {
            $info['start_date'] = $params['start_date'];
        }

        if (isset($params['due_date'])) {
            $info['due_date'] = $params['due_date'];
        }
        if (isset($params['gant_hide'])) {
            $info['gant_hide'] = (int)$params['gant_hide'];
        }

        if (isset($params['progress'])) {
            $info['progress'] = max(0, (int)$params['progress']);
        }

        if (isset($params['depends'])) {
            $info['depends'] = (int)$params['depends'];
        }

        if (isset($_GET['from_gantt']) && $_GET['from_gantt'] == '1') {
            if (isset($params['is_start_milestone'])) {
                $info['is_start_milestone'] = (int)$params['is_start_milestone'] > 0 ? 1 : 0;
            } else {
                $info['is_start_milestone'] = 0;
            }
            if (isset($params['is_end_milestone'])) {
                $info['is_end_milestone'] = (int)$params['is_end_milestone'] > 0 ? 1 : 0;
            } else {
                $info['is_end_milestone'] = 0;
            }
            // 如果是在某一事项之下,排序值是两个事项之间二分之一
            if (isset($params['below_id']) && !empty($params['below_id'])) {
                $belowIssueId = (int)$params['below_id'];
                $model = new IssueModel();
                $table = $model->getTable();
                $belowIssue = $model->getRow("gant_sprint_weight,sprint,master_id", ['id' => $belowIssueId]);
                $fieldWeight = 'gant_sprint_weight';
                $aboveWeight = (int)$belowIssue[$fieldWeight];
                $sprintId = $belowIssue['sprint'];
                $sql = "Select {$fieldWeight} From {$table} Where `$fieldWeight` < {$aboveWeight}  AND `sprint` = {$sprintId} Order by {$fieldWeight} DESC  limit 1";

                $nextWeight = (int)$model->getFieldBySql($sql);
                if (empty($nextWeight)) {
                    $nextWeight = 0;
                }
                $info[$fieldWeight] = max(0, $nextWeight + intval(($aboveWeight - $nextWeight) / 2));

                if (!empty($belowIssue['master_id'])) {
                    $params['master_issue_id'] = $belowIssue['master_id'];
                }
                // print_r($params);
                unset($model, $belowIssue);
            }
            // 如果是在某一事项之上,排序值是两个事项之间二分之一
            if (isset($params['above_id']) && !empty($params['above_id'])) {
                $aboveIssueId = (int)$params['above_id'];
                $model = new IssueModel();
                $table = $model->getTable();
                $aboveIssue = $model->getRow("gant_sprint_weight, sprint,master_id", ['id' => $aboveIssueId]);
                $fieldWeight = 'gant_sprint_weight';
                $belowWeight = (int)$aboveIssue[$fieldWeight];
                $sprintId = $aboveIssue['sprint'];
                $sql = "Select {$fieldWeight} From {$table} Where $fieldWeight>$belowWeight  AND sprint=$sprintId Order by {$fieldWeight} DESC limit 1";
                // echo $sql;
                $prevWeight = (int)$model->getFieldBySql($sql);
                if (empty($prevWeight)) {
                    $prevWeight = 0;
                }
                $info[$fieldWeight] = max(0, $belowWeight + intval(($prevWeight - $belowWeight) / 2));
                unset($model, $belowIssue);
            }
            // print_r($info);
        }
    }

    /**
     * @param array $params
     * @param $info
     * @throws \Doctrine\DBAL\DBALException
     */
    private function initAddGanttWeight($params, &$info)
    {
        // 如果是不在甘特图提交的
        $fieldWeight = 'gant_sprint_weight';
        $model = new IssueModel();
        $table = $model->getTable();
        $sprintId = 0;
        if (isset($params['sprint'])) {
            $sprintId = intval($params['sprint']);
        }
        if (@empty($params['above_id']) && @empty($params['below_id'])) {
            $model = new IssueModel();
            if (isset($params['master_issue_id']) && !empty($params['master_issue_id'])) {
                // 如果是子任务
                $masterId = (int)$params['master_issue_id'];
                $sql = "Select {$fieldWeight} From {$table} Where master_id={$masterId}  AND sprint={$sprintId} Order by {$fieldWeight} ASC limit 1";

                $prevWeight = (int)$model->getFieldBySql($sql);
                $sql = "Select {$fieldWeight} From {$table} Where $prevWeight>{$fieldWeight} AND sprint={$sprintId} Order by {$fieldWeight} DESC limit 1";
                //echo $sql;

                $nextWeight = (int)$model->getFieldBySql($sql);
                if (($prevWeight - $nextWeight) > (ProjectGantt::$offset * 2)) {
                    $info[$fieldWeight] = $prevWeight - ProjectGantt::$offset;
                } else {
                    $info[$fieldWeight] = max(0, intval($prevWeight - ($prevWeight - $nextWeight) / 2));
                }
            } else {
                // 如果是普通任务
                $sql = "Select {$fieldWeight} From {$table} Where   sprint={$sprintId} Order by {$fieldWeight} ASC limit 1";

                $minWeight = (int)$model->getFieldBySql($sql);
                if ($minWeight > (ProjectGantt::$offset * 2)) {
                    $info[$fieldWeight] = $minWeight - ProjectGantt::$offset;
                } else {
                    $info[$fieldWeight] = max(0, intval($minWeight / 2));
                }
            }

        }
    }

    /**
     * 取新增或编辑时提交上来的事项内容
     * @param array $params
     * @return array
     * @throws \Exception
     */
    private function getAddFormInfo(&$params = [])
    {
        $info = [];

        // 标题
        if (isset($params['summary'])) {

            $info['summary'] = htmlentities($params['summary']);
        }

        if (isset($params['issue_type'])) {
            $info['issue_type'] = (int)$params['issue_type'];
        } else {
            $issueTypeId = (new IssueTypeModel())->getIdByKey('task');
            $info['issue_type'] = $issueTypeId;
        }

        // 状态
        if (isset($params['status'])) {
            $statusId = (int)$params['status'];
            $model = new IssueStatusModel();
            $issueStatusArr = $model->getAll();
            if (!isset($issueStatusArr[$statusId])) {
                $this->ajaxFailed('param_error:status_not_found');
            }
            unset($issueStatusArr);
            $info['status'] = $statusId;
        } else {
            $statusId = (new IssueStatusModel())->getIdByKey('open');
            $info['status'] = $statusId;
        }

        // 解决结果, @todo 数据库字段增加一个默认值，管理页面可以修改
        $getDefaultResolveId = function () {
            $resolveId = (new IssueResolveModel())->getIdByKey('not_fix');
            $info['resolve'] = $resolveId;
            return $resolveId;
        };
        if (isset($params['resolve']) && !empty($params['resolve'])) {
            $resolveId = (int)$params['resolve'];
            $model = new IssueResolveModel();
            $issueResolves = $model->getAll();
            if (!isset($issueResolves[$resolveId])) {
                $resolveId = $getDefaultResolveId();
            }
            unset($issueResolves);
            $info['resolve'] = $resolveId;
        } else {
            $info['resolve'] = $getDefaultResolveId();
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
        } else {
            $info['assignee'] = UserAuth::getId();
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
            $info['reporter'] = $reporterUid;
        } else {
            $info['reporter'] = UserAuth::getId();
        }

        if (isset($params['description'])) {
            $info['description'] = $params['description'];
        } else {
            $info['description'] = '';
        }

        if (isset($params['module'])) {
            $info['module'] = $params['module'];
        }

        if (isset($params['environment'])) {

            $info['environment'] = htmlentities($params['environment']);
        }


        if (isset($params['milestone'])) {
            $info['milestone'] = (int)$params['milestone'];
        }

        if (array_key_exists('sprint', $params)) {
            $info['sprint'] = (int)$params['sprint'];
        }
        //print_r($info);
        if (isset($params['weight'])) {
            $info['weight'] = (int)$params['weight'];
        }
        $this->getGanttInfo($params, $info);
        if (!empty($params['start_date']) && !empty($params['due_date'])) {
            $holidays = (new HolidayModel())->getDays($params['project_id']);
            $extraWorkerDays = (new ExtraWorkerDayModel())->getDays($params['project_id']);
            $ganttSetting = (new ProjectGanttSettingModel())->getByProject($params['project_id']);
            $workDates = json_decode($ganttSetting['work_dates'], true);
            $info['duration'] = getWorkingDays($params['start_date'], $params['due_date'], $workDates, $holidays, $extraWorkerDays);
        }

        $this->initAddGanttWeight($params, $info);
        // print_r($info);
        return $info;
    }

    private function getUpdateFormInfo($params = [])
    {
        $info = [];
        // 标题
        if (isset($params['summary'])) {

            $info['summary'] = htmlentities($params['summary']);
        }

        if (isset($params['issue_type'])) {
            $info['issue_type'] = (int)$params['issue_type'];
        }

        // 状态
        if (isset($params['status'])) {
            $statusId = (int)$params['status'];
            $model = new IssueStatusModel();
            $issueStatusArr = $model->getAll();
            if (!isset($issueStatusArr[$statusId])) {
                $this->ajaxFailed('param_error:status_not_found');
            }
            unset($issueStatusArr);
            $info['status'] = $statusId;
        }

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
            $info['reporter'] = $reporterUid;
        }

        if (isset($params['description'])) {
            $info['description'] = $params['description'];
        }

        if (isset($params['module'])) {
            $info['module'] = $params['module'];
        }

        if (isset($params['environment'])) {

            $info['environment'] = htmlentities($params['environment']);
        }


        if (isset($params['milestone'])) {
            $info['milestone'] = (int)$params['milestone'];
        }

        if (isset($params['sprint'])) {
            $info['sprint'] = (int)$params['sprint'];
        }
        //print_r($info);
        if (isset($params['weight'])) {
            $info['weight'] = (int)$params['weight'];
        }

        $this->getGanttInfo($params, $info);
        // print_r($info);
        return $info;
    }

    /**
     * 更新事项的附件
     * @param $issueId
     * @param $params
     * @throws \Exception
     */
    private function updateFileAttachment($issueId, $params)
    {
        if (isset($params['attachment'])) {
            $model = new IssueFileAttachmentModel();
            $attachments = json_decode($params['attachment'], true);
            if (empty($attachments)) {
                $model->delete(['issue_id' => $issueId]);
            } else {
                foreach ($attachments as $file) {
                    $uuid = $file['uuid'];
                    $model->update(['issue_id' => $issueId], ['uuid' => $uuid]);
                }
            }
        }
    }

    /**
     * 更新事项的内容
     * @param $params
     * @throws \Exception
     */
    public function update($params)
    {
        // 如果是复制事项
        if (isset($_POST['form_type']) && $_POST['form_type'] == 'copy') {
            $this->add($params);
            return;
        }

        $issueId = null;
        // @todo 不使用 $_REQUEST 全局变量
        if (isset($_REQUEST['issue_id'])) {
            $issueId = (int)$_REQUEST['issue_id'];
        }
        if (empty($issueId)) {
            $this->ajaxFailed('参数错误', '事项id不能为空');
        }
        $uid = $this->getCurrentUid();

        $info = [];

        if (isset($params['summary'])) {

            $info['summary'] = htmlentities($params['summary']);
        }

        $info = $info + $this->getUpdateFormInfo($params);
        if (empty($info)) {
            $this->ajaxFailed('参数错误,数据为空');
        }

        $event = new CommonPlacedEvent($this, $_REQUEST);
        $this->dispatcher->dispatch($event, Events::onIssueUpdateBefore);

        $issueModel = new IssueModel();
        $issue = $issueModel->getById($issueId);
        $issueType = $issue['issue_type'];
        if (isset($params['issue_type'])) {
            $issueType = $params['issue_type'];
        }
        // 事项UI配置判断输入是否为空
        $issueUiModel = new IssueUiModel();
        $fieldModel = new FieldModel();
        $fieldsArr = $fieldModel->getAll();
        $uiConfigs = $issueUiModel->getsByUiType($issueType, 'edit');
        //print_r($uiConfigs);
        // 迭代字段不会判断输入
        $excludeFieldArr = ['sprint'];
        foreach ($uiConfigs as $uiConfig) {
            if ($uiConfig['required'] && isset($fieldsArr[$uiConfig['field_id']])) {
                $field = $fieldsArr[$uiConfig['field_id']];
                $fieldName = $field['name'];
                if (in_array($fieldName, $excludeFieldArr)) {
                    continue;
                }
                if (isset($info[$fieldName]) && isset($params[$fieldName]) && empty(trimStr($params[$fieldName]))) {
                    $err[$fieldName] = $field['title'] . '不能为空';
                }
            }
        }
        if (!empty($err)) {
            $this->ajaxFailed('表单验证失败', $err, BaseCtrl::AJAX_FAILED_TYPE_FORM_ERROR);
        }
        $updatePerm = PermissionLogic::check($issue['project_id'], UserAuth::getId(), PermissionLogic::EDIT_ISSUES);
        if (!$updatePerm) {
            $this->ajaxFailed('当前项目中您没有权限进行此操作,需要编辑事项权限');
        }


        $noModified = true;
        foreach ($info as $k => $v) {
            if ($v == $issue[$k]) {
                unset($info[$k]);
            }
        }
        /*
        if ($noModified) {
            //$this->ajaxSuccess('success');
        }
        */

        // 实例化邮件通知
        $notifyLogic = new NotifyLogic();
        $notifyFlag = NotifyLogic::NOTIFY_FLAG_ISSUE_UPDATE;

        $info['modifier'] = $uid;

        // 状态 如果是关闭状态则要检查权限
        if (isset($info['status']) && $issue['status'] != $info['status']) {
            //检测当前用户角色权限是否有修改事项状态的权限
            if (!PermissionLogic::check($issue['project_id'], UserAuth::getId(), PermissionLogic::EDIT_ISSUES_STATUS)) {
                $this->ajaxFailed('当前项目中您没有权限进行此操作,需要修改事项状态权限');
            }
            $notifyFlag = $notifyLogic->getEmailNotifyFlag($info['status']);
            $statusClosedId = IssueStatusModel::getInstance()->getIdByKey('closed');
            if ($info['status'] == $statusClosedId) {
                $closePerm = PermissionLogic::check($issue['project_id'], UserAuth::getId(), PermissionLogic::CLOSE_ISSUES);
                if (!$closePerm) {
                    $this->ajaxFailed('当前项目中您没有权限关闭状态');
                }
            }
        }

        // 解决结果 如果是关闭状态则要检查权限
        if (isset($info['resolve']) && $issue['resolve'] != $info['resolve']) {
            if (!PermissionLogic::check($issue['project_id'], UserAuth::getId(), PermissionLogic::EDIT_ISSUES_RESOLVE)) {
                $this->ajaxFailed('当前项目中您没有权限进行此操作,需要修改事项解决结果权限');
            }

            $resolve = IssueResolveModel::getInstance()->getByKey('done');
            $resolveDoneId = $resolve['id'];
            if ($info['resolve'] == $resolveDoneId) {
                $info['resolve_date'] = date('Y-m-d');
                $closePerm = PermissionLogic::check($issue['project_id'], UserAuth::getId(), PermissionLogic::CLOSE_ISSUES);
                if (!$closePerm) {
                    $this->ajaxFailed('当前项目中您没有权限将解决结果修改为:' . $resolve['name']);
                }
            }
        }
        list($ret, $affectedRows) = $issueModel->updateById($issueId, $info);
        if (!$ret) {
            $this->ajaxFailed('服务器错误', '更新数据失败,详情:' . $affectedRows);
        }
        // 更新用时
        if (isset($info['start_date']) || isset($info['due_date'])) {
            $holidays = (new HolidayModel())->getDays($issue['project_id']);
            $extraWorkerDays = (new ExtraWorkerDayModel())->getDays($issue['project_id']);
            $updatedIssue = $issueModel->getById($issueId);
            $updateDurationArr = [];
            $ganttSetting = (new ProjectGanttSettingModel())->getByProject($issue['project_id']);
            if (empty($ganttSetting)) {
                $workDates = null;
            } else {
                $workDates = json_decode($ganttSetting['work_dates'], true);
            }
            $updateDurationArr['duration'] = getWorkingDays($updatedIssue['start_date'], $updatedIssue['due_date'], $workDates, $holidays, $extraWorkerDays);
            // print_r($updateDurationArr);
            list($ret) = $issueModel->updateById($issueId, $updateDurationArr);
            if ($ret) {
                $updatedIssue['duration'] = $updateDurationArr['duration'];
            }
        }
        //写入操作日志
        $curIssue = $issue;
        foreach ($curIssue as $k => $v) {
            if (isset($info[$k])) {
                $curIssue[$k] = $info[$k];
            }
        }
        $issueLogic = new IssueLogic();
        // 协助人
        if (isset($params['assistants'])) {
            if (empty($params['assistants'])) {
                $issueLogic->emptyAssistants($issueId);
            } else {
                $issueLogic->updateAssistants($issueId, $params['assistants']);
            }
        }
        // fix version
        if (isset($params['fix_version'])) {
            $model = new IssueFixVersionModel();
            $model->delete(['issue_id' => $issueId]);
            $issueLogic->addChildData($model, $issueId, $params['fix_version'], 'version_id');
        }
        // effect version
        if (isset($params['effect_version'])) {
            $model = new IssueEffectVersionModel();
            $model->delete(['issue_id' => $issueId]);
            $issueLogic->addChildData($model, $issueId, $params['effect_version'], 'version_id');
        }
        // labels
        if (isset($params['labels'])) {
            $model = new IssueLabelDataModel();
            if (empty($params['labels'])) {
                $model->delete(['issue_id' => $issueId]);
            } else {
                $model->delete(['issue_id' => $issueId]);
                $issueLogic->addChildData($model, $issueId, $params['labels'], 'label_id');
            }
        }
        // FileAttachment
        $this->updateFileAttachment($issueId, $params);
        // 自定义字段值
        $issueLogic->updateCustomFieldValue($issueId, $params, $issue['project_id']);

        // 记录活动日志
        $fromModule = null;
        if (isset($params['from_module'])) {
            $fromModule = strtolower(trim($params['from_module']));
        } elseif (isset($_GET['from_module'])) {
            $fromModule = strtolower(trim($_GET['from_module']));
        }

        // 操作日志
        $logData = [];
        $logData['user_name'] = $this->auth->getUser()['username'];
        $logData['real_name'] = $this->auth->getUser()['display_name'];
        $logData['obj_id'] = $issueId;
        $logData['module'] = LogOperatingLogic::MODULE_NAME_ISSUE;
        $logData['page'] = $_SERVER['REQUEST_URI'];
        $logData['action'] = LogOperatingLogic::ACT_EDIT;
        $logData['remark'] = '修改事项';
        $logData['pre_data'] = $issue;
        $logData['cur_data'] = $curIssue;
        LogOperatingLogic::add($uid, $issue['project_id'], $logData);

        // email通知
        if (isset($notifyFlag)) {
            $notifyLogic->send($notifyFlag, $issue['project_id'], $issueId);
        }
        $updatedIssue = $issueModel->getById($issueId);
        $event = new CommonPlacedEvent($this, $updatedIssue);
        $this->dispatcher->dispatch($event, Events::onIssueUpdateAfter);
        $this->ajaxSuccess('更新成功', $updatedIssue);
    }


    /**
     * 批量修改
     * @param $params
     * @throws \Exception
     */
    public function batchUpdate($params)
    {
        // @todo 判断权限:全局权限和项目角色
        $issueIdArr = null;
        if (isset($_REQUEST['issue_id_arr'])) {
            $issueIdArr = $_REQUEST['issue_id_arr'];
        }
        if (empty($issueIdArr)) {
            $this->ajaxFailed('参数错误', '事项id数据不能为空');
        }

        $field = null;
        if (isset($_REQUEST['field'])) {
            $field = $_REQUEST['field'];
        }
        if (empty($field)) {
            $this->ajaxFailed('参数错误', 'field数据不能为空');
        }

        $value = null;
        if (isset($_REQUEST['value'])) {
            $value = (int)$_REQUEST['value'];
        }
        if (empty($field)) {
            $this->ajaxFailed('参数错误', 'value数据不能为空');
        }

        $uid = $this->getCurrentUid();
        $projectId = null;
        $issueModel = new IssueModel();
        foreach ($issueIdArr as $issueId) {
            $issue = $issueModel->getById($issueId);
            $projectId = $issue['project_id'];
            break;
        }
        // 是否有编辑权限
        $editPerm = PermissionLogic::check($projectId, UserAuth::getId(), PermissionLogic::EDIT_ISSUES);
        if (!$editPerm) {
            $this->ajaxFailed('当前项目中你没有权限进行此操作');
        }
        // 是否有关闭事项权限
        $statusClosedId = IssueStatusModel::getInstance()->getIdByKey('closed');
        $resolveDoneId = IssueResolveModel::getInstance()->getIdByKey('done');
        if (($field == 'status' && $value == $statusClosedId) || ($field == 'resolve' && $value == $resolveDoneId)) {
            $closePerm = PermissionLogic::check($projectId, UserAuth::getId(), PermissionLogic::CLOSE_ISSUES);
            if (!$closePerm) {
                $this->ajaxFailed('当前项目中你没有权限关闭该事项');
            }
        }
        $info = [];
        $successIssueIdArr = [];
        $errArr = [];
        foreach ($issueIdArr as $issueId) {
            $info[$field] = $value;
            list($ret, $affectedRows) = $issueModel->updateById($issueId, $info);
            if (!$ret) {
                //$this->ajaxFailed('服务器错误', '更新数据失败,详情:' . $affectedRows);
                $errArr[] = "事项id:{$issueId} 更新失败:{$affectedRows},已忽略";
            }
            $successIssueIdArr[] = $issueId;
        }

        // 操作日志
        $logData = [];
        $logData['user_name'] = $this->auth->getUser()['username'];
        $logData['real_name'] = $this->auth->getUser()['display_name'];
        $logData['obj_id'] = null;//json_encode($successIssueIdArr);
        $logData['module'] = LogOperatingLogic::MODULE_NAME_ISSUE;
        $logData['page'] = $_SERVER['REQUEST_URI'];
        $logData['action'] = LogOperatingLogic::ACT_EDIT;
        $logData['remark'] = '批量修改事项id:' . implode(',', $successIssueIdArr);
        $logData['pre_data'] = '-';
        $logData['cur_data'] = $value;
        LogOperatingLogic::add($uid, $issue['project_id'], $logData);

        $event = new CommonPlacedEvent($this, ['field' => $field, 'value' => $value, 'project_id' => $projectId, 'issue_id_arr' => $successIssueIdArr]);
        $this->dispatcher->dispatch($event, Events::onIssueBatchUpdate);
        $this->ajaxSuccess('success');
    }

    /**
     * @param $params
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Doctrine\DBAL\Exception\InvalidArgumentException
     * @throws \Exception
     */
    public function batchMoveProject($params)
    {
        // @todo 判断权限:全局权限和项目角色
        $issueIdArr = null;
        if (isset($_POST['issue_id_arr'])) {
            $issueIdArr = $_POST['issue_id_arr'];
        }
        if (empty($issueIdArr)) {
            $this->ajaxFailed('参数错误', '事项id数据不能为空');
        }
        $projectId = null;
        if (isset($_POST['project_id'])) {
            $projectId = $_POST['project_id'];
        }
        if (empty($projectId)) {
            $this->ajaxFailed('参数错误', '项目id数据不能为空');
        }

        $updateArr = [];
        $updateArr['project_id'] = $projectId;
        if (isset($_POST['module'])) {
            $updateArr['module'] = (int)$_POST['module'];
        }
        if (isset($_POST['sprint'])) {
            $updateArr['sprint'] = (int)$_POST['sprint'];
        }
        $updateLabelArr = [];
        if (isset($_POST['labels']) && empty($_POST['labels'])) {
            $updateLabelArr = $_POST['labels'];
        }
        $updateEffectVersionArr = [];
        if (isset($_POST['effect_version']) && empty($_POST['effect_version'])) {
            $updateEffectVersionArr = $_POST['effect_version'];
        }
        $updateFixVersionArr = [];
        if (isset($_POST['fix_version']) && empty($_POST['fix_version'])) {
            $updateFixVersionArr = $_POST['fix_version'];
        }
        $uid = $this->getCurrentUid();
        $project = (new ProjectModel())->getById($projectId);
        $issueModel = new IssueModel();
        $curProjectId = null;
        foreach ($issueIdArr as $issueId) {
            $issue = $issueModel->getById($issueId);
            $curProjectId = $issue['project_id'];
            break;
        }
        // 是否有编辑权限
        $editPerm = PermissionLogic::check($curProjectId, UserAuth::getId(), PermissionLogic::EDIT_ISSUES);
        if (!$editPerm) {
            $this->ajaxFailed('当前项目中你没有编辑权限进行此操作');
        }
        // 是否有编辑权限
        $targetEditPerm = PermissionLogic::check($projectId, UserAuth::getId(), PermissionLogic::EDIT_ISSUES);
        if (!$targetEditPerm) {
            $this->ajaxFailed('要移动的项目你没有编辑权限进行此操作');
        }

        $issueLogic = new IssueLogic();
        $successIssueIdArr = [];
        $errArr = [];
        foreach ($issueIdArr as $issueId) {
            $issue = $issueModel->getById($issueId);
            if (!empty($updateArr)) {
                list($ret, $affectedRows) = $issueModel->updateById($issueId, $updateArr);
                if (!$ret) {
                    $errArr[] = "事项id:{$issueId} 更新失败:{$affectedRows},已忽略";
                }
                $model = new IssueLabelDataModel();
                if (empty($updateLabelArr)) {
                    $model->delete(['issue_id' => $issueId]);
                } else {
                    $model->delete(['issue_id' => $issueId]);
                    $issueLogic->addChildData($model, $issueId, $updateLabelArr, 'label_id');
                }
                $model = new IssueEffectVersionModel();
                if (empty($updateEffectVersionArr)) {
                    $model->delete(['issue_id' => $issueId]);
                } else {
                    $model->delete(['issue_id' => $issueId]);
                    $issueLogic->addChildData($model, $issueId, $updateEffectVersionArr, 'version_id');
                }
                $model = new IssueFixVersionModel();
                if (empty($updateFixVersionArr)) {
                    $model->delete(['issue_id' => $issueId]);
                } else {
                    $model->delete(['issue_id' => $issueId]);
                    $issueLogic->addChildData($model, $issueId, $updateFixVersionArr, 'version_id');
                }
            }
            if(isset($_POST['is_delete_current']) && $_POST['is_delete_current']=='1'){
                $deletedRet = $issueModel->deleteItemById($issueId);
                if ($deletedRet) {
                    $this->deletedAfter($issueId, $issue);
                }
            }
            $successIssueIdArr[] = $issueId;
        }

        // 操作日志
        $logData = [];
        $logData['user_name'] = $this->auth->getUser()['username'];
        $logData['real_name'] = $this->auth->getUser()['display_name'];
        $logData['obj_id'] = null;//json_encode($successIssueIdArr);
        $logData['module'] = LogOperatingLogic::MODULE_NAME_ISSUE;
        $logData['page'] = $_SERVER['REQUEST_URI'];
        $logData['action'] = LogOperatingLogic::ACT_EDIT;
        $logData['remark'] = '批量移动事项:' . implode(',', $successIssueIdArr) . ' 至项目' . $project['name'];
        $logData['pre_data'] = '';
        $logData['cur_data'] = '';
        LogOperatingLogic::add($uid, $projectId, $logData);
        $childrenArr = [];
        $childrenArr['labels'] = $updateLabelArr;
        $childrenArr['effect_version'] = $updateEffectVersionArr;
        $childrenArr['fix_version'] = $updateFixVersionArr;

        $eventData = [
            'update_arr' => $updateArr,
            'children_arr' => $childrenArr,
            'source_project_id' => $curProjectId,
            'target_project_id' => $projectId,
            'issue_id_arr' => $successIssueIdArr
        ];
        // print_r($eventData);
        $event = new CommonPlacedEvent($this, $eventData);
        $this->dispatcher->dispatch($event, Events::onIssueBatchMoveProject);
        $this->ajaxSuccess('success');
    }

    /**
     * @param $issueId
     * @param array $issue
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Doctrine\DBAL\Exception\InvalidArgumentException
     * @throws \Exception
     */
    private function deletedAfter($issueId, $issue=[])
    {
        $issueModel = new IssueModel();
        if(empty($issue)){
            $issue = $issueModel->getById($issueId);
        }
        // 将子任务的关系清除
        $issueModel->update(['master_id' => '0'], ['master_id' => $issueId]);
        // 将父任务的 have_children 减 1
        if (!empty($issue['master_id'])) {
            $masterId = $issue['master_id'];
            $issueModel->dec('have_children', $masterId, 'id', 1);
        }
        // 删除附件
        $issueFileModel = new IssueFileAttachmentModel();
        $issueFilesRows = $issueFileModel->getsByIssueId($issueId);
        foreach ($issueFilesRows as $issueFilesRow) {
            $fileName = $issueFilesRow['file_name'];
            if(strpos($fileName,'?')!==false){
                list($fileName) = explode('?', $fileName);
            }
            if(file_exists(PUBLIC_PATH.'attachment/'.$fileName)){
                @unlink(PUBLIC_PATH.'attachment/'.$fileName);
            }
            $issueFileModel->deleteById($issueFilesRow['id']);
        }
        // 删除标签数据
        $labelDataModel = new IssueLabelDataModel();
        $labelDataModel->deleteItemByIssueId($issueId);
        unset($issue['id']);
        $issue['delete_user_id'] = $this->getCurrentUid();
        $issueRecycleModel = new IssueRecycleModel();
        $info = [];
        $info['issue_id'] = $issueId;
        $info['project_id'] = $issue['project_id'];
        $info['delete_user_id'] = $this->getCurrentUid();
        $info['summary'] = $issue['summary'];
        $info['data'] = json_encode($issue);
        $info['time'] = time();
        $issueRecycleModel->insert($info);
        unset($info);
    }

    /**
     * 当前用户关注某一事项
     * @throws \Exception
     */
    public function follow()
    {
        $issueId = null;
        if (isset($_GET['_target'][2])) {
            $issueId = (int)$_GET['_target'][2];
        }
        if (isset($_GET['issue_id'])) {
            $issueId = (int)$_GET['issue_id'];
        }
        if (empty($issueId)) {
            $this->ajaxFailed('参数错误', '事项id不能为空');
        }
        if (empty(UserAuth::getId())) {
            $this->ajaxFailed('提示', '您尚未登录', BaseCtrl::AJAX_FAILED_TYPE_TIP);
        }

        $model = new IssueFollowModel();
        $ret = $model->add($issueId, UserAuth::getId());
        if ($ret[0]) {
            $issueLogic = new IssueLogic();
            $issueLogic->updateFollowCount($issueId);
        }

        $issueModel = new IssueModel();
        $issue = $issueModel->getById($issueId);
        $event = new CommonPlacedEvent($this, $issue);
        $this->dispatcher->dispatch($event, Events::onIssueFollow);
        $this->ajaxSuccess('success', $ret);
    }

    /**
     * 当前用户取消关注某一事项
     * @throws \Exception
     */
    public function unFollow()
    {
        $issueId = null;
        if (isset($_GET['_target'][2])) {
            $issueId = (int)$_GET['_target'][2];
        }
        if (isset($_GET['issue_id'])) {
            $issueId = (int)$_GET['issue_id'];
        }
        if (empty($issueId)) {
            $this->ajaxFailed('参数错误', '事项id不能为空');
        }
        if (empty(UserAuth::getId())) {
            $this->ajaxFailed('提示', '您尚未登录', BaseCtrl::AJAX_FAILED_TYPE_TIP);
        }
        $model = new IssueFollowModel();
        $ret = (int)$model->deleteItemByIssueUserId($issueId, UserAuth::getId());

        if ($ret > 0) {
            $issueLogic = new IssueLogic();
            $issueLogic->updateFollowCount($issueId);
        }

        $event = new CommonPlacedEvent($this, $issueId);
        $this->dispatcher->dispatch($event, Events::onIssueUnFollow);

        $this->ajaxSuccess('success');
    }

    /**
     * 获取子任务事项
     * @throws \Exception
     */
    public function getChildIssues()
    {
        // $uid = $this->getCurrentUid();
        //检测当前用户角色权限
        //$checkPermission = Permission::getInstance( $uid ,'DELETE_ISSUES' )->check();
        //if( !$checkPermission )
        // {
        //$this->ajaxFailed(Permission::$errorMsg);
        //}
        $issueId = null;
        if (isset($_GET['_target'][2])) {
            $issueId = (int)$_GET['_target'][2];
        }
        if (isset($_GET['issue_id'])) {
            $issueId = (int)$_GET['issue_id'];
        }
        if (empty($issueId)) {
            $this->ajaxFailed('参数错误', '事项id不能为空');
        }
        $issueLogic = new IssueLogic();
        $data['children'] = $issueLogic->getChildIssue($issueId);

        $this->ajaxSuccess('ok', $data);
    }

    /**
     * 删除事项，并进入回收站
     * @throws \Exception
     */
    public function delete()
    {
        $issueId = null;
        if (isset($_POST['issue_id'])) {
            $issueId = (int)$_POST['issue_id'];
        }
        if (empty($issueId)) {
            $this->ajaxFailed('参数错误', '事项id不能为空');
        }

        $issueModel = new IssueModel();
        $issue = $issueModel->getById($issueId);
        if (empty($issue)) {
            $this->ajaxFailed('参数错误', '事项不存在');
        }
        $deletePerm = PermissionLogic::check($issue['project_id'], UserAuth::getId(), PermissionLogic::DELETE_ISSUES);
        if (!$deletePerm) {
            $this->ajaxFailed('您没有权限进行此操作,需要删除事项权限');
        }

        try {
            $issueModel->db->beginTransaction();
            $ret = $issueModel->deleteById($issueId);
            if ($ret) {
                $this->deletedAfter($issueId, $issue);
            }
            $issueModel->db->commit();
        } catch (\PDOException $e) {
            $issueModel->db->rollBack();
            $this->ajaxFailed('服务器错误', '数据库异常,详情:' . $e->getMessage());
        }
        $issue['id'] = $issueId;
        $event = new CommonPlacedEvent($this, $issue);
        $this->dispatcher->dispatch($event, Events::onIssueDelete);
        $this->ajaxSuccess('ok');
    }

    /**
     * 批量删除
     * @throws \Exception
     */
    public function batchDelete()
    {
        $issueIdArr = null;
        if (isset($_REQUEST['issue_id_arr'])) {
            $issueIdArr = $_REQUEST['issue_id_arr'];
        }
        if (empty($issueIdArr)) {
            $this->ajaxFailed('参数错误', '事项id数据不能为空');
        }
        $issueModel = new IssueModel();
        $userId = $this->getCurrentUid();
        $projectId = null;
        foreach ($issueIdArr as $issueId) {
            $issue = $issueModel->getById($issueId);
            $projectId = $issue['project_id'];
            break;
        }
        // 是否有编辑权限
        $deletePerm = PermissionLogic::check($projectId, $userId, PermissionLogic::DELETE_ISSUES);
        if (!$deletePerm) {
            $this->ajaxFailed('当前项目中你没有删除事项的权限');
        }

        $issueNames = '';
        try {
            $issueLogic = new IssueLogic();
            $issueIds = implode(',', $issueIdArr);
            $issueNames = $issueLogic->getIssueSummary($issueIds);
            $issueModel->db->beginTransaction();
            foreach ($issueIdArr as $issueId) {
                $issue = $issueModel->getById($issueId);
                if (empty($issue)) {
                    continue;
                }
                $ret = $issueModel->deleteById($issueId);
                if ($ret) {
                    $this->deletedAfter($issueId, $issue);
                }
            }
            $issueModel->db->commit();
        } catch (\PDOException $e) {
            $issueModel->db->rollBack();
            $this->ajaxFailed('服务器错误', '数据库异常,详情:' . $e->getMessage());
        }


        // 分发事件
        $event = new CommonPlacedEvent($this, ['title' => $issueNames, 'project_id' => $projectId, 'issue_id_arr' => $issueIdArr]);
        $this->dispatcher->dispatch($event, Events::onIssueBatchDelete);
        $this->ajaxSuccess('ok');
    }

    /**
     * 关闭事项
     * @throws \Exception
     */
    public function close()
    {
        $issueId = null;
        if (isset($_POST['issue_id'])) {
            $issueId = (int)$_POST['issue_id'];
        }
        if (empty($issueId)) {
            $this->ajaxFailed('参数错误', '事项id不能为空');
        }
        $issueModel = new IssueModel();
        $issue = $issueModel->getById($issueId);
        if (empty($issue)) {
            $this->ajaxFailed('参数错误', '事项不存在');
        }
        $info = [];
        $info['status'] = IssueStatusModel::getInstance()->getIdByKey('closed');
        $info['resolve'] = IssueResolveModel::getInstance()->getIdByKey('done');
        $info['resolve_date'] = date('Y-m-d');

        $closePerm = PermissionLogic::check($issue['project_id'], UserAuth::getId(), PermissionLogic::CLOSE_ISSUES);
        if (!$closePerm) {
            $this->ajaxFailed('当前项目中你没有权限关闭该事项');
        }

        $issue['status'] = intval($issue['status']);
        $issue['resolve'] = intval($issue['resolve']);
        if ($issue['status'] == $info['status'] && $issue['resolve'] == $info['resolve']) {
            $this->ajaxSuccess("操作成功，但该事项已处于关闭状态");
        }

        list($ret, $msg) = $issueModel->updateItemById($issueId, $info);
        if (!$ret) {
            $this->ajaxFailed('服务器错误', '数据库异常,详情:' . $msg);
        } else {
            // 分发事件
            $event = new CommonPlacedEvent($this, $issueId);
            $this->dispatcher->dispatch($event, Events::onIssueClose);
            $this->ajaxSuccess("操作成功");
        }
    }


    /**
     * 转化为子任务
     * @throws \Exception
     */
    public function convertChild()
    {
        $issueId = null;
        if (isset($_POST['issue_id'])) {
            $issueId = (int)$_POST['issue_id'];
        }
        if (empty($issueId)) {
            $this->ajaxFailed('参数错误', '事项id不能为空');
        }

        $masterId = null;
        if (isset($_POST['master_id'])) {
            $masterId = (int)$_POST['master_id'];
        }
        if (empty($masterId)) {
            $this->ajaxFailed('参数错误', '父事项id不能为空');
        }
        $issueModel = new IssueModel();
        $masterIssue = $issueModel->getById($masterId);

        $secondType = null;
        if (isset($_POST['second_type'])) {
            $secondType = $_POST['second_type'];
        }

        $issueLogic = new IssueLogic();
        list($ret, $msg) = $issueLogic->convertChild($issueId, $masterId, $secondType);
        if (!$ret) {
            $this->ajaxFailed('服务器错误', '数据库异常,详情:' . $msg);
        } else {
            $event = new CommonPlacedEvent($this, ['master_id' => $masterId, 'issue_id' => $issueId]);
            $this->dispatcher->dispatch($event, Events::onIssueConvertChild);
            $this->ajaxSuccess($msg);
        }
    }

    /**
     * 事项不再是子任务
     * @throws \Exception
     */
    public function removeChild()
    {
        $issueId = null;
        if (isset($_POST['issue_id'])) {
            $issueId = (int)$_POST['issue_id'];
        }
        if (empty($issueId)) {
            $this->ajaxFailed('参数错误', '事项id不能为空');
        }

        $issueLogic = new IssueLogic();
        list($ret, $msg) = $issueLogic->removeChild($issueId);
        if (!$ret) {
            $this->ajaxFailed('服务器错误', '数据库异常,详情:' . $msg);
        } else {
            $event = new CommonPlacedEvent($this, $issueId);
            $this->dispatcher->dispatch($event, Events::onIssueRemoveChild);
            $this->ajaxSuccess($msg);
        }
    }


    /**
     * 粘贴上传图片的接口
     */
    public function pasteUpload()
    {
        $base64 = file_get_contents("php://input");

        $ymd = date("Ymd");
        $userId = UserAuth::getId();
        $saveRet = UploadLogic::saveFileText($base64, PUBLIC_PATH . 'attachment/image/' . $ymd . '/', $userId);
        $url = '';
        if ($saveRet !== false) {
            $url = '/attachment/image/' . $ymd . '/' . $saveRet;
        }
        $data['md_text'] = '![' . $saveRet . '](' . $url . ' "截图-' . $saveRet . '")';
        $data['file_name'] = $saveRet;
        $data['url'] = ROOT_URL . $url;
        $this->ajaxSuccess('ok', $data);
        //echo $url . '  尺寸为：533 * 387';
    }

    /**
     * 处理前端提交的导入excel
     * @throws \Exception
     */
    public function importExcel()
    {
        //检测当前用户角色权限
        // print_r($this->projectPermArr);
        if (!$this->isAdmin) {
            if (!isset($this->projectPermArr[PermissionLogic::IMPORT_EXCEL])) {
                $this->ajaxFailed('当前项目中您没有权限进行此操作,需要导入事项权限');
            }
        }
        $filename = null;
        $projectId = null;
        if (isset($_REQUEST['project_id']) && !empty($_REQUEST['project_id'])) {
            $projectId = (int)$_REQUEST['project_id'];
        }
        if (empty($projectId)) {
            $this->ajaxFailed('参数错误', '项目id不能为空');
        }

        if (empty($_FILES['import_excel_file'])) {
            $this->ajaxFailed('上传错误', '文件不能为空');
        }
        $originName = $_FILES['import_excel_file']['name'];
        $fileSize = (int)$_FILES['import_excel_file']['size'];

        $uploadLogic = new UploadLogic();
        $ret = $uploadLogic->move('import_excel_file', 'file', '', $originName, $fileSize);
        if (!empty($ret['error'])) {
            $this->ajaxFailed('上传错误', $ret['message']);
        }
        $filename = PUBLIC_PATH . 'attachment/' . $ret['relate_path'];
        //var_dump($filename);
        if (empty($filename) || !file_exists($filename)) {
            $this->ajaxFailed('参数错误', '找不到上传文件');
        }
        $issueLogic = new IssueLogic();
        error_reporting(E_ERROR);
        list($ret, $successRows, $errArr) = $issueLogic->importExcel($projectId, $filename);
        if ($ret) {
            @unlink($filename);
            $successText = '成功导入事项共 ' . count($successRows) . '条,细节如下:<br>';
            foreach ($successRows as $successRow) {
                $successText .= "第" . $successRow['cell'] . '行: ' . $successRow['summary'] . '<br>';
            }
            $event = new CommonPlacedEvent($this, $successRows);
            $this->dispatcher->dispatch($event, Events::onIssueImportByExcel);
            $this->ajaxSuccess('导入成功', $successText);
        } else {
            $errText = '';
            foreach ($errArr as $line => $err) {
                $errText .= "第" . $line . '行: ' . $err . '<br>';
            }
            $this->ajaxFailed('导入失败', $errText);
        }
    }

    /**
     * @throws \Exception
     */
    public function getProjectRelateData()
    {
        $projectId = isset($_GET['project_id']) ? (int)$_GET['project_id'] : null;
        $data['project_id'] = $projectId;
        ConfigLogic::getAllConfigs($data);
        $this->ajaxSuccess('ok', $data);
    }

}