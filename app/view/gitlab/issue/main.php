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
                <div class="container-fluid">
                    <div class="top-area">
                        <ul class="nav-links issues-state-filters">
                            <li class="active">
                                <a id="state-opened" title="Filter by issues that are currently opened." href="/ismond/xphp/issues?scope=all&amp;state=opened"><span>杨文杰未解决</span> <span class="badge">0</span>
                                </a>
                            </li>
                            <li class="">
                                <a id="state-all" title="Filter by issues that are currently closed." href="/ismond/xphp/issues?scope=all&amp;state=closed"><span>所有重构的问题</span> <span class="badge">1</span>
                                </a>
                            </li>
                            <li class="">
                                <a id="state-all" title="Show all issues." href="/ismond/xphp/issues?scope=all&amp;state=all"><span>App所有问题</span> <span class="badge">1</span>
                                </a>
                            </li>
                            <li class="">
                                <a id="state-all" title="Show all issues." href="/ismond/xphp/issues?scope=all&amp;state=all"><span>App未解决</span> <span class="badge">1</span>
                                </a>
                            </li>
                        </ul>
                        <div class="js-notification-dropdown notification-dropdown project-action-button dropdown inline">

                            <div class="js-notification-toggle-btns">
                                <div class="">
                                    <a class="dropdown-new  notifications-btn " style="color: #8b8f94;"  href="#" data-target="dropdown-15-31-Project" data-toggle="dropdown" id="notifications-button" type="button" aria-expanded="false">
                                        更多
                                        <i class="fa fa-caret-down"></i>
                                    </a>
                                    <ul class="dropdown-15-31-Project dropdown-menu dropdown-menu-large dropdown-menu-no-wrap dropdown-menu-selectable" role="menu">
                                        <li role="menuitem"><a class="update-notification is-active" data-notification-level="global" data-notification-title="Global" href="#"><strong class="dropdown-menu-inner-title">Global</strong><span class="dropdown-menu-inner-content">Use your global notification setting</span></a></li>
                                        <li role="menuitem"><a class="update-notification " data-notification-level="watch" data-notification-title="Watch" href="#"><strong class="dropdown-menu-inner-title">Watch</strong><span class="dropdown-menu-inner-content">You will receive notifications for any activity</span></a></li>
                                        <li role="menuitem"><a class="update-notification " data-notification-level="mention" data-notification-title="On mention" href="#"><strong class="dropdown-menu-inner-title">On mention</strong><span class="dropdown-menu-inner-content">You will receive notifications only for comments in which you were @mentioned</span></a></li>
                                        <li role="menuitem"><a class="update-notification " data-notification-level="participating" data-notification-title="Participate" href="#"><strong class="dropdown-menu-inner-title">Participate</strong><span class="dropdown-menu-inner-content">You will only receive notifications for threads you have participated in</span></a></li>
                                        <li role="menuitem"><a class="update-notification " data-notification-level="disabled" data-notification-title="Disabled" href="#"><strong class="dropdown-menu-inner-title">Disabled</strong><span class="dropdown-menu-inner-content">You will not get any notifications via email</span></a></li>
                                        <li class="divider"></li>
                                        <li>
                                            <a class="update-notification" data-notification-level="custom" data-notification-title="Custom" data-target="#modal-15-31-Project" data-toggle="modal" href="#" role="button">
                                                <strong class="dropdown-menu-inner-title">Custom</strong>
                                                <span class="dropdown-menu-inner-content">You will only receive notifications for the events you choose</span>
                                            </a>
                                        </li>
                                    </ul>

                                </div>
                            </div>



                        </div>

                        <a style="margin-left: 10px;color: #8b8f94;"  class=" missing" title="New issue" id="new_filter" href="#">New filter&nbsp;<i class="fa fa-filter "></i>
                        </a>

                        <div class="nav-controls">

                            <a class="btn append-right-10 has-tooltip" title="Subscribe" href="/ismond/xphp/issues.atom?private_token=vyxEf937XeWRN9gDqyXk&amp;scope=all&amp;state=opened"><i class="fa fa-rss"></i>
                            </a>
                            <a class="btn btn-new" data-target="#modal-create-new-dir" data-toggle="modal" href="#modal-create-new-dir"><i class="fa fa-plus fa-fw"></i>
                                New issue
                            </a>

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
                </div>
                <div class="container-fluid">
                    <div class="project-show-files">
                        <div class="tree-holder clearfix" id="tree-holder">
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
                                                <div class="filtered-search-input-dropdown-menu dropdown-menu hint-dropdown" id="js-dropdown-hint" data-dropdown-active="true" style="left: 30px; display: none;">
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
                                                                <i class="fa fa-tag"></i>
                                                                <span class="js-filter-hint">
label
</span>
                                                                <span class="js-filter-tag dropdown-light-content">
&lt;~label&gt;
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
<span>
{{name}}
</span>
                                                                    <span class="dropdown-light-content">
@{{username}}
</span>
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
                                                                <div class="dropdown-user-details">
<span>
{{name}}
</span>
                                                                    <span class="dropdown-light-content">
@{{username}}
</span>
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
                                                <button class="dropdown-toggle" data-toggle="dropdown" type="button" aria-expanded="false">
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
                                <div class="issues_bulk_update hide">
                                    <form class="bulk-update" action="/ismond/xphp/issues/bulk_update" accept-charset="UTF-8" method="post"><input name="utf8" type="hidden" value="✓"><input type="hidden" name="authenticity_token" value="alAZE77Wv+jsZsepqr5ffMh6XJjLYUkeLjs0bvLB64/6J1vbN6l9FujLjDfRLABcXz9HXgsOk4Ob9gBXooWBaA=="><div class="filter-item inline">
                                            <div class="dropdown "><button class="dropdown-menu-toggle js-issue-status" type="button" data-field-name="update[state_event]" data-toggle="dropdown"><span class="dropdown-toggle-text ">Status</span><i class="fa fa-chevron-down"></i></button><div class="dropdown-menu dropdown-select dropdown-menu-status dropdown-menu-selectable"><div class="dropdown-title"><span>Change status</span><button class="dropdown-title-button dropdown-menu-close" aria-label="Close" type="button"><i class="fa fa-times dropdown-menu-close-icon"></i></button></div><div class="dropdown-content "><ul>
                                                            <li>
                                                                <a data-id="reopen" href="#">Open</a>
                                                            </li>
                                                            <li>
                                                                <a data-id="close" href="#">Closed</a>
                                                            </li>
                                                        </ul>
                                                    </div><div class="dropdown-loading"><i class="fa fa-spinner fa-spin"></i></div></div></div></div>
                                        <div class="filter-item inline">
                                            <div class="dropdown "><button class="dropdown-menu-toggle js-user-search js-update-assignee js-filter-submit js-filter-bulk-update" type="button" data-first-user="sven" data-null-user="true" data-current-user="true" data-project-id="31" data-field-name="update[assignee_id]" data-toggle="dropdown"><span class="dropdown-toggle-text ">Assignee</span><i class="fa fa-chevron-down"></i></button><div class="dropdown-menu dropdown-select dropdown-menu-user dropdown-menu-selectable"><div class="dropdown-title"><span>Assign to</span><button class="dropdown-title-button dropdown-menu-close" aria-label="Close" type="button"><i class="fa fa-times dropdown-menu-close-icon"></i></button></div><div class="dropdown-input"><input type="search" id="" class="dropdown-input-field" placeholder="Search authors" autocomplete="off" value=""><i class="fa fa-search dropdown-input-search"></i><i role="button" class="fa fa-times dropdown-input-clear js-dropdown-input-clear"></i></div><div class="dropdown-content "></div><div class="dropdown-loading"><i class="fa fa-spinner fa-spin"></i></div></div></div>
                                        </div>
                                        <div class="filter-item inline">
                                            <div class="dropdown "><button class="dropdown-menu-toggle js-milestone-select js-extra-options js-filter-submit js-filter-bulk-update" type="button" data-show-no="true" data-field-name="update[milestone_id]" data-project-id="31" data-milestones="/ismond/xphp/milestones.json" data-use-id="true" data-toggle="dropdown"><span class="dropdown-toggle-text ">Milestone</span><i class="fa fa-chevron-down"></i></button><div class="dropdown-menu dropdown-select dropdown-menu-selectable dropdown-menu-milestone"><div class="dropdown-title"><span>Assign milestone</span><button class="dropdown-title-button dropdown-menu-close" aria-label="Close" type="button"><i class="fa fa-times dropdown-menu-close-icon"></i></button></div><div class="dropdown-input"><input type="search" id="" class="dropdown-input-field" placeholder="Search milestones" autocomplete="off" value=""><i class="fa fa-search dropdown-input-search"></i><i role="button" class="fa fa-times dropdown-input-clear js-dropdown-input-clear"></i></div><div class="dropdown-content "></div><div class="dropdown-loading"><i class="fa fa-spinner fa-spin"></i></div></div></div>
                                        </div>
                                        <div class="filter-item inline labels-filter">
                                            <div class="dropdown">
                                                <button class="dropdown-menu-toggle js-filter-bulk-update js-label-select js-multiselect" data-default-label="Labels" data-field-name="update[label_ids][]" data-labels="/ismond/xphp/labels.json" data-namespace-path="ismond" data-persist-when-hide="true" data-project-path="xphp" data-toggle="dropdown" data-use-id="" type="button">
<span class="dropdown-toggle-text is-default">
Labels
</span>
                                                    <i class="fa fa-chevron-down"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-select dropdown-menu-paging dropdown-menu-labels dropdown-menu-selectable">
                                                    <div class="dropdown-page-one">
                                                        <div class="dropdown-title"><span>Apply a label</span><button class="dropdown-title-button dropdown-menu-close" aria-label="Close" type="button"><i class="fa fa-times dropdown-menu-close-icon"></i></button></div>
                                                        <div class="dropdown-input"><input type="search" id="" class="dropdown-input-field" placeholder="Search" autocomplete="off" value=""><i class="fa fa-search dropdown-input-search"></i><i role="button" class="fa fa-times dropdown-input-clear js-dropdown-input-clear"></i></div>
                                                        <div class="dropdown-content"></div>
                                                        <div class="dropdown-loading"><i class="fa fa-spinner fa-spin"></i></div>
                                                    </div>

                                                    <div class="dropdown-loading"><i class="fa fa-spinner fa-spin"></i></div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="filter-item inline">
                                            <div class="dropdown "><button class="dropdown-menu-toggle js-subscription-event" type="button" data-field-name="update[subscription_event]" data-toggle="dropdown"><span class="dropdown-toggle-text ">Subscription</span><i class="fa fa-chevron-down"></i></button><div class="dropdown-menu dropdown-select dropdown-menu-selectable"><div class="dropdown-title"><span>Change subscription</span><button class="dropdown-title-button dropdown-menu-close" aria-label="Close" type="button"><i class="fa fa-times dropdown-menu-close-icon"></i></button></div><div class="dropdown-content "><ul>
                                                            <li>
                                                                <a data-id="subscribe" href="#">Subscribe</a>
                                                            </li>
                                                            <li>
                                                                <a data-id="unsubscribe" href="#">Unsubscribe</a>
                                                            </li>
                                                        </ul>
                                                    </div><div class="dropdown-loading"><i class="fa fa-spinner fa-spin"></i></div></div></div></div>
                                        <input type="hidden" name="update[issuable_ids]" id="update_issuable_ids" value="">
                                        <input type="hidden" name="state_event" id="state_event">
                                        <div class="filter-item inline update-issues-btn">
                                            <button name="button" type="submit" class="btn update_selected_issues btn-save">Update issues</button>
                                        </div>
                                    </form></div>
                            </div>

                            <div class="tree-content-holder">
                                <div class="table-holder">
                                    <table class="table table_da39a3ee5e6b4b0d3255bfef95601890afd80709 tree-table" id="tree-slider">
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
                                            <th class="js-pipeline-actions pipeline-actions">
                                            </th>
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

                                                <a href="<?=ROOT_URL?>issue/main/detail" class="commit-row-message">
                                                    Merge branch 'test'
                                                </a>

                                            </td>
                                            <td  >
                                                <span class="list-item-name">
                                                        <a href="/sven">韦朝夺</a>
                                                    <span class="cgray">@sven</span>
                                                </span>

                                            </td>
                                            <td  >
                                                <span class="list-item-name">
                                                        <a href="/sven">韦朝夺</a>
                                                    <span class="cgray">@sven</span>
                                                </span>

                                            </td>
                                            <td  >
                                                <span class="label " style="color:red">高</span>

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
                                                <div class="js-notification-dropdown notification-dropdown project-action-button dropdown inline">

                                                    <div class="js-notification-toggle-btns">
                                                        <div class="">
                                                            <a class="dropdown-new  notifications-btn " style="color: #8b8f94;" href="#" data-target="dropdown-15-31-Project" data-toggle="dropdown" id="notifications-button" type="button" aria-expanded="false">
                                                                ...
                                                                <i class="fa fa-caret-down"></i>
                                                            </a>

                                                            <ul class="dropdown-15-31-Project dropdown-menu dropdown-menu-large dropdown-menu-no-wrap dropdown-menu-selectable">

                                                                <li class="aui-list-item active">
                                                                    <a data-target="#modal-create-new-dir" data-toggle="modal" href="#modal-create-new-dir"><i class="fa fa-edit fa-fw"></i>
                                                                        编辑
                                                                    </a>
                                                                </li>
                                                                <li class="aui-list-item ">
                                                                    <a href="#" class=""
                                                                       data-issueid="10920" data-issuekey="IP-524">备注</a>
                                                                </li>
                                                                <li class="aui-list-item">
                                                                    <a href="#" class="" data-issueid="10920" data-issuekey="IP-524">Agile Board</a>
                                                                </li>
                                                                <li class="aui-list-item">
                                                                    <a href="#" class="#" data-issueid="10920" data-issuekey="IP-524">Rank to Top</a>
                                                                </li>
                                                                <li class="aui-list-item">
                                                                    <a href="#" class="" data-issueid="10920" data-issuekey="IP-524">Rank to Bottom</a>
                                                                </li>
                                                                <li class="aui-list-item">
                                                                    <a href="#" class="" data-issueid="10920" data-issuekey="IP-524">查看投票</a>
                                                                </li>
                                                                <li class="aui-list-item">
                                                                    <a href="#" class="" data-issueid="10920" data-issuekey="IP-524">Watch issue</a>
                                                                </li>
                                                                <li class="aui-list-item">
                                                                    <a href="#" class="" data-issueid="10920" data-issuekey="IP-524">管理关注人</a></li>
                                                                <li class="aui-list-item">
                                                                    <a href="#" class="" data-issueid="10920" data-issuekey="IP-524">Convert to sub-task</a></li>
                                                                <li class="aui-list-item">
                                                                    <a href="#" class="#" data-issueid="10920" data-issuekey="IP-524">移动</a>
                                                                </li>
                                                                <li class="aui-list-item">
                                                                    <a href="#" class="" data-issueid="10920" data-issuekey="IP-524">链接</a></li>
                                                                <li class="aui-list-item"><a href="" class="" data-issueid="10920" data-issuekey="IP-524">复制</a></li>
                                                                <li class="aui-list-item"><a href="" class="" data-issueid="10920" data-issuekey="IP-524">删除</a></li>
                                                                <li class="aui-list-item"><a href="" class="" data-issueid="10920" data-issuekey="IP-524">添加字段</a></li>
                                                                <li class="aui-list-item"><a href="" class="" data-issueid="10920" data-issuekey="IP-524">权限助手</a></li>
                                                                <li class="aui-list-item">
                                                                    <a href="" class="aui-list-item-link notificationhelper-trigger" data-issueid="10920" data-issuekey="IP-524">通知方案助手</a>
                                                                </li>
                                                            </ul>



                                                        </div>
                                                    </div>



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

                                                <a href="<?=ROOT_URL?>project/main/detail" class="commit-row-message">
                                                    Merge branch 'test'
                                                </a>

                                            </td>
                                            <td  >
                                                <span class="list-item-name">
                                                        <a href="/sven">韦朝夺</a>
                                                    <span class="cgray">@sven</span>
                                                </span>

                                            </td>
                                            <td  >
                                                <span class="list-item-name">
                                                        <a href="/sven">韦朝夺</a>
                                                    <span class="cgray">@sven</span>
                                                </span>

                                            </td>
                                            <td  >
                                                <span class="label " style="color:red">高</span>

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

                                                <a href="<?=ROOT_URL?>project/main/home" class="commit-row-message">
                                                    Merge branch 'test'
                                                </a>

                                            </td>
                                            <td  >
                                                <span class="list-item-name">
                                                        <a href="/sven">韦朝夺</a>
                                                    <span class="cgray">@sven</span>
                                                </span>

                                            </td>
                                            <td  >
                                                <span class="list-item-name">
                                                        <a href="/sven">韦朝夺</a>
                                                    <span class="cgray">@sven</span>
                                                </span>

                                            </td>
                                            <td  >
                                                <span class="label " style="color:red">高</span>

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

                                                <a href="<?=ROOT_URL?>project/main/home" class="commit-row-message">
                                                    Merge branch 'test'
                                                </a>

                                            </td>
                                            <td  >
                                                <span class="list-item-name">
                                                        <a href="/sven">韦朝夺</a>
                                                    <span class="cgray">@sven</span>
                                                </span>

                                            </td>
                                            <td  >
                                                <span class="list-item-name">
                                                        <a href="/sven">韦朝夺</a>
                                                    <span class="cgray">@sven</span>
                                                </span>

                                            </td>
                                            <td  >
                                                <span class="label " style="color:red">高</span>

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

                                                <a href="<?=ROOT_URL?>project/main/home" class="commit-row-message">
                                                    Merge branch 'test'
                                                </a>

                                            </td>
                                            <td  >
                                                <span class="list-item-name">
                                                        <a href="/sven">韦朝夺</a>
                                                    <span class="cgray">@sven</span>
                                                </span>

                                            </td>
                                            <td  >
                                                <span class="list-item-name">
                                                        <a href="/sven">韦朝夺</a>
                                                    <span class="cgray">@sven</span>
                                                </span>

                                            </td>
                                            <td  >
                                                <span class="label " style="color:red">高</span>

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

                                                <a href="<?=ROOT_URL?>project/main/home" class="commit-row-message">
                                                    Merge branch 'test'
                                                </a>

                                            </td>
                                            <td  >
                                                <span class="list-item-name">
                                                        <a href="/sven">韦朝夺</a>
                                                    <span class="cgray">@sven</span>
                                                </span>

                                            </td>
                                            <td  >
                                                <span class="list-item-name">
                                                        <a href="/sven">韦朝夺</a>
                                                    <span class="cgray">@sven</span>
                                                </span>

                                            </td>
                                            <td  >
                                                <span class="label " style="color:red">高</span>

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

                                                <a href="<?=ROOT_URL?>project/main/home" class="commit-row-message">
                                                    Merge branch 'test'
                                                </a>

                                            </td>
                                            <td  >
                                                <span class="list-item-name">
                                                        <a href="/sven">韦朝夺</a>
                                                    <span class="cgray">@sven</span>
                                                </span>

                                            </td>
                                            <td  >
                                                <span class="list-item-name">
                                                        <a href="/sven">韦朝夺</a>
                                                    <span class="cgray">@sven</span>
                                                </span>

                                            </td>
                                            <td  >
                                                <span class="label " style="color:red">高</span>

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

                                                <a href="<?=ROOT_URL?>project/main/home" class="commit-row-message">
                                                    Merge branch 'test'
                                                </a>

                                            </td>
                                            <td  >
                                                <span class="list-item-name">
                                                        <a href="/sven">韦朝夺</a>
                                                    <span class="cgray">@sven</span>
                                                </span>

                                            </td>
                                            <td  >
                                                <span class="list-item-name">
                                                        <a href="/sven">韦朝夺</a>
                                                    <span class="cgray">@sven</span>
                                                </span>

                                            </td>
                                            <td  >
                                                <span class="label " style="color:red">高</span>

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

                                                <a href="<?=ROOT_URL?>project/main/home" class="commit-row-message">
                                                    Merge branch 'test'
                                                </a>

                                            </td>
                                            <td  >
                                                <span class="list-item-name">
                                                        <a href="/sven">韦朝夺</a>
                                                    <span class="cgray">@sven</span>
                                                </span>

                                            </td>
                                            <td  >
                                                <span class="list-item-name">
                                                        <a href="/sven">韦朝夺</a>
                                                    <span class="cgray">@sven</span>
                                                </span>

                                            </td>
                                            <td  >
                                                <span class="label " style="color:red">高</span>

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

                                                <a href="<?=ROOT_URL?>project/main/home" class="commit-row-message">
                                                    Merge branch 'test'
                                                </a>

                                            </td>
                                            <td  >
                                                <span class="list-item-name">
                                                        <a href="/sven">韦朝夺</a>
                                                    <span class="cgray">@sven</span>
                                                </span>

                                            </td>
                                            <td  >
                                                <span class="list-item-name">
                                                        <a href="/sven">韦朝夺</a>
                                                    <span class="cgray">@sven</span>
                                                </span>

                                            </td>
                                            <td  >
                                                <span class="label " style="color:red">高</span>

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

                                                <a href="<?=ROOT_URL?>project/main/home" class="commit-row-message">
                                                    Merge branch 'test'
                                                </a>

                                            </td>
                                            <td  >
                                                <span class="list-item-name">
                                                        <a href="/sven">韦朝夺</a>
                                                    <span class="cgray">@sven</span>
                                                </span>

                                            </td>
                                            <td  >
                                                <span class="list-item-name">
                                                        <a href="/sven">韦朝夺</a>
                                                    <span class="cgray">@sven</span>
                                                </span>

                                            </td>
                                            <td  >
                                                <span class="label " style="color:red">高</span>

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

                                                <a href="<?=ROOT_URL?>project/main/home" class="commit-row-message">
                                                    Merge branch 'test'
                                                </a>

                                            </td>
                                            <td  >
                                                <span class="list-item-name">
                                                        <a href="/sven">韦朝夺</a>
                                                    <span class="cgray">@sven</span>
                                                </span>

                                            </td>
                                            <td  >
                                                <span class="list-item-name">
                                                        <a href="/sven">韦朝夺</a>
                                                    <span class="cgray">@sven</span>
                                                </span>

                                            </td>
                                            <td  >
                                                <span class="label " style="color:red">高</span>

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



                                        </tbody></table>
                                </div>


                            </div>
                            <style>
                                .modal-dialog {
                                    position: absolute;
                                    top: 0;
                                    bottom: 0;
                                    left: 0;
                                    right: 0;
                                }

                                .modal-content {
                                    /*overflow-y: scroll; */
                                    position: absolute;
                                    top: 0;
                                    bottom: 0;
                                    width: 100%;
                                }

                                .modal-body {
                                    overflow-y: scroll;
                                    position: absolute;
                                    top: 55px;
                                    bottom: 65px;
                                    width: 100%;
                                }

                                .modal-header .close {margin-right: 15px;}

                                .modal-footer {
                                    position: absolute;
                                    width: 100%;
                                    bottom: 0;
                                }

                            </style>
                            <div class="modal" id="modal-upload-blob">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <a class="close" data-dismiss="modal" href="#">×</a>
                                            <h3 class="page-title">创建问题</h3>
                                        </div>
                                        <div class="modal-body">
                                            <form class="js-quick-submit js-upload-blob-form form-horizontal" data-method="post" action="#" accept-charset="UTF-8" method="post">

                                                <br>
                                                <div class="form-group">
                                                    <label class="control-label" for="project_id">项目
                                                    </label>
                                                    <div class="col-sm-10">

                                                        <div class="issuable-form-select-holder">
                                                            <input type="hidden" name="issue[project_id]" id="issue_project_id">
                                                            <div class="dropdown ">
                                                                <button
                                                                        class="dropdown-menu-toggle js-dropdown-keep-input js-user-search js-issuable-form-dropdown js-assignee-search"
                                                                        type="button"
                                                                        data-first-user="sven"
                                                                        data-null-user="true"
                                                                        data-current-user="true"
                                                                        data-project-id="31"
                                                                        data-selected="null"
                                                                        data-field-name="issue[project_id]"
                                                                        data-default-label="Assignee"
                                                                        data-toggle="dropdown">
                                                                    <span class="dropdown-toggle-text is-default">Assignee</span>
                                                                    <i class="fa fa-chevron-down"></i>
                                                                </button>
                                                                <div class="dropdown-menu dropdown-select dropdown-menu-user dropdown-menu-selectable dropdown-menu-assignee js-filter-submit">
                                                                    <div class="dropdown-title">
                                                                        <span>Select project</span>
                                                                        <button class="dropdown-title-button dropdown-menu-close" aria-label="Close" type="button">
                                                                            <i class="fa fa-times dropdown-menu-close-icon"></i>
                                                                        </button>
                                                                    </div>
                                                                    <div class="dropdown-input">
                                                                        <input type="search" id="" class="dropdown-input-field" placeholder="Search assignee" autocomplete="off" value="">
                                                                        <i class="fa fa-search dropdown-input-search"></i>
                                                                        <i role="button" class="fa fa-times dropdown-input-clear js-dropdown-input-clear"></i>
                                                                    </div>
                                                                    <div class="dropdown-content "></div>
                                                                    <div class="dropdown-loading">
                                                                        <i class="fa fa-spinner fa-spin"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label" for="issue_type">问题类型
                                                    </label>
                                                    <div class="col-sm-10">

                                                        <div class="issuable-form-select-holder">
                                                            <input type="hidden" name="issue[type]" id="issue_type">

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group commit_message-group">
                                                    <label class="control-label" for="commit_title">主题
                                                    </label>
                                                    <div class="col-sm-10">

                                                        <input type="text" name="commit_title" id="commit_title" class="form-control" placeholder="" required="required" />

                                                    </div>
                                                </div>

                                                <div class="dropzone-alerts alert alert-danger data" style="display:none"></div>
                                                <div class="form-group commit_message-group">
                                                    <label class="control-label" for="commit_message">Commit message
                                                    </label><div class="col-sm-10">
                                                        <div class="commit-message-container">
                                                            <div class="max-width-marker"></div>
                                                            <textarea name="commit_message" id="commit_message" class="form-control js-commit-message" placeholder="Upload new file" required="required" rows="3">Upload new file</textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group commit_message-group">
                                                    <label class="control-label" for="commit_title">附件
                                                    </label>
                                                    <div class="col-sm-10">
                                                        <div class="dropzone dz-clickable">
                                                            <div style="min-height:20px;" class="dropzone-previews blob-upload-dropzone-previews">
                                                                <p class="dz-message light">
                                                                    Attach a file by drag &amp; drop or
                                                                    <a class="markdown-selector" href="#">click to upload</a>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                            </form>


                                        </div>

                                        <div class="modal-footer">
                                            <div class="form-actions">
                                                <button name="button" type="submit" class="btn btn-small btn-create btn-upload-file" id="submit-all">
                                                    创建</button>
                                                <a class="btn btn-cancel" data-dismiss="modal" href="#">取消</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php include VIEW_PATH.'gitlab/issue/form.php'; ?>
                            <script>
                                new NewCommitForm($('.js-create-dir-form'))
                            </script>

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
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>


<script>
    new UsersSelect();
    new LabelsSelect();
    new MilestoneSelect();
    new IssueStatusSelect();
    new SubscriptionSelect();
    new ProjectSelect();
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

</body>
</html>


</div>