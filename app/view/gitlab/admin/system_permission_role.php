<!DOCTYPE html>
<html class="" lang="en">
<head>

    <? require_once VIEW_PATH . 'gitlab/common/header/include.php'; ?>
    <script src="<?=ROOT_URL?>dev/js/admin/permission.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?= ROOT_URL ?>dev/js/admin/setting.js?v=<?=$_version?>" type="text/javascript" charset="utf-8"></script>
    <script src="<?= ROOT_URL ?>dev/lib/handlebars-v4.0.10.js" type="text/javascript" charset="utf-8"></script>

</head>
<body class="" data-group="" data-page="projects:issues:index" data-project="xphp">
<? require_once VIEW_PATH . 'gitlab/common/body/script.php'; ?>

<section class="has-sidebar page-layout max-sidebar">
<? require_once VIEW_PATH . 'gitlab/common/body/page-left.php'; ?>

<div class="page-layout page-content-body system-page">
<? require_once VIEW_PATH . 'gitlab/common/body/header-content.php'; ?>

<script>
    var findFileURL = "";
</script>
<div class="page-with-sidebar">
    <? require_once VIEW_PATH . 'gitlab/admin/common-page-nav-admin.php'; ?>


    <div class="content-wrapper page-with-layout-nav page-with-sub-nav">
        <div class="alert-wrapper">

            <div class="flash-container flash-container-page">
            </div>

        </div>
        <div class="container-fluid ">

            <div class="content" id="content-body">

                <?php include VIEW_PATH . 'gitlab/admin/common_system_left_nav.php'; ?>

                <div class="prepend-top-default" style="margin-left: 160px">
                    <div class=" prepend-top-default">
                        <div class="col-lg-2 settings-sidebar">
                            <h4 class="prepend-top-0">
                                系统角色
                            </h4>

                        </div>

                        <div class="col-lg-10">

                            <form id="form_add" class="js-requires-input" action="<?= ROOT_URL ?>admin/system/project_role_add" accept-charset="UTF-8" method="post">

                                <div class="form-group  col-md-2">
                                    <input style="margin-left: -15px;" type="text" name="params[name]" id="role_name" placeholder="角色名称" required="required" tabindex="1" class="form-control">

                                </div>

                                <div class="form-group col-md-4">
                                    <input type="text" name="params[description]" id="description" placeholder="描 述" required="required" tabindex="2" class="form-control">

                                </div>
                                <!--
                                <div class="form-group col-md-2">
                                    <input type="button" name="commit" id="commit" value="添加" class="btn  ">

                                </div>
                                -->

                            </form>

                        </div>


                    </div>

                    <div class=" prepend-top-default">
                        <div class="col-lg-2 settings-sidebar">

                           <!-- <p>
                                你可以使用项目角色来将用户或用户组关联到指定项目中。 下面表格显示JIRA中所有可用的项目角色。 这个页面可以添加,编辑以及删除项目角色。 你可以通过点击 '查看方案应用'
                                聊查看每个项目中项目角色的权限 方案以及通知方案。
                            </p>-->
                        </div>
                        <div class="col-lg-10">

                            <div class="panel panel-default">
                                <div class="panel-heading">

                                    <strong>系统角色</strong>
                                    <form class="form-inline member-search-form"
                                          action="#" accept-charset="UTF-8" method="get">
                                        <div class="form-group">

                                        </div>
                                    </form>
                                </div>
                                <ul class="content-list" id="render_id">


                                </ul>
                            </div>


                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>


<div class="modal" id="modal-issue_type_edit">
    <form class="js-quick-submit js-upload-blob-form form-horizontal" id="form_edit"
          action="<?=ROOT_URL?>admin/issue_type/update"
          accept-charset="UTF-8"
          method="post">
        <div class="modal-dialog">
            <div class="modal-content modal-middle">
                <div class="modal-header">
                    <a class="close" data-dismiss="modal" href="#">×</a>
                    <h3 class="modal-header-title">编辑事项类型</h3>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="edit_id" value="">
                    <input type="hidden" name="format" id="format" value="json">

                    <div class="form-group">
                        <label class="control-label" for="id_name">角色名称:</label>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="params[name]" id="edit_name"  value="" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="id_description">描述:</label>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="params[description]" id="edit_description"  value="" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="id_font_icon">权限分配:</label>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type="text" class="form-control fontawesome-iconpicker " name="params[font_awesome]" id="edit_font_awesome"  value="" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button name="submit" type="button" class="btn btn-save js-key-enter" id="btn-permission_update">保存</button>
                    <a class="btn btn-cancel" data-dismiss="modal" href="#">取消</a>
                </div>
            </div>
        </div>
    </form>
</div>

</div>
</section>

<script type="text/html" id="roles_tpl">
    {{#roles}}
    <li class="member project_member" id="permission_role_{{id}}">

        <span class="list-item-name">
            <strong>
                <a href="#">{{name}}</a>
            </strong>
            <div class="hidden-xs cgray">
                {{description}}
            </div>
        </span>

        <div class="controls member-controls ">
            <a class="list_for_edit btn btn-transparent" href="#" data-value="{{id}}"> 权限分配 </a>
        </div>
    </li>
    {{/roles}}

</script>

<script type="text/javascript">

    $(function () {
        fetchPermission('/admin/system/permission_fetch', 'roles_tpl', 'render_id');


        var options = {
            list_render_id:"list_render_id",
            list_tpl_id:"list_tpl",
            filter_form_id:"filter_form",
            get_url:"<?=ROOT_URL?>admin/system/get",
            update_url:"<?=ROOT_URL?>admin/system/update",
        }
        window.$permission = new Permission( options );
        window.$permission.fetchPermissionDetail( );
    });

</script>

</body>
</html>
