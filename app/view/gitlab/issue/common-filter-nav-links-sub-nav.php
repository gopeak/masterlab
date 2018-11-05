
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
            <li>
                <div class="js-notification-dropdown notification-dropdown project-action-button dropdown inline">

                    <div class="js-notification-toggle-btns">
                        <div class="">
                            <?php
                            if (count($favFilters) > 0) {
                                ?>
                                <a class="dropdown-new  notifications-btn " style="color: #8b8f94;" href="#"
                                   data-target="dropdown-15-31-Project" data-toggle="dropdown"
                                   id="notifications-button" type="button" aria-expanded="false">
                                    更多
                                    <i class="fa fa-caret-down"></i>
                                </a>
                            <?php } ?>
                            <ul class="dropdown-menu dropdown-menu-large dropdown-menu-no-wrap dropdown-menu-selectable"
                                role="menu" id="fav_filters">
                                <?php
                                foreach ($favFilters as $f) {
                                    $active = '';
                                    if ($f['id'] == $active_id) {
                                        $active = 'is-active';
                                    }
                                    ?>
                                    <li>
                                        <a class="update-notification <?= $active ?>"
                                           id="fav_filter-<?= $f['id'] ?>"
                                           href="<?= ROOT_URL ?>issue/main?fav_filter=<?= $f['id'] ?>"
                                           role="button">
                                            <strong class="dropdown-menu-inner-title"><?= $f['name'] ?></strong>
                                            <span class="dropdown-menu-inner-content"><?= $f['description'] ?></span>
                                        </a>
                                        <span class="float-right"></span>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </li>

        </ul>


    </div>
</div>
