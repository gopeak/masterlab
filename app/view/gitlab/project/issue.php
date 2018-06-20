<!DOCTYPE html>
<html class="" lang="en">
<head  >

    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>
    <script src="/gitlab/assets/webpack/filtered_search.bundle.js"></script>

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
    <? require_once VIEW_PATH.'gitlab/project/common-page-nav-project.php';?>

    <? require_once VIEW_PATH.'gitlab/project/common-setting-nav-links-sub-nav.php';?>

    <div class="content-wrapper page-with-layout-nav page-with-sub-nav">
        <div class="alert-wrapper">

            <div class="flash-container flash-container-page">
            </div>

        </div>
        <div class="container-fluid ">

            <div class="content" id="content-body">

                <div class="row prepend-top-default">
                    <div class="col-lg-2 settings-sidebar">
                        <h4 class="prepend-top-0">
                            过滤器
                        </h4>
                        <p>
                            <a class="btn btn-default" title="Import members from another project" href="#">新建过滤器</a>
                        </p>
                        <div class="filter-panel-wrapper" style="max-height: 404px;">
                            <div class="filter-panel-system-container">
                                <div class="filter-panel-section">
                                    <div class="filter-content">
                                        <ul class="saved-filter filter-list system-filters">
                                            <li>
                                                <a class="filter-link" href="/issues/?filter=-1" data-id="-1" title="My open issues">My open issues</a></li>
                                            <li>
                                                <a class="filter-link" href="/issues/?filter=-2" data-id="-2" title="Reported by me">Reported by me</a></li>
                                            <li>
                                                <a class="filter-link active" href="/issues/?filter=-4" data-id="-4" title="All issues">All issues</a></li>
                                            <li>
                                                <a class="filter-link" href="/issues/?filter=-5" data-id="-5" title="Open issues">Open issues</a></li>
                                            <li>
                                                <a class="filter-link" href="/issues/?filter=-9" data-id="-9" title="Done issues">Done issues</a></li>
                                            <li>
                                                <a class="filter-link" href="/issues/?filter=-3" data-id="-3" title="Viewed recently">Viewed recently</a></li>
                                            <li>
                                                <a class="filter-link" href="/issues/?filter=-6" data-id="-6" title="Created recently">Created recently</a></li>
                                            <li>
                                                <a class="filter-link" href="/issues/?filter=-7" data-id="-7" title="最近解决的">最近解决的</a></li>
                                            <li>
                                                <a class="filter-link" href="/issues/?filter=-8" data-id="-8" title="最近更新的">最近更新的</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="filter-panel-favourites-container">
                                <div class="filter-panel-section">
                                    <h4 class="filter-title">收藏的过滤器</h4>
                                    <div class="filter-content">
                                        <ul class="saved-filter filter-list favourite-filters">
                                            <li>
                                                <a class="filter-link" href="/issues/?filter=10002" data-id="10002" title="杨文杰-未解决">杨文杰-未解决</a>
                                                <a href="#" class="filter-actions" data-id="10002">
                                                    <span>过滤器操作</span></a>
                                            </li>
                                            <li>
                                                <a class="filter-link" href="/issues/?filter=10104" data-id="10104" title="重构所有问题">重构所有问题</a>
                                                <a href="#" class="filter-actions" data-id="10104">
                                                    <span>过滤器操作</span></a>
                                            </li>
                                            <li>
                                                <a class="filter-link" href="/issues/?filter=10100" data-id="10100" title="APP2.1全部问题">APP2.1全部问题</a>
                                                <a href="#" class="filter-actions" data-id="10100">
                                                    <span>过滤器操作</span></a>
                                            </li>
                                            <li>
                                                <a class="filter-link" href="/issues/?filter=10010" data-id="10010" title="APP2.1未解决">APP2.1未解决</a>
                                                <a href="#" class="filter-actions" data-id="10010">
                                                    <span>过滤器操作</span></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-10">
                        <div class="light prepend-top-default">
                            <form class="users-project-form" id="new_project_member" action="/ismond/xphp/project_members" accept-charset="UTF-8" method="post"><input name="utf8" type="hidden" value="✓"><input type="hidden" name="authenticity_token" value="v3cyIWMoSPUlmZl0aR87Bq72rXtsYvv58uAayAFJsQCMYt8ld5bOqsH23T8vsNchT+iK72oqKhS1DPGvx6Sg7w=="><div class="form-group">
                                    <div class="select2-container select2-container-multi ajax-users-select multiselect input-clamp" id="s2id_user_ids"><ul class="select2-choices">  <li class="select2-search-field">    <label for="s2id_autogen2" class="select2-offscreen"></label>    <input type="text" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" class="select2-input select2-default" id="s2id_autogen2" placeholder="" style="width: 1389px;">  </li></ul><div class="select2-drop select2-drop-multi select2-display-none ajax-users-dropdown">   <ul class="select2-results">   <li class="select2-no-results">No matches found</li></ul></div></div><input type="hidden" name="user_ids" id="user_ids" value="" class="ajax-users-select multiselect input-clamp" data-placeholder="Search for members to update or invite" data-null-user="false" data-any-user="false" data-email-user="true" data-first-user="false" data-current-user="false" data-push-code-to-protected-branches="null" data-author-id="" data-skip-users="null" tabindex="-1" style="display: none;">
                                    <div class="help-block append-bottom-10">
                                        Search for members by name, username, or email, or invite new ones using their email address.
                                    </div>
                                </div>
                                <div class="form-group">
                                    <select name="access_level" id="access_level" class="form-control project-access-select"><option value="10">Guest</option>
                                        <option value="20">Reporter</option>
                                        <option value="30">Developer</option>
                                        <option value="40">Master</option></select>
                                    <div class="help-block append-bottom-10">
                                        <a class="vlink" href="/help/user/permissions">Read more</a>
                                        about role permissions
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="clearable-input">
                                        <input type="text" name="expires_at" id="expires_at" class="form-control js-access-expiration-date" placeholder="Expiration date">
                                        <i class="clear-icon js-clear-input"></i>
                                    </div>
                                    <div class="help-block append-bottom-10">
                                        On this date, the member(s) will automatically lose access to this project.
                                    </div>
                                </div>
                                <input type="submit" name="commit" value="Add to project" class="btn btn-create disabled" disabled="disabled">
                                <a class="btn btn-default" title="Import members from another project" href="/ismond/xphp/project_members/import">Import</a>
                            </form>

                            <div class="append-bottom-default clearfix">
                                <h5 class="member existing-title">
                                    Existing members and groups
                                </h5>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Members with access to
                                <strong>xphp</strong>
                                <span class="badge">16</span>
                                <form class="form-inline member-search-form" action="/ismond/xphp/settings/members" accept-charset="UTF-8" method="get"><input name="utf8" type="hidden" value="✓"><div class="form-group">
                                        <input type="search" name="search" id="search" placeholder="Find existing members by name" class="form-control" spellcheck="false" value="">
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
                            <div class="content-list pipelines">

                                <div class="table-holder">
                                    <table class="table ci-table">
                                        <thead>
                                        <tr>
                                            <th class="js-pipeline-info pipeline-info">类型</th>
                                            <th class="js-pipeline-commit pipeline-commit">项目</th>
                                            <th class="js-pipeline-stages pipeline-info">键值</th>
                                            <th class="js-pipeline-stages pipeline-info"><span class="js-pipeline-date pipeline-stages">负责人</span></th>
                                            <th class="js-pipeline-stages pipeline-info"><span class="js-pipeline-date pipeline-stages">网址</span></th>
                                            <th class="js-pipeline-date pipeline-date">创建时间</th>
                                            <th class="js-pipeline-actions pipeline-actions"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr class="commit">
                                            <td>
                                                <i class="fa fa-code-fork"></i>
                                                <a href="#"  class="commit-id monospace">Scrum</a>
                                            </td>
                                            <td>
                                                <div class="branch-commit">
                                                    <p class="commit-title">
                                                        <strong><span>
                                                    <a href="mailto:1131544367@qq.com" class="avatar-image-container">
                                                        <img src="http://www.gravatar.com/avatar/369ea35620f75dddced869daa37a6a7e?s=80&amp;d=identicon"
                                                             title="guosheng" class="avatar has-tooltip s20">
                                                    </a>
                                                    <a href="/project/main/home" class="commit-row-message">
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
                                                <a href="#" class="commit-id monospace">ismond/xphp</a>

                                            </td>
                                            <td  >
                                        <span class="list-item-name">
                                            <img class="avatar s40" alt="" src="http://192.168.3.213/uploads/user/avatar/15/avatar.png">
                                            <strong>
                                            <a href="/sven">韦朝夺</a>
                                            </strong>
                                            <span class="cgray">@sven</span>
                                            <span class="label label-success prepend-left-5">It's you</span>
                                            ·
                                            <a class="member-group-link" href="/ismond">ismond</a>

                                         </span>

                                            </td>
                                            <td  >
                                                <a href="#" class="commit-id monospace">http://</a>


                                            </td>
                                            <td class="pipelines-time-ago">
                                                <!---->
                                                <p class="finished-at">
                                                    <i class="fa fa-calendar"></i>
                                                    <time data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Oct 20, 2017 3:25pm GMT+0800">
                                                        4 days ago
                                                    </time>
                                                </p>
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
                            </div>
                        </div>


                    </div>
                </div>




            </div>
            
        </div>
    </div>
</div>
</body>
</html>


</div>