<?php

namespace main\app\ctrl;

use main\app\classes\ProjectLogic;
use main\app\model\OrgModel;
use main\app\model\project\ProjectModel;
use main\app\classes\UserLogic;
use main\app\classes\SettingsLogic;
use main\app\classes\ConfigLogic;
use main\app\model\user\UserModel;
use main\app\classes\UploadLogic;
use main\lib\MySqlDump;

class Projects extends BaseUserCtrl
{

    public function __construct()
    {
        parent::__construct();
        parent::addGVar('top_menu_active', 'project');
    }

    /**
     * index
     */
    public function index()
    {
        $data = [];
        $data['title'] = '项目';
        $data['sub_nav_active'] = 'project';

        $dataKey = array(
            'count',
            'display_name'
        );

        $outProjectTypeList = [];
        $projectModel = new ProjectModel();
        $projectTypeAndCount = $projectModel->getAllProjectTypeCount();
        foreach ($projectTypeAndCount as $key => $value) {
            switch ($key) {
                case 'WHOLE':
                    $outProjectTypeList[0] = array_combine($dataKey, [$value, '全部']);
                    break;
                case 'SCRUM':
                    $outProjectTypeList[ProjectLogic::PROJECT_TYPE_SCRUM] =
                    array_combine($dataKey, [$value, ProjectLogic::$typeAll[ProjectLogic::PROJECT_TYPE_SCRUM]]);
                    break;
                case 'KANBAN':
                    $outProjectTypeList[ProjectLogic::PROJECT_TYPE_KANBAN] =
                    array_combine($dataKey, [$value, ProjectLogic::$typeAll[ProjectLogic::PROJECT_TYPE_KANBAN]]);
                    break;
                case 'SOFTWARE_DEV':
                    $outProjectTypeList[ProjectLogic::PROJECT_TYPE_SOFTWARE_DEV] =
                    array_combine($dataKey, [$value, ProjectLogic::$typeAll[ProjectLogic::PROJECT_TYPE_SOFTWARE_DEV]]);
                    break;
                case 'PROJECT_MANAGE':
                    $outProjectTypeList[ProjectLogic::PROJECT_TYPE_PROJECT_MANAGE] =
                    array_combine($dataKey, [$value, ProjectLogic::$typeAll[ProjectLogic::PROJECT_TYPE_PROJECT_MANAGE]]);
                    break;
                case 'FLOW_MANAGE':
                    $outProjectTypeList[ProjectLogic::PROJECT_TYPE_FLOW_MANAGE] =
                    array_combine($dataKey, [$value, ProjectLogic::$typeAll[ProjectLogic::PROJECT_TYPE_FLOW_MANAGE]]);
                    break;
                case 'TASK_MANAGE':
                    $outProjectTypeList[ProjectLogic::PROJECT_TYPE_TASK_MANAGE] =
                    array_combine($dataKey, [$value, ProjectLogic::$typeAll[ProjectLogic::PROJECT_TYPE_TASK_MANAGE]]);
                    break;
            }
        }

        $data['type_list'] = $outProjectTypeList;
        ConfigLogic::getAllConfigs($data);
        $this->render('gitlab/project/main.php', $data);
    }

    public function fetchAll($typeId = 0)
    {
        $typeId = intval($typeId);
        $projectModel = new ProjectModel();
        if($typeId){
            $projects = $projectModel->filterByType($typeId, false);
        }else{
            $projects = $projectModel->getAll(false);
        }

        $model = new OrgModel();
        $originsMap = $model->getMapIdAndPath();
        $types = ProjectLogic::$typeAll;
        foreach ($projects as &$item) {
            $item['type_name'] = isset($types[$item['type']]) ? $types[$item['type']] : '--';
            $item['path'] = isset($originsMap[$item['org_id']]) ? $originsMap[$item['org_id']] : 'default';
            $item['create_time_text'] = format_unix_time($item['create_time'], time());
            $item['create_time_origin'] = date('y-m-d H:i:s', $item['create_time']);
            $item['first_word'] = mb_substr(ucfirst($item['name']), 0, 1, 'utf-8');
            $item['bg_color'] = mapKeyColor($item['key']);
            list($item['avatar'], $item['avatar_exist']) = ProjectLogic::formatAvatar($item['avatar']);
        }

        $userLogic = new UserLogic();
        $data['users'] = $userLogic->getAllNormalUser();
        unset($userLogic, $item);

        $data['projects'] = $projects;
        $this->ajaxSuccess('success', $data);
    }


    public function create($params=array())
    {
        if(empty($params)){
            $this->ajaxFailed('param_error');
        }

        $uid = $this->getCurrentUid();
        $projectModel = new ProjectModel($uid);
        if (isset($params['name']) && empty(trimStr($params['name']))) {
            $this->ajaxFailed('param_error:name_is_null');
        }

        $maxLengthProjectName = (new SettingsLogic)->maxLengthProjectName();
        if (strlen($params['name']) > $maxLengthProjectName) {
            $this->ajaxFailed('param_error:name_length>' . $maxLengthProjectName);
        }
        if (isset($params['org_id']) && empty(trimStr($params['org_id']))) {
            $this->ajaxFailed('param_error:org_is_null');
        }

        if (isset($params['key']) && empty(trimStr($params['key']))) {
            $this->ajaxFailed('param_error:key_is_null');
        }
        $maxLengthProjectKey = (new SettingsLogic)->maxLengthProjectKey();
        if (strlen($params['key']) > $maxLengthProjectKey) {
            $this->ajaxFailed('param_error:key_length>' . $maxLengthProjectKey);
        }

        if (intval($params['lead']) <= 0) {
            $this->ajaxFailed('请选择项目负责人');
        }

        if(empty(( UserModel::getInstance())->getByUid($params['lead']) )){
            $this->ajaxFailed('该用户不存在');
        }

        if (isset($params['type']) && empty(trimStr($params['type']))) {
            $this->ajaxFailed('param_error:type_is_null');
        }

        if ($projectModel->checkNameExist($params['name'])) {
            $this->ajaxFailed('param_error:name_exist');
        }
        if ($projectModel->checkKeyExist($params['key'])) {
            $this->ajaxFailed('param_error:key_exist');
        }

        if (!preg_match("/^[a-zA-Z\s]+$/", $params['key'])) {
            $this->ajaxFailed('param_error:must_be_abc');
        }

        if (strlen($params['key']) > 20) {
            $this->ajaxFailed('param_error:key_max_20');
        }
        $params['key'] = mb_strtoupper(trimStr($params['key']));
        $params['name'] = trimStr($params['name']);
        $params['type'] = intval($params['type']);

        if (!isset($params['lead']) || empty($params['lead'])) {
            $params['lead'] = $uid;
        }

        $info = [];
        $info['name'] = $params['name'];
        $info['org_id'] = $params['org_id'];
        $info['key'] = $params['key'];
        $info['lead'] = $params['lead'];
        $info['description'] = $params['description'];
        $info['type'] = $params['type'];
        $info['category'] = 0;
        $info['url'] = $params['url'];
        $info['create_time'] = time();
        $info['create_uid'] = $uid;
        //$info['avatar'] = !empty($avatar) ? $avatar : "";

        $ret = $projectModel->addProject($info, $uid);
        //$ret['errorCode'] = 0;
        $orgModel = new OrgModel();
        $orgInfo = $orgModel->getById($params['org_id']);
        $final = array(
            'key' => $params['key'],
            'org_name' => $orgInfo['name'],
            'path' => $orgInfo['path'].'/'.$params['key'],
        );
        if (!$ret['errorCode']) {
            $this->ajaxSuccess('success', $final);
        } else {
            $this->ajaxFailed('add_failed:' . $ret['msg']);
        }
    }


    /**
     * 项目的上传文件接口
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

    public function test()
    {
        echo (new SettingsLogic)->dateTimezone();
    }




}
