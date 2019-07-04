
<div class="scrolling-tabs-container sub-nav-scroll">
    <div class="fade-left">
        <i class="fa fa-angle-left"></i>
    </div>
    <div class="fade-right">

    </div>

    <div class="nav-links sub-nav scrolling-tabs is-initialized">
        <ul class="container-fluid">
            <li class="filter_nav_li <? if($sys_filter=='' && empty($active_id)) echo 'active';?>">
                <a title="所有事项" href="<?=$issue_main_url?>"><span>所有事项</span>
                </a>
            </li>
            <li class="filter_nav_li <? if($sys_filter=='assignee_mine') echo 'active';?>">
                <a title="分配我的事项" href="<?=$issue_main_url?>?sys_filter=assignee_mine">
                    <span>分配我的</span>
                </a>
            </li>
            <li class="filter_nav_li <? if($sys_filter=='my_unsolved') echo 'active';?>">
                <a title="分配我未解决的事项" href="<?=$issue_main_url?>?sys_filter=my_unsolved">
                    <span>我未解决的</span>
                </a>
            </li>
            <li class="filter_nav_li <? if($sys_filter=='my_report') echo 'active';?>">
                <a title="我报告的事项" href="<?=$issue_main_url?>?sys_filter=my_report"><span>我报告的</span>
                </a>
            </li>
            <li class="filter_nav_li <? if($sys_filter=='open') echo 'active';?>">
                <a title="打开的事项" href="<?=$issue_main_url?>?sys_filter=open"><span>打开的</span>
                </a>
            </li>
            <li class="filter_nav_li <? if($sys_filter=='unsolved') echo 'active';?>">
                <a title="非'已经解决'状态的事项" href="<?=$issue_main_url?>?sys_filter=unsolved"><span>未解决的</span>
                </a>
            </li>
            <li class="filter_nav_li <? if($sys_filter=='active_sprint_unsolved') echo 'active';?>">
                <a title="当前活跃迭代的未解决事项" href="<?=$issue_main_url?>?sys_filter=active_sprint_unsolved"><span>当前迭代未解决的</span>
                </a>
            </li>
            <li class="filter_nav_li <? if($sys_filter=='done') echo 'active';?>">
                <a title="'已经解决'状态的事项" href="<?=$issue_main_url?>?sys_filter=done"><span>完成的</span>
                </a>
            </li>
            <li class="filter_nav_li <? if($sys_filter=='recently_create') echo 'active';?>">
                <a title="按最近创建时间排序" href="<?=$issue_main_url?>?sys_filter=recently_create"><span>最近创建的</span>
                </a>
            </li>
            <li class="filter_nav_li <? if($sys_filter=='recently_resolve') echo 'active';?>">
                <a title="最近解决的" href="<?=$issue_main_url?>?sys_filter=recently_resolve"><span>最近解决的</span>
                </a>
            </li>
            <li class="filter_nav_li <? if($sys_filter=='recently_update') echo 'active';?>">
                <a title="最近更新的" href="<?=$issue_main_url?>?sys_filter=recently_update"><span>最近更新的</span>
                </a>
            </li>
            <?php if( $favFilters) { ?>
            <li class="filter_nav_li  ">
                <a id="custom-filter-more" title="您收藏的过滤器 <a>管理</a>" href="#"><span>自定义过滤器</span><i class="fa fa-caret-down"></i>
                </a>
            </li>
            <?php } ?>
        </ul>

    </div>

</div>
