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
    <? require_once VIEW_PATH.'gitlab/admin/common-page-nav-admin.php';?>


    <div class="content-wrapper page-with-layout-nav page-with-sub-nav">
        <div class="alert-wrapper">

            <div class="flash-container flash-container-page">
            </div>

        </div>
        <div class="container-fluid ">

            <div class="content" id="content-body">

                <?php include VIEW_PATH.'gitlab/admin/common_project_left_nav.php';?>

                <div class="prepend-top-default" style="margin-left: 160px">
                    <div class=" prepend-top-default">
                        <div class="col-lg-2 settings-sidebar">
                            <h4 class="prepend-top-0">
                                项目角色
                            </h4>

                        </div>
                        <div class="col-lg-10">

                            <form class="js-requires-input" action="/ismond/xphp/group_links" accept-charset="UTF-8" method="post">

                                <div class="form-group  col-md-2">
                                    <input style="margin-left: -15px;" type="text" name="name" id="version_name" placeholder="Version name" required="required" tabindex="1" autofocus="autofocus" class="form-control">

                                </div>

                                <div class="form-group col-md-4">
                                    <input type="text" name="description" id="description" placeholder="Description (optional)" required="required" tabindex="4" autofocus="autofocus" class="form-control">

                                </div>
                                <div class="form-group col-md-2">
                                    <input type="submit" name="commit" value="Add" class="btn btn-create disabled" disabled="disabled">

                                </div>


                            </form>

                        </div>


                    </div>

                    <div class=" prepend-top-default">
                        <div class="col-lg-2 settings-sidebar">

                            <p>
                                你可以使用项目角色来将用户或用户组关联到指定项目中。 下面表格显示JIRA中所有可用的项目角色。 这个页面可以添加,编辑以及删除项目角色。 你可以通过点击 '查看方案应用' 聊查看每个项目中项目角色的权限 方案以及通知方案。
                            </p>
                        </div>
                        <div class="col-lg-10">

                            <div class="panel panel-default">
                                <div class="panel-heading">

                                    <strong>项目角色</strong>
                                    <span class="badge">4</span>
                                    <form class="form-inline member-search-form" action="/ismond/xphp/settings/members" accept-charset="UTF-8" method="get"><input name="utf8" type="hidden" value="✓">
                                        <div class="form-group">

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
                                    <li class="member project_member" id="project_member_73">
                                            <span class="list-item-name">
                                              <img class="avatar s40" alt="" src="http://www.gravatar.com/avatar/8ceb21e5b4b18e6ae2f63f4568ffcca6?s=80&amp;d=identicon">
                                              <strong>
                                                <a href="/gitlab-runner">Administrator</a>
                                              </strong>

                                              <div class="hidden-xs cgray">A project role that represents administrators in a project </div>
                                            </span>

                                        <div class="controls member-controls ">

                                            <a   class="" href="#">所属权限方案 </a>
                                            <a   class=""  style="margin-left: 10px" href="#">管理默认成员 </a>
                                            <a   class=""  style="margin-left: 10px" href="#">编辑 </a>

                                            <a data-confirm="Are you sure you want to remove gitlab-runner from the ismond / xphp project?"
                                               class="btn btn-remove prepend-left-10" title="Remove user from project" data-remote="true"
                                               rel="nofollow" data-method="delete" href="#">
                                                <span class="visible-xs-block">Delete</span>
                                                <i class="fa fa-trash hidden-xs"></i>
                                            </a>
                                        </div>
                                    </li>
                                    <li class="member project_member" id="project_member_73">
                                            <span class="list-item-name">
                                              <img class="avatar s40" alt="" src="http://www.gravatar.com/avatar/8ceb21e5b4b18e6ae2f63f4568ffcca6?s=80&amp;d=identicon">
                                              <strong>
                                                <a href="/gitlab-runner">Developers</a>
                                              </strong>

                                              <div class="hidden-xs cgray">	A project role that represents developers in a project </div>
                                            </span>

                                        <div class="controls member-controls ">

                                            <a   class="" href="#">所属权限方案 </a>
                                            <a   class=""  style="margin-left: 10px" href="#">管理默认成员 </a>
                                            <a   class=""  style="margin-left: 10px" href="#">编辑 </a>

                                            <a data-confirm="Are you sure you want to remove gitlab-runner from the ismond / xphp project?"
                                               class="btn btn-remove prepend-left-10" title="Remove user from project" data-remote="true"
                                               rel="nofollow" data-method="delete" href="#">
                                                <span class="visible-xs-block">Delete</span>
                                                <i class="fa fa-trash hidden-xs"></i>
                                            </a>
                                        </div>
                                    </li>
                                    <li class="member project_member" id="project_member_73">
                                            <span class="list-item-name">
                                              <img class="avatar s40" alt="" src="http://www.gravatar.com/avatar/8ceb21e5b4b18e6ae2f63f4568ffcca6?s=80&amp;d=identicon">
                                              <strong>
                                                <a href="/gitlab-runner">QA</a>
                                              </strong>

                                              <div class="hidden-xs cgray">软件测试工程师</div>
                                            </span>

                                        <div class="controls member-controls ">

                                            <a   class="" href="#">所属权限方案 </a>
                                            <a   class=""  style="margin-left: 10px" href="#">管理默认成员 </a>
                                            <a   class=""  style="margin-left: 10px" href="#">编辑 </a>

                                            <a data-confirm="Are you sure you want to remove gitlab-runner from the ismond / xphp project?"
                                               class="btn btn-remove prepend-left-10" title="Remove user from project" data-remote="true"
                                               rel="nofollow" data-method="delete" href="#">
                                                <span class="visible-xs-block">Delete</span>
                                                <i class="fa fa-trash hidden-xs"></i>
                                            </a>
                                        </div>
                                    </li>
                                    <li class="member project_member" id="project_member_73">
                                            <span class="list-item-name">
                                              <img class="avatar s40" alt="" src="http://www.gravatar.com/avatar/8ceb21e5b4b18e6ae2f63f4568ffcca6?s=80&amp;d=identicon">
                                              <strong>
                                                <a href="/gitlab-runner">Users</a>
                                              </strong>

                                              <div class="hidden-xs cgray">A project role that represents users in a project</div>
                                            </span>

                                        <div class="controls member-controls ">

                                            <a   class="" href="#">所属权限方案 </a>
                                            <a   class=""  style="margin-left: 10px" href="#">管理默认成员 </a>
                                            <a   class=""  style="margin-left: 10px" href="#">编辑 </a>

                                            <a data-confirm="Are you sure you want to remove gitlab-runner from the ismond / xphp project?"
                                               class="btn btn-remove prepend-left-10" title="Remove user from project" data-remote="true"
                                               rel="nofollow" data-method="delete" href="#">
                                                <span class="visible-xs-block">Delete</span>
                                                <i class="fa fa-trash hidden-xs"></i>
                                            </a>
                                        </div>
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
</body>
</html>


</div>