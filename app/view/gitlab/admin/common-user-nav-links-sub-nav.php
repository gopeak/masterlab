
<div class="scrolling-tabs-container sub-nav-scroll">
    <div class="fade-left">
        <i class="fa fa-angle-left"></i>
    </div>
    <div class="fade-right">
        <i class="fa fa-angle-right"></i>
    </div>

    <div class="nav-links sub-nav scrolling-tabs is-initialized">
        <ul class="container-fluid">
            <li class="<? if($sub_nav_active=='user') echo 'active';?>">
                <a title="用户" href="<?=ROOT_URL?>admin/user">
                    <span>用户</span>
                </a></li>
            <li class="<? if($sub_nav_active=='group') echo 'active';?>">
                <a title="用户组" href="<?=ROOT_URL?>admin/user/group"><span>用户组</span>
                </a>
            </li>
        </ul>
    </div>
</div>
