
<div class="scrolling-tabs-container sub-nav-scroll">
    <div class="fade-left">
        <i class="fa fa-angle-left"></i>
    </div>
    <div class="fade-right">
        <i class="fa fa-angle-right"></i>
    </div>

    <div class="nav-links sub-nav scrolling-tabs is-initialized">
        <ul class="container-fluid">
            <li class="filter_nav_li <? if($sys_filter=='') echo 'active';?>">
                <a title="所有问题" href="<?=ROOT_URL?>issue/main"><span>所有问题</span>
                </a>
            </li>
            <li class="filter_nav_li <? if($sys_filter=='assignee_mine') echo 'active';?>">
                <a title="分配我的问题" href="<?=ROOT_URL?>issue/main?sys_filter=assignee_mine">
                    <span>分配我的</span>
                </a></li>
            <li class="filter_nav_li <? if($sys_filter=='my_report') echo 'active';?>">
                <a title="我报告的问题" href="<?=ROOT_URL?>issue/main?sys_filter=my_report"><span>我报告的</span>
                </a>
            </li>
            <li class="filter_nav_li <? if($sys_filter=='open') echo 'active';?>">
                <a title="Open issues" href="<?=ROOT_URL?>issue/main?sys_filter=open"><span>打开的</span>
                </a>
            </li>
            <li class="filter_nav_li <? if($sys_filter=='done') echo 'active';?>">
                <a title="Done issues" href="<?=ROOT_URL?>issue/main?sys_filter=done"><span>完成的</span>
                </a>
            </li>
            <li class="filter_nav_li <? if($sys_filter=='recently_create') echo 'active';?>">
                <a title="Created recently" href="<?=ROOT_URL?>issue/main?sys_filter=recently_create"><span>最近创建的</span>
                </a>
            </li>
            <li class="filter_nav_li <? if($sys_filter=='recently_resolve') echo 'active';?>">
                <a title="最近解决的" href="<?=ROOT_URL?>issue/main?sys_filter=recently_resolve"><span>最近解决的</span>
                </a>
            </li>
            <li class="filter_nav_li <? if($sys_filter=='update_recently') echo 'active';?>">
                <a title="最近更新的" href="<?=ROOT_URL?>issue/main?sys_filter=recently_update"><span>最近更新的</span>
                </a>
            </li>
        </ul>

    </div>
</div>
