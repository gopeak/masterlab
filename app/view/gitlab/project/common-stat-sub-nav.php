
<div class="scrolling-tabs-container sub-nav-scroll">
    <div class="fade-left">
        <i class="fa fa-angle-left"></i>
    </div>
    <div class="fade-right">
        <i class="fa fa-angle-right"></i>
    </div>

    <div class="nav-links sub-nav scrolling-tabs is-initialized">
        <ul class="container-fluid">
            <li class="<? if($sub_nav_active=='project') echo 'active';?>">
                <a href="<?=$project_root_url?>/stat"><span>项目统计</span></a>
            </li>
            <li class="<? if($sub_nav_active=='sprint') echo 'active';?>">
                <a href="<?=$project_root_url?>/stat_sprint">迭代统计</a>
            </li>
        </ul>

    </div>
</div>
