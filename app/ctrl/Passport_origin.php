<?php
/**
 * Created by PhpStorm. 
 */

namespace main\app\ctrl;
use main\app\classes\UserAuth;
use main\app\model\UserModel;
use main\app\model\SettingModel;
use main\app\model\RegVerifyCodeModel;
use main\app\model\UserTokenModel;
use main\app\model\LoginlogModel;
use main\app\model\EmailVerifyCodeModel;

/**
 * Class Passport
 
 * 用户账号相关功能
 */
class Passport_origin extends BaseUserCtrl
{


    /**
     * 重新刷新token
     * @param string $openid
     * @param string $refresh_token
     * @return array
     */
    public function refresh_token( $openid='', $refresh_token=''){

        $final = [];

        $userModel = UserModel::getInstance( '' );
        $userTokenModel = UserTokenModel::getInstance();
        $user = $userModel->getByOpenid( $openid );
        $uid  = $user['uid'];

        $row = $userTokenModel->getUserToken( $uid );

        if( !isset($row['refresh_token']) ||  $row['refresh_token']!=$refresh_token ){
            $this->ajaxFailed('token值错误!');
        }

        $data_config    =  getConfigVar( 'data' );

        if( ( time()- intval($row['refresh_token_time']))> intval($data_config['token']['refresh_expire_time'])  ){
            $this->ajaxFailed('token已经过期,请重新登录App!');
        }
        list(  $ret ,$token, $refresh_token ) =  $userTokenModel->makeToken( $user );

        if( !$ret ) {
            $this->ajaxFailed('刷新token失败');
        }

        $final['token'] =  $token;
        $final['refresh_token'] = $refresh_token;
        $token_cfg   =  getConfigVar( 'data' );
        $final['token_expire'] =  intval($token_cfg['token']['expire_time']);
        $this->ajaxSuccess( '刷新成功', $final );
        return $final;

    }


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

        if( strpos( $user['avatar'] , 'http://')===false ) {
            if( empty($user['avatar'])  ) {
                $user['avatar']  = PUBLIC_URL.'assets/images/portrait/default_user.png';
            }
            $user['avatar'] =  PUBLIC_URL .  $user['avatar'] ;
        }

        return  (object) $user;
    }


    /**
     * 登录
     * @param string $username
     * @param string $password
     * @param string $ios_token
     * @param string $android_token
     * @param string $version
     * @param string $openid
     * @param string $display_name
     * @param string $headimgurl
     * @param int $source
     */
    public function do_login( $username='', $password='' , $ios_token ='' ,$android_token ='' ,$version='' ,$openid='',$display_name='',$headimgurl='',$source=0 )
    {
        $userModel = UserModel::getInstance( '' );
        $final = [];
        $final['user'] =  new \stdClass();
        $final['static_url'] =  PUBLIC_URL;
        $final['msg'] = '';
        $final['code'] = 0;
        // sleep( 5 );
        // 使用对称aes加密解密
        if( isset( $_POST["aes_json"] ) && isset( $_POST["passphrase"] )  ) {
            $password = cryptoJsAesDecrypt( 'gohome@#fine', $_POST["aes_json"]);
            //$final['$password'] = $password;
        }

        // 检查登录错误次数,一个ip的登录错误次数限制
        $times = 0;
        $settingModel =   SettingModel::getInstance();
        $login_much_error_times_vcode = $settingModel->getSetting( 'login_much_error_times_vcode' );
        $tip   = $this->auth->checkIpErrorTimes( $times ,$login_much_error_times_vcode);
        if(  !empty( $tip )) {
            $this->ajaxFailed( $tip['msg'], [], $tip['code']);
        }
        // 检车登录账号和密码
        list( $re ,$user ) = $this->auth->checkLoginByUsername( $username, $password );

        if( $re!=UserModel::LOGIN_CODE_OK )
        {
            $code  = intval( $re );
            $tip   = 'password_error';
            $arr = $this->auth->checkRequireLoginVcode( $times ,$login_much_error_times_vcode );
            if(  !empty( $arr )) {
                $code = $arr['code'];
                $tip  = 'password_too_much_error_require_captcha';//$arr['msg'];
            }
            $this->ajaxFailed( $tip, $code );
        }
        unset( $_SESSION['login_captcha'] , $_SESSION['login_captcha_time'] );

        // 更新登录次数
        $this->auth->updateIpLoginTime( $times ,$login_much_error_times_vcode );

        if(  $user['status']!=UserModel::STATUS_NORMAL ) {
            $this->ajaxFailed( 'user_baned' );
        }

        if($openid){
            $info['weixin_openid'] = $openid;
            if(!$user['avatar']){
                $info['avatar'] = $headimgurl;
            }
            $info['weixin_openid'] = $openid;
            $userModel->updateUserById( $info,$user['uid'] );
        }
        if($ios_token){
            $info['ios_token'] = $ios_token;
        }
        if($android_token){
            $info['android_token'] = $android_token;
        }
        if($version){
            $info['version'] = $version;
        }
        if($display_name){
            $info['display_name'] = $display_name;
        }
        if($source){
            $info['source'] = $source;
        }

        // 自动登录处理
        if( isset( $_POST['auto_login'] ) &&  $_POST['auto_login']=="true" )
        {
            $set_token = UserAuth::createToken($user['password']);
            setcookie( UserAuth::SESSION_UID_KEY , $user['uid'] ,time()+3600*7*24,  '/',  getCookieHost() );
            setcookie( UserAuth::SESSION_TOKEN_KEY , $set_token, time()+3600*7*24 , '/', getCookieHost() );
        }else{
            setcookie( UserAuth::SESSION_UID_KEY ,'' ,time()+3600*4 ,  '/',  getCookieHost() );
            setcookie( UserAuth::SESSION_TOKEN_KEY ,'' ,time()+3600*4 ,  '/', getCookieHost() );
        }

        // 更新登录信息
        $userModel->uid = $user['uid'];
        $this->update_login_info(  $userModel->uid );
        // 处理登录返回值
        $this->process_login_return( $final ,$user );
        // 记录登录日志,用于只允许单个用户登录
        $loginLogModel = new LoginlogModel();
        $loginLogModel->loginLogInsert( $user['uid'] ) ;
        $loginLogModel->kickCurrentUserOtherLogin( $user['uid'] );
        $this->ajaxSuccess( $final['msg'],$final  );
    }

    /**
     * 处理登录返回值
     * @param $final
     * @param $user
     */
    private function process_login_return( &$final ,$user  )
    {
        // 生成和刷新token
        $userTokenModel = new UserTokenModel( $user['uid'] );
        list(  $ret ,$token, $refresh_token ) =  $userTokenModel->makeToken( $user );
        if( !$ret ) {
            $this->ajaxFailed( 'refresh_token' );
        }

        $final['token'] =  $token;
        $final['refresh_token'] = $refresh_token;
        $token_cfg   =  getConfigVar( 'data' );
        $final['token_expire'] =  intval($token_cfg['token']['expire_time']);

        if( isset($user['password']) ) unset($user['password']);
        // $_SESSION[UserAuth::SESSION_UID_KEY] = $user['uid'];
        $this->auth->login( $user);
        $_SESSION['user_info'] = $user;
        $final['user']  = $this->get($user['token'] );

        $final['code']  = UserModel::LOGIN_CODE_OK;
        $final['msg']   = '亲,登录成功';
    }

    /**
     * 更新登录信息
     * @param $uid
     */
    private function update_login_info( $uid  )
    {
        $updateInfo = array();
        if( isset($_REQUEST['ios_token'])  && !empty($_REQUEST['ios_token']) )
        {
            $updateInfo['ios_token'] = str_replace( array(" ",'<','>'), array('','',''), $_REQUEST['ios_token']);
        }

        if( isset($_REQUEST['android_token']) && !empty($_REQUEST['android_token'])  )
        {
            $updateInfo['android_token'] = str_replace( array(" ",'<','>'), array('','',''), $_REQUEST['android_token']);
        }
        $updateInfo['last_login_time'] = time();
        if( !empty($updateInfo) )
        {
            $userModel = UserModel::getInstance( $uid );
            $userModel->updateUser(  $updateInfo );
            unset( $updateInfo );
        }
    }

    /**
     * 注销接口
     */
    public function do_logout(   )
    {
        //清除会话
        UserAuth::getInstance()->logout();
        $this->ajaxSuccess('ok');
    }


    /**
     * 检查邮箱是否
     * @param string $email
     */
    public function email_exist( $email='' ) {
        unset( $email );
        $userModel = UserModel::getInstance();
        $email     =  isset($_REQUEST['email']) ?  ($_REQUEST['email']) : '';
        $user = $userModel->getByEmail( $email );
        if( !isset($user['uid']) || $user['status'] ==3)
        {
            $this->ajaxSuccess('邮箱可以使用');
        }
        $this->ajaxFailed( '邮箱已经被注册了');
    }


    /**
     * 检查手机号码是否存在
     * @param string $phone
     * @param bool $is_ajax
     */
    public function phone_exist( $phone='' ,$is_ajax=false)
    {
        unset( $phone ,$is_ajax );
        $phone      =  isset($_REQUEST['phone']) ?  ($_REQUEST['phone']) : '';
        $is_ajax    =  isset($_REQUEST['is_ajax']) ?  true : false;
        if( empty($phone) ){
            if( $is_ajax ) {
                echo 'false';die;
            }
            $this->ajaxFailed( '手机号格式错误');
        }

        //参数检查
        if(!is_phone( $phone) )
        {
            if( $is_ajax ) {
                echo 'false';die;
            }
            $this->ajaxFailed( '手机号码输入错误');
        }

        $user = UserModel::getInstance()->getUserByMobile( $phone );
        if( !isset($user['phone']) || $user['status'] ==UserModel::STATUS_DELETED) {
            if( $is_ajax ) {
                echo 'true';die;
            }
            $this->ajaxFailed( '手机号可以使用');
            return;
        }else{
            if( $is_ajax ) {
                echo 'false';die;
            }
        }
        $this->ajaxFailed( '手机号已经被注册了');
    }


    /**
     * 注册  <br>返回值:1为成功,2为已经存在,3为错误
     * @param string $type
     * @param string $email
     * @param string $phone
     * @param string $username
     * @param string $password
     * @param string $msg_code
     * @param string $display_name
     * @param string $sex
     * @param string $birthday
     * @param string $source
     * @param string $source_openid
     * @param string $avatar
     */
    public function register_complex( $type='email', $email='',  $phone='', $username='', $password='', $msg_code='',$display_name='',
                              $sex='0', $birthday='',$source='',$source_openid='',$avatar=''  )
    {

        //参数检查
        if( !in_array( $type,['phone','email'] ) ) {
            $this->ajaxFailed( 'type参数错误');
            return;
        }
        $settingModel = new SettingModel( );
        // 是否需要图形验证码
        if( $settingModel->getSetting(  'reg_require_pic_code' ) ) {
            $captcha = $_POST['captcha'];
            if( empty( $captcha ) ) {
                $this->ajaxFailed( '图形验证码为空!');
                return;
            }
            if( isset($_SESSION['reg_captcha'])
                && $captcha!==$_SESSION['reg_captcha']
                && (time()-$_SESSION['reg_captcha_time']) >300   )
            {
                $this->ajaxFailed( '图形验证码错误!');
                return;
            }
            if( isset($_SESSION['reg_captcha']) ) unset( $_SESSION['reg_captcha'] );
            if( isset($_SESSION['reg_captcha_time']) ) unset( $_SESSION['reg_captcha_time'] );
        }

        $userModel = UserModel::getInstance('');
        if( $type=='phone' ){

            if(!is_phone( $phone ) )
            {
                $this->ajaxFailed( '手机号码输入错误');
            }
            $user_by_phone = $userModel->getUserByMobile( $phone );
            if( isset($user_by_phone['uid']) )
            {
                $this->ajaxFailed( '手机号码已经被使用了!');
            }
            unset( $user_by_phone );
            // 校验验证码
            if( $settingModel->getSetting(  'reg_require_msg_code' ) ) {
                $regVerifyCodeModel  = new RegVerifyCodeModel();
                $find  = $regVerifyCodeModel->getByPhone( $phone );

                if( !isset($find['phone']) ||  $msg_code!=$find['code'] )
                {
                    $this->ajaxFailed( '亲,短信验证码输入不正确!');
                }
                if( (time()-$find['time']) >3600  )
                {
                    $this->ajaxFailed( '亲,短信验证码已经失效了!');
                    $regVerifyCodeModel->deleteByPhone( $phone );
                }
                $regVerifyCodeModel->deleteByPhone( $phone );
            }
        }

        if( $type=='email' ) {

            $email = trimStr( $email );
            if ( empty($email) ) {
                $this->ajaxFailed('email不能为空');
            }

            $user = $userModel->getByEmail($email);
            if (isset($user['uid'])) {
                $this->ajaxFailed('email已经被使用了!');
            }
        }

        unset( $user );
        if (strlen($password)>20 )
        {
            $this->ajaxFailed('密码长度太长了!');
        }

        $userInfo = [];
        $userInfo['email']      =  $email;
        $userInfo['phone']      =  $phone;
        $userInfo['password']   =  UserAuth::createPassword( $password );
        $userInfo['display_name']   =  $display_name ;
        $userInfo['username']   =  $username ;
        $userInfo['sex']   = !empty($sex) ? ($sex) : '0';
        $userInfo['birthday'] = !empty($birthday) ? ($birthday) : '';
        $userInfo['status']   =  UserModel::STATUS_NORMAL ;
        $userInfo['create_time'] = time();
        $userInfo['source_openid'] = $source_openid;
        $userInfo['avatar'] = !empty($avatar) ? $avatar : "";
        $userInfo['source'] = $source;

        $userModel = new  UserModel( );
        $ret= $userModel->addUser( $userInfo );
        if( $ret[1]['uid'] ) {
            $this->ajaxSuccess('注册成功');
        }else{
            $this->ajaxFailed( '注册失败');
        }

    }

    public function register(  $email='',  $username='', $password='',$display_name='',$avatar=''  )
    {

        //参数检查
        $settingModel = new SettingModel( );
        // 是否需要图形验证码
        if( $settingModel->getSetting(  'reg_require_pic_code' ) ) {
            $captcha_code= $_POST['captcha_code'];
            if( empty( $captcha_code ) ) {
                $this->ajaxFailed( '图形验证码为空!');
                return;
            }
            if( isset($_SESSION['reg_captcha'])
                && $captcha_code!==$_SESSION['reg_captcha']
                && (time()-$_SESSION['reg_captcha_time']) >300   )
            {
                $this->ajaxFailed( '图形验证码错误!');
                return;
            }
            if( isset($_SESSION['reg_captcha']) ) unset( $_SESSION['reg_captcha'] );
            if( isset($_SESSION['reg_captcha_time']) ) unset( $_SESSION['reg_captcha_time'] );
        }

        $userModel = UserModel::getInstance('');

        $email = trimStr( $email );
        if ( empty($email) ) {
            $this->ajaxFailed('email不能为空');
        }

        $user = $userModel->getByEmail($email);
        if ( isset($user['uid']) && $user['status']!=UserModel::STATUS_PENDING_APPROVAL) {
            $this->ajaxFailed('email已经被使用了!');
        }
        unset( $user );

        if (strlen($password)>20 )
        {
            $this->ajaxFailed('密码长度太长了!');
        }

        $userInfo = [];
        $userInfo['email']      =  $email;
        $userInfo['password']   =  UserAuth::createPassword( $password );
        $userInfo['display_name']   =  $display_name ;
        $userInfo['username']   =  $username ;
        $userInfo['status']   =  UserModel::STATUS_PENDING_APPROVAL ;
        $userInfo['create_time'] = time();
        $userInfo['avatar'] = !empty($avatar) ? $avatar : "";

        $userModel = new  UserModel( );
        $ret= $userModel->addUser( $userInfo );
        if( $ret[1]['uid'] ) {
            $this->ajaxSuccess('注册成功');
        }else{
            $this->ajaxFailed( '注册失败');
        }

    }

    /**
     * 绑定手机号  <br>返回值:1为成功
     * @param $phone string
     * @param $captcha string
     */
    public function bind_phone($phone='', $captcha=''  )
    {
        unset( $phone,$captcha);
        $phone = $_REQUEST['phone'];
        $captcha = $_REQUEST['captcha'];
        if( UserAuth::getInstance()->isGuest() )
        {
            $this->ajaxFailed( 'no_login');
        }

        $userModel = UserModel::getInstance( $_SESSION[UserAuth::SESSION_UID_KEY] );
        $user = $userModel->getByPhone( $phone );

        if( isset($user['phone']) )
        {
            $this->ajaxFailed( 'phone_used');
        }
        unset( $user );

        // 校验验证码
        $regVcodeModel = new RegVerifyCodeModel();
        $find  = $regVcodeModel->getByPhone( $phone );

        if( !isset($find['phone']) ||  $captcha!=$find['code'] )
        {
            $this->ajaxFailed( 'captcha_error');
        }

        if( (time()-$find['time']) >3600    )
        {
            $this->ajaxFailed( 'captcha_timeout');
        }

        //参数检查
        if( isset($_REQUEST['phone']) ){
            $userinfo = [];
            $userinfo['phone'] = $phone ;
            $ret = $userModel->updateUser( $userinfo );
            if( $ret ) {
                $regVcodeModel->deleteByPhone( $phone );
                $this->ajaxSuccess( 'bind_success');
            }
        }
        $this->ajaxFailed( '绑定失败');
    }


    /**
     * 发送邮箱进行绑定的
     * @param string $email
     * @param string $captcha
     */
    public function send_email_vcode( $email='',$captcha='' )
    {
        unset($email,$captcha);
        $email = isset( $_REQUEST['email'] ) ? ( $_REQUEST['email'] ) :'';

        $userModel = UserModel::getInstance();
        $user = $userModel->getByEmail( $email );

        if(isset($user['email']) && !empty($user['email']) )
        {
            $this->ajaxFailed( 'Email地址已经被注册过哦');
        }

        if( !isset($_SESSION[UserAuth::SESSION_UID_KEY]) ||  empty($_SESSION[UserAuth::SESSION_UID_KEY]) )
        {
            $this->ajaxFailed( '您尚未登录或登录会话已经失效');
        }
        $uid = $_SESSION[UserAuth::SESSION_UID_KEY];

        $settingModel = new SettingModel( );
        $send_email_require_captcha = $settingModel->getSetting(  'send_email_require_captcha' );
        // 图形验证码
        if( $send_email_require_captcha>0 ) {
            $captcha = $_REQUEST['captcha'];
            if ( empty($captcha) ) {
                $this->ajaxFailed( '图片验证码为空');
            }
            if ( strtolower( $captcha ) != strtolower( $_SESSION['bind_email_verify_code'] ) || (time() - $_SESSION['bind_email_verify_code_time']) > 300 ) {
                $this->ajaxFailed( '图片验证码错误');
            }
            unset($_SESSION['bind_email_verify_code']);
            unset($_SESSION['bind_email_verify_code_time']);
        }
        $verify_code = mt_rand( 10000,99999 );
        $emailVcodeModel = new EmailVerifyCodeModel();

        $row = $emailVcodeModel->getByEmail( $email );
        if( isset( $row['email'] ) ) {
            if( time()-intval( $row['time'] ) <59  ) {
                $this->ajaxFailed( '请稍后再点击发送验证码');
            }
        }

        $flag =  $emailVcodeModel->insert( $uid, $email, $verify_code );
        if( $flag )
        {
            $user = $userModel->getByUid( $uid );
            $args = [];
            $args['{{site_name}}'] = SITE_NAME;
            $args['{{name}}'] = $user['display_name'];
            $args['{{email}}'] = $email;
            $args['{{verify_code}}'] = $verify_code;
            $mail_config = getConfigVar( 'mail' );
            $body = str_replace( array_keys($args), array_values($args), $mail_config['tpl']['bind_email']);
            //@异步发送
            list( $ret, $err_msg )  =   send_mail( $email,'绑定邮箱通知', $body );
            if( !$ret ){
                $this->ajaxFailed( $err_msg);
            }
        }else{
            //'很抱歉,服务器繁忙，请重试!!';
            $this->ajaxFailed( '很抱歉,服务器繁忙，请重试!');
        }
        $this->ajaxSuccess( '提交成功,请耐心等待邮箱验证!' );
    }


    /**
     * 绑定email
     * @param $email
     * @param $vcode
     */
    public function bind_email(  $email, $vcode  )
    {
        if( !isset($_SESSION[UserAuth::SESSION_UID_KEY]) ||  empty($_SESSION[UserAuth::SESSION_UID_KEY]) )
        {
            $this->ajaxFailed( 'nologin');
        }

        $userModel = UserModel::getInstance( $_SESSION[UserAuth::SESSION_UID_KEY] );
        $user = $userModel->getByEmail( $email );

        if( isset($user['email']) )
        {
            $this->ajaxFailed( 'email_exist');
        }
        unset( $user );

        // 校验验证码
        $emailVcodeModel = new EmailVerifyCodeModel();
        $find  = $emailVcodeModel->getEmailVcode2( $email ,$vcode );

        if( !isset($find['email']) ||  $vcode!=$find['vcode'] )
        {
            $this->ajaxFailed( '亲,验证码输入不正确，或验证码已经失效!');
        }

        if( (time()-(int)$find['time']) >3600    )
        {
            $this->ajaxFailed( 'vcode_err2');
        }

        //参数检查
        $userInfo = [];
        $userInfo['email'] = $email ;
        $userInfo['bind_email_uptime'] = time() ;
        $userModel->uid = $find['uid'];
        $ret = $userModel->updateUser( $userInfo );
        if( $ret ) {
            $emailVcodeModel->deleteByEmail( $email );
            $this->ajaxSuccess( '绑定成功' );
        }else{
            $this->ajaxFailed( 'nologin');
        }

    }

    /**
     * 检查邮箱是否
     * @param string $email
     */
    public function check_email_bind( $email='' ) {

        $userModel = UserModel::getInstance();

        $user = $userModel->getByEmail( $email );
        if( isset( $user['uid'] )   ) {
            $this->ajaxFailed( '已经绑定' );
        }else{
            $this->ajaxSuccess( '未绑定' );
        }
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
    public function set_new_pass_by_origin( $origin_pass,$new_pass ) {

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
