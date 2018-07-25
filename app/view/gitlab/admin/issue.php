<!DOCTYPE html>
<html class="" lang="en">
<head  >

    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>
    <script src="<?=ROOT_URL?>gitlab/assets/webpack/filtered_search.bundle.js"></script>

</head>
<body class="" data-group="" data-page="projects:issues:index" data-project="xphp">
<? require_once VIEW_PATH.'gitlab/common/body/script.php';?>
<header class="navbar navbar-gitlab with-horizontal-nav">
    <a class="sr-only gl-accessibility" href="#content-body" tabindex="1">Skip to content</a>
    <div class="container-fluid">
        <? require_once VIEW_PATH.'gitlab/common/body/header-content.php';?>
    </div>
</header>
<script>
    var findFileURL = "/ismond/xphp/find_file/master";
</script>
<div class="page-with-sidebar">
    <? require_once VIEW_PATH.'gitlab/common/body/page-nav.php';?>
    <? require_once VIEW_PATH.'gitlab/common/body/page-sub-nav.php';?>

    <div class="content-wrapper page-with-layout-nav page-with-sub-nav">
        <div class="alert-wrapper">
            <div class="flash-container flash-container-page">
            </div>
        </div>
        <div class="">
            <div class="content" id="content-body">
                <div class="container-fluid">
                    <div class="top-area">
                        <ul class="nav-links issues-state-filters">
                            <li class="active"> <a id="state-opened" title="Filter by issues that are currently opened." href="/ismond/xphp/issues?scope=all&amp;state=opened"><span>Open</span> <span class="badge">1</span> </a></li>
                            <li class=""> <a id="state-all" title="Filter by issues that are currently closed." href="/ismond/xphp/issues?scope=all&amp;state=closed"><span>Closed</span> <span class="badge">0</span> </a></li>
                            <li class=""> <a id="state-all" title="Show all issues." href="/ismond/xphp/issues?scope=all&amp;state=all"><span>All</span> <span class="badge">1</span> </a></li>
                        </ul>
                        <div class="nav-controls">
                            <a class="btn append-right-10 has-tooltip" title="Subscribe" href="/ismond/xphp/issues.atom?private_token=vyxEf937XeWRN9gDqyXk&amp;scope=all&amp;state=opened"><i class="fa fa-rss"></i> </a>
                            <a class="btn btn-new" title="New issue" id="new_issue_link" href="/ismond/xphp/issues/new?issue%5Bassignee_id%5D=&amp;issue%5Bmilestone_id%5D=">创建事项 </a>
                        </div>
                    </div>
                    <div class="issues-filters">
                        <div class="filtered-search-block issues-details-filters row-content-block second-block" v-pre="false">
                            <form class="filter-form js-filter-form" action="/ismond/xphp/issues?scope=all&amp;state=opened" accept-charset="UTF-8" method="get">
                                <input name="utf8" type="hidden" value="✓" />
                                <div class="check-all-holder">
                                    <input type="checkbox" name="check_all_issues" id="check_all_issues" class="check_all_issues left" />
                                </div>
                                <div class="issues-other-filters filtered-search-wrapper">
                                    <div class="filtered-search-box">
                                        <div class="dropdown filtered-search-history-dropdown-wrapper">
                                            <button class="dropdown-menu-toggle filtered-search-history-dropdown-toggle-button" type="button" data-toggle="dropdown"><span class="dropdown-toggle-text "><i class="fa fa-history"></i></span><i class="fa fa-chevron-down"></i></button>
                                            <div class="dropdown-menu dropdown-select filtered-search-history-dropdown">
                                                <div class="dropdown-title">
                                                    <span>Recent searches</span>
                                                    <button class="dropdown-title-button dropdown-menu-close" aria-label="Close" type="button"><i class="fa fa-times dropdown-menu-close-icon"></i></button>
                                                </div>
                                                <div class="dropdown-content filtered-search-history-dropdown-content">
                                                    <div class="js-filtered-search-history-dropdown"></div>
                                                </div>
                                                <div class="dropdown-loading">
                                                    <i class="fa fa-spinner fa-spin"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="filtered-search-box-input-container">
                                            <div class="scroll-container">
                                                <ul class="tokens-container list-unstyled">
                                                    <li class="input-token"> <input class="form-control filtered-search" data-base-endpoint="/ismond/xphp" data-project-id="31" data-username-params="[]" id="filtered-search-issues" placeholder="Search or filter results..." /> </li>
                                                </ul>
                                                <i class="fa fa-filter"></i>
                                                <button class="clear-search hidden" type="button"> <i class="fa fa-times"></i> </button>
                                            </div>
                                            <div class="filtered-search-input-dropdown-menu dropdown-menu hint-dropdown" id="js-dropdown-hint">
                                                <ul data-dropdown="">
                                                    <li class="filter-dropdown-item" data-action="submit"> <button class="btn btn-link"> <i class="fa fa-search"></i> <span> Press Enter or click to search </span> </button> </li>
                                                </ul>
                                                <ul class="filter-dropdown" data-dropdown="" data-dynamic="">
                                                    <li class="filter-dropdown-item"> <button class="btn btn-link"> <i class="fa {{icon}}"></i> <span class="js-filter-hint"> {{hint}} </span> <span class="js-filter-tag dropdown-light-content"> {{tag}} </span> </button> </li>
                                                </ul>
                                            </div>
                                            <div class="filtered-search-input-dropdown-menu dropdown-menu" data-hint="author" data-icon="pencil" data-tag="@author" id="js-dropdown-author">
                                                <ul class="filter-dropdown" data-dropdown="" data-dynamic="">
                                                    <li class="filter-dropdown-item"> <button class="btn btn-link dropdown-user"> <img alt="{{name}}'s avatar" class="avatar" data-src="{{avatar_url}}" width="30" />
                                                            <div class="dropdown-user-details">
                                                                <span> {{name}} </span>
                                                                <span class="dropdown-light-content"> @{{username}} </span>
                                                            </div> </button> </li>
                                                </ul>
                                            </div>
                                            <div class="filtered-search-input-dropdown-menu dropdown-menu" data-hint="assignee" data-icon="user" data-tag="@assignee" id="js-dropdown-assignee">
                                                <ul data-dropdown="">
                                                    <li class="filter-dropdown-item" data-value="none"> <button class="btn btn-link"> No Assignee </button> </li>
                                                    <li class="divider"></li>
                                                </ul>
                                                <ul class="filter-dropdown" data-dropdown="" data-dynamic="">
                                                    <li class="filter-dropdown-item"> <button class="btn btn-link dropdown-user"> <img alt="{{name}}'s avatar" class="avatar" data-src="{{avatar_url}}" width="30" />
                                                            <div class="dropdown-user-details">
                                                                <span> {{name}} </span>
                                                                <span class="dropdown-light-content"> @{{username}} </span>
                                                            </div> </button> </li>
                                                </ul>
                                            </div>
                                            <div class="filtered-search-input-dropdown-menu dropdown-menu" data-hint="milestone" data-icon="clock-o" data-tag="%milestone" id="js-dropdown-milestone">
                                                <ul data-dropdown="">
                                                    <li class="filter-dropdown-item" data-value="none"> <button class="btn btn-link"> No Milestone </button> </li>
                                                    <li class="filter-dropdown-item" data-value="upcoming"> <button class="btn btn-link"> Upcoming </button> </li>
                                                    <li class="filter-dropdown-item" data-value="started"> <button class="btn btn-link"> Started </button> </li>
                                                    <li class="divider"></li>
                                                </ul>
                                                <ul class="filter-dropdown" data-dropdown="" data-dynamic="">
                                                    <li class="filter-dropdown-item"> <button class="btn btn-link js-data-value"> {{title}} </button> </li>
                                                </ul>
                                            </div>
                                            <div class="filtered-search-input-dropdown-menu dropdown-menu" data-hint="label" data-icon="tag" data-tag="~label" data-type="array" id="js-dropdown-label">
                                                <ul data-dropdown="">
                                                    <li class="filter-dropdown-item" data-value="none"> <button class="btn btn-link"> No Label </button> </li>
                                                    <li class="divider"></li>
                                                </ul>
                                                <ul class="filter-dropdown" data-dropdown="" data-dynamic="">
                                                    <li class="filter-dropdown-item"> <button class="btn btn-link"> <span class="dropdown-label-box" style="background: {{color}}"></span> <span class="label-title js-data-value"> {{title}} </span> </button> </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="filter-dropdown-container">
                                        <div class="dropdown inline prepend-left-10">
                                            <button class="dropdown-toggle" data-toggle="dropdown" type="button"> Last created <i class="fa fa-chevron-down"></i> </button>
                                            <ul class="dropdown-menu dropdown-menu-align-right dropdown-menu-sort">
                                                <li> <a href="/ismond/xphp/issues?scope=all&amp;sort=priority&amp;state=opened">Priority </a><a href="/ismond/xphp/issues?scope=all&amp;sort=label_priority&amp;state=opened">Label priority </a><a href="/ismond/xphp/issues?scope=all&amp;sort=created_desc&amp;state=opened">Last created </a><a href="/ismond/xphp/issues?scope=all&amp;sort=created_asc&amp;state=opened">Oldest created </a><a href="/ismond/xphp/issues?scope=all&amp;sort=updated_desc&amp;state=opened">Last updated </a><a href="/ismond/xphp/issues?scope=all&amp;sort=updated_asc&amp;state=opened">Oldest updated </a><a href="/ismond/xphp/issues?scope=all&amp;sort=milestone_due_asc&amp;state=opened">Milestone due soon </a><a href="/ismond/xphp/issues?scope=all&amp;sort=milestone_due_desc&amp;state=opened">Milestone due later </a><a href="/ismond/xphp/issues?scope=all&amp;sort=due_date_asc&amp;state=opened">Due soon </a><a href="/ismond/xphp/issues?scope=all&amp;sort=due_date_desc&amp;state=opened">Due later </a><a href="/ismond/xphp/issues?scope=all&amp;sort=upvotes_desc&amp;state=opened">Most popular </a><a href="/ismond/xphp/issues?scope=all&amp;sort=downvotes_desc&amp;state=opened">Least popular </a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="issues_bulk_update hide">
                                <form class="bulk-update" action="/ismond/xphp/issues/bulk_update" accept-charset="UTF-8" method="post">
                                    <input name="utf8" type="hidden" value="✓" />
                                    <input type="hidden" name="authenticity_token"
                                           value="5ECMiqyHd77C8GnsliIK6b+MQjvKdW4rTL2NtrJincdL+eINGMfr0Ss4MPFZCu5UO45u2e2k18n4/jWMhTBWTg==" />
                                    <div class="filter-item inline">
                                        <div class="dropdown ">
                                            <button class="dropdown-menu-toggle js-issue-status" type="button"
                                                    data-field-name="update[state_event]" data-toggle="dropdown">
                                                <span class="dropdown-toggle-text ">Status</span><i class="fa fa-chevron-down"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-select dropdown-menu-status dropdown-menu-selectable">
                                                <div class="dropdown-title">
                                                    <span>Change status</span>
                                                    <button class="dropdown-title-button dropdown-menu-close" aria-label="Close" type="button">
                                                        <i class="fa fa-times dropdown-menu-close-icon"></i>
                                                    </button>
                                                </div>
                                                <div class="dropdown-content ">
                                                    <ul>
                                                        <li> <a data-id="reopen" href="#">Open</a> </li>
                                                        <li> <a data-id="close" href="#">Closed</a> </li>
                                                    </ul>
                                                </div>
                                                <div class="dropdown-loading">
                                                    <i class="fa fa-spinner fa-spin"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="filter-item inline">

                                        <div class="dropdown ">
                                            <button class="dropdown-menu-toggle js-user-search js-update-assignee js-filter-submit js-filter-bulk-update"
                                                    type="button" data-first-user="sven" data-null-user="true" data-current-user="true"
                                                    data-project-id="31" data-field-name="update[assignee_id]" data-toggle="dropdown">
                                                <span class="dropdown-toggle-text ">Assignee</span><i class="fa fa-chevron-down"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-select dropdown-menu-user dropdown-menu-selectable">
                                                <div class="dropdown-title">
                                                    <span>Assign to</span>
                                                    <button class="dropdown-title-button dropdown-menu-close" aria-label="Close" type="button">
                                                        <i class="fa fa-times dropdown-menu-close-icon"></i>
                                                    </button>
                                                </div>
                                                <div class="dropdown-input">
                                                    <input type="search" id="" class="dropdown-input-field" placeholder="Search authors" autocomplete="off" />
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
                                    <div class="filter-item inline">
                                        <div class="dropdown ">
                                            <button class="dropdown-menu-toggle js-milestone-select js-extra-options js-filter-submit js-filter-bulk-update"
                                                    type="button" data-show-no="true" data-field-name="update[milestone_id]"
                                                    data-project-id="31" data-milestones="/ismond/xphp/milestones.json" data-use-id="true" data-toggle="dropdown">
                                                <span class="dropdown-toggle-text ">Milestone</span><i class="fa fa-chevron-down"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-select dropdown-menu-selectable dropdown-menu-milestone">
                                                <div class="dropdown-title">
                                                    <span>Assign milestone</span>
                                                    <button class="dropdown-title-button dropdown-menu-close" aria-label="Close" type="button">
                                                        <i class="fa fa-times dropdown-menu-close-icon"></i>
                                                    </button>
                                                </div>
                                                <div class="dropdown-input">
                                                    <input type="search" id="" class="dropdown-input-field" placeholder="Search milestones" autocomplete="off" />
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
                                    <div class="filter-item inline labels-filter">
                                        <div class="dropdown">
                                            <button class="dropdown-menu-toggle js-filter-bulk-update js-label-select js-multiselect"
                                                    data-default-label="Labels" data-field-name="update[label_ids][]"
                                                    data-labels="/api/v4/labels.json" data-namespace-path="ismond" data-persist-when-hide="true"
                                                    data-project-path="xphp" data-toggle="dropdown" data-use-id="" type="button">
                                                <span class="dropdown-toggle-text is-default"> Labels </span> <i class="fa fa-chevron-down"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-select dropdown-menu-paging dropdown-menu-labels dropdown-menu-selectable">
                                                <div class="dropdown-page-one">
                                                    <div class="dropdown-title">
                                                        <span>Apply a label</span>
                                                        <button class="dropdown-title-button dropdown-menu-close" aria-label="Close"
                                                                type="button"><i class="fa fa-times dropdown-menu-close-icon"></i>
                                                        </button>
                                                    </div>
                                                    <div class="dropdown-input">
                                                        <input type="search" id="" class="dropdown-input-field" placeholder="Search" autocomplete="off" />
                                                        <i class="fa fa-search dropdown-input-search"></i>
                                                        <i role="button" class="fa fa-times dropdown-input-clear js-dropdown-input-clear"></i>
                                                    </div>
                                                    <div class="dropdown-content"></div>
                                                    <div class="dropdown-loading">
                                                        <i class="fa fa-spinner fa-spin"></i>
                                                    </div>
                                                </div>
                                                <div class="dropdown-loading">
                                                    <i class="fa fa-spinner fa-spin"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="filter-item inline">
                                        <div class="dropdown ">
                                            <button class="dropdown-menu-toggle js-subscription-event" type="button"
                                                    data-field-name="update[subscription_event]" data-toggle="dropdown">
                                                <span class="dropdown-toggle-text ">Subscription</span><i class="fa fa-chevron-down"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-select dropdown-menu-selectable">
                                                <div class="dropdown-title">
                                                    <span>Change subscription</span>
                                                    <button class="dropdown-title-button dropdown-menu-close" aria-label="Close"
                                                            type="button"><i class="fa fa-times dropdown-menu-close-icon"></i>
                                                    </button>
                                                </div>
                                                <div class="dropdown-content ">
                                                    <ul>
                                                        <li> <a data-id="subscribe" href="#">Subscribe</a> </li>
                                                        <li> <a data-id="unsubscribe" href="#">Unsubscribe</a> </li>
                                                    </ul>
                                                </div>
                                                <div class="dropdown-loading">
                                                    <i class="fa fa-spinner fa-spin"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="update[issuable_ids]" id="update_issuable_ids" value="" />
                                    <input type="hidden" name="state_event" id="state_event" />
                                    <div class="filter-item inline update-issues-btn">
                                        <button name="button" type="submit" class="btn update_selected_issues btn-save">Update issues</button>
                                    </div>
                                </form>
                            </div>
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


                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Members with access to
                            <strong>xphp</strong>
                            <span class="badge">16</span>
                            <form class="form-inline member-search-form" action="/ismond/xphp/settings/members" accept-charset="UTF-8" method="get"><input name="utf8" type="hidden" value="✓"><div class="form-group">
                                   <!-- <input type="search" name="search" id="search" placeholder="Find existing members by name" class="form-control" spellcheck="false" value="">
                                    -->
                                      <input class="form-control filtered-search" data-base-endpoint="/ismond/xphp" data-project-id="31" data-username-params="[]" id="filtered-search-issues" placeholder="Search or filter results..." data-dropdown-trigger="#js-dropdown-hint"> </li>


                                    <button aria-label="Submit search" class="member-search-btn" type="submit">
                                        <i class="fa fa-search"></i>
                                    </button>
                                    <div class="dropdown inline member-sort-dropdown">
                                        <button class="dropdown-menu-toggle " type="button" data-toggle="dropdown"><span class="dropdown-toggle-text ">Name, ascending</span><i class="fa fa-chevron-down"></i></button>
                                        <ul class="dropdown-menu dropdown-menu-align-right dropdown-menu-selectable">
                                            <li class="dropdown-header">
                                                Sort by
                                            </li>
                                            <li>
                                                <a href="/ismond/xphp/settings/members?sort=access_level_asc">Access level, ascending
                                                </a></li>
                                            <li>
                                                <a href="/ismond/xphp/settings/members?sort=access_level_desc">Access level, descending
                                                </a></li>
                                            <li>
                                                <a href="/ismond/xphp/settings/members?sort=last_joined">Last joined
                                                </a></li>
                                            <li>
                                                <a href="/ismond/xphp/settings/members?sort=oldest_joined">Oldest joined
                                                </a></li>
                                            <li>
                                                <a class="is-active" href="/ismond/xphp/settings/members?sort=name_asc">Name, ascending
                                                </a></li>
                                            <li>
                                                <a href="/ismond/xphp/settings/members?sort=name_desc">Name, descending
                                                </a></li>
                                            <li>
                                                <a href="/ismond/xphp/settings/members?sort=recent_sign_in">Recent sign in
                                                </a></li>
                                            <li>
                                                <a href="/ismond/xphp/settings/members?sort=oldest_sign_in">Oldest sign in
                                                </a></li>
                                        </ul>
                                    </div>

                                </div>
                            </form></div>
                        <ul class="content-list">
                            <li class="group_member member" id="group_member_2">
<span class="list-item-name">
<img class="avatar s40" alt="" src="http://www.gravatar.com/avatar/fe9832e90a7fbb5fff87bac06a4adff4?s=80&amp;d=identicon">
<strong>
<a href="/root">Administrator</a>
</strong>
<span class="cgray">@root</span>
·
<a class="member-group-link" href="/ismond">ismond</a>
<div class="hidden-xs cgray">
Joined <time class="js-timeago js-timeago-render" title="" datetime="2017-04-25T06:50:15Z" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Apr 25, 2017 2:50pm GMT+0800">5 months ago</time>
</div>
</span>
                                <div class="controls member-controls">
                                    <span class="member-access-text">Owner</span>
                                </div>
                            </li>
                            <li class="member project_member" id="project_member_73">
<span class="list-item-name">
<img class="avatar s40" alt="" src="http://www.gravatar.com/avatar/8ceb21e5b4b18e6ae2f63f4568ffcca6?s=80&amp;d=identicon">
<strong>
<a href="/gitlab-runner">gitlab-runner</a>
</strong>
<span class="cgray">@gitlab-runner</span>
<div class="hidden-xs cgray">
Joined <time class="js-timeago js-timeago-render" title="" datetime="2017-07-29T08:06:25Z" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Jul 29, 2017 4:06pm GMT+0800">2 months ago</time>
</div>
</span>
                                <div class="controls member-controls">
                                    <form class="form-horizontal js-edit-member-form" id="edit_project_member_73" action="/ismond/xphp/project_members/73" accept-charset="UTF-8" data-remote="true" method="post"><input name="utf8" type="hidden" value="✓"><input type="hidden" name="_method" value="patch"><input type="hidden" value="30" name="project_member[access_level]" id="project_member_access_level">
                                        <div class="member-form-control dropdown append-right-5">
                                            <button class="dropdown-menu-toggle js-member-permissions-dropdown" data-field-name="project_member[access_level]" data-toggle="dropdown" type="button">
<span class="dropdown-toggle-text">
Developer
</span>
                                                <i class="fa fa-chevron-down"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-select dropdown-menu-align-right dropdown-menu-selectable">
                                                <div class="dropdown-title"><span>Change permissions</span><button class="dropdown-title-button dropdown-menu-close" aria-label="Close" type="button"><i class="fa fa-times dropdown-menu-close-icon"></i></button></div>
                                                <div class="dropdown-content">
                                                    <ul>
                                                        <li>
                                                            <a data-id="10" data-el-id="project_member_73" href="javascript:void(0)">Guest</a>
                                                        </li>
                                                        <li>
                                                            <a data-id="20" data-el-id="project_member_73" href="javascript:void(0)">Reporter</a>
                                                        </li>
                                                        <li>
                                                            <a class="is-active" data-id="30" data-el-id="project_member_73" href="javascript:void(0)">Developer</a>
                                                        </li>
                                                        <li>
                                                            <a data-id="40" data-el-id="project_member_73" href="javascript:void(0)">Master</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="prepend-left-5 clearable-input member-form-control">
                                            <input class="form-control js-access-expiration-date js-member-update-control" placeholder="Expiration date" id="member_expires_at_73" data-el-id="project_member_73" type="text" name="project_member[expires_at]" aria-label="Use the arrow keys to pick a date">
                                            <i class="clear-icon js-clear-input"></i>
                                        </div>
                                    </form><a data-confirm="Are you sure you want to remove gitlab-runner from the ismond / xphp project?" class="btn btn-remove prepend-left-10" title="Remove user from project" data-remote="true" rel="nofollow" data-method="delete" href="/ismond/xphp/project_members/73"><span class="visible-xs-block">
Delete
</span>
                                        <i class="fa fa-trash hidden-xs"></i>
                                    </a></div>
                            </li>
                            <li class="member project_member" id="project_member_65">
<span class="list-item-name">
<img class="avatar s40" alt="" src="http://www.gravatar.com/avatar/d59a94a888bff71ec46c6dc9299d2752?s=80&amp;d=identicon">
<strong>
<a href="/zhouzhicong">周智聪</a>
</strong>
<span class="cgray">@zhouzhicong</span>
<div class="hidden-xs cgray">
Joined <time class="js-timeago js-timeago-render" title="" datetime="2017-07-27T07:54:02Z" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Jul 27, 2017 3:54pm GMT+0800">2 months ago</time>
</div>
</span>
                                <div class="controls member-controls">
                                    <form class="form-horizontal js-edit-member-form" id="edit_project_member_65" action="/ismond/xphp/project_members/65" accept-charset="UTF-8" data-remote="true" method="post"><input name="utf8" type="hidden" value="✓"><input type="hidden" name="_method" value="patch"><input type="hidden" value="30" name="project_member[access_level]" id="project_member_access_level">
                                        <div class="member-form-control dropdown append-right-5">
                                            <button class="dropdown-menu-toggle js-member-permissions-dropdown" data-field-name="project_member[access_level]" data-toggle="dropdown" type="button">
<span class="dropdown-toggle-text">
Developer
</span>
                                                <i class="fa fa-chevron-down"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-select dropdown-menu-align-right dropdown-menu-selectable">
                                                <div class="dropdown-title"><span>Change permissions</span><button class="dropdown-title-button dropdown-menu-close" aria-label="Close" type="button"><i class="fa fa-times dropdown-menu-close-icon"></i></button></div>
                                                <div class="dropdown-content">
                                                    <ul>
                                                        <li>
                                                            <a data-id="10" data-el-id="project_member_65" href="javascript:void(0)">Guest</a>
                                                        </li>
                                                        <li>
                                                            <a data-id="20" data-el-id="project_member_65" href="javascript:void(0)">Reporter</a>
                                                        </li>
                                                        <li>
                                                            <a class="is-active" data-id="30" data-el-id="project_member_65" href="javascript:void(0)">Developer</a>
                                                        </li>
                                                        <li>
                                                            <a data-id="40" data-el-id="project_member_65" href="javascript:void(0)">Master</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="prepend-left-5 clearable-input member-form-control">
                                            <input class="form-control js-access-expiration-date js-member-update-control" placeholder="Expiration date" id="member_expires_at_65" data-el-id="project_member_65" type="text" name="project_member[expires_at]">
                                            <i class="clear-icon js-clear-input"></i>
                                        </div>
                                    </form><a data-confirm="Are you sure you want to remove 周智聪 from the ismond / xphp project?" class="btn btn-remove prepend-left-10" title="Remove user from project" data-remote="true" rel="nofollow" data-method="delete" href="/ismond/xphp/project_members/65"><span class="visible-xs-block">
Delete
</span>
                                        <i class="fa fa-trash hidden-xs"></i>
                                    </a></div>
                            </li>
                            <li class="member project_member" id="project_member_71">
<span class="list-item-name">
<img class="avatar s40" alt="" src="http://www.gravatar.com/avatar/991fac7b338428d9df4c83da0ae18468?s=80&amp;d=identicon">
<strong>
<a href="/songweiping">宋卫平</a>
</strong>
<span class="cgray">@songweiping</span>
<div class="hidden-xs cgray">
Joined <time class="js-timeago js-timeago-render" title="" datetime="2017-07-27T07:54:02Z" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Jul 27, 2017 3:54pm GMT+0800">2 months ago</time>
</div>
</span>
                                <div class="controls member-controls">
                                    <form class="form-horizontal js-edit-member-form" id="edit_project_member_71" action="/ismond/xphp/project_members/71" accept-charset="UTF-8" data-remote="true" method="post"><input name="utf8" type="hidden" value="✓"><input type="hidden" name="_method" value="patch"><input type="hidden" value="30" name="project_member[access_level]" id="project_member_access_level">
                                        <div class="member-form-control dropdown append-right-5">
                                            <button class="dropdown-menu-toggle js-member-permissions-dropdown" data-field-name="project_member[access_level]" data-toggle="dropdown" type="button">
<span class="dropdown-toggle-text">
Developer
</span>
                                                <i class="fa fa-chevron-down"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-select dropdown-menu-align-right dropdown-menu-selectable">
                                                <div class="dropdown-title"><span>Change permissions</span><button class="dropdown-title-button dropdown-menu-close" aria-label="Close" type="button"><i class="fa fa-times dropdown-menu-close-icon"></i></button></div>
                                                <div class="dropdown-content">
                                                    <ul>
                                                        <li>
                                                            <a data-id="10" data-el-id="project_member_71" href="javascript:void(0)">Guest</a>
                                                        </li>
                                                        <li>
                                                            <a data-id="20" data-el-id="project_member_71" href="javascript:void(0)">Reporter</a>
                                                        </li>
                                                        <li>
                                                            <a class="is-active" data-id="30" data-el-id="project_member_71" href="javascript:void(0)">Developer</a>
                                                        </li>
                                                        <li>
                                                            <a data-id="40" data-el-id="project_member_71" href="javascript:void(0)">Master</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="prepend-left-5 clearable-input member-form-control">
                                            <input class="form-control js-access-expiration-date js-member-update-control" placeholder="Expiration date" id="member_expires_at_71" data-el-id="project_member_71" type="text" name="project_member[expires_at]">
                                            <i class="clear-icon js-clear-input"></i>
                                        </div>
                                    </form><a data-confirm="Are you sure you want to remove 宋卫平 from the ismond / xphp project?" class="btn btn-remove prepend-left-10" title="Remove user from project" data-remote="true" rel="nofollow" data-method="delete" href="/ismond/xphp/project_members/71"><span class="visible-xs-block">
Delete
</span>
                                        <i class="fa fa-trash hidden-xs"></i>
                                    </a></div>
                            </li>
                            <li class="member project_member" id="project_member_67">
<span class="list-item-name">
<img class="avatar s40" alt="" src="http://www.gravatar.com/avatar/c88ecf5162619f8e6baf2f47ac7c9930?s=80&amp;d=identicon">
<strong>
<a href="/pengzhenglu">彭振陆</a>
</strong>
<span class="cgray">@pengzhenglu</span>
<div class="hidden-xs cgray">
Joined <time class="js-timeago js-timeago-render" title="" datetime="2017-07-27T07:54:02Z" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Jul 27, 2017 3:54pm GMT+0800">2 months ago</time>
</div>
</span>
                                <div class="controls member-controls">
                                    <form class="form-horizontal js-edit-member-form" id="edit_project_member_67" action="/ismond/xphp/project_members/67" accept-charset="UTF-8" data-remote="true" method="post"><input name="utf8" type="hidden" value="✓"><input type="hidden" name="_method" value="patch"><input type="hidden" value="30" name="project_member[access_level]" id="project_member_access_level">
                                        <div class="member-form-control dropdown append-right-5">
                                            <button class="dropdown-menu-toggle js-member-permissions-dropdown" data-field-name="project_member[access_level]" data-toggle="dropdown" type="button">
<span class="dropdown-toggle-text">
Developer
</span>
                                                <i class="fa fa-chevron-down"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-select dropdown-menu-align-right dropdown-menu-selectable">
                                                <div class="dropdown-title"><span>Change permissions</span><button class="dropdown-title-button dropdown-menu-close" aria-label="Close" type="button"><i class="fa fa-times dropdown-menu-close-icon"></i></button></div>
                                                <div class="dropdown-content">
                                                    <ul>
                                                        <li>
                                                            <a data-id="10" data-el-id="project_member_67" href="javascript:void(0)">Guest</a>
                                                        </li>
                                                        <li>
                                                            <a data-id="20" data-el-id="project_member_67" href="javascript:void(0)">Reporter</a>
                                                        </li>
                                                        <li>
                                                            <a class="is-active" data-id="30" data-el-id="project_member_67" href="javascript:void(0)">Developer</a>
                                                        </li>
                                                        <li>
                                                            <a data-id="40" data-el-id="project_member_67" href="javascript:void(0)">Master</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="prepend-left-5 clearable-input member-form-control">
                                            <input class="form-control js-access-expiration-date js-member-update-control" placeholder="Expiration date" id="member_expires_at_67" data-el-id="project_member_67" type="text" name="project_member[expires_at]">
                                            <i class="clear-icon js-clear-input"></i>
                                        </div>
                                    </form><a data-confirm="Are you sure you want to remove 彭振陆 from the ismond / xphp project?" class="btn btn-remove prepend-left-10" title="Remove user from project" data-remote="true" rel="nofollow" data-method="delete" href="/ismond/xphp/project_members/67"><span class="visible-xs-block">
Delete
</span>
                                        <i class="fa fa-trash hidden-xs"></i>
                                    </a></div>
                            </li>
                            <li class="member project_member" id="project_member_66">
<span class="list-item-name">
<img class="avatar s40" alt="" src="http://192.168.3.213/uploads/user/avatar/10/avatar.png">
<strong>
<a href="/lijian">李健</a>
</strong>
<span class="cgray">@lijian</span>
<div class="hidden-xs cgray">
Joined <time class="js-timeago js-timeago-render" title="" datetime="2017-07-27T07:54:02Z" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Jul 27, 2017 3:54pm GMT+0800">2 months ago</time>
</div>
</span>
                                <div class="controls member-controls">
                                    <form class="form-horizontal js-edit-member-form" id="edit_project_member_66" action="/ismond/xphp/project_members/66" accept-charset="UTF-8" data-remote="true" method="post"><input name="utf8" type="hidden" value="✓"><input type="hidden" name="_method" value="patch"><input type="hidden" value="30" name="project_member[access_level]" id="project_member_access_level">
                                        <div class="member-form-control dropdown append-right-5">
                                            <button class="dropdown-menu-toggle js-member-permissions-dropdown" data-field-name="project_member[access_level]" data-toggle="dropdown" type="button">
<span class="dropdown-toggle-text">
Developer
</span>
                                                <i class="fa fa-chevron-down"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-select dropdown-menu-align-right dropdown-menu-selectable">
                                                <div class="dropdown-title"><span>Change permissions</span><button class="dropdown-title-button dropdown-menu-close" aria-label="Close" type="button"><i class="fa fa-times dropdown-menu-close-icon"></i></button></div>
                                                <div class="dropdown-content">
                                                    <ul>
                                                        <li>
                                                            <a data-id="10" data-el-id="project_member_66" href="javascript:void(0)">Guest</a>
                                                        </li>
                                                        <li>
                                                            <a data-id="20" data-el-id="project_member_66" href="javascript:void(0)">Reporter</a>
                                                        </li>
                                                        <li>
                                                            <a class="is-active" data-id="30" data-el-id="project_member_66" href="javascript:void(0)">Developer</a>
                                                        </li>
                                                        <li>
                                                            <a data-id="40" data-el-id="project_member_66" href="javascript:void(0)">Master</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="prepend-left-5 clearable-input member-form-control">
                                            <input class="form-control js-access-expiration-date js-member-update-control" placeholder="Expiration date" id="member_expires_at_66" data-el-id="project_member_66" type="text" name="project_member[expires_at]">
                                            <i class="clear-icon js-clear-input"></i>
                                        </div>
                                    </form><a data-confirm="Are you sure you want to remove 李健 from the ismond / xphp project?" class="btn btn-remove prepend-left-10" title="Remove user from project" data-remote="true" rel="nofollow" data-method="delete" href="/ismond/xphp/project_members/66"><span class="visible-xs-block">
Delete
</span>
                                        <i class="fa fa-trash hidden-xs"></i>
                                    </a></div>
                            </li>
                            <li class="member project_member" id="project_member_72">
<span class="list-item-name">
<img class="avatar s40" alt="" src="http://www.gravatar.com/avatar/e5baff75af01ef5b66fbaa1435f89330?s=80&amp;d=identicon">
<strong>
<a href="/yangwenjie">杨文杰</a>
</strong>
<span class="cgray">@yangwenjie</span>
<div class="hidden-xs cgray">
Joined <time class="js-timeago js-timeago-render" title="" datetime="2017-07-27T12:12:42Z" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Jul 27, 2017 8:12pm GMT+0800">2 months ago</time>
</div>
</span>
                                <div class="controls member-controls">
                                    <form class="form-horizontal js-edit-member-form" id="edit_project_member_72" action="/ismond/xphp/project_members/72" accept-charset="UTF-8" data-remote="true" method="post"><input name="utf8" type="hidden" value="✓"><input type="hidden" name="_method" value="patch"><input type="hidden" value="30" name="project_member[access_level]" id="project_member_access_level">
                                        <div class="member-form-control dropdown append-right-5">
                                            <button class="dropdown-menu-toggle js-member-permissions-dropdown" data-field-name="project_member[access_level]" data-toggle="dropdown" type="button">
<span class="dropdown-toggle-text">
Developer
</span>
                                                <i class="fa fa-chevron-down"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-select dropdown-menu-align-right dropdown-menu-selectable">
                                                <div class="dropdown-title"><span>Change permissions</span><button class="dropdown-title-button dropdown-menu-close" aria-label="Close" type="button"><i class="fa fa-times dropdown-menu-close-icon"></i></button></div>
                                                <div class="dropdown-content">
                                                    <ul>
                                                        <li>
                                                            <a data-id="10" data-el-id="project_member_72" href="javascript:void(0)">Guest</a>
                                                        </li>
                                                        <li>
                                                            <a data-id="20" data-el-id="project_member_72" href="javascript:void(0)">Reporter</a>
                                                        </li>
                                                        <li>
                                                            <a class="is-active" data-id="30" data-el-id="project_member_72" href="javascript:void(0)">Developer</a>
                                                        </li>
                                                        <li>
                                                            <a data-id="40" data-el-id="project_member_72" href="javascript:void(0)">Master</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="prepend-left-5 clearable-input member-form-control">
                                            <input class="form-control js-access-expiration-date js-member-update-control" placeholder="Expiration date" id="member_expires_at_72" data-el-id="project_member_72" type="text" name="project_member[expires_at]">
                                            <i class="clear-icon js-clear-input"></i>
                                        </div>
                                    </form><a data-confirm="Are you sure you want to remove 杨文杰 from the ismond / xphp project?" class="btn btn-remove prepend-left-10" title="Remove user from project" data-remote="true" rel="nofollow" data-method="delete" href="/ismond/xphp/project_members/72"><span class="visible-xs-block">
Delete
</span>
                                        <i class="fa fa-trash hidden-xs"></i>
                                    </a></div>
                            </li>
                            <li class="member project_member" id="project_member_68">
<span class="list-item-name">
<img class="avatar s40" alt="" src="http://www.gravatar.com/avatar/53bbf5f63aa1fef75870d3ef2160f66a?s=80&amp;d=identicon">
<strong>
<a href="/oushuquan">欧树权</a>
</strong>
<span class="cgray">@oushuquan</span>
<div class="hidden-xs cgray">
Joined <time class="js-timeago js-timeago-render" title="" datetime="2017-07-27T07:54:02Z" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Jul 27, 2017 3:54pm GMT+0800">2 months ago</time>
</div>
</span>
                                <div class="controls member-controls">
                                    <form class="form-horizontal js-edit-member-form" id="edit_project_member_68" action="/ismond/xphp/project_members/68" accept-charset="UTF-8" data-remote="true" method="post"><input name="utf8" type="hidden" value="✓"><input type="hidden" name="_method" value="patch"><input type="hidden" value="30" name="project_member[access_level]" id="project_member_access_level">
                                        <div class="member-form-control dropdown append-right-5">
                                            <button class="dropdown-menu-toggle js-member-permissions-dropdown" data-field-name="project_member[access_level]" data-toggle="dropdown" type="button">
<span class="dropdown-toggle-text">
Developer
</span>
                                                <i class="fa fa-chevron-down"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-select dropdown-menu-align-right dropdown-menu-selectable">
                                                <div class="dropdown-title"><span>Change permissions</span><button class="dropdown-title-button dropdown-menu-close" aria-label="Close" type="button"><i class="fa fa-times dropdown-menu-close-icon"></i></button></div>
                                                <div class="dropdown-content">
                                                    <ul>
                                                        <li>
                                                            <a data-id="10" data-el-id="project_member_68" href="javascript:void(0)">Guest</a>
                                                        </li>
                                                        <li>
                                                            <a data-id="20" data-el-id="project_member_68" href="javascript:void(0)">Reporter</a>
                                                        </li>
                                                        <li>
                                                            <a class="is-active" data-id="30" data-el-id="project_member_68" href="javascript:void(0)">Developer</a>
                                                        </li>
                                                        <li>
                                                            <a data-id="40" data-el-id="project_member_68" href="javascript:void(0)">Master</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="prepend-left-5 clearable-input member-form-control">
                                            <input class="form-control js-access-expiration-date js-member-update-control" placeholder="Expiration date" id="member_expires_at_68" data-el-id="project_member_68" type="text" name="project_member[expires_at]">
                                            <i class="clear-icon js-clear-input"></i>
                                        </div>
                                    </form><a data-confirm="Are you sure you want to remove 欧树权 from the ismond / xphp project?" class="btn btn-remove prepend-left-10" title="Remove user from project" data-remote="true" rel="nofollow" data-method="delete" href="/ismond/xphp/project_members/68"><span class="visible-xs-block">
Delete
</span>
                                        <i class="fa fa-trash hidden-xs"></i>
                                    </a></div>
                            </li>
                            <li class="member project_member" id="project_member_64">
<span class="list-item-name">
<img class="avatar s40" alt="" src="http://www.gravatar.com/avatar/3333f73983020f51aaa42c2887f9174d?s=80&amp;d=identicon">
<strong>
<a href="/shenzebiao">沈泽彪</a>
</strong>
<span class="cgray">@shenzebiao</span>
<div class="hidden-xs cgray">
Joined <time class="js-timeago js-timeago-render" title="" datetime="2017-07-27T07:54:02Z" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Jul 27, 2017 3:54pm GMT+0800">2 months ago</time>
</div>
</span>
                                <div class="controls member-controls">
                                    <form class="form-horizontal js-edit-member-form" id="edit_project_member_64" action="/ismond/xphp/project_members/64" accept-charset="UTF-8" data-remote="true" method="post"><input name="utf8" type="hidden" value="✓"><input type="hidden" name="_method" value="patch"><input type="hidden" value="30" name="project_member[access_level]" id="project_member_access_level">
                                        <div class="member-form-control dropdown append-right-5">
                                            <button class="dropdown-menu-toggle js-member-permissions-dropdown" data-field-name="project_member[access_level]" data-toggle="dropdown" type="button">
<span class="dropdown-toggle-text">
Developer
</span>
                                                <i class="fa fa-chevron-down"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-select dropdown-menu-align-right dropdown-menu-selectable">
                                                <div class="dropdown-title"><span>Change permissions</span><button class="dropdown-title-button dropdown-menu-close" aria-label="Close" type="button"><i class="fa fa-times dropdown-menu-close-icon"></i></button></div>
                                                <div class="dropdown-content">
                                                    <ul>
                                                        <li>
                                                            <a data-id="10" data-el-id="project_member_64" href="javascript:void(0)">Guest</a>
                                                        </li>
                                                        <li>
                                                            <a data-id="20" data-el-id="project_member_64" href="javascript:void(0)">Reporter</a>
                                                        </li>
                                                        <li>
                                                            <a class="is-active" data-id="30" data-el-id="project_member_64" href="javascript:void(0)">Developer</a>
                                                        </li>
                                                        <li>
                                                            <a data-id="40" data-el-id="project_member_64" href="javascript:void(0)">Master</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="prepend-left-5 clearable-input member-form-control">
                                            <input class="form-control js-access-expiration-date js-member-update-control" placeholder="Expiration date" id="member_expires_at_64" data-el-id="project_member_64" type="text" name="project_member[expires_at]">
                                            <i class="clear-icon js-clear-input"></i>
                                        </div>
                                    </form><a data-confirm="Are you sure you want to remove 沈泽彪 from the ismond / xphp project?" class="btn btn-remove prepend-left-10" title="Remove user from project" data-remote="true" rel="nofollow" data-method="delete" href="/ismond/xphp/project_members/64"><span class="visible-xs-block">
Delete
</span>
                                        <i class="fa fa-trash hidden-xs"></i>
                                    </a></div>
                            </li>
                            <li class="member project_member" id="project_member_69">
<span class="list-item-name">
<img class="avatar s40" alt="" src="http://www.gravatar.com/avatar/90aad2acd7cdc5d19faaf4a6f6e4cac5?s=80&amp;d=identicon">
<strong>
<a href="/luoshengxin">罗胜欣</a>
</strong>
<span class="cgray">@luoshengxin</span>
<div class="hidden-xs cgray">
Joined <time class="js-timeago js-timeago-render" title="" datetime="2017-07-27T07:54:02Z" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Jul 27, 2017 3:54pm GMT+0800">2 months ago</time>
</div>
</span>
                                <div class="controls member-controls">
                                    <form class="form-horizontal js-edit-member-form" id="edit_project_member_69" action="/ismond/xphp/project_members/69" accept-charset="UTF-8" data-remote="true" method="post"><input name="utf8" type="hidden" value="✓"><input type="hidden" name="_method" value="patch"><input type="hidden" value="30" name="project_member[access_level]" id="project_member_access_level">
                                        <div class="member-form-control dropdown append-right-5">
                                            <button class="dropdown-menu-toggle js-member-permissions-dropdown" data-field-name="project_member[access_level]" data-toggle="dropdown" type="button">
<span class="dropdown-toggle-text">
Developer
</span>
                                                <i class="fa fa-chevron-down"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-select dropdown-menu-align-right dropdown-menu-selectable">
                                                <div class="dropdown-title"><span>Change permissions</span><button class="dropdown-title-button dropdown-menu-close" aria-label="Close" type="button"><i class="fa fa-times dropdown-menu-close-icon"></i></button></div>
                                                <div class="dropdown-content">
                                                    <ul>
                                                        <li>
                                                            <a data-id="10" data-el-id="project_member_69" href="javascript:void(0)">Guest</a>
                                                        </li>
                                                        <li>
                                                            <a data-id="20" data-el-id="project_member_69" href="javascript:void(0)">Reporter</a>
                                                        </li>
                                                        <li>
                                                            <a class="is-active" data-id="30" data-el-id="project_member_69" href="javascript:void(0)">Developer</a>
                                                        </li>
                                                        <li>
                                                            <a data-id="40" data-el-id="project_member_69" href="javascript:void(0)">Master</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="prepend-left-5 clearable-input member-form-control">
                                            <input class="form-control js-access-expiration-date js-member-update-control" placeholder="Expiration date" id="member_expires_at_69" data-el-id="project_member_69" type="text" name="project_member[expires_at]">
                                            <i class="clear-icon js-clear-input"></i>
                                        </div>
                                    </form><a data-confirm="Are you sure you want to remove 罗胜欣 from the ismond / xphp project?" class="btn btn-remove prepend-left-10" title="Remove user from project" data-remote="true" rel="nofollow" data-method="delete" href="/ismond/xphp/project_members/69"><span class="visible-xs-block">
Delete
</span>
                                        <i class="fa fa-trash hidden-xs"></i>
                                    </a></div>
                            </li>
                            <li class="group_member member" id="group_member_24">
<span class="list-item-name">
<img class="avatar s40" alt="" src="http://www.gravatar.com/avatar/72507d193a1e05ed4a3e010e7430721e?s=80&amp;d=identicon">
<strong>
<a href="/huqiang">胡强</a>
</strong>
<span class="cgray">@huqiang</span>
·
<a class="member-group-link" href="/ismond">ismond</a>
<div class="hidden-xs cgray">
Joined <time class="js-timeago js-timeago-render" title="" datetime="2017-06-28T02:07:23Z" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Jun 28, 2017 10:07am GMT+0800">3 months ago</time>
</div>
</span>
                                <div class="controls member-controls">
                                    <span class="member-access-text">Master</span>
                                </div>
                            </li>
                            <li class="member project_member" id="project_member_86">
<span class="list-item-name">
<img class="avatar s40" alt="" src="http://www.gravatar.com/avatar/36fd844cd09775f2d326556d02d5e3f6?s=80&amp;d=identicon">
<strong>
<a href="/hurong">胡熔</a>
</strong>
<span class="cgray">@hurong</span>
<div class="hidden-xs cgray">
Joined <time class="js-timeago js-timeago-render" title="" datetime="2017-08-07T07:30:46Z" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Aug 7, 2017 3:30pm GMT+0800">2 months ago</time>
</div>
</span>
                                <div class="controls member-controls">
                                    <form class="form-horizontal js-edit-member-form" id="edit_project_member_86" action="/ismond/xphp/project_members/86" accept-charset="UTF-8" data-remote="true" method="post"><input name="utf8" type="hidden" value="✓"><input type="hidden" name="_method" value="patch"><input type="hidden" value="30" name="project_member[access_level]" id="project_member_access_level">
                                        <div class="member-form-control dropdown append-right-5">
                                            <button class="dropdown-menu-toggle js-member-permissions-dropdown" data-field-name="project_member[access_level]" data-toggle="dropdown" type="button">
<span class="dropdown-toggle-text">
Developer
</span>
                                                <i class="fa fa-chevron-down"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-select dropdown-menu-align-right dropdown-menu-selectable">
                                                <div class="dropdown-title"><span>Change permissions</span><button class="dropdown-title-button dropdown-menu-close" aria-label="Close" type="button"><i class="fa fa-times dropdown-menu-close-icon"></i></button></div>
                                                <div class="dropdown-content">
                                                    <ul>
                                                        <li>
                                                            <a data-id="10" data-el-id="project_member_86" href="javascript:void(0)">Guest</a>
                                                        </li>
                                                        <li>
                                                            <a data-id="20" data-el-id="project_member_86" href="javascript:void(0)">Reporter</a>
                                                        </li>
                                                        <li>
                                                            <a class="is-active" data-id="30" data-el-id="project_member_86" href="javascript:void(0)">Developer</a>
                                                        </li>
                                                        <li>
                                                            <a data-id="40" data-el-id="project_member_86" href="javascript:void(0)">Master</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="prepend-left-5 clearable-input member-form-control">
                                            <input class="form-control js-access-expiration-date js-member-update-control" placeholder="Expiration date" id="member_expires_at_86" data-el-id="project_member_86" type="text" name="project_member[expires_at]">
                                            <i class="clear-icon js-clear-input"></i>
                                        </div>
                                    </form><a data-confirm="Are you sure you want to remove 胡熔 from the ismond / xphp project?" class="btn btn-remove prepend-left-10" title="Remove user from project" data-remote="true" rel="nofollow" data-method="delete" href="/ismond/xphp/project_members/86"><span class="visible-xs-block">
Delete
</span>
                                        <i class="fa fa-trash hidden-xs"></i>
                                    </a></div>
                            </li>
                            <li class="group_member member" id="group_member_23">
<span class="list-item-name">
<img class="avatar s40" alt="" src="http://www.gravatar.com/avatar/369ea35620f75dddced869daa37a6a7e?s=80&amp;d=identicon">
<strong>
<a href="/guosheng">郭胜</a>
</strong>
<span class="cgray">@guosheng</span>
·
<a class="member-group-link" href="/ismond">ismond</a>
<div class="hidden-xs cgray">
Joined <time class="js-timeago js-timeago-render" title="" datetime="2017-06-28T02:07:11Z" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Jun 28, 2017 10:07am GMT+0800">3 months ago</time>
</div>
</span>
                                <div class="controls member-controls">
                                    <span class="member-access-text">Master</span>
                                </div>
                            </li>
                            <li class="group_member member" id="group_member_46">
<span class="list-item-name">
<img class="avatar s40" alt="" src="http://192.168.3.213/uploads/user/avatar/15/avatar.png">
<strong>
<a href="/sven">韦朝夺</a>
</strong>
<span class="cgray">@sven</span>
<span class="label label-success prepend-left-5">It's you</span>
·
<a class="member-group-link" href="/ismond">ismond</a>
<div class="hidden-xs cgray">
Joined <time class="js-timeago js-timeago-render" title="" datetime="2017-07-10T07:25:45Z" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Jul 10, 2017 3:25pm GMT+0800">3 months ago</time>
</div>
</span>
                                <div class="controls member-controls">
                                    <span class="member-access-text">Master</span>
                                </div>
                            </li>
                            <li class="member project_member" id="project_member_74">
<span class="list-item-name">
<img class="avatar s40" alt="" src="http://www.gravatar.com/avatar/1b4a748ddcb785cc327def5af752ea67?s=80&amp;d=identicon">
<strong>
<a href="/weiyulin">魏玉林</a>
</strong>
<span class="cgray">@weiyulin</span>
<div class="hidden-xs cgray">
Joined <time class="js-timeago js-timeago-render" title="" datetime="2017-08-01T10:29:27Z" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Aug 1, 2017 6:29pm GMT+0800">2 months ago</time>
</div>
</span>
                                <div class="controls member-controls">
                                    <form class="form-horizontal js-edit-member-form" id="edit_project_member_74" action="/ismond/xphp/project_members/74" accept-charset="UTF-8" data-remote="true" method="post"><input name="utf8" type="hidden" value="✓"><input type="hidden" name="_method" value="patch"><input type="hidden" value="30" name="project_member[access_level]" id="project_member_access_level">
                                        <div class="member-form-control dropdown append-right-5">
                                            <button class="dropdown-menu-toggle js-member-permissions-dropdown" data-field-name="project_member[access_level]" data-toggle="dropdown" type="button">
<span class="dropdown-toggle-text">
Developer
</span>
                                                <i class="fa fa-chevron-down"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-select dropdown-menu-align-right dropdown-menu-selectable">
                                                <div class="dropdown-title"><span>Change permissions</span><button class="dropdown-title-button dropdown-menu-close" aria-label="Close" type="button"><i class="fa fa-times dropdown-menu-close-icon"></i></button></div>
                                                <div class="dropdown-content">
                                                    <ul>
                                                        <li>
                                                            <a data-id="10" data-el-id="project_member_74" href="javascript:void(0)">Guest</a>
                                                        </li>
                                                        <li>
                                                            <a data-id="20" data-el-id="project_member_74" href="javascript:void(0)">Reporter</a>
                                                        </li>
                                                        <li>
                                                            <a class="is-active" data-id="30" data-el-id="project_member_74" href="javascript:void(0)">Developer</a>
                                                        </li>
                                                        <li>
                                                            <a data-id="40" data-el-id="project_member_74" href="javascript:void(0)">Master</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="prepend-left-5 clearable-input member-form-control">
                                            <input class="form-control js-access-expiration-date js-member-update-control" placeholder="Expiration date" id="member_expires_at_74" data-el-id="project_member_74" type="text" name="project_member[expires_at]">
                                            <i class="clear-icon js-clear-input"></i>
                                        </div>
                                    </form><a data-confirm="Are you sure you want to remove 魏玉林 from the ismond / xphp project?" class="btn btn-remove prepend-left-10" title="Remove user from project" data-remote="true" rel="nofollow" data-method="delete" href="/ismond/xphp/project_members/74"><span class="visible-xs-block">
Delete
</span>
                                        <i class="fa fa-trash hidden-xs"></i>
                                    </a></div>
                            </li>
                            <li class="member project_member" id="project_member_70">
<span class="list-item-name">
<img class="avatar s40" alt="" src="http://www.gravatar.com/avatar/56c8883b6c05ed54889df0aedfc9d47d?s=80&amp;d=identicon">
<strong>
<a href="/huangjie">黄杰</a>
</strong>
<span class="cgray">@huangjie</span>
<div class="hidden-xs cgray">
Joined <time class="js-timeago js-timeago-render" title="" datetime="2017-07-27T07:54:02Z" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Jul 27, 2017 3:54pm GMT+0800">2 months ago</time>
</div>
</span>
                                <div class="controls member-controls">
                                    <form class="form-horizontal js-edit-member-form" id="edit_project_member_70" action="/ismond/xphp/project_members/70" accept-charset="UTF-8" data-remote="true" method="post"><input name="utf8" type="hidden" value="✓"><input type="hidden" name="_method" value="patch"><input type="hidden" value="30" name="project_member[access_level]" id="project_member_access_level">
                                        <div class="member-form-control dropdown append-right-5">
                                            <button class="dropdown-menu-toggle js-member-permissions-dropdown" data-field-name="project_member[access_level]" data-toggle="dropdown" type="button">
<span class="dropdown-toggle-text">
Developer
</span>
                                                <i class="fa fa-chevron-down"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-select dropdown-menu-align-right dropdown-menu-selectable">
                                                <div class="dropdown-title"><span>Change permissions</span><button class="dropdown-title-button dropdown-menu-close" aria-label="Close" type="button"><i class="fa fa-times dropdown-menu-close-icon"></i></button></div>
                                                <div class="dropdown-content">
                                                    <ul>
                                                        <li>
                                                            <a data-id="10" data-el-id="project_member_70" href="javascript:void(0)">Guest</a>
                                                        </li>
                                                        <li>
                                                            <a data-id="20" data-el-id="project_member_70" href="javascript:void(0)">Reporter</a>
                                                        </li>
                                                        <li>
                                                            <a class="is-active" data-id="30" data-el-id="project_member_70" href="javascript:void(0)">Developer</a>
                                                        </li>
                                                        <li>
                                                            <a data-id="40" data-el-id="project_member_70" href="javascript:void(0)">Master</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="prepend-left-5 clearable-input member-form-control">
                                            <input class="form-control js-access-expiration-date js-member-update-control" placeholder="Expiration date" id="member_expires_at_70" data-el-id="project_member_70" type="text" name="project_member[expires_at]">
                                            <i class="clear-icon js-clear-input"></i>
                                        </div>
                                    </form><a data-confirm="Are you sure you want to remove 黄杰 from the ismond / xphp project?" class="btn btn-remove prepend-left-10" title="Remove user from project" data-remote="true" rel="nofollow" data-method="delete" href="/ismond/xphp/project_members/70"><span class="visible-xs-block">
Delete
</span>
                                        <i class="fa fa-trash hidden-xs"></i>
                                    </a></div>
                            </li>

                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>