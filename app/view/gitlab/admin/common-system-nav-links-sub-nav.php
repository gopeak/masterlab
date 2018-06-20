
<div class="scrolling-tabs-container sub-nav-scroll">
    <div class="fade-left">
        <i class="fa fa-angle-left"></i>
    </div>
    <div class="fade-right">
        <i class="fa fa-angle-right"></i>
    </div>

    <div class="nav-links sub-nav scrolling-tabs is-initialized">
        <ul class="container-fluid">
            <li class="<? if($sub_nav_active=='setting') echo 'active';?>">
                <a title="设置" href="<?=ROOT_URL?>admin/system">
                    <span>设置</span>
                </a></li>
            <li class="<? if($sub_nav_active=='security') echo 'active';?>">
                <a title="安全" href="<?=ROOT_URL?>admin/system/security"><span>安全</span>
                </a>
            </li>
            <li class="<? if($sub_nav_active=='ui') echo 'active';?>">
                <a title="用户界面" href="<?=ROOT_URL?>admin/system/ui_setting"><span>用户界面</span>
                </a>
            </li>
            <li class="<? if($sub_nav_active=='email') echo 'active';?>">
                <a title="邮件" href="<?=ROOT_URL?>admin/system/smtp_config"><span>邮件</span>
                </a>
            </li>
            <li class="<? if($sub_nav_active=='export_import') echo 'active';?>">
                <a title="导入与导出" href="<?=ROOT_URL?>admin/system/export_import"><span>导入与导出</span>
                </a>
            </li>
            <li class="<? if($sub_nav_active=='advance') echo 'active';?>">
                <a title="高级" href="<?=ROOT_URL?>admin/system/advance"><span>高级</span>
                </a>
            </li>
        </ul>
    </div>
</div>
