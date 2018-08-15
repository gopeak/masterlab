<!DOCTYPE html>
<html class="" lang="en">
<head>
    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>
    <script src="<?=ROOT_URL?>dev/lib/jquery.form.js"></script>
    <script src="<?=ROOT_URL?>dev/lib/url_param.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?=ROOT_URL?>dev/lib/handlebars-v4.0.10.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?=ROOT_URL?>dev/js/handlebars.helper.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?=ROOT_URL?>dev/js/project/role.js" type="text/javascript" charset="utf-8"></script>
    <link href="<?=ROOT_URL?>dev/lib/laydate/theme/default/laydate.css" rel="stylesheet">
    <script src="<?=ROOT_URL?>dev/lib/laydate/laydate.js"></script>
    <script src="<?=ROOT_URL?>dev/lib/bootstrap-paginator/src/bootstrap-paginator.js"  type="text/javascript"></script>
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
        <div class="container-fluid container-limited">

            <div class="content" id="content-body">

                <div class="row prepend-top-default">
                    <div class="col-lg-3 profile-settings-sidebar">
                        <h4 class="prepend-top-0">
                            项目角色
                        </h4>
                        <p>
                            系统预定义了如下几个角色：User, Developer,Administrator,PO,QA
                        </p>
                        <p>
                            您还可以自定义自己的角色
                        </p>
                    </div>
                    <div class="col-lg-9">

                        <form id="form_add_role" class="" action="<?=ROOT_URL?>project/role/add?project_id=<?=$project_id?>" accept-charset="UTF-8" method="post">
                            <input name="utf8" type="hidden" value="✓">
                            <input type="hidden" name="project_id" value="<?=$project_id?>">
                            <div class="form-group col-md-3">
                                <input style="margin-left: -15px;" type="text" name="params[name]" id="role_name" placeholder="角色名称" required="required" tabindex="1" autofocus="autofocus" class="form-control">

                            </div>
                            <div class="form-group col-md-6">
                                <input type="text" name="params[description]" id="role_description" placeholder="描 述" required="required" tabindex="4" autofocus="autofocus" class="form-control">

                            </div>
                            <div class="form-group col-md-3">
                                <input type="submit"  value="添 加" class="btn btn-create" >
                            </div>
                        </form>

                    </div>
                    <div class="col-lg-9 ">
                        <hr>
                    </div>
                    <div class="col-lg-9  ">
                        <ul class="well-list" id="list_render_id">
                            <li>
                                <div class="pull-left append-right-10 hidden-xs">
                                    <i class="fa fa-key key-icon"></i>
                                </div>
                                <div class="deploy-key-content key-list-item-info">
                                    <strong class="title">
                                        Users
                                    </strong>
                                    <div class="description">
                                        A project role that represents users in a project
                                    </div>
                                </div>

                                <div class="deploy-key-content">
                                    <span class="key-created-at">
                                        系统默认
                                    </span>
                                    <div class="visible-xs-block visible-sm-block"></div>
                                    <a class=" prepend-left-10" rel="nofollow" data-method="put" href="#">
                                        编辑权限
                                    </a>
                                    <a class="  prepend-left-10" rel="nofollow" data-method="put" href="#">
                                        添加用户
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


<script type="text/html"  id="list_tpl">
    {{#roles}}
        <li>
            <div class="pull-left append-right-10 hidden-xs">
                <i class="fa fa-users key-icon"></i>
            </div>
            <div class="deploy-key-content key-list-item-info">
                <strong class="title">
                    {{name}}
                </strong>
                <div class="description">
                    {{description}}
                </div>
            </div>

            <div class="deploy-key-content">
                <span class="key-created-at">
                     {{#if_eq is_system '1'}}
                    系 统
                    {{^}}
                    自定义
                    {{/if_eq}}
                </span>
                <div class="visible-xs-block visible-sm-block"></div>

                <a class="list_for_edit prepend-left-10" rel="nofollow" data-value="{{id}}"  href="#">
                    编 辑
                </a>
                <a class="list_edit_perm prepend-left-10" rel="nofollow" data-value="{{id}}"  href="#">
                    权 限
                </a>
                <a class="list_add_user  prepend-left-10" rel="nofollow" data-value="{{id}}"  href="#">
                    用 户
                </a>
            </div>
        </li>
    {{/roles}}
</script>

<script type="text/javascript">

    window.$role = null;

    $(function() {
        var options = {
            list_render_id:"list_render_id",
            list_tpl_id:"list_tpl",
            filter_url:"/project/role/fetchAll?project_id=<?=$project_id?>",
            get_url:"/project/role/get",
            update_url:"/project/role/update",
            add_url:"/project/role/add",
            delete_url:"/project/role/delete",
        }
        window.$role = new Role( options );
        window.$role.fetchRoles( );
    });

</script>


</body>
</html>
