<ul class="nav-links center user-profile-nav scrolling-tabs">
    <li class="js-activity-tab  <? if($profile_nav=='activity'){ echo 'active';} ?>">
        <a href="<?=ROOT_URL?>user/profile/<?=$user_id?>"><i class="fa fa-calculator" ></i> 活动日志</a>
    </li>

    <li class="js-projects-tab <? if($profile_nav=='have_join_projects'){ echo 'active';} ?>">
        <a  href="<?=ROOT_URL?>user/have_join_projects/<?=$user_id?>"><i class="fa fa-product-hunt" ></i> 参与项目</a>
    </li>
    <li class="js-groups-tab <? if($profile_nav=='log_operation'){ echo 'active';} ?>">
        <a href="<?=ROOT_URL?>user/log_operation/<?=$user_id?>">操作记录</a>
    </li>

</ul>