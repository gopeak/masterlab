<?php
/**
 * Created by PhpStorm. 
 */

namespace main\app\ctrl\project;
use main\app\classes\UserAuth;
use main\app\ctrl\BaseUserCtrl;
use main\app\model\project\ProjectModel;
use main\app\model\project\ProjectVersionModel;
use main\app\model\project\ProjectModuleModel;

/**
 * 项目
 */
class Category extends BaseUserCtrl
{


    public function index(    )
    {
        $data = [];
        $data['title'] = '项目分类';
        $data['sub_nav_active'] = 'category';
        $this->render('gitlab/project/category.php' ,$data );

    }

    public function _new(    )
    {
        $data = [];
        $data['title'] = '项目分类';
        $this->render('gitlab/project/main_form.php' ,$data );

    }

    public function detail(    )
    {
        $data = [];
        $data['title'] = 'Sign in';
        $this->render('gitlab/passport/login.php' ,$data );

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

        $uid = $this->get_current_uid();
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
        $uid = $this->get_current_uid();
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

        $uid = $this->get_current_uid();
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
