<?php

namespace main\app\classes;

use main\app\model\SettingModel;

/**
 * Class SettingsLogic
 * @package main\app\classes
 */
class SettingsLogic
{

    /**
     * @param string $module
     * @return array
     * @throws \Exception
     */
    public static function getsByModule($module = '')
    {
        $settingModel = new SettingModel();
        $settings = $settingModel->getSettingByModule($module);
        $config = [];
        if (empty($settings)) {
            return [false, new \stdClass()];
        }
        foreach ($settings as $s) {
            $config[$s['_key']] = $settingModel->formatValue($s);
        }

        return [true,$config];
    }

    /**
     * 显示系统标题
     * @return string
     * @throws \Exception
     */
    public function showSysTitle()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('title');
        if (empty($setting['_value'])) {
            return SITE_NAME;
        }
        return $setting['_value'];
    }

    /**
     * 系统开关
     * @throws \Exception
     */
    public function sysSwitch()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('open_status');
        return $setting['_value'];
    }

    /**
     * 最大尝试验证登录次数
     * max_login_error
     * @throws \Exception
     */
    public function maxLoginErrorNumber()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('max_login_error');
        return $setting['_value'];
    }

    /**
     * 录时需要验证码
     * login_require_captcha
     * @return mixed
     * @throws \Exception
     */
    public function loginRequireCaptcha()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('login_require_captcha');
        return $setting['_value'];
    }

    /**
     * 注册时需要验证码
     * reg_require_captcha
     * @throws \Exception
     */
    public function regRequireCaptcha()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('reg_require_captcha');
        return $setting['_value'];
    }

    /**
     * 邮件发件人显示格式
     * sender_format
     * @throws \Exception
     */
    public function senderFormat()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('sender_format');
        return $setting['_value'];
    }

    /**
     * 说明
     * description
     * @throws \Exception
     */
    public function description()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('description');
        return $setting['_value'];
    }

    /**
     * 默认用户时区
     * date_timezone
     * @throws \Exception
     */
    public function dateTimezone()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('date_timezone');
        return $setting['_value'];
    }

    /**
     * 允许用户分享过滤器或面部
     * allow_share_public
     * @throws \Exception
     */
    public function allowSharePublic()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('allow_share_public');
        return $setting['_value'];
    }

    /**
     * 项目名称最大长度
     * max_project_name
     * @throws \Exception
     */
    public function maxLengthProjectName()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('max_project_name');
        return $setting['_value'];
    }

    /**
     * 项目键值最大长度
     * max_project_key
     * @throws \Exception
     */
    public function maxLengthProjectKey()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('max_project_key');
        return $setting['_value'];
    }

    /**
     * 邮件可见性
     * email_public
     * @throws \Exception
     */
    public function emailPublic()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('email_public');
        return $setting['_value'];
    }

    /**
     * 事项选择器自动完成
     * enable_filter_autocomplete
     * @throws \Exception
     */
    public function enableFilterAutocomplete()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('enable_filter_autocomplete');
        return $setting['_value'];
    }

    /**
     * 允许联系管理员
     * allow_contact_admin
     * @throws \Exception
     */
    public function allowContactAdmin()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('allow_contact_admin');
        return $setting['_value'];
    }

    /**
     * 联系管理员的信息
     * contact_admin_text
     * @throws \Exception
     */
    public function contactAdminText()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('contact_admin_text');
        return $setting['_value'];
    }

    /**
     * 允许使用Gravatars用户头像
     * allow_gravatars
     * @throws \Exception
     */
    public function allowGravatars()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('allow_gravatars');
        return $setting['_value'];
    }

    /**
     * Gravatar服务器
     * gravatar_server
     * @throws \Exception
     */
    public function gravatarServer()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('gravatar_server');
        return $setting['_value'];
    }

    /**
     * 自动更新搜索结果
     * auto_update_search
     * @throws \Exception
     */
    public function autoUpdateSearch()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('auto_update_search');
        return $setting['_value'];
    }

    /**
     * 项目描述允许使用 HTML 标签
     * allow_project_desc_html
     * @throws \Exception
     */
    public function allowProjectDescHtml()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('allow_project_desc_html');
        return $setting['_value'];
    }

    /**
     * 默认发送个邮件的格式
     * send_mail_format
     * @throws \Exception
     */
    public function sendMailFormat()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('send_mail_format');
        return $setting['_value'];
    }

    /**
     * 事项导航每页显示的事项数量
     * issue_page_size
     * @throws \Exception
     */
    public function issuePageSize()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('issue_page_size');
        return $setting['_value'];
    }

    /**
     * 自定义logo
     * banner
     * @throws \Exception
     */
    public function banner()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('banner');
        return $setting['_value'];
    }

    /**
     * 图标
     * logo
     * @throws \Exception
     */
    public function logo()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('logo');
        return $setting['_value'];
    }

    /**
     * 页头背景颜色
     * color_page_bg
     * @throws \Exception
     */
    public function colorPageBg()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('color_page_bg');
        return $setting['_value'];
    }

    /**
     * 页头高亮背景颜色
     * color_page_header_hover
     * @throws \Exception
     */
    public function colorPageHeaderHover()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('color_page_header_hover');
        return $setting['_value'];
    }

    /**
     * Header分隔颜色
     * color_header_split
     * @throws \Exception
     */
    public function colorHeaderSplit()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('color_header_split');
        return $setting['_value'];
    }

    /**
     * 页头文字颜色
     * color_page_header_text
     * @throws \Exception
     */
    public function colorPageHeaderText()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('color_page_header_text');
        return $setting['_value'];
    }

    /**
     * 页头高亮文字颜色
     * color_page_header_hover_text
     * @throws \Exception
     */
    public function colorPageHeaderHoverText()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('color_page_header_hover_text');
        return $setting['_value'];
    }

    /**
     * 菜单项高亮背景颜色
     * color_menu_hover
     * @throws \Exception
     */
    public function colorMenuHover()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('color_menu_hover');
        return $setting['_value'];
    }

    /**
     * 菜单项文字颜色高亮
     * color_menu_hover_text
     * @throws \Exception
     */
    public function colorMenuHoverText()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('color_menu_hover_text');
        return $setting['_value'];
    }

    /**
     * 时间格式
     * time_format
     * @throws \Exception
     */
    public function timeFormat()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('time_format');
        return $setting['_value'];
    }

    /**
     * 星期格式
     * week_format
     * @throws \Exception
     */
    public function weekFormat()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('week_format');
        return $setting['_value'];
    }

    /**
     * 完整日期/时间格式
     * full_datetime_format
     * @throws \Exception
     */
    public function fullDatetimeFormat()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('full_datetime_format');
        return $setting['_value'];
    }

    /**
     * 短日期格式(年月日)
     * datetime_format
     * @throws \Exception
     */
    public function datetimeFormat()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('datetime_format');
        return $setting['_value'];
    }

    /**
     * 在日期选择器中使用 ISO8601 标准
     * use_iso
     * @throws \Exception
     */
    public function useISO()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('use_iso');
        return $setting['_value'];
    }

    /**
     * 允许上传附件
     * allow_attachment
     * @throws \Exception
     */
    public function allowAttachment()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('allow_attachment');
        return $setting['_value'];
    }

    /**
     * 附件路径
     * attachment_dir
     * @throws \Exception
     */
    public function attachmentDir()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('attachment_dir');
        return $setting['_value'];
    }

    /**
     * 附件大小(单位M)
     * attachment_size
     * @throws \Exception
     */
    public function attachmentSize()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('attachment_size');
        return $setting['_value'];
    }

    /**
     * 启用缩略图
     * enbale_thum
     * @throws \Exception
     */
    public function enbaleThumb()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('enbale_thum');
        return $setting['_value'];
    }

    /**
     * 启用ZIP支持
     * enable_zip
     * @throws \Exception
     */
    public function enableZip()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('enable_zip');
        return $setting['_value'];
    }

    /**
     * 密码策略
     * password_strategy
     * @throws \Exception
     */
    public function passwordStrategy()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('password_strategy');
        return $setting['_value'];
    }

    /**
     * 发信人
     * send_mailer
     * @throws \Exception
     */
    public function sendMailer()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('send_mailer');
        return $setting['_value'];
    }

    /**
     * 前缀
     * mail_prefix
     * @throws \Exception
     */
    public function mailPrefix()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('mail_prefix');
        return $setting['_value'];
    }

    /**
     * 主机
     * mail_host
     * @throws \Exception
     */
    public function mailHost()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('mail_host');
        return $setting['_value'];
    }

    /**
     * SMTP端口
     * mail_port
     * @throws \Exception
     */
    public function mailPort()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('mail_port');
        return $setting['_value'];
    }

    /**
     * 账号
     * mail_account
     * @throws \Exception
     */
    public function mailAccount()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('mail_account');
        return $setting['_value'];
    }

    /**
     * 密码
     * mail_password
     * @throws \Exception
     */
    public function mailPassword()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('mail_password');
        return $setting['_value'];
    }

    /**
     * 发送超时
     * mail_timeout
     * @throws \Exception
     */
    public function mailTimeout()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('mail_timeout');
        return $setting['_value'];
    }

    /**
     * 邮件推送是否开启
     * enable_mail
     * @throws \Exception
     */
    public function enableMail()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('enable_mail');
        return $setting['_value'];
    }
}
