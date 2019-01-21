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
            <div class="admin_left_header aui-nav-heading  <? if($sub_nav_active=='setting') echo 'active';?>"><strong>用户管理</strong></div>
            <ul class="aui-nav" resolved="">
                <li class="<? if($left_nav_active=='user') echo 'active';?>"><a href="<?=ROOT_URL?>admin/user" id="general_configuration">用户</a>
                </li>
                <li class="<? if($left_nav_active=='group') echo 'active';?>"><a href="<?=ROOT_URL?>admin/group" id="find_more_admin_tools">用户组</a>
                </li>

            </ul>

        </div>
    </div>
</aside>