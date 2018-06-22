<!DOCTYPE html>
<html class="" lang="en">
<head  >

    <? require_once VIEW_PATH . 'gitlab/common/header/include.php';?>
    <script src="<?=ROOT_URL?>gitlab/assets/webpack/filtered_search.bundle.js"></script>

</head>
<body class="" data-group="" data-page="projects:issues:index" data-project="xphp">
<? require_once VIEW_PATH . 'gitlab/common/body/script.php';?>
<header class="navbar navbar-gitlab with-horizontal-nav">
    <a class="sr-only gl-accessibility" href="#content-body" tabindex="1">Skip to content</a>
    <div class="container-fluid">
        <? require_once VIEW_PATH . 'gitlab/common/body/header-content.php';?>
    </div>
</header>
<script>
    var findFileURL = "/ismond/xphp/find_file/master";
</script>
<div class="page-with-sidebar">
    <? require_once VIEW_PATH . 'gitlab/project/common-page-nav-project.php';?>

    <? require_once VIEW_PATH . 'gitlab/issue/common-filter-nav-links-sub-nav.php';?>



    <div class="content-wrapper page-with-layout-nav page-with-sub-nav">
        <div class="alert-wrapper">

            <div class="flash-container flash-container-page">
            </div>

        </div>

        <div class="container-fluid ">

            <div class="content" id="content-body">

                <nav class="container-fluid project-stats">

                    <ul class="nav nav-links issues-state-filters">
                        <li class="missing">
                            <a href="#">新增过滤器
                            </a>
                        </li>

                        <li class="active">
                            <a id="state-opened" title="Filter by issues that are currently opened."
                               href="/ismond/xphp/issues?scope=all&amp;state=opened"><span>杨文杰未解决</span> <span class="badge">0</span>
                            </a>
                        </li>
                        <li class="">
                            <a id="state-all" title="Filter by issues that are currently closed."
                               href="/ismond/xphp/issues?scope=all&amp;state=closed"><span>所有重构的问题</span> <span class="badge">1</span>
                            </a>
                        </li>
                        <li class="">
                            <a id="state-all" title="Show all issues."
                               href="/ismond/xphp/issues?scope=all&amp;state=all"><span>App所有问题</span> <span class="badge">1</span>
                            </a>
                        </li>
                        <li class="">
                            <a id="state-all" title="Show all issues."
                               href="/ismond/xphp/issues?scope=all&amp;state=all"><span>App未解决</span> <span class="badge">1</span>
                            </a>
                        </li>
                    </ul>
                </nav>

                <div class="container-fluid">

                    <div class="issues-filters">
                        <div class="filtered-search-block issues-details-filters row-content-block second-block" v-pre="false">
                            <form class="filter-form js-filter-form" action="/ismond/xphp/issues?scope=all&amp;state=opened" accept-charset="UTF-8" method="get"><input name="utf8" type="hidden" value="✓"><div class="check-all-holder">
                                    <input type="checkbox" name="check_all_issues" id="check_all_issues" class="check_all_issues left">
                                </div>
                                <div class="issues-other-filters filtered-search-wrapper">
                                    <div class="filtered-search-box">
                                        <div class="dropdown filtered-search-history-dropdown-wrapper">
                                            <button class="dropdown-menu-toggle filtered-search-history-dropdown-toggle-button" type="button" data-toggle="dropdown">
                                                <span class="dropdown-toggle-text "><i class="fa fa-history"></i></span><i class="fa fa-chevron-down"></i></button>
                                            <div class="dropdown-menu dropdown-select filtered-search-history-dropdown">
                                                <div class="dropdown-title"><span>Recent searches</span><button class="dropdown-title-button dropdown-menu-close" aria-label="Close" type="button"><i class="fa fa-times dropdown-menu-close-icon"></i></button></div><div class="dropdown-content filtered-search-history-dropdown-content"><div><div class="dropdown-info-note">
                                                            You don't have any recent searches
                                                        </div></div>
                                                </div><div class="dropdown-loading"><i class="fa fa-spinner fa-spin"></i></div></div></div><div class="filtered-search-box-input-container">
                                            <div class="scroll-container">
                                                <ul class="tokens-container list-unstyled">
                                                    <li class="input-token">
                                                        <input class="form-control filtered-search" data-base-endpoint="/ismond/xphp" data-project-id="31" data-username-params="[]" id="filtered-search-issues" placeholder="Search or filter results..." data-dropdown-trigger="#js-dropdown-hint">
                                                    </li>
                                                </ul>
                                                <i class="fa fa-filter"></i>
                                                <button class="clear-search hidden" type="button">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            </div>
                                            <div class="filtered-search-input-dropdown-menu dropdown-menu hint-dropdown" id="js-dropdown-hint" data-dropdown-active="true" style="left: 30px;">
                                                <ul data-dropdown="">
                                                    <li class="filter-dropdown-item" data-action="submit">
                                                        <button class="btn btn-link">
                                                            <i class="fa fa-search"></i>
                                                            <span>
Press Enter or click to search
</span>
                                                        </button>
                                                    </li>
                                                </ul>
                                                <ul class="filter-dropdown" data-dropdown="" data-dynamic=""><li class="filter-dropdown-item" style="display: block;">
                                                        <button class="btn btn-link">
                                                            <i class="fa fa-pencil"></i>
                                                            <span class="js-filter-hint">
author
</span>
                                                            <span class="js-filter-tag dropdown-light-content">
&lt;@author&gt;
</span>
                                                        </button>
                                                    </li><li class="filter-dropdown-item" style="display: block;">
                                                        <button class="btn btn-link">
                                                            <i class="fa fa-user"></i>
                                                            <span class="js-filter-hint">
assignee
</span>
                                                            <span class="js-filter-tag dropdown-light-content">
&lt;@assignee&gt;
</span>
                                                        </button>
                                                    </li><li class="filter-dropdown-item" style="display: block;">
                                                        <button class="btn btn-link">
                                                            <i class="fa fa-clock-o"></i>
                                                            <span class="js-filter-hint">
milestone
</span>
                                                            <span class="js-filter-tag dropdown-light-content">
&lt;%milestone&gt;
</span>
                                                        </button>
                                                    </li><li class="filter-dropdown-item" style="display: block;">
                                                        <button class="btn btn-link">
                                                            <i class="fa fa-tag"></i>
                                                            <span class="js-filter-hint">
label
</span>
                                                            <span class="js-filter-tag dropdown-light-content">
&lt;~label&gt;
</span>
                                                        </button>
                                                    </li></ul>
                                            </div>
                                            <div class="filtered-search-input-dropdown-menu dropdown-menu" data-hint="author" data-icon="pencil" data-tag="@author" id="js-dropdown-author">
                                                <ul class="filter-dropdown" data-dropdown="" data-dynamic="">
                                                    <li class="filter-dropdown-item">
                                                        <button class="btn btn-link dropdown-user">
                                                            <img alt="{{name}}'s avatar" class="avatar" data-src="{{avatar_url}}" width="30">
                                                            <div class="dropdown-user-details">
                                                                <span>{{name}}</span>
                                                                <span class="dropdown-light-content">@{{username}}</span>
                                                            </div>
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="filtered-search-input-dropdown-menu dropdown-menu" data-hint="assignee" data-icon="user" data-tag="@assignee" id="js-dropdown-assignee">
                                                <ul data-dropdown="">
                                                    <li class="filter-dropdown-item" data-value="none">
                                                        <button class="btn btn-link">
                                                            No Assignee
                                                        </button>
                                                    </li>
                                                    <li class="divider"></li>
                                                </ul>
                                                <ul class="filter-dropdown" data-dropdown="" data-dynamic="">
                                                    <li class="filter-dropdown-item">
                                                        <button class="btn btn-link dropdown-user">
                                                            <img alt="{{name}}'s avatar" class="avatar" data-src="{{avatar_url}}" width="30">
                                                            <div class="dropdown-user-details"><span>{{name}}</span>
                                                                <span class="dropdown-light-content">@{{username}}</span>
                                                            </div>
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="filtered-search-input-dropdown-menu dropdown-menu" data-hint="milestone" data-icon="clock-o" data-tag="%milestone" id="js-dropdown-milestone">
                                                <ul data-dropdown="">
                                                    <li class="filter-dropdown-item" data-value="none">
                                                        <button class="btn btn-link">
                                                            No Milestone
                                                        </button>
                                                    </li>
                                                    <li class="filter-dropdown-item" data-value="upcoming">
                                                        <button class="btn btn-link">
                                                            Upcoming
                                                        </button>
                                                    </li>
                                                    <li class="filter-dropdown-item" data-value="started">
                                                        <button class="btn btn-link">
                                                            Started
                                                        </button>
                                                    </li>
                                                    <li class="divider"></li>
                                                </ul>
                                                <ul class="filter-dropdown" data-dropdown="" data-dynamic="">
                                                    <li class="filter-dropdown-item">
                                                        <button class="btn btn-link js-data-value">
                                                            {{title}}
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="filtered-search-input-dropdown-menu dropdown-menu" data-hint="label" data-icon="tag" data-tag="~label" data-type="array" id="js-dropdown-label">
                                                <ul data-dropdown="">
                                                    <li class="filter-dropdown-item" data-value="none">
                                                        <button class="btn btn-link">
                                                            No Label
                                                        </button>
                                                    </li>
                                                    <li class="divider"></li>
                                                </ul>
                                                <ul class="filter-dropdown" data-dropdown="" data-dynamic="">
                                                    <li class="filter-dropdown-item">
                                                        <button class="btn btn-link">
                                                            <span class="dropdown-label-box" style="background: {{color}}"></span>
                                                            <span class="label-title js-data-value">
{{title}}
</span>
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="filter-dropdown-container">
                                        <div class="dropdown inline prepend-left-10">
                                            <button class="dropdown-toggle" data-toggle="dropdown" type="button">
                                                Last created
                                                <i class="fa fa-chevron-down"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-align-right dropdown-menu-sort">
                                                <li>
                                                    <a href="/ismond/xphp/issues?scope=all&amp;sort=priority&amp;state=opened">Priority
                                                    </a><a href="/ismond/xphp/issues?scope=all&amp;sort=label_priority&amp;state=opened">Label priority
                                                    </a><a href="/ismond/xphp/issues?scope=all&amp;sort=created_desc&amp;state=opened">Last created
                                                    </a><a href="/ismond/xphp/issues?scope=all&amp;sort=created_asc&amp;state=opened">Oldest created
                                                    </a><a href="/ismond/xphp/issues?scope=all&amp;sort=updated_desc&amp;state=opened">Last updated
                                                    </a><a href="/ismond/xphp/issues?scope=all&amp;sort=updated_asc&amp;state=opened">Oldest updated
                                                    </a><a href="/ismond/xphp/issues?scope=all&amp;sort=milestone_due_asc&amp;state=opened">Milestone due soon
                                                    </a><a href="/ismond/xphp/issues?scope=all&amp;sort=milestone_due_desc&amp;state=opened">Milestone due later
                                                    </a><a href="/ismond/xphp/issues?scope=all&amp;sort=due_date_asc&amp;state=opened">Due soon
                                                    </a><a href="/ismond/xphp/issues?scope=all&amp;sort=due_date_desc&amp;state=opened">Due later
                                                    </a><a href="/ismond/xphp/issues?scope=all&amp;sort=upvotes_desc&amp;state=opened">Most popular
                                                    </a><a href="/ismond/xphp/issues?scope=all&amp;sort=downvotes_desc&amp;state=opened">Least popular
                                                    </a></li>
                                            </ul>
                                        </div>

                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <script>
                        new UsersSelect();
                        new LabelsSelect();
                        new MilestoneSelect();
                        new IssueStatusSelect();
                        new SubscriptionSelect();

                        $(document).off('page:restore').on('page:restore', function (event) {
                            if (gl.FilteredSearchManager) {
                                new gl.FilteredSearchManager();
                            }
                            Issuable.init();
                            new gl.IssuableBulkActions({
                                prefixId: 'issue_',
                            });
                        });
                    </script>

                    <div class="issues-holder">
                        <ul class="content-list issues-list issuable-list">

                            <div class="table-holder">
                                <table class="table  tree-table">
                                    <thead>
                                    <tr>
                                        <th class="js-pipeline-info pipeline-info">类型</th>
                                        <th class="js-pipeline-info pipeline-info">关键字</th>
                                        <th class="js-pipeline-info pipeline-info">模块</th>
                                        <th class="js-pipeline-commit pipeline-commit">主题</th>
                                        <th class="js-pipeline-stages pipeline-info">经办人</th>
                                        <th class="js-pipeline-stages pipeline-info"><span class="js-pipeline-date pipeline-stages">报告人</span></th>
                                        <th class="js-pipeline-stages pipeline-info"><span class="js-pipeline-date pipeline-stages">优先级</span></th>
                                        <th class="js-pipeline-stages pipeline-info"><span class="js-pipeline-date pipeline-stages">状态</span></th>
                                        <th class="js-pipeline-stages pipeline-info"><span class="js-pipeline-date pipeline-stages">解决结果</span></th>
                                        <th class="js-pipeline-date pipeline-date">创建时间</th>
                                        <th class="js-pipeline-date pipeline-date">更新时间</th>
                                        <th class="js-pipeline-actions pipeline-actions"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr class="tree-item">
                                        <td>
                                            <i class="fa fa-code-fork"></i>
                                            <a href="#"  class="commit-id monospace">Scrum</a>
                                        </td>
                                        <td>
                                            <i class="fa fa-code-fork"></i>
                                            <a href="#"  class="commit-id monospace">AAA</a>
                                        </td>
                                        <td>
                                            <i class="fa fa-code-fork"></i>
                                            <a href="#"  class="commit-id monospace">module</a>
                                        </td>
                                        <td>
                                            <div class="branch-commit">
                                                <p class="commit-title">
                                                    <strong><span>
                                                    <a href="mailto:1131544367@qq.com" class="avatar-image-container">
                                                        <img src="http://www.gravatar.com/avatar/369ea35620f75dddced869daa37a6a7e?s=80&amp;d=identicon"
                                                             title="guosheng" class="avatar has-tooltip s20">
                                                    </a>
                                                    <a href="<?=ROOT_URL?>project/main/home" class="commit-row-message">
                                                        Merge branch 'test'
                                                    </a>
                                                </span>
                                                    </strong>
                                                </p>
                                                <div class="icon-container">
                                                    <i class="fa fa-tag"></i>
                                                </div>
                                                <a href="/ismond/ProductTree/tree/v1.1.2" class="monospace branch-name">v1.1.2</a>

                                                <span href="#" class="commit-id monospace">ismond/xphp............................................</span>

                                            </div>
                                        </td>
                                        <td  >
                                                <span class="list-item-name">
                                                    <img class="avatar s40" alt="" src="http://192.168.3.213/uploads/user/avatar/15/avatar.png">
                                                    <strong>
                                                        <a href="/sven">韦朝夺</a>
                                                    </strong>
                                                    <span class="cgray">@sven</span>
                                                </span>

                                        </td>
                                        <td  >
                                                <span class="list-item-name">
                                                    <img class="avatar s40" alt="" src="http://192.168.3.213/uploads/user/avatar/15/avatar.png">
                                                    <strong>
                                                        <a href="/sven">韦朝夺</a>
                                                    </strong>
                                                    <span class="cgray">@sven</span>
                                                </span>



                                        </td>
                                        <td  >
                                            <span class="label dropdown-labels-error prepend-left-5">高</span>



                                        </td>
                                        <td  >
                                            <span class="label label-success prepend-left-5">进行中</span>


                                        </td>

                                        <td  >
                                            <a href="#" class="commit-id monospace">已解决</a>

                                        </td>
                                        <td >4 days ago
                                        </td>
                                        <td >4 days ago
                                        </td>
                                        <td class="pipeline-actions">
                                            <div class="pull-right btn-group">

                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="tree-item">
                                        <td>
                                            <i class="fa fa-code-fork"></i>
                                            <a href="#"  class="commit-id monospace">Scrum</a>
                                        </td>
                                        <td>
                                            <i class="fa fa-code-fork"></i>
                                            <a href="#"  class="commit-id monospace">AAA</a>
                                        </td>
                                        <td>
                                            <i class="fa fa-code-fork"></i>
                                            <a href="#"  class="commit-id monospace">module</a>
                                        </td>
                                        <td>
                                            <div class="branch-commit">
                                                <p class="commit-title">
                                                    <strong><span>
                                                    <a href="mailto:1131544367@qq.com" class="avatar-image-container">
                                                        <img src="http://www.gravatar.com/avatar/369ea35620f75dddced869daa37a6a7e?s=80&amp;d=identicon"
                                                             title="guosheng" class="avatar has-tooltip s20">
                                                    </a>
                                                    <a href="<?=ROOT_URL?>project/main/home" class="commit-row-message">
                                                        Merge branch 'test'
                                                    </a>
                                                </span>
                                                    </strong>
                                                </p>
                                                <div class="icon-container">
                                                    <i class="fa fa-tag"></i>
                                                </div>
                                                <a href="/ismond/ProductTree/tree/v1.1.2" class="monospace branch-name">v1.1.2</a>

                                                <span href="#" class="commit-id monospace">ismond/xphp............................................</span>

                                            </div>
                                        </td>
                                        <td  >
                                                <span class="list-item-name">
                                                    <img class="avatar s40" alt="" src="http://192.168.3.213/uploads/user/avatar/15/avatar.png">
                                                    <strong>
                                                        <a href="/sven">韦朝夺</a>
                                                    </strong>
                                                    <span class="cgray">@sven</span>
                                                </span>

                                        </td>
                                        <td  >
                                                <span class="list-item-name">
                                                    <img class="avatar s40" alt="" src="http://192.168.3.213/uploads/user/avatar/15/avatar.png">
                                                    <strong>
                                                        <a href="/sven">韦朝夺</a>
                                                    </strong>
                                                    <span class="cgray">@sven</span>
                                                </span>



                                        </td>
                                        <td  >
                                            <span class="label dropdown-labels-error prepend-left-5">高</span>



                                        </td>
                                        <td  >
                                            <span class="label label-success prepend-left-5">进行中</span>


                                        </td>

                                        <td  >
                                            <a href="#" class="commit-id monospace">已解决</a>

                                        </td>
                                        <td >4 days ago
                                        </td>
                                        <td >4 days ago
                                        </td>
                                        <td class="pipeline-actions">
                                            <div class="pull-right btn-group">

                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="tree-item">
                                        <td>
                                            <i class="fa fa-code-fork"></i>
                                            <a href="#"  class="commit-id monospace">Scrum</a>
                                        </td>
                                        <td>
                                            <i class="fa fa-code-fork"></i>
                                            <a href="#"  class="commit-id monospace">AAA</a>
                                        </td>
                                        <td>
                                            <i class="fa fa-code-fork"></i>
                                            <a href="#"  class="commit-id monospace">module</a>
                                        </td>
                                        <td>
                                            <div class="branch-commit">
                                                <p class="commit-title">
                                                    <strong><span>
                                                    <a href="mailto:1131544367@qq.com" class="avatar-image-container">
                                                        <img src="http://www.gravatar.com/avatar/369ea35620f75dddced869daa37a6a7e?s=80&amp;d=identicon"
                                                             title="guosheng" class="avatar has-tooltip s20">
                                                    </a>
                                                    <a href="<?=ROOT_URL?>project/main/home" class="commit-row-message">
                                                        Merge branch 'test'
                                                    </a>
                                                </span>
                                                    </strong>
                                                </p>
                                                <div class="icon-container">
                                                    <i class="fa fa-tag"></i>
                                                </div>
                                                <a href="/ismond/ProductTree/tree/v1.1.2" class="monospace branch-name">v1.1.2</a>

                                                <span href="#" class="commit-id monospace">ismond/xphp............................................</span>

                                            </div>
                                        </td>
                                        <td  >
                                                <span class="list-item-name">
                                                    <img class="avatar s40" alt="" src="http://192.168.3.213/uploads/user/avatar/15/avatar.png">
                                                    <strong>
                                                        <a href="/sven">韦朝夺</a>
                                                    </strong>
                                                    <span class="cgray">@sven</span>
                                                </span>

                                        </td>
                                        <td  >
                                                <span class="list-item-name">
                                                    <img class="avatar s40" alt="" src="http://192.168.3.213/uploads/user/avatar/15/avatar.png">
                                                    <strong>
                                                        <a href="/sven">韦朝夺</a>
                                                    </strong>
                                                    <span class="cgray">@sven</span>
                                                </span>



                                        </td>
                                        <td  >
                                            <span class="label dropdown-labels-error prepend-left-5">高</span>



                                        </td>
                                        <td  >
                                            <span class="label label-success prepend-left-5">进行中</span>


                                        </td>

                                        <td  >
                                            <a href="#" class="commit-id monospace">已解决</a>

                                        </td>
                                        <td >4 days ago
                                        </td>
                                        <td >4 days ago
                                        </td>
                                        <td class="pipeline-actions">
                                            <div class="pull-right btn-group">

                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="tree-item">
                                        <td>
                                            <i class="fa fa-code-fork"></i>
                                            <a href="#"  class="commit-id monospace">Scrum</a>
                                        </td>
                                        <td>
                                            <i class="fa fa-code-fork"></i>
                                            <a href="#"  class="commit-id monospace">AAA</a>
                                        </td>
                                        <td>
                                            <i class="fa fa-code-fork"></i>
                                            <a href="#"  class="commit-id monospace">module</a>
                                        </td>
                                        <td>
                                            <div class="branch-commit">
                                                <p class="commit-title">
                                                    <strong><span>
                                                    <a href="mailto:1131544367@qq.com" class="avatar-image-container">
                                                        <img src="http://www.gravatar.com/avatar/369ea35620f75dddced869daa37a6a7e?s=80&amp;d=identicon"
                                                             title="guosheng" class="avatar has-tooltip s20">
                                                    </a>
                                                    <a href="<?=ROOT_URL?>project/main/home" class="commit-row-message">
                                                        Merge branch 'test'
                                                    </a>
                                                </span>
                                                    </strong>
                                                </p>
                                                <div class="icon-container">
                                                    <i class="fa fa-tag"></i>
                                                </div>
                                                <a href="/ismond/ProductTree/tree/v1.1.2" class="monospace branch-name">v1.1.2</a>

                                                <span href="#" class="commit-id monospace">ismond/xphp............................................</span>

                                            </div>
                                        </td>
                                        <td  >
                                                <span class="list-item-name">
                                                    <img class="avatar s40" alt="" src="http://192.168.3.213/uploads/user/avatar/15/avatar.png">
                                                    <strong>
                                                        <a href="/sven">韦朝夺</a>
                                                    </strong>
                                                    <span class="cgray">@sven</span>
                                                </span>

                                        </td>
                                        <td  >
                                                <span class="list-item-name">
                                                    <img class="avatar s40" alt="" src="http://192.168.3.213/uploads/user/avatar/15/avatar.png">
                                                    <strong>
                                                        <a href="/sven">韦朝夺</a>
                                                    </strong>
                                                    <span class="cgray">@sven</span>
                                                </span>



                                        </td>
                                        <td  >
                                            <span class="label dropdown-labels-error prepend-left-5">高</span>



                                        </td>
                                        <td  >
                                            <span class="label label-success prepend-left-5">进行中</span>


                                        </td>

                                        <td  >
                                            <a href="#" class="commit-id monospace">已解决</a>

                                        </td>
                                        <td >4 days ago
                                        </td>
                                        <td >4 days ago
                                        </td>
                                        <td class="pipeline-actions">
                                            <div class="pull-right btn-group">

                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="tree-item">
                                        <td>
                                            <i class="fa fa-code-fork"></i>
                                            <a href="#"  class="commit-id monospace">Scrum</a>
                                        </td>
                                        <td>
                                            <i class="fa fa-code-fork"></i>
                                            <a href="#"  class="commit-id monospace">AAA</a>
                                        </td>
                                        <td>
                                            <i class="fa fa-code-fork"></i>
                                            <a href="#"  class="commit-id monospace">module</a>
                                        </td>
                                        <td>
                                            <div class="branch-commit">
                                                <p class="commit-title">
                                                    <strong><span>
                                                    <a href="mailto:1131544367@qq.com" class="avatar-image-container">
                                                        <img src="http://www.gravatar.com/avatar/369ea35620f75dddced869daa37a6a7e?s=80&amp;d=identicon"
                                                             title="guosheng" class="avatar has-tooltip s20">
                                                    </a>
                                                    <a href="<?=ROOT_URL?>project/main/home" class="commit-row-message">
                                                        Merge branch 'test'
                                                    </a>
                                                </span>
                                                    </strong>
                                                </p>
                                                <div class="icon-container">
                                                    <i class="fa fa-tag"></i>
                                                </div>
                                                <a href="/ismond/ProductTree/tree/v1.1.2" class="monospace branch-name">v1.1.2</a>

                                                <span href="#" class="commit-id monospace">ismond/xphp............................................</span>

                                            </div>
                                        </td>
                                        <td  >
                                                <span class="list-item-name">
                                                    <img class="avatar s40" alt="" src="http://192.168.3.213/uploads/user/avatar/15/avatar.png">
                                                    <strong>
                                                        <a href="/sven">韦朝夺</a>
                                                    </strong>
                                                    <span class="cgray">@sven</span>
                                                </span>
                                        </td>
                                        <td  >
                                                <span class="list-item-name">
                                                    <img class="avatar s40" alt="" src="http://192.168.3.213/uploads/user/avatar/15/avatar.png">
                                                    <strong>
                                                        <a href="/sven">韦朝夺</a>
                                                    </strong>
                                                    <span class="cgray">@sven</span>
                                                </span>
                                        </td>
                                        <td  >
                                            <span class="label dropdown-labels-error prepend-left-5">高</span>



                                        </td>
                                        <td  >
                                            <span class="label label-success prepend-left-5">进行中</span>


                                        </td>

                                        <td  >
                                            <a href="#" class="commit-id monospace">已解决</a>

                                        </td>
                                        <td >4 days ago
                                        </td>
                                        <td >4 days ago
                                        </td>
                                        <td class="pipeline-actions">
                                            <div class="pull-right btn-group">

                                            </div>
                                        </td>
                                    </tr>


                                    </tbody>
                                </table>
                            </div>
                            <div class="gl-pagination" pagenum="1" count="56">
                                <ul class="pagination clearfix">
                                    <li class="prev disabled">
                                        <a>Prev</a>
                                    </li>
                                    <li class="page active">
                                        <a>1</a>
                                    </li>
                                    <li class="page">
                                        <a>2</a>
                                    </li>
                                    <li class="page">
                                        <a>3</a>
                                    </li>
                                    <li class="next">
                                        <a>Next</a>
                                    </li>
                                    <li class="">
                                        <a>Last »</a>
                                    </li>
                                </ul>
                            </div>

                        </ul>

                    </div>
                </div>

            </div>
            
        </div>
    </div>
</div>
</body>
</html>


</div>