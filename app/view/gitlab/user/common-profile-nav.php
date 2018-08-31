<ul class="nav-links center user-profile-nav scrolling-tabs">
    <li class="js-activity-tab  <? if($profile_nav=='activity'){ echo 'active';} ?>">
        <a   href="<?=ROOT_URL?>user/profile"><i class="fa fa-calculator" ></i> 活动日志</a>
    </li>

    <li class="js-projects-tab <? if($profile_nav=='have_join_projects'){ echo 'active';} ?>">
        <a  href="<?=ROOT_URL?>user/have_join_projects"><i class="fa fa-product-hunt" ></i> 参与项目</a>
    </li>
    <li class="js-groups-tab <? if($profile_nav=='custom'){ echo 'active';} ?>">
        <a data-target="div#groups" data-action="groups" data-toggle="tab" href="<?=ROOT_URL?>users/sven/groups">操作记录</a>
    </li>

</ul>