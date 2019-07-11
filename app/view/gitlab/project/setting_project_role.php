<!DOCTYPE html>
<html class="" lang="en">
<head>
    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>

    <script src="<?=ROOT_URL?>gitlab/assets/webpack/common_vue.bundle.js"></script>

    <script src="<?=ROOT_URL?>dev/lib/jquery.form.js"></script>
    <script src="<?=ROOT_URL?>dev/lib/url_param.js?v=<?=$_version?>" type="text/javascript" charset="utf-8"></script>
    <script src="<?=ROOT_URL?>dev/lib/handlebars-v4.0.10.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?=ROOT_URL?>dev/js/handlebars.helper.js?v=<?=$_version?>" type="text/javascript" charset="utf-8"></script>
    <script src="<?=ROOT_URL?>dev/js/project/role.js?v=<?=$_version?>" type="text/javascript" charset="utf-8"></script>
    <script src="<?=ROOT_URL ?>dev/js/admin/jstree/dist/jstree.min.js" type="text/javascript" charset="utf-8"></script>
    <link rel="stylesheet" href="<?= ROOT_URL ?>dev/js/admin/jstree/dist/themes/default/style.min.css"/>
    <style>
        .text-muted {
            color: #777777;
        }
        label {
            display: inline-block;
            max-width: 100%;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .modal .modal-content .modal-body {
            padding: 15px 30px 0;
        }

        .role-table {
            padding: 0 20px;
        }
    </style>
</head>
<body class="" data-group="" data-page="projects:issues:index" data-project="">
<? require_once VIEW_PATH.'gitlab/common/body/script.php';?>

<section class="has-sidebar page-layout max-sidebar">
    <? require_once VIEW_PATH . 'gitlab/common/body/page-left.php'; ?>

    <div class="page-layout page-content-body">
<? require_once VIEW_PATH.'gitlab/common/body/header-content.php';?>

<script>
    var findFileURL = "";
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
                        <form id="form_add_role" class="setting-form clearfix" action="<?=ROOT_URL?>project/role/add?project_id=<?=$project_id?>" accept-charset="UTF-8" method="post">
                            <input name="utf8" type="hidden" value="✓">
                            <input type="hidden" name="project_id" value="<?=$project_id?>">
                            <div class="form-group col-md-3">
                                <input style="margin-left: -15px;" type="text" name="params[name]" id="role_name" placeholder="角色名称" required="required" tabindex="1" autofocus="autofocus" class="form-control">

                            </div>
                            <div class="form-group col-md-6">
                                <input type="text" name="params[description]" id="role_description" placeholder="描 述" required="required" tabindex="4" autofocus="autofocus" class="form-control">

                            </div>
                            <div class="form-group col-md-3">
                                <input id="btn-role_add" type="button"   value="添 加" class="btn btn-create" >
                            </div>
                        </form>

                        <div class="panel panel-default margin-t-lg">
                            <div class="panel-heading">
                                <strong>角色</strong>
                            </div>
                            <ul class="flex-list well-list content-list" id="list_render_id">

                            </ul>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

<div class="modal" id="modal-role_edit">
    <form class="js-quick-submit js-upload-blob-form form-horizontal" id="form_edit"
          action="#"
          accept-charset="UTF-8"
          method="post">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <a class="close" data-dismiss="modal" href="#">×</a>
                    <h3 class="modal-header-title">编辑项目角色</h3>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="id" id="edit_id" value="">
                    <input type="hidden" name="format" id="format" value="json">
                    <input type="hidden" name="project_id" value="<?=$project_id?>">

                    <div class="form-group">
                        <label class="control-label" >名称:</label>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="" name="params[name]" id="edit_name" value="">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label" >描述:</label>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <textarea placeholder="" class="form-control" rows="3" maxlength="250" name="params[description]" id="edit_description"></textarea>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button name="edit_role_save" type="button" class="btn  btn-create " id="btn-update">保存</button>
                    <a class="btn btn-cancel" data-dismiss="modal" href="#">取消</a>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="modal fade" id="modal-permission_edit" data-keyboard=true role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form class="js-quick-submit js-upload-blob-form form-horizontal" id="form_permission_edit"
          action="#"
          accept-charset="UTF-8"
          method="post">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <a class="close" data-dismiss="modal" href="#">×</a>
                    <h3 class="modal-header-title">权限分配</h3>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="role_id" id="perm_role_id" value="">
                    <input type="hidden" name="permission_ids" id="permission_ids" value="">

                    <div class="form-group">
                        <label class="control-label">角色名称:</label>
                        <div class="col-sm-5">
                            <div class="form-group" >
                                <input type="text" class="form-control" disabled placeholder="" name="perm_role_name" id="perm_role_name" value="">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="id_font_icon">权限分配:</label>
                        <div class="col-sm-6">
                            <div class="form-group" style="margin-top: 7px;">
                                <span class="text-muted"><input type="checkbox" name="" id="checkall"> <label for="checkall"><small>选中全部</small></label></span>
                                <div id="container">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button name="btn-permission_update" type="button" class="btn btn-save" id="btn-permission_update">保存</button>
                    <a  class="btn btn-cancel" data-dismiss="modal" href="#">取消</a>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="modal" id="modal-role_user">
    <form class="js-quick-submit js-upload-blob-form form-horizontal" id="form-role_user"
          action="#"
          accept-charset="UTF-8"
          method="post">
        <input type="hidden" name="role_id" id="role_user-role_id" value="">
        <input type="hidden" name="project_id" id="role_user-project_id" value="<?=$project_id?>">
        <input type="hidden" name="format" id="format" value="json">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <a class="close" data-dismiss="modal" href="#">×</a>
                    <h3 class="modal-header-title">角色用户</h3>
                </div>

                <div class="modal-body min-height400">

                    <div class="form-group">
                        <label class="control-label" >请选择用户:</label>
                        <div class="row">
                            <div class="col-md-6">

                                <div class="issuable-form-select-holder">
                                    <input type="hidden" value="" name="params[select_user]" id="role_user_selected_user_id" />
                                    <div class="dropdown ">
                                        <button class="dropdown-menu-toggle js-multiselect  js-dropdown-keep-input js-user-search js-issuable-form-dropdown js-assignee-search"
                                                type="button"
                                                data-onSelectedFnc="Role.prototype.addRoleUser"
                                                data-first-user="<?=$user['username']?>"
                                                data-null-user="true"
                                                data-current-user="true"
                                                data-project-id=""
                                                data-field-name="params[select_user]"
                                                data-default-label=""
                                                data-selected=""
                                                data-toggle="dropdown">
                                            <span class="dropdown-toggle-text is-default">点击选择用户</span>
                                            <i class="fa fa-chevron-down"></i>
                                        </button>

                                        <div class="dropdown-menu dropdown-select dropdown-menu-user dropdown-menu-selectable dropdown-menu-assignee js-filter-submit">
                                            <div class="dropdown-title">
                                                <span>选择用户</span>
                                                <button class="dropdown-title-button dropdown-menu-close" aria-label="Close" type="button">
                                                    <i class="fa fa-times dropdown-menu-close-icon"></i>
                                                </button>
                                            </div>
                                            <div class="dropdown-input">
                                                <input type="search" id="" class="dropdown-input-field" placeholder="Search assignee" autocomplete="off" />
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
                                <a class="assign-to-me-link " href="#">选择自己</a>

                                <script>
                                    new UsersSelect();
                                </script>

                            </div>
                            <!--<div class="col-md-3">
                                <button id="btn-role_user_save" name="btn-role_user_save" type="button" class="btn " >添 加</button>
                            </div>-->
                        </div>
                    </div>

                    <div class="role-table">
                        <div class="form-group">
                            <table class="table ci-table">
                                <tbody id="role_user_list_render_id">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <a class="btn btn-cancel" data-dismiss="modal" href="#">关 闭</a>
                </div>
            </div>
        </div>
    </form>
</div>

    </div>
</section>
<script type="text/html"  id="role_user_list_tpl">
    {{#role_users}}
    <tr class="commit" id="role_user_id_{{id}}">
        <td>{{user_html user_id}}</td>
        <td>{{user_account_str user_id}}</td>
        <td>
            <a class="role_user_remove btn btn-transparent "
               href="javascript:;"
               data-id="{{id}}"
               data-user_id="{{user_id}}"
               data-project_id="{{project_id}}"
               data-role_id="{{role_id}}"
               data-value="{{user_id}}">
                <i class="fa fa-trash"></i><span class="sr-only">移除</span>
            </a>
        </td>
    </tr>
    {{/role_users}}
</script>

<script type="text/html"  id="list_tpl">
    {{#roles}}
        <li>
            <div class="pull-left append-right-10 hidden-xs">
                <i class="fa fa-users key-icon"></i>
            </div>
            <div class="deploy-key-content key-list-item-info">
                <strong class="title">
                    {{name}}{{#if_eq is_system '1'}}
                    {{^}}
                    <span class="badge color-label " style="background-color: #428bca; color: #FFFFFF" >自定义</span>
                    {{/if_eq}}
                </strong>
                <div class="description">
                    {{description}}
                </div>
            </div>

            <div class="deploy-key-content">
                <div class="visible-xs-block visible-sm-block"></div>

                    {{#if_eq is_system '1'}}
                    {{^}}
                    <a class="list_for_edit prepend-left-10" rel="nofollow" data-id="{{id}}"  href="#">
                        编 辑
                    </a>
                    <a class="list_for_delete prepend-left-10" rel="nofollow" data-id="{{id}}"  href="#">
                        删 除
                    </a>
                    {{/if_eq}}
                    <a class="list_edit_perm prepend-left-10" rel="nofollow" data-id="{{id}}" data-name="{{name}}"  href="#">
                        权 限
                    </a>
                    <a class="list_add_user prepend-left-10" rel="nofollow" data-id="{{id}}"  href="#">
                        用 户
                    </a>
            </div>
        </li>
    {{/roles}}
</script>

<script type="text/javascript">

    var _issueConfig = {
        users:<?=json_encode($users)?>
    };
    console.log(_issueConfig.users);
    window.$role = null;

    $(function() {
        var options = {
            list_render_id:"list_render_id",
            list_tpl_id:"list_tpl",
            filter_url:"<?=ROOT_URL?>project/role/fetchAll?project_id=<?=$project_id?>",
            get_url:"<?=ROOT_URL?>project/role/get",
            role_user_fetch_url:"<?=ROOT_URL?>project/role/fetchRoleUser",
            role_user_add_url:"<?=ROOT_URL?>project/role/addRoleUser",
            tree_url: "<?=ROOT_URL?>project/role/perm_tree",
            update_url:"<?=ROOT_URL?>project/role/update",
            update_perm_url:"<?=ROOT_URL?>project/role/update_perm",
            add_url:"<?=ROOT_URL?>project/role/add?project_id=<?=$project_id?>",
            delete_url:"<?=ROOT_URL?>project/role/delete",
            delete_role_user_url:"<?=ROOT_URL?>project/role/deleteRoleUser"
        }
        window.$role = new Role( options );
        window.$role.fetchRoles( );

    });

</script>


</body>
</html>
