<?php
/**
 * Created by PhpStorm. 
 */

namespace main\app\ctrl\project;
use main\app\classes\ProjectLogic;
use main\app\classes\UserAuth;
use main\app\ctrl\BaseUserCtrl;
use main\app\model\project\ProjectIssueTypeSchemeDataModel;
use main\app\model\project\ProjectModel;
use main\app\model\project\ProjectVersionModel;
use main\app\model\project\ProjectModuleModel;
use main\app\model\user\UserModel;

/**
 * 项目
 */
class Setting extends BaseUserCtrl
{
    public $dataMerge = array();
    public function __construct()
    {
        parent::__construct();
        if(!ProjectLogic::check()){
            $this->warn("错误页面", "该项目不存在");
        }
        $this->dataMerge = array(
            "get_projectid" => $_REQUEST[ProjectLogic::PROJECT_GET_PARAM_ID],
            "get_skey" => $_REQUEST[ProjectLogic::PROJECT_GET_PARAM_SECRET_KEY],
        );
    }

    public function index($params)
    {
        if(isPost()){
            $uid = $this->getCurrentUid();
            $projectModel = new ProjectModel( $uid );

            if ( isset($params['type']) && empty(trimStr( $params['type'] )) ) {
                $this->ajaxFailed('param_error:type_is_null');
            }

            $params['type'] = intval($params['type']);

            if(!isset($params['lead']) || empty($params['lead']) ){
                $params['lead'] = $uid;
            }

            $info = [];
            $info['lead']   =  $params['lead'] ;
            $info['description']   =  $params['description'] ;
            $info['type']   =  $params['type'];
            $info['category']   =  0 ;
            $info['url']   =  $params['url'] ;

            $ret = $projectModel->update( $info, array("id"=>$_REQUEST[ProjectLogic::PROJECT_GET_PARAM_ID]) );
            if( $ret[0] ) {
                $this->ajaxSuccess("success");
            }else{
                $this->ajaxFailed( 'failed', array(), 500);
            }
            return;
        }

        $userModel = new UserModel();
        $users = $userModel->getUsers();

        $projectModel = new ProjectModel();
        $info = $projectModel->getById( $_REQUEST[ProjectLogic::PROJECT_GET_PARAM_ID]);

        $data = [];
        $data['title'] = '设置';
        $data['nav_links_active'] = 'setting';
        $data['sub_nav_active'] = 'basic_info';
        $data['users'] = $users;
        $data['info'] = $info;

        $data = array_merge($data, $this->dataMerge );
        $this->render('gitlab/project/setting_basic_info.php' ,$data );

    }


    public function issue_type(    )
    {
        $projectIssueTypeSchemeDataModel = new ProjectIssueTypeSchemeDataModel();
        $list = $projectIssueTypeSchemeDataModel->getByProjectId($_REQUEST[ProjectLogic::PROJECT_GET_PARAM_ID]);

        $data = [];
        $data['title'] = '问题类型';
        $data['nav_links_active'] = 'setting';
        $data['sub_nav_active'] = 'issue_type';

        $data['list'] = $list;

        $data = array_merge($data, $this->dataMerge );
        $this->render('gitlab/project/setting_issue_type.php' ,$data );

    }

    public function version()
    {
        $projectVersionModel = new ProjectVersionModel();
        $list = $projectVersionModel->getByProject($_REQUEST[ProjectLogic::PROJECT_GET_PARAM_ID]);
        $data = [];
        $data['title'] = '版本';
        $data['nav_links_active'] = 'setting';
        $data['sub_nav_active'] = 'version';

        $data['list'] = $list;

        $data = array_merge($data, $this->dataMerge );
        $this->render('gitlab/project/setting_version.php' ,$data );

    }

    public function module(    )
    {
        $userModel = new UserModel();
        $users = $userModel->getUsers();

        $projectModuleModel = new ProjectModuleModel();
        $list = $projectModuleModel->getByProjectWithUser($_REQUEST[ProjectLogic::PROJECT_GET_PARAM_ID]);

        $data = [];
        $data['title'] = '模块';
        $data['nav_links_active'] = 'setting';
        $data['sub_nav_active'] = 'module';
        $data['users'] = $users;
        $data['list'] = $list;

        $data = array_merge($data, $this->dataMerge );
        $this->render('gitlab/project/setting_module.php' ,$data );

    }

    public function worker_flow(    )
    {
        $data = [];
        $data['title'] = '工作流';
        $data['nav_links_active'] = 'setting';
        $data['sub_nav_active'] = 'worker_flow';
        $this->render('gitlab/project/setting_worker_flow.php' ,$data );

    }

    public function project_role(    )
    {
        $data = [];
        $data['title'] = '用户和权限';
        $data['nav_links_active'] = 'setting';
        $data['sub_nav_active'] = 'project_role';
        $data = array_merge($data, $this->dataMerge );
        $this->render('gitlab/project/setting_project_role.php' ,$data );

    }

    public function permission(    )
    {
        $data = [];
        $data['title'] = '权限';
        $data['nav_links_active'] = 'setting';
        $data['sub_nav_active'] = 'permission';
        $data = array_merge($data, $this->dataMerge );
        $this->render('gitlab/project/setting_permission.php' ,$data );

    }

    public function ui(    )
    {
        $data = [];
        $data['title'] = '界面';
        $data['nav_links_active'] = 'setting';
        $data['sub_nav_active'] = 'ui';
        $this->render('gitlab/project/setting_ui.php' ,$data );

    }
    public function field(    )
    {
        $data = [];
        $data['title'] = '字段';
        $data['nav_links_active'] = 'setting';
        $data['sub_nav_active'] = 'field';
        $this->render('gitlab/project/setting_field.php' ,$data );

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
    public function add( $name, $key  ,$type ,$lead='', $url ='',$category='' ,$avatar='', $description=''  )
    {
        // @todo 判断权限:全局权限和项目角色

        $uid = $this->getCurrentUid();
        $projectModel = new ProjectModel( $uid );
        if ( empty(trimStr( $name )) ) {
            $this->ajaxFailed('param_error:name_is_null');
        }
        if ( empty(trimStr( $key )) ) {
            $this->ajaxFailed('param_error:key_is_null');
        }
        if ( empty(trimStr( $type )) ) {
            $this->ajaxFailed('param_error:type_is_null');
        }
        if( $projectModel->checkNameExist( $name ) ){
            $this->ajaxFailed('param_error:name_exist');
        }
        if(  $projectModel->checkKeyExist( $key ) ){
            $this->ajaxFailed('param_error:key_exist');
        }

        if(!preg_match("/^[a-zA-Z\s]+$/",$key)){
            $this->ajaxFailed('param_error:must_be_abc');
        }

        if (strlen($key)>10 )
        {
            $this->ajaxFailed('param_error:key_max_10');
        }
        $key = trimStr($key);
        $name = trimStr($name);
        $type = intval($type);
        if( empty($lead) ){
            $lead = $uid;
        }

        $info = [];
        $info['name']   =  $name;
        $info['key']   =  $key ;
        $info['lead']   =  $lead ;
        $info['description']   =  $description ;
        $info['type']   =  $type;
        $info['category']   =  $category ;
        $info['url']   =  $url ;
        $info['create_time'] = time();
        $info['create_uid'] = $uid;
        $info['avatar'] = !empty($avatar) ? $avatar : "";

        $ret= $projectModel->insert( $info );
        if( $ret[0] ) {
            $this->ajaxSuccess('add_success');
        }else{
            $this->ajaxFailed( 'add_failed');
        }
    }


    public function update( $project_id,$name, $key  ,$type  , $url ='',$category='' ,$avatar='', $description='' )
    {

        // @todo 判断权限:全局权限和项目角色
        $uid = $this->getCurrentUid();
        $projectModel = new ProjectModel( $uid );
        $this->param_valid( $projectModel, $name, $key  ,$type );


        $project_id = intval($project_id);

        $info = [];
        if( isset($_REQUEST['name']) ){
            $name = trimStr( $_REQUEST['name'] );
            if( $projectModel->checkIdNameExist( $project_id, $name ) ){
                $this->ajaxFailed('param_error:name_exist');
            }
            $info['name']   =  trimStr( $_REQUEST['name'] );
        }
        if( isset($_REQUEST['key']) ){
            $key = trimStr( $_REQUEST['key'] );
            if( $projectModel->checkIdKeyExist( $project_id, $key ) ){
                $this->ajaxFailed('param_error:key_exist');
            }
            $info['key']   =  trimStr( $_REQUEST['key'] );
        }
        if( isset($_REQUEST['type']) ){
            $info['type']   =  intval( $_REQUEST['type'] );
        }
        if( isset($_REQUEST['lead']) ){
            $info['lead']   =  intval( $_REQUEST['lead'] );
        }
        if( isset($_REQUEST['description']) ){
            $info['description']   =  $_REQUEST['description'];
        }
        if( isset($_REQUEST['category']) ){
            $info['category']   = (int) $_REQUEST['category'];
        }
        if( isset($_REQUEST['url']) ){
            $info['url']   =  $_REQUEST['url'];
        }
        if( isset($_REQUEST['avatar']) ){
            $info['avatar']   =  $_REQUEST['avatar'];
        }
        if( empty($info) ){
            $this->ajaxFailed( 'param_error:data_is_empty');
        }
        $project =  $projectModel->getRowById( $project_id );
        $ret= $projectModel->updateById( $project_id,$info );
        if( $ret[0] ) {
            if( $project['key']!=$key ) {
                // @todo update issue key
            }
            $this->ajaxSuccess('add_success');
        }else{
            $this->ajaxFailed( 'add_failed');
        }
    }


    public function delete( $project_id  ) {

        if( empty( $project_id ) ){
            $this->ajaxFailed( 'no_project_id');
        }
        // @todo 判断权限

        $uid = $this->getCurrentUid();
        $project_id = intval( $project_id );
        $projectModel = new ProjectModel( $uid );
        $ret = $projectModel->deleteById( $project_id );
        if( !$ret ) {
            $this->ajaxFailed( 'delete_failed');
        }else{

            // @todo 删除问题


            // @todo 删除版本
            $projectVersionModel = new ProjectVersionModel( $uid );
            $projectVersionModel->deleteByProject( $project_id );

            // @todo 删除模块
            $projectModuleModel = new ProjectModuleModel( $uid );
            $projectModuleModel->deleteByProject( $project_id );

            $this->ajaxSuccess('success');
        }

    }


}
