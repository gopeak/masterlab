<?php
/**
 * Created by PhpStorm.
 */

namespace main\app\ctrl;

use main\app\classes\UserAuth;
use main\app\classes\UserLogic;
use main\app\classes\SystemLogic;
use main\app\model\project\ProjectModel;
use main\app\model\user\EmailFindPasswordModel;
use main\app\model\user\InviteEmailModel;
use main\app\model\user\UserModel;
use main\app\model\SettingModel;
use main\app\model\user\UserTokenModel;
use main\app\model\user\LoginlogModel;
use main\app\model\user\EmailVerifyCodeModel;
use \main\lib\CaptchaBuilder;
use main\app\classes\SettingsLogic;

/**
 * 邀请功能
 */
class Invite extends BaseCtrl
{

    /**
     * 登录状态保持对象
     * @var \main\app\classes\UserAuth;
     */
    protected $auth;

    /**
     * Passport constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct();
        $this->auth = UserAuth::getInstance();
    }

    public function send()
    {
        $projectId = null;
        if (isset($_POST['project_id'])) {
            $projectId = (int)$_POST['project_id'];
        }
        $projectRoles = '';
        if (isset($_POST['project_roles'])) {
            $projectRoles = $_POST['project_roles'];
        }
        $emails = null;
        if (isset($_POST['emails'])) {
            $emails = str_replace([',','，'],[';',';'],$_POST['emails']);
        }

        if (!$projectId) {
            $this->ajaxFailed('参数错误', '项目不能为空');
        }
        if (!$projectRoles) {
            $this->ajaxFailed('参数错误', '项目角色不能为空');
        }
        if (!$emails) {
            $this->ajaxFailed('参数错误', 'email地址不能为空');
        }
        $emailArr = explode(';', $emails);
        if (!$emailArr) {
            $this->ajaxFailed('参数错误', 'email地址不能为空');
        }
        $currentUser = UserModel::getInstance()->getByUid(UserAuth::getId()) ;
        $project = (new ProjectModel())->getById($projectId);

        $inviteModel = new InviteEmailModel();
        $body = '';
        foreach ($emailArr as $email) {
            $token = md5(uniqid() .time().$email);
            list($ret, $insertId) = $inviteModel->add($email,$token,$projectId,$projectRoles);
            if($ret  && APP_STATUS != 'travis'){
                $args = [];
                $args['{{token}}'] = $token;
                $args['{{admin}}'] = $currentUser['display_name'];
                $args['{{org_path}}'] = $project['org_path'];
                $args['{{project_key}}'] = $project['key'];
                $args['{{root_url}}'] = ROOT_URL;
                $args['{{project_url}}'] = ROOT_URL.$project['org_path'].'/'.$project['key'];
                $args['{{logo_url}}'] = ROOT_URL.'gitlab/images/logo.png';
                $url = ROOT_URL . 'invite/setting?email=' . $email . '&token=' . $token;
                $args['{{url}}'] = $url;
                $body = str_replace(array_keys($args), array_values($args), getCommonConfigVar('mail_tpl')['tpl']['invite_email']);
                echo $body;die;
                $systemLogic = new SystemLogic();
                list($ret, $errMsg) = $systemLogic->mail($email, '邀请加入项目'.$project['name'], $body);
                if (!$ret) {
                    $this->ajaxFailed('服务器错误', '发送邮件失败,请求:' . $errMsg);
                }
            }else{
                $this->ajaxFailed('提示','发送邀请失败,请重试.错误信息:'.$insertId);
            }
        }
        $this->ajaxSuccess('提示','发送成功'.$body);

    }


    /**
     * 设置用户名和密码
     */
    public function pageSetting()
    {
        $data = [];
        $data['title'] = '登录';
        $data['is_login_page'] = true;
        $data['captcha_login_switch'] = (new SettingsLogic())->loginRequireCaptcha();
        $data['captcha_reg_switch'] = (new SettingsLogic())->regRequireCaptcha();

        // 是否开启用户注册
        $isAllowReg = (new SettingsLogic())->allowUserReg();
        $data['is_allow_user_reg'] = $isAllowReg;

        $this->render('gitlab/passport/login.php', $data);
    }


    /**
     * 处理重置密码
     * @throws \Exception
     */
    public function pageResetPassword()
    {
        if (!isset($_POST['email'])) {
            $this->error('参数错误', '邮件地址为空');
            return;
        }
        if (!isset($_POST['verify_code'])) {
            $this->error('参数错误', '验证码为空');
            return;
        }
        if (!isset($_POST['password'])) {
            $this->error('参数错误', '密码为空');
            return;
        }
        if (!isset($_POST['password_confirmation'])) {
            $this->error('参数错误', '确认密码为空');
            return;
        }
        $email = trimStr($_POST['email']);
        $verifyCode = trimStr($_POST['verify_code']);
        $password = trimStr($_POST['password']);
        $passwordConfirmation = trimStr($_POST['password_confirmation']);

        $userModel = UserModel::getInstance('');
        $user = $userModel->getByEmail($email);
        if (!isset($user['email'])) {
            $this->error('参数错误', '邮件不存在');
            return;
        }
        // 校验验证码
        $emailFindPwdModel = new EmailFindPasswordModel();
        $find = $emailFindPwdModel->getByEmailVerifyCode($email, $verifyCode);

        if (!isset($find['email']) || $verifyCode != $find['verify_code']) {
            $this->error('信息提示', '亲,此链接已经失效');
            return;
        }

        if ((time() - (int)$find['time']) > (3600 * 24)) {
            $this->error('信息提示', '亲,此链接时间已经失效');
            return;
        }
        if ($password != $passwordConfirmation) {
            $this->error('信息提示', '两次密码输入不一致');
            return;
        }

        $userInfo = [];
        $userInfo['password'] = UserAuth::createPassword($password);
        $userModel->uid = $user['uid'];
        list($ret, $msg) = $userModel->updateUser($userInfo);
        if ($ret) {
            $emailFindPwdModel->deleteByEmail($email);
            $this->info('信息提示', '重置密码成功!');
        } else {
            $this->info('信息提示', '很抱歉,重置密码失败,请重试.' . $msg);
        }
    }


}
