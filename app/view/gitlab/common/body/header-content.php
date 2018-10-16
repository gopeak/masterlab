<header class="navbar navbar-gitlab with-horizontal-nav">
    <a class="sr-only gl-accessibility" href="#content-body" tabindex="1">Skip to content</a>
    <div class="container-fluid">


        <div class="header-content">

            <? require_once VIEW_PATH . 'gitlab/common/body/header-logo.php'; ?>
            <? require_once VIEW_PATH . 'gitlab/common/body/header-dropdown.php'; ?>
            <? require_once VIEW_PATH . 'gitlab/common/body/header-title-container.php'; ?>

            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li class="hidden-sm hidden-xs">
                        <div class="has-location-badge search search-form">
                            <form class="navbar-form" action="/search" accept-charset="UTF-8" method="get">
                                <input name="utf8" type="hidden" value="✓">
                                <input name="scope" type="hidden" value="">
                                <div class="search-input-container">
                                    <?php
                                    if (isset($project_id) && $project_id) {
                                        ?>
                                        <div class="location-badge">
                                            当前项目
                                        </div>
                                        <?php
                                    }
                                    ?>
                                    <div class="search-input-wrap">
                                        <div class="dropdown" data-url="/search/autocomplete">
                                            <input type="search" name="keyword" id="search" placeholder="Search"
                                                   class="search-input dropdown-menu-toggle no-outline js-search-dashboard-options disabled"
                                                   spellcheck="false" tabindex="1" autocomplete="off" data-toggle="dropdown"
                                                   data-issues-path="">
                                            <div class="dropdown-menu dropdown-select">
                                                <div class="dropdown-content">
                                                    <ul>
                                                        <li><a class="is-focused dropdown-menu-empty-link"> Loading... </a></li>
                                                    </ul>
                                                </div>
                                                <div class="dropdown-loading">
                                                    <i class="fa fa-spinner fa-spin"></i>
                                                </div>
                                            </div>
                                            <i class="search-icon"></i>
                                            <i class="clear-icon js-clear-input"></i>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="group_id" id="group_id" class="js-search-group-options">
                                <input type="hidden" name="project_id" id="search_project_id" value="<?= @$project_id ?>"
                                       class="js-search-project-options" data-project-path="xphp" data-name="<?=@$project['name']?>"
                                       data-issues-path="<?=@$project_root_url?>/issues">
                                <input type="hidden" name="repository_ref" id="repository_ref">
                                <div class="search-autocomplete-opts hide" data-autocomplete-path="/search/autocomplete"
                                     data-autocomplete-project-id="<?= @$project_id ?>">

                                </div>
                            </form>
                        </div>
                    </li>

                    <li class="visible-sm-inline-block visible-xs-inline-block">
                        <a title="Search" aria-label="Search" data-toggle="tooltip" data-placement="bottom"
                           data-container="body" href="/search">
                            <i class="fa fa-search"></i>
                        </a>
                    </li>

                    <li>
                        <a title="新增项目" aria-label="New project" data-toggle="tooltip" data-placement="bottom"
                           data-container="body" href="<?=ROOT_URL?>project/main/_new">
                            <i class="fa fa-plus fa-fw"></i>
                        </a>
                    </li>

                    <li>
                        <a title="分配给我的问题" aria-label="分配给我的问题" data-toggle="tooltip" data-placement="bottom"
                           data-container="body" href="<?=ROOT_URL?>issue/main?sys_filter=assignee_mine">
                            <i class="fa fa-hashtag fa-fw"></i><!--  <span class="badge issues-count"> <?=$assignee_count?> </span> -->
                        </a>
                    </li>

                    <li>
                        <a title="开启的问题" aria-label="Open issue" class="shortcuts-todos" data-toggle="tooltip"
                           data-placement="bottom"
                           data-container="body" href="<?=ROOT_URL?>issue/main?sys_filter=open">
                            <i class="fa fa-check-circle fa-fw"></i> <span class="badge hidden todos-count">  </span>
                        </a>
                    </li>
                    <li class="header-user dropdown">
                        <a class="header-user-dropdown-toggle" data-toggle="dropdown" href="<?=ROOT_URL?><?= $user['username'] ?>">
                            <img width="26" height="26" class="header-user-avatar" src="<?= $user['avatar'] ?>" alt="Avatar"> <i
                                    class="fa fa-caret-down"></i>
                        </a>
                        <div class="dropdown-menu-nav dropdown-menu-align-right">
                            <ul>
                                <li><a class="profile-link" aria-label="Profile" data-user="sven"
                                       href="<?= ROOT_URL ?>user/profile">个人资料</a></li>
                                <li><a aria-label="Settings" href="<?= ROOT_URL ?>user/profile_edit">个人设置</a></li>
                                <li class="divider"></li>
                                <li><a class="sign-out-link" aria-label="Sign out" rel="nofollow"
                                       href="<?= ROOT_URL ?>passport/logout">注  销</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>

            <button class="navbar-toggle" type="button"><span class="sr-only">Toggle navigation</span> <i
                        class="fa fa-ellipsis-v"></i></button>
            <div class="js-dropdown-menu-projects">
                <div class="dropdown-menu dropdown-select dropdown-menu-projects">
                    <div class="dropdown-title">
                        <span>Go to a project.</span>
                        <button class="dropdown-title-button dropdown-menu-close" aria-label="Close" type="button">
                            <i class="fa fa-times dropdown-menu-close-icon"></i>
                        </button>
                    </div>
                    <div class="dropdown-input">
                        <input type="search" id="project_search" class="dropdown-input-field" placeholder="搜索你的项目"
                               autocomplete="off"/>
                        <i class="fa fa-search dropdown-input-search"></i>
                        <i role="button" class="fa fa-times dropdown-input-clear js-dropdown-input-clear"></i>
                    </div>
                    <div class="dropdown-content"></div>
                    <div class="dropdown-loading">
                        <i class="fa fa-spinner fa-spin"></i>
                    </div>
                </div>
            </div>
        </div>


    </div>
</header>


<!--
<?php include VIEW_PATH . 'gitlab/common/announcement.php';?>
-->
