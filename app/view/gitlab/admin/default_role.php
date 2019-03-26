<!DOCTYPE html>
<html class="" lang="en">
<head>

    <? require_once VIEW_PATH . 'gitlab/common/header/include.php'; ?>
    <link rel="stylesheet" href="<?= ROOT_URL ?>dev/js/admin/jstree/dist/themes/default/style.min.css"/>
    <script src="<?= ROOT_URL ?>dev/js/admin/permission.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?= ROOT_URL ?>dev/lib/handlebars-v4.0.10.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?= ROOT_URL ?>dev/js/admin/jstree/dist/jstree.min.js" type="text/javascript" charset="utf-8"></script>
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
    </style>
</head>
<body class="" data-group="" data-page="permission:role" data-project="xphp">
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
                <div class="row has-side-margin-left">
                    <div class="col-lg-12">
                        <div class="top-area">
                            <ul class="nav-links">
                                <li class="active">
                                    <a href="#">默认角色</a>
                                </li>
                            </ul>
                            <div class="nav-controls">
                                <div class="btn-group" role="group">
                                </div>
                            </div>
                        </div>
                        <div class="content-list">
                            <div class="bs-callout bs-callout-warning shared-runners-description">
                              <!--  <p>你可以使用项目角色来将用户或用户组关联到指定项目中。 下面表格显示所有可用的项目角色。 这个页面可以添加,编辑以及删除项目角色。 你可以通过点击 '查看方案应用' 来查看每个项目中项目角色的权限 方案以及通知方案。</p>
                            --></div>
                            <ul id="render_id" class="projects-list brd-bottom">
                            </ul>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>


<div class="modal" id="modal-permission_edit">
    <form class="js-quick-submit js-upload-blob-form form-horizontal" id="form_edit"
          action="<?= ROOT_URL ?>admin/permission/role_edit"
          accept-charset="UTF-8"
          method="post">
        <div class="modal-dialog">
            <div class="modal-content modal-middle">
                <div class="modal-header">
                    <a class="close" data-dismiss="modal" href="#">×</a>
                    <h3 class="modal-header-title">用户角色权限分配</h3>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="roleId" id="edit_id" value="">
                    <input type="hidden" name="format" id="format" value="json">
                    <input type="hidden" name="permissionIds" id="permissionIds" value="">

                    <div class="form-group">
                        <label class="control-label" for="id_name">角色名称:</label>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="params[name]" id="edit_name" value="" disabled="disabled"/>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="id_description">描述:</label>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="params[description]" id="edit_description" value="" disabled="disabled"/>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="id_font_icon">权限分配:</label>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <span class="text-muted"><input type="checkbox" name="" id="checkall"> <label for="checkall"><small>选中全部</small></label></span>
                                <span class="text-muted"><input type="checkbox" name="" id="expandall"> <label for="expandall"><small>展开全部</small></label></span>
                                <div id="container">
                                </div>
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
    <li class="member permission_member" id="permission_role_{{id}}">

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
        var options = {
            list_render_id: "list_render_id",
            list_tpl_id: "list_tpl",
            filter_form_id: "filter_form",
            get_url: "<?=ROOT_URL?>admin/permission/role_get",
            update_url: "<?=ROOT_URL?>admin/permission/role_edit",
            tree_url: "<?=ROOT_URL?>admin/permission/tree?roleId=",
        }
        window.$permission = new Permission(options);
        window.$permission.fetchPermissionDetail('/admin/permission/role_fetch', 'roles_tpl', 'render_id');
        //点击切换
        $('#container').on("changed.jstree", function (e, data) {
            $("#permissionIds").val(data.selected);
        });
        //全选和展开
        $(document).on("click", "#checkall", function () {
            $("#container").jstree($(this).prop("checked") ? "check_all" : "uncheck_all");
        });
        $(document).on("click", "#expandall", function () {
            $("#container").jstree($(this).prop("checked") ? "open_all" : "close_all");
        });
    });

</script>

</body>
</html>
