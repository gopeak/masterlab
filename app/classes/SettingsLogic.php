<?php
namespace main\app\classes;

use main\app\model\SettingModel;
class SettingsLogic
{
    /**
     * 显示系统标题
     */
    function showSysTitle()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('title');
        if(empty($setting['_value'])){
            return SITE_NAME;
        }
        return $setting['_value'];
    }

    /**
     * 系统开关
     */
    function sysSwitch()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('open_status');
        return $setting['_value'];
    }

    /**
     * 最大尝试验证登录次数
     * max_login_error
     */
    function maxLoginErrorNumber()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('max_login_error');
        return $setting['_value'];
    }

    /**
     * 登录时需要验证码
     * login_require_captcha
     */
    function loginRequireCaptcha()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('login_require_captcha');
        return $setting['_value'];
    }

    /**
     * 注册时需要验证码
     * reg_require_captcha
     */
    function regRequireCaptcha()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('reg_require_captcha');
        return $setting['_value'];
    }

    /**
     * 邮件发件人显示格式
     * sender_format
     */
    function senderFormat()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('sender_format');
        return $setting['_value'];
    }

    /**
     * 说明
     * description
     */
    function description()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('description');
        return $setting['_value'];
    }

    /**
     * 默认用户时区
     * date_timezone
     */
    function dateTimezone()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('date_timezone');
        return $setting['_value'];
    }

    /**
     * 允许用户为问题投票
     * allow_issue_vote
     */
    function allowIssueVote()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('allow_issue_vote');
        return $setting['_value'];
    }

    /**
     * 允许用户关注问题
     * allow_issue_follow
     */
    function allowIssueFollow()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('allow_issue_follow');
        return $setting['_value'];
    }

    /**
     * 允许用户分享过滤器或面部
     * allow_share_public
     */
    function allowSharePublic()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('allow_share_public');
        return $setting['_value'];
    }

    /**
     * 项目名称最大长度
     * max_project_name
     */
    function maxLengthProjectName()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('max_project_name');
        return $setting['_value'];
    }

    /**
     * 项目键值最大长度
     * max_project_key
     */
    function maxLengthProjectKey()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('max_project_key');
        return $setting['_value'];
    }

    /**
     * 允许使用未分配的问题
     * allow_use_no_assign_issue
     */
    function allowUseNoAssignIssue()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('allow_use_no_assign_issue');
        return $setting['_value'];
    }

    /**
     * 邮件可见性
     * email_public
     */
    function emailPublic()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('email_public');
        return $setting['_value'];
    }

    /**
     * 备注可见性
     * desc_public
     */
    function descPublic()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('desc_public');
        return $setting['_value'];
    }

    /**
     * 问题选择器自动完成
     * enable_filter_autocomplete
     */
    function enableFilterAutocomplete()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('enable_filter_autocomplete');
        return $setting['_value'];
    }

    /**
     * 允许联系管理员
     * allow_contact_admin
     */
    function allowContactAdmin()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('allow_contact_admin');
        return $setting['_value'];
    }

    /**
     * 联系管理员的信息
     * contact_admin_text
     */
    function contactAdminText()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('contact_admin_text');
        return $setting['_value'];
    }

    /**
     * 允许使用Gravatars用户头像
     * allow_gravatars
     */
    function allowGravatars()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('allow_gravatars');
        return $setting['_value'];
    }

    /**
     * Gravatar服务器
     * gravatar_server
     */
    function gravatarServer()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('gravatar_server');
        return $setting['_value'];
    }

    /**
     * 自动更新搜索结果
     * auto_update_search
     */
    function autoUpdateSearch()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('auto_update_search');
        return $setting['_value'];
    }

    /**
     * 项目描述允许使用 HTML 标签
     * allow_project_desc_html
     */
    function allowProjectDescHtml()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('allow_project_desc_html');
        return $setting['_value'];
    }

    /**
     * 默认发送个邮件的格式
     * send_mail_format
     */
    function sendMailFormat()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('send_mail_format');
        return $setting['_value'];
    }

    /**
     * 问题导航每页显示的问题数量
     * issue_page_size
     */
    function issuePageSize()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('issue_page_size');
        return $setting['_value'];
    }

    /**
     * 自定义logo
     * banner
     */
    function banner()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('banner');
        return $setting['_value'];
    }

    /**
     * 图标
     * logo
     */
    function logo()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('logo');
        return $setting['_value'];
    }

    /**
     * 页头背景颜色
     * color_page_bg
     */
    function colorPageBg()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('color_page_bg');
        return $setting['_value'];
    }

    /**
     * 页头高亮背景颜色
     * color_page_header_hover
     */
    function colorPageHeaderHover()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('color_page_header_hover');
        return $setting['_value'];
    }

    /**
     * Header分隔颜色
     * color_header_split
     */
    function colorHeaderSplit()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('color_header_split');
        return $setting['_value'];
    }

    /**
     * 页头文字颜色
     * color_page_header_text
     */
    function colorPageHeaderText()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('color_page_header_text');
        return $setting['_value'];
    }

    /**
     * 页头高亮文字颜色
     * color_page_header_hover_text
     */
    function colorPageHeaderHoverText()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('color_page_header_hover_text');
        return $setting['_value'];
    }

    /**
     * 菜单项高亮背景颜色
     * color_menu_hover
     */
    function colorMenuHover()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('color_menu_hover');
        return $setting['_value'];
    }

    /**
     * 菜单项文字颜色高亮
     * color_menu_hover_text
     */
    function colorMenuHoverText()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('color_menu_hover_text');
        return $setting['_value'];
    }

    /**
     * 时间格式
     * time_format
     */
    function timeFormat()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('time_format');
        return $setting['_value'];
    }

    /**
     * 星期格式
     * week_format
     */
    function weekFormat()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('week_format');
        return $setting['_value'];
    }

    /**
     * 完整日期/时间格式
     * full_datetime_format
     */
    function fullDatetimeFormat()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('full_datetime_format');
        return $setting['_value'];
    }

    /**
     * 短日期格式(年月日)
     * datetime_format
     */
    function datetimeFormat()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('datetime_format');
        return $setting['_value'];
    }

    /**
     * 在日期选择器中使用 ISO8601 标准
     * use_iso
     */
    function useISO()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('use_iso');
        return $setting['_value'];
    }

    /**
     * 允许上传附件
     * allow_attachment
     */
    function allowAttachment()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('allow_attachment');
        return $setting['_value'];
    }

    /**
     * 附件路径
     * attachment_dir
     */
    function attachmentDir()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('attachment_dir');
        return $setting['_value'];
    }

    /**
     * 附件大小(单位M)
     * attachment_size
     */
    function attachmentSize()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('attachment_size');
        return $setting['_value'];
    }

    /**
     * 启用缩略图
     * enbale_thum
     */
    function enbaleThumb()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('enbale_thum');
        return $setting['_value'];
    }

    /**
     * 启用ZIP支持
     * enable_zip
     */
    function enableZip()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('enable_zip');
        return $setting['_value'];
    }

    /**
     * 密码策略
     * password_strategy
     */
    function passwordStrategy()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('password_strategy');
        return $setting['_value'];
    }

    /**
     * 发信人
     * send_mailer
     */
    function sendMailer()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('send_mailer');
        return $setting['_value'];
    }

    /**
     * 前缀
     * mail_prefix
     */
    function mailPrefix()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('mail_prefix');
        return $setting['_value'];
    }

    /**
     * 主机
     * mail_host
     */
    function mailHost()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('mail_host');
        return $setting['_value'];
    }

    /**
     * SMTP端口
     * mail_port
     */
    function mailPort()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('mail_port');
        return $setting['_value'];
    }

    /**
     * 账号
     * mail_account
     */
    function mailAccount()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('mail_account');
        return $setting['_value'];
    }

    /**
     * 密码
     * mail_password
     */
    function mailPassword()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('mail_password');
        return $setting['_value'];
    }

    /**
     * 发送超时
     * mail_timeout
     */
    function mailTimeout()
    {
        $setting = SettingModel::getInstance()->getSettingByKey('mail_timeout');
        return $setting['_value'];
    }

}
