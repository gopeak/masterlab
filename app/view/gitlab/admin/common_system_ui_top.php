<div class="top-area">
    <ul class="nav-links issues-state-filters">
        <li class="<? if($top_active=='ui_setting') echo 'active';?>">
            <a id="state-opened" title="外观设置" href="<?=ROOT_URL?>admin/system/ui_setting"><span>外观设置</span>
            </a>
        </li>
        <li class="<? if($top_active=='user_default_setting') echo 'active';?>">
            <a id="state-all" title="用户默认设置" href="<?=ROOT_URL?>admin/system/user_default_setting"><span>用户默认设置</span>
            </a>
        </li>
        <li class="<? if($top_active=='default_dashboard') echo 'active';?>">
            <a id="state-all" title="系统仪表板" href="<?=ROOT_URL?>admin/system/default_dashboard"><span>系统仪表板</span>
            </a>
        </li>
        <li class="<? if($top_active=='announcement') echo 'active';?>">
            <a id="state-all" title="公告栏" href="<?=ROOT_URL?>admin/system/announcement"><span>公告栏</span>
            </a>
        </li>
    </ul>
</div>