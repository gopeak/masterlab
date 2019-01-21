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
            <div class="admin_left_header aui-nav-heading  <? if($sub_nav_active=='issue_type') echo 'active';?>"><strong>事项类型</strong></div>
            <ul class="aui-nav" resolved="">
                <li class="<? if($left_nav_active=='type') echo 'active';?>">
                    <a href="<?=ROOT_URL?>admin/issue_type" id="left_issue_type">事项类型</a>
                </li>
                <li class="<? if($left_nav_active=='type_scheme') echo 'active';?>">
                    <a href="<?=ROOT_URL?>admin/issue_type_scheme" id="left_issue_type_scheme">事项类型方案</a>
                </li>
                <li class="<? if($left_nav_active=='type_tpl') echo 'active';?>">
                    <a href="<?=ROOT_URL?>admin/issue_desc_tpl" id="left_issue_desc_tpl">事项描述模板</a>
                </li>
            </ul>
            <hr>
            <div  class="admin_left_header aui-nav-heading <? if($sub_nav_active=='issue_attribute') echo 'active';?>">事项属性</div>
            <ul class="aui-nav" resolved="">
                <li class="<? if($left_nav_active=='status') echo 'active';?>">
                    <a href="<?=ROOT_URL?>admin/issue_status" id="left_status">状态</a>
                </li>
                <li class="<? if($left_nav_active=='workflow') echo 'active';?>">
                    <a href="<?=ROOT_URL?>admin/workflow" id="left_worker_flow">工作流</a>
                </li>
                <li class="<? if($left_nav_active=='user_default_setting') echo 'active';?>">
                    <a href="<?=ROOT_URL?>admin/workflow_scheme" id="left_worker_flow_scheme">工作流方案</a>
                </li>
                <li class="<? if($left_nav_active=='resolve') echo 'active';?>">
                    <a href="<?=ROOT_URL?>admin/issue_resolve" id="left_resolve">解决结果</a>
                </li>
                <li class="<? if($left_nav_active=='priority') echo 'active';?>">
                    <a href="<?=ROOT_URL?>admin/issue_priority" id="left_priority">优先级</a>
                </li>
            </ul>
            <div  class="admin_left_header aui-nav-heading <? if($sub_nav_active=='ui') echo 'active';?>">事项界面</div>
            <ul class="aui-nav" resolved="">
                <li class="<? if($left_nav_active=='field') echo 'active';?>">
                    <a href="<?=ROOT_URL?>admin/field" id="left_field_custom">字段</a>
                </li>
                <li class="<? if($left_nav_active=='issue_ui') echo 'active';?>">
                    <a href="<?=ROOT_URL?>admin/issue_ui" id="left_issue_ui">事项类型界面方案</a>
                </li>
            </ul>

        </div>
    </div>
</aside>