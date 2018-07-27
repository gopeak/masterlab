<?php
/**
 * Created by PhpStorm.
 */

namespace main\app\ctrl\project;

use main\app\classes\UserLogic;
use main\app\ctrl\Agile;
use main\app\ctrl\issue\Main as IssueMain;
use main\app\classes\ProjectLogic;
use main\app\classes\RewriteUrl;
use main\app\model\project\ProjectIssueTypeSchemeDataModel;
use main\app\model\project\ProjectLabelModel;
use main\app\model\project\ProjectModel;
use main\app\model\project\ProjectVersionModel;
use main\app\model\project\ProjectModuleModel;
use main\app\classes\SettingsLogic;

/**
 * 项目
 */
class Main extends Base
{
    public function __construct()
    {
        parent::__construct();
        parent::addGVar('top_menu_active', 'project');
    }

    public function index()
    {
        $projectModel = new ProjectModel();
        $list = $projectModel->getAll();
        //dump($list);
        $data = [];
        $data['list'] = $list;
        $data['title'] = '浏览 项目';
        $data['sub_nav_active'] = 'project';
        ConfigLogic::getAllConfigs($data);
        $this->render('gitlab/project/main.php', $data);
    }

    public function _new()
    {
        $userLogic = new UserLogic();
        $users = $userLogic->getAllNormalUser();
        $data = [];
        $data['title'] = '项目分类';
        $data['sub_nav_active'] = 'project';
        $data['users'] = $users;

        $data['full_type'] = ProjectLogic::faceMap();


        $data['project_name_max_length'] = (new SettingsLogic)->maxLengthProjectName();
        $data['project_key_max_length'] = (new SettingsLogic)->maxLengthProjectKey();

        $this->render('gitlab/project/main_form.php', $data);
    }

    public function home()
    {
        $projectModel = new ProjectModel();
        $projectName = $projectModel->getNameById($_GET[ProjectLogic::PROJECT_GET_PARAM_ID]);

        $data = [];
        $data['title'] = $projectName['name'];
        $data['nav_links_active'] = 'home';
        $data['sub_nav_active'] = 'profile';
        $data['scrolling_tabs'] = 'home';
        $data = RewriteUrl::setProjectData($data);

        $this->render('gitlab/project/home.php', $data);
    }


    public function profile()
    {
        $this->home();
    }

    public function issueType()
    {
        $projectLogic = new ProjectLogic();
        $list = $projectLogic->typeList($_GET[ProjectLogic::PROJECT_GET_PARAM_ID]);

        $projectModel = new ProjectModel();
        $projectName = $projectModel->getNameById($_GET[ProjectLogic::PROJECT_GET_PARAM_ID]);

        $data = [];
        $data['title'] =  '事项类型 - ' . $projectName['name'];
        $data['nav_links_active'] = 'home';
        $data['sub_nav_active'] = 'issue_type';
        $data['scrolling_tabs'] = 'home';

        $data['list'] = $list;
        $data = RewriteUrl::setProjectData($data);

        $this->render('gitlab/project/issue_type.php', $data);
    }

    public function version()
    {
        $projectModel = new ProjectModel();
        $projectName = $projectModel->getNameById($_GET[ProjectLogic::PROJECT_GET_PARAM_ID]);

        $data = [];
        $data['title'] =  '版本 - ' . $projectName['name'];
        $data['nav_links_active'] = 'home';
        $data['sub_nav_active'] = 'version';
        $data['scrolling_tabs'] = 'home';

        $data['query_str'] = http_build_query($_GET);
        $data = RewriteUrl::setProjectData($data);

        $this->render('gitlab/project/version.php', $data);
    }

    public function module()
    {
        $userLogic = new UserLogic();
        $users = $userLogic->getAllNormalUser();

        $projectModuleModel = new ProjectModuleModel();
        $count = $projectModuleModel->getAllCount($_GET[ProjectLogic::PROJECT_GET_PARAM_ID]);

        $projectModel = new ProjectModel();
        $projectName = $projectModel->getNameById($_GET[ProjectLogic::PROJECT_GET_PARAM_ID]);

        $data = [];
        $data['title'] = '模块 - ' . $projectName['name'];
        $data['nav_links_active'] = 'home';
        $data['sub_nav_active'] = 'module';
        $data['users'] = $users;
        $data['query_str'] = http_build_query($_GET);
        $data['count'] = $count;

        $data = RewriteUrl::setProjectData($data);


        $this->render('gitlab/project/module.php', $data);
    }

    /**
     * 跳转至事项页面
     */
    public function issues()
    {
        $issueMainCtrl = new IssueMain();
        $issueMainCtrl->index();
    }

    /**
     * backlog页面
     */
    public function backlog()
    {
        $agileCtrl = new Agile();
        $agileCtrl->backlog();
    }

    /**
     * Sprints页面
     */
    public function sprints()
    {
        $agileCtrl = new Agile();
        $agileCtrl->sprint();
    }

    /**
     * Kanban页面
     */
    public function kanban()
    {
        $agileCtrl = new Agile();
        $agileCtrl->board();
    }

    /**
     * 设置页面
     */
    public function settings()
    {
        $this->settingsProfile();
    }

    public function settingsProfile()
    {
        if (isPost()) {
            $params = $_POST['params'];
            $uid = $this->getCurrentUid();
            $projectModel = new ProjectModel($uid);

            if (isset($params['type']) && empty(trimStr($params['type']))) {
                $this->ajaxFailed('param_error:type_is_null');
            }

            $params['type'] = intval($params['type']);

            if (!isset($params['lead']) || empty($params['lead'])) {
                $params['lead'] = $uid;
            }

            $info = [];
            $info['lead'] = $params['lead'];
            $info['description'] = $params['description'];
            $info['type'] = $params['type'];
            $info['category'] = 0;
            $info['url'] = $params['url'];

            $ret = $projectModel->update($info, array("id" => $_GET[ProjectLogic::PROJECT_GET_PARAM_ID]));
            if ($ret[0]) {
                $this->ajaxSuccess("success");
            } else {
                $this->ajaxFailed('failed', array(), 500);
            }
            return;
        }

        $userLogic = new UserLogic();
        $users = $userLogic->getAllNormalUser();
        $projectModel = new ProjectModel();
        $info = $projectModel->getById($_GET[ProjectLogic::PROJECT_GET_PARAM_ID]);

        $data = [];
        $data['title'] = '设置';
        $data['nav_links_active'] = 'setting';
        $data['sub_nav_active'] = 'basic_info';

        $data['users'] = $users;
        $data['info'] = $info;


        $data['full_type'] = ProjectLogic::faceMap();


        $data = RewriteUrl::setProjectData($data);

        $this->render('gitlab/project/setting_basic_info.php', $data);
    }


    public function settingsIssueType()
    {
        $projectLogic = new ProjectLogic();
        $list = $projectLogic->typeList($_GET[ProjectLogic::PROJECT_GET_PARAM_ID]);

        $data = [];
        $data['title'] = '事项类型';
        $data['nav_links_active'] = 'setting';
        $data['sub_nav_active'] = 'issue_type';

        $data['list'] = $list;

        $data = RewriteUrl::setProjectData($data);

        $this->render('gitlab/project/setting_issue_type.php', $data);
    }

    public function settingsVersion()
    {
        $projectVersionModel = new ProjectVersionModel();
        //$list = $projectVersionModel->getByProject($_GET[ProjectLogic::PROJECT_GET_PARAM_ID]);
        $data = [];
        $data['title'] = '版本';
        $data['nav_links_active'] = 'setting';
        $data['sub_nav_active'] = 'version';

        $data['query_str'] = http_build_query($_GET);

        $data = RewriteUrl::setProjectData($data);

        $this->render('gitlab/project/setting_version.php', $data);
    }

    public function settingsModule()
    {
        $userLogic = new UserLogic();
        $users = $userLogic->getAllNormalUser();

        $projectModuleModel = new ProjectModuleModel();
        //$list = $projectModuleModel->getByProjectWithUser($_GET[ProjectLogic::PROJECT_GET_PARAM_ID]);
        $count = $projectModuleModel->getAllCount($_GET[ProjectLogic::PROJECT_GET_PARAM_ID]);

        $data = [];
        $data['title'] = '模块';
        $data['nav_links_active'] = 'setting';
        $data['sub_nav_active'] = 'module';
        $data['users'] = $users;
        $data['query_str'] = http_build_query($_GET);
        //$data['list'] = $list;
        $data['count'] = $count;

        $data = RewriteUrl::setProjectData($data);
        $this->render('gitlab/project/setting_module.php', $data);
    }

    public function settingsLabel()
    {
        $data = [];
        $data['title'] = '标签';
        $data['nav_links_active'] = 'setting';
        $data['sub_nav_active'] = 'label';
        $data['query_str'] = http_build_query($_GET);

        $data = RewriteUrl::setProjectData($data);
        $this->render('gitlab/project/setting_label.php', $data);
    }
    public function settingsLabelNew()
    {
        $data = [];
        $data['title'] = '标签';
        $data['nav_links_active'] = 'setting';
        $data['sub_nav_active'] = 'label';
        $data['query_str'] = http_build_query($_GET);
        $data = RewriteUrl::setProjectData($data);
        $this->render('gitlab/project/setting_label_new.php', $data);
    }
    public function settingsLabelEdit()
    {
        $id = isset($_GET['id']) && !empty($_GET['id']) ? intval($_GET['id']) : 0;
        if($id > 0){
            $projectLabelModel = new ProjectLabelModel();
            $info = $projectLabelModel->getById($id);

            $data = [];
            $data['title'] = '标签';
            $data['nav_links_active'] = 'setting';
            $data['sub_nav_active'] = 'label';

            $data['query_str'] = http_build_query($_GET);
            $data = RewriteUrl::setProjectData($data);

            $data['row'] = $info;
            $this->render('gitlab/project/setting_label_edit.php', $data);
        }else{
            echo 404;exit;
        }
    }

    public function settingsPermission()
    {
        $data = [];
        $data['title'] = '权限';
        $data['nav_links_active'] = 'setting';
        $data['sub_nav_active'] = 'permission';
        $data = RewriteUrl::setProjectData($data);
        $this->render('gitlab/project/setting_permission.php', $data);
    }

    public function settingsProjectRole()
    {
        $data = [];
        $data['title'] = '用户和权限';
        $data['nav_links_active'] = 'setting';
        $data['sub_nav_active'] = 'project_role';
        $data = RewriteUrl::setProjectData($data);
        $this->render('gitlab/project/setting_project_role.php', $data);
    }

    public function activity()
    {
        $data = [];
        $data['title'] = 'Activity';
        $data['top_menu_active'] = 'time_line';
        $data['nav_links_active'] = 'home';
        $data['scrolling_tabs'] = 'activity';

        $this->render('gitlab/project/activity.php', $data);
    }

    public function stat()
    {
        $data = [];
        $data['title'] = '项目统计';
        $data['nav_links_active'] = 'stat';
        $data = RewriteUrl::setProjectData($data);
        $this->render('gitlab/project/chart.php', $data);
    }

    public function chart()
    {
        $data = [];
        $data['title'] = '项目图表';
        $data['nav_links_active'] = 'chart';
        $data = RewriteUrl::setProjectData($data);
        $this->render('gitlab/project/chart.php', $data);
    }


    /**
     * @param $name
     * @param $key
     * @param $type
     * @param string $url
     * @param string $category
     * @param string $avatar
     * @param string $description
     */
    public function add($params)
    {
        // @todo 判断权限:全局权限和项目角色
        // dump($params);exit;
        $uid = $this->getCurrentUid();
        $projectModel = new ProjectModel($uid);
        if (isset($params['name']) && empty(trimStr($params['name']))) {
            $this->ajaxFailed('param_error:name_is_null');
        }

        $maxLengthProjectName = (new SettingsLogic)->maxLengthProjectName();
        if(  strlen($params['name']) > $maxLengthProjectName   ){
            $this->ajaxFailed('param_error:name_length>'.$maxLengthProjectName);
        }

        if (isset($params['key']) && empty(trimStr($params['key']))) {
            $this->ajaxFailed('param_error:key_is_null');
        }
        $maxLengthProjectKey = (new SettingsLogic)->maxLengthProjectKey();
        if(  strlen($params['key']) > $maxLengthProjectKey   ){
            $this->ajaxFailed('param_error:key_length>'.$maxLengthProjectKey);
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

        if (strlen($params['key']) > 10) {
            $this->ajaxFailed('param_error:key_max_10');
        }
        $params['key'] = trimStr($params['key']);
        $params['name'] = trimStr($params['name']);
        $params['type'] = intval($params['type']);

        if (!isset($params['lead']) || empty($params['lead'])) {
            $params['lead'] = $uid;
        }

        $info = [];
        $info['name'] = $params['name'];
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
        if (!$ret['errorCode']) {
            $skey = sprintf("%u", crc32($info['key']));
            $this->jump("/project/main/home?project_id={$ret['data']['project_id']}&skey={$skey}");
        } else {
            $this->ajaxFailed('add_failed:'.$ret['msg']);
        }
    }

    public function update($project_id, $name, $key, $type, $url = '', $category = '', $avatar = '', $description = '')
    {

        // @todo 判断权限:全局权限和项目角色
        $uid = $this->getCurrentUid();
        $projectModel = new ProjectModel($uid);
        $this->param_valid($projectModel, $name, $key, $type);


        $project_id = intval($project_id);

        $info = [];
        if (isset($_REQUEST['name'])) {
            $name = trimStr($_REQUEST['name']);
            if ($projectModel->checkIdNameExist($project_id, $name)) {
                $this->ajaxFailed('param_error:name_exist');
            }
            $info['name'] = trimStr($_REQUEST['name']);
        }
        if (isset($_REQUEST['key'])) {
            $key = trimStr($_REQUEST['key']);
            if ($projectModel->checkIdKeyExist($project_id, $key)) {
                $this->ajaxFailed('param_error:key_exist');
            }
            $info['key'] = trimStr($_REQUEST['key']);
        }
        if (isset($_REQUEST['type'])) {
            $info['type'] = intval($_REQUEST['type']);
        }
        if (isset($_REQUEST['lead'])) {
            $info['lead'] = intval($_REQUEST['lead']);
        }
        if (isset($_REQUEST['description'])) {
            $info['description'] = $_REQUEST['description'];
        }
        if (isset($_REQUEST['category'])) {
            $info['category'] = (int)$_REQUEST['category'];
        }
        if (isset($_REQUEST['url'])) {
            $info['url'] = $_REQUEST['url'];
        }
        if (isset($_REQUEST['avatar'])) {
            $info['avatar'] = $_REQUEST['avatar'];
        }
        if (empty($info)) {
            $this->ajaxFailed('param_error:data_is_empty');
        }
        $project = $projectModel->getRowById($project_id);
        $ret = $projectModel->updateById($project_id, $info);
        if ($ret[0]) {
            if ($project['key'] != $key) {
                // @todo update issue key
            }
            $this->ajaxSuccess('add_success');
        } else {
            $this->ajaxFailed('add_failed');
        }
    }


    public function delete($project_id)
    {

        if (empty($project_id)) {
            $this->ajaxFailed('no_project_id');
        }
        // @todo 判断权限

        $uid = $this->getCurrentUid();
        $project_id = intval($project_id);
        $projectModel = new ProjectModel($uid);
        $ret = $projectModel->deleteById($project_id);
        if (!$ret) {
            $this->ajaxFailed('delete_failed');
        } else {
            // @todo 删除事项

            // @todo 删除版本
            $projectVersionModel = new ProjectVersionModel($uid);
            $projectVersionModel->deleteByProject($project_id);

            // @todo 删除模块
            $projectModuleModel = new ProjectModuleModel($uid);
            $projectModuleModel->deleteByProject($project_id);

            $this->ajaxSuccess('success');
        }
    }
}
