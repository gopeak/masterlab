<?php

if( !isset($left_nav_active) ){
    $left_nav_active = '';
}
if( !isset($sub_nav_active) ){
    $sub_nav_active = '';
}

?>

<aside aria-live="polite" class="js-right-sidebar left-sidebar right-sidebar-expanded affix-top"
       data-spy="affix" tabindex="0"  >
    <div class="issuable-sidebar">

        <div class="admin-menu-links">
            <div class="admin_left_header aui-nav-heading  <? if($sub_nav_active=='setting') echo 'active';?>"><strong>设置</strong></div>
            <ul class="aui-nav" resolved="">
                <li class="<? if($left_nav_active=='setting') echo 'active';?>"><a href="<?=ROOT_URL?>admin/system" id="general_configuration">基本配置</a>
                </li>
                <li class="<? if($left_nav_active=='datetime_setting') echo 'active';?>"><a href="<?=ROOT_URL?>admin/system/datetime_setting" id="find_more_admin_tools">时间设置</a>
                </li>
                <li class="<? if($left_nav_active=='attachment_setting') echo 'active';?>"><a href="<?=ROOT_URL?>admin/system/attachment_setting" id="find_more_admin_tools">附件设置</a>
                </li>
            </ul>
            <hr>
            <div class="admin_left_header aui-nav-heading <? if($sub_nav_active=='ui') echo 'active';?>">界面</div>
            <ul class="aui-nav" resolved="">
                <!--<li class="<? if($left_nav_active=='ui_setting') echo 'active';?>">
                    <a href="<?=ROOT_URL?>admin/system/ui_setting" id="system_info">外观设置</a>
                </li>-->
                <li class="<? if($left_nav_active=='user_default_setting') echo 'active';?>">
                    <a href="<?=ROOT_URL?>admin/system/user_default_setting" id="instrumentation">用户默认设置</a>
                </li>
                <!--<li class="<? if($left_nav_active=='default_dashboard') echo 'active';?>">
                    <a href="#/admin/system/default_dashboard" id="database_connections_link">工作面板todo</a>
                </li>-->
                <li class="<? if($left_nav_active=='announcement') echo 'active';?>">
                    <a href="<?=ROOT_URL?>admin/system/announcement" id="integrity_checker">公告栏</a>
                </li>
            </ul>
            <hr>
            <div class="admin_left_header aui-nav-heading <? if($sub_nav_active=='security') echo 'active';?>">安全</div>
            <ul class="aui-nav" resolved="">
<!--                <li class="<?/* if($left_nav_active=='permission') echo 'active';*/?>">
                    <a href="<?/*=ROOT_URL*/?>admin/permission/default_role" id="permission_role_browser">默认角色</a>
                </li>-->
                <li class="<? if($left_nav_active=='global_permission') echo 'active';?>">
                    <a href="<?=ROOT_URL?>admin/system/global_permission" id="global_permissions">全局权限</a>
                </li>
                <li class="<? if($left_nav_active=='password_strategy') echo 'active';?>">
                    <a href="<?=ROOT_URL?>admin/system/password_strategy" id="password_strategy">密码策略</a>
                </li>
<!--                <li class="<?/* if($left_nav_active=='user_session') echo 'active';*/?>">
                    <a href="<?/*=ROOT_URL*/?>admin/system/user_session" id="user_session">用户会话</a>
                </li>-->
            </ul>
            <hr>
            <div class="admin_left_header aui-nav-heading <? if($sub_nav_active=='email') echo 'active';?>">邮件</div>
            <ul class="aui-nav" resolved="">
                <li class="<? if($left_nav_active=='smtp_config') echo 'active';?>">
                    <a href="<?=ROOT_URL?>admin/system/smtp_config" id="outgoing_mail">邮件配置</a>
                </li>
                <li class="<? if($left_nav_active=='email_queue') echo 'active';?>">
                    <a href="<?=ROOT_URL?>admin/system/email_queue" id="mail_queue">邮件队列</a>
                </li>
                <li class="<? if($left_nav_active=='email_notify_setting') echo 'active';?>">
                    <a href="<?=ROOT_URL?>admin/system/email_notify_setting" id="email_notify_setting">邮件通知配置</a>
                </li>
                <li class="<? if($left_nav_active=='send_mail') echo 'active';?>">
                    <a href="<?=ROOT_URL?>admin/system/send_mail" id="send_email">发送邮件</a>
                </li>
            </ul>
            <!--
            <hr>
            <div class="admin_left_header aui-nav-heading <? if($sub_nav_active=='import_export') echo 'active';?>">导入与导出todo</div>
            <ul class="aui-nav" resolved="">
                <li class="<? if($left_nav_active=='backup_data') echo 'active';?>">
                    <a href="<?=ROOT_URL?>admin/system/backup_data" id="backup_data">备份系统数据</a>
                </li>
                <li class="<? if($left_nav_active=='restore_data') echo 'active';?>">
                    <a href="<?=ROOT_URL?>admin/system/restore_data" id="restore_data">恢复系统数据</a>
                </li>
              <li>
                    <a href="#" id="project_import">项目导入</a>
                </li>
                <li>
                    <a href="#" id="external_import">导入外部系统</a>
                </li>-
            </ul>->

<!--            <hr>
            <div class="admin_left_header aui-nav-heading <?/* if($sub_nav_active=='share') echo 'active';*/?>">共享条目todo</div>
            <ul class="aui-nav" resolved="">
                <li><a href="#" id="shared_filters">共享的过滤器</a></li>
                <li><a href="#" id="shared_dashboards">共享的仪表板</a></li>
            </ul>-->
            <hr>
            <div class="admin_left_header aui-nav-heading <? if($sub_nav_active=='advanced') echo 'active';?>">高级</div>
            <ul class="aui-nav" resolved="">
                <li>
                    <a href="<?=ROOT_URL?>admin/system/cache"  class="<? if($left_nav_active=='system_cache') echo 'active';?>" id="system_cache">缓存</a>
                </li>
                <li>
                    <a href="#" id="services">服务(敬请期待)</a>
                </li>
                <li>
                    <a href="#a" id="eventtypes">事件(敬请期待)</a>
                </li>
                <li>
                    <a href="#" id="webhooks-admin">网络钩子(敬请期待)</a>
                </li>
            </ul>
            <hr>
            <div class="admin_left_header aui-nav-heading <? if($sub_nav_active=='log') echo 'active';?>">日志</div>
            <ul class="aui-nav" resolved="">
                <li><a href="<?=ROOT_URL?>admin/log_operating/index"  class="<? if($left_nav_active=='log_operating') echo 'active';?>" id="log_operating">操作日志</a></li>
               <!-- <li><a href="#" id="logging_profiling">日志和分析</a></li>-->
                <li><a href="<?=ROOT_URL?>admin/log_operating/slow_sql" class="<? if($left_nav_active=='log_slow_sql') echo 'active';?>" id="log_slow_sql">Sql慢查询</a></li>
               <!-- <li><a href="#" id="scheduler_details">计划程序详情</a></li>
                <li><a href="#" id="view_auditing">审计日志</a></li>-->
            </ul>
           <hr>

        </div>
    </div>
</aside>