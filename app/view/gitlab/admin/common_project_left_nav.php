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
            <div class="aui-nav-heading  <? if($sub_nav_active=='setting') echo 'active';?>"><strong>项目</strong></div>
            <ul class="aui-nav" resolved="">
                <li class="<? if($left_nav_active=='list') echo 'active';?>"><a href="<?=ROOT_URL?>admin/project/_list" id="general_configuration">项目列表</a>
                </li>
                <li class="<? if($left_nav_active=='category') echo 'active';?>">
                    <a href="<?=ROOT_URL?>admin/project/category" id="system_info">项目类别</a>
                </li>
            </ul>
            <hr>
        </div>
    </div>
</aside>