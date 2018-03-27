<?php
/**
 * Created by PhpStorm. 
 */

namespace main\app\ctrl;
use main\app\classes\ProjectLogic;
use main\app\classes\UserAuth;
use main\app\classes\UserLogic;
use main\app\model\user\UserModel;
use main\app\model\user\RegVerifyCodeModel;
use main\app\model\user\UserTokenModel;
use main\app\model\user\LoginlogModel;
use main\app\model\user\EmailVerifyCodeModel;

/**
 * Class Passport
 
 * 用户账号相关功能
 */
class User extends BaseUserCtrl
{


    /**
     * 获取单个用户信息
     * @param string $token
     * @param string $openid
     * @return object
     */
    public function get( $token='', $openid='' )
    {
        $userModel = UserModel::getInstance( '' );

        if( !empty( $openid ) ) {
            $user = $userModel->getByOpenid( $openid );
            $this->uid  = $uid  = $user['uid'];
        }
        if( !empty( $token ) ){
            $user_token = UserTokenModel::getInstance()->getUserTokenByToken( $token );
            if( !isset($user_token['uid']) ){
                $this->ajaxFailed('token无效!');
            }
            $this->uid  = $uid  = $user_token['uid'];
        }
        $userModel->uid = $this->uid;
        $user = $userModel->getUser();
        if( isset($user['password']) ) unset($user['password']);
        if( !isset($user['uid']) ) {
            return new \stdClass();
        }
        $user['avatar'] = UserLogic::format_avatar( $user['avatar'] );

        return  (object) $user;
    }

    public function select_filter(
                                    $search = null,
                                    $per_page = null,
                                    $active = true,
                                    $project_id = null,
                                    $group_id = null,
                                    $current_user = false,
                                    $skip_users = null
    ){

        header('Content-Type:application/json');
        $current_uid  = UserAuth::getInstance()->getId();
        $userModel = UserModel::getInstance(  $current_uid  );
        $per_page =  abs( intval( $per_page ) );
        $field_type = isset($_GET['field_type']) ? $_GET['field_type'] : null;
        $users = [];

        if(empty($field_type)||$field_type=='user'){
            $userLogic = new UserLogic();
            $users = $userLogic->selectUserFilter( $search , $per_page ,  $active , $project_id , $group_id , $skip_users );
            foreach ( $users as$k=> &$row ){
                $row['avatar_url'] = UserLogic::format_avatar( $row['avatar'] );
                if( $current_user && $row['id']==$current_uid ){
                    unset($users[$k]);
                }
            }
            if( $current_user ){
                $user = $userModel->getUser();
                $tmp = [];
                $tmp['id'] = $user['uid'];
                $tmp['name'] = $user['display_name'];
                $tmp['username'] = $user['username'];
                $tmp['avatar_url'] =  UserLogic::format_avatar( $user['avatar'] ,$user['email']);
                array_unshift( $users,  $tmp );
            }
            sort($users);
        }
        if($field_type=='project'){
            $logic = new ProjectLogic();
            $users = $logic->selectFilter( $search , $per_page  );
            foreach ( $users as &$row ){
                $row['avatar_url'] = UserLogic::format_avatar( $row['avatar'] );
            }
        }



        return $users;



    }

    /**
     * 编辑用户资料
     * @param string $first_name
     * @param string $last_name
     * @param string $display_name
     * @param string $sex
     * @param string $avatar
     * @param string $birthday
     */
    public function set_profile(  $first_name='', $last_name='',$display_name='',$sex='0',$avatar='', $birthday='' )
    {
        unset( $first_name, $last_name,$display_name,$sex,$avatar, $birthday );
        //参数检查
        $uid = $this->uid;

        $userinfo = [];
        if( isset($_REQUEST['first_name']) ){
            $userinfo['first_name'] = es( $_REQUEST['first_name'] );
        }
        if( isset($_REQUEST['last_name']) ){
            $userinfo['last_name'] = es( $_REQUEST['last_name'] );
        }
        if( isset($_REQUEST['display_name']) ){
            $userinfo['display_name'] = es( $_REQUEST['display_name'] );
        }
        if( isset($_REQUEST['sex']) ){
            $userinfo['sex'] = (int)$_REQUEST['sex'] ;
        }
        if( isset($_REQUEST['birthday']) ){
            $userinfo['birthday'] =es( $_REQUEST['birthday'] ) ;
        }
        if( isset($_REQUEST['avatar']) ){
            if( strpos( $_REQUEST['avatar'],'http://' ) !==false ) {
                $_REQUEST['avatar'] = str_replace( PUBLIC_URL,'', $_REQUEST['avatar'] );
            }
            $userinfo['avatar'] =es(  $_REQUEST['avatar']) ;
        }

        $userModel = UserModel::getInstance( $uid );
        if( !empty($userinfo) ) {
            $userModel->updateUser( $userinfo );
        }
        $this->ajaxSuccess( '保存成功' ,$userinfo);
    }


    /**
     * 直接修改修改密码
     * @param string $origin_pass
     * @param string $new_pass
     */
    public function set_new_password( $origin_pass,$new_pass ) {

        $final = [];
        $final['code']  = 2;
        $final['msg']  = '';
        if( !isset($_SESSION[UserAuth::SESSION_UID_KEY]) ) {
            $this->ajaxFailed( 'nologin');
        }
        if( empty( $old_pass ) || empty( $new_pass )  )
        {
            $this->ajaxFailed( 'param_err');
        }

        $uid  = $_SESSION[UserAuth::SESSION_UID_KEY];
        $userModel = new UserModel( $uid );
        $user = $userModel->getUser();

        if( md5($origin_pass)!=$user['password'] ) {
            $this->ajaxFailed( 'origin_password_error');
        }
        $update_info = [];
        $update_info['password'] = md5( $new_pass );
        $userModel->updateUser( $update_info ) ;

        $this->ajaxSuccess( '修改密码完成，您可以重新登录了' );
    }


    /**
     * 本地裁剪后提交服务器
     * @param null $file
     */
    public function crop(  $file=null  )
    {
        unset( $file );
        $user_info = [];

        if( !isset($_SESSION[UserAuth::SESSION_UID_KEY]) ||  empty($_SESSION[UserAuth::SESSION_UID_KEY]) )
        {
            $this->ajaxFailed( 'nologin');
        }
        $uid = $_SESSION[UserAuth::SESSION_UID_KEY];
        $userModel = UserModel::getInstance( $uid );
        if( isset($_REQUEST['direct_pic'])  && !empty($_REQUEST['direct_pic']) ) {

            $user_info['avatar'] =  es( $_REQUEST['direct_pic']);
            $userModel->updateUser( $user_info );
            $this->ajaxSuccess( '操作成功' );
        }
        if(!isset($_FILES['avatar']))
        {
            $this->ajaxFailed( 'param_file_null' ,[],500);
        }

        $dir  = (strlen($uid)>1) ?  substr($uid, 0,2) : $uid;
        $relate_path = 'attached/avatar/'.$dir;
        $abs_path = PUBLIC_PATH.'assets/'.$relate_path;
        if( !file_exists($abs_path) ) mkdir( $abs_path,0755 );
        $ext = get_image_ext( $_FILES['avatar']['tmp_name'] );
        $origin_filename  = $uid.'_origin.'.$ext;
        list( $re ) =  uploadFile( $_FILES['avatar'], $abs_path, $origin_filename );
        if( !$re ){
            $this->ajaxFailed( 'upload_file_failed' ,[],500);
        }
        $user_info['avatar'] = $relate_path.'/'.$uid.'_origin.'.$ext.'?t='.time();

        $userModel->updateUser( $user_info );
        $this->ajaxSuccess( '操作成功' );
    }

}
