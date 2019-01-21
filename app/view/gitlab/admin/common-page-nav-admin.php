<div class="layout-nav">
    <div class="container-fluid">
        <div class="nav-control scrolling-tabs-container">
            <div class="fade-left">
                <i class="fa fa-angle-left"></i>
            </div>
            <div class="fade-right">
                <i class="fa fa-angle-right"></i>
            </div>
            <ul class="nav-links scrolling-tabs">

                <li class="<? if($nav_links_active=='project') echo 'active';?>">
                    <a title="项目" href="<?=ROOT_URL?>admin/project">
                        <i class="fa fa-product-hunt"></i> <span>项目</span>
                    </a></li>
                <li class="<? if($nav_links_active=='issue') echo 'active';?>">
                    <a title="事项" href="<?=ROOT_URL?>admin/issue_type"><i class="fa fa-bug"></i> <span>事项</span>
                    </a>
                </li>
                <li class="<? if($nav_links_active=='user') echo 'active';?>">
                    <a title="用户管理" href="<?=ROOT_URL?>admin/user"><i class="fa fa-user"></i> <span>用户管理</span>
                    </a>
                </li>
                <li class="<? if($nav_links_active=='system') echo 'active';?>">
                    <a title="系统" href="<?=ROOT_URL?>admin/system"><i class="fa fa-cogs"></i> <span>系统</span>
                    </a>
                </li>

            </ul>
        </div>
    </div>
</div>

<style type="text/css">
    .admin_left_header{
        font-weight: bold;
        /*margin-left: 0px !important;*/
    }
</style>
