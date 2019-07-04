<ul class="nav-links center user-profile-nav scrolling-tabs">

    <li class="js-groups-tab <? if($profile_nav=='custom_index'){ echo 'active';} ?>">
        <a href="<?=ROOT_URL?>user/widgets"><i class="fa fa-arrows" ></i> 自定义面板</a>
    </li>
    <li class="js-groups-tab <? if($profile_nav=='preferences'){ echo 'active';} ?>">
        <a href="<?=ROOT_URL?>user/preferences"><i class="fa fa-eye" ></i> 界面设置</a>
    </li>
    <li class="js-groups-tab <? if($profile_nav=='filters'){ echo 'active';} ?>">
        <a href="<?=ROOT_URL?>user/filters"><i class="fa fa-filter" ></i> 自定义过滤器</a>
    </li>
   <li class="js-groups-tab <? if($profile_nav=='notify'){ echo 'active';} ?>">
        <a data-target="div#groups" data-action="groups" data-toggle="tab" href="<?=ROOT_URL?>users/sven/groups"><i class="fa fa-envelope" ></i> 通知设置(开发中)</a>
    </li>
    <li class="js-snippets-tab <? if($profile_nav=='profile_edit'){ echo 'active';} ?>">
        <a  href="<?=ROOT_URL?>user/profile_edit"><i class="fa fa-edit" ></i> 修改资料</a>
    </li>
    <li class="js-snippets-tab <? if($profile_nav=='password'){ echo 'active';} ?>">
        <a href="<?=ROOT_URL?>user/password"><i class="fa fa-lock" ></i> 修改密码</a>
    </li>

</ul>