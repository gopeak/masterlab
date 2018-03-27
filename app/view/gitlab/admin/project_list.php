<!DOCTYPE html>
<html class="" lang="en">
<head  >
    <?php require_once VIEW_PATH.'gitlab/common/header/include.php';?>
    <script src="<?=ROOT_URL?>dev/lib/handlebars-v4.0.10.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?=ROOT_URL?>dev/lib/bootstrap-paginator/src/bootstrap-paginator.js"  type="text/javascript"></script>
    <script src="<?=ROOT_URL?>dev/js/admin/project.js" type="text/javascript" charset="utf-8"></script>
</head>
<body class="" data-group="" data-page="projects:issues:index" data-project="xphp">
<? require_once VIEW_PATH.'gitlab/common/body/script.php';?>
<header class="navbar navbar-gitlab with-horizontal-nav">
    <a class="sr-only gl-accessibility" href="#content-body" tabindex="1">Skip to content</a>
    <div class="container-fluid">
        <?php require_once VIEW_PATH.'gitlab/common/body/header-content.php';?>
    </div>
</header>
<script>
    var findFileURL = "/ismond/xphp/find_file/master";
</script>
<div class="page-with-sidebar">

    <?php require_once VIEW_PATH.'gitlab/admin/common-page-nav-admin.php';?>

    <div class="content-wrapper page-with-layout-nav page-with-sub-nav">
        <div class="alert-wrapper">

            <div class="flash-container flash-container-page">
            </div>

        </div>
        <div class="content" id="content-body">
            <?php include VIEW_PATH.'gitlab/admin/common_project_left_nav.php';?>
            <div class="container-fluid"  style="margin-left: 248px">
                <div class="top-area">
                    <ul class="nav-links user-state-filters" style="float:left">
                        <li class="active" data-value="">
                            <a id="state-opened"  title="项目列表" href="#" ><span> 项目列表 </span>
                            </a>
                        </li>
                    </ul>
                    <div class="nav-controls" style="right: ">
                        <a class="btn has-tooltip" title="" href="#" data-original-title="邀请用户">
                            <i class="fa fa-rss"></i>
                        </a>
                        <div class="project-item-select-holder">
                            <a class="btn btn-new new-project-item-select-button" data-target="#modal-add" data-toggle="modal" href="#modal-add">
                                <i class="fa fa-plus"></i>
                                新建项目
                            </a>
                        </div>
                    </div>
                </div>

                <div class="content-list pipelines">
                    <div class="table-holder">
                        <table class="table ci-table">
                            <thead>
                            <tr>
                                <th class="js-pipeline-info pipeline-info">名称</th>
                                <th class="js-pipeline-info pipeline-info">KEY</th>
                                <th class="js-pipeline-info pipeline-info">项目类型</th>
                                <th class="js-pipeline-commit pipeline-commit">网址</th>
                                <th class="js-pipeline-stages pipeline-info">项目负责人</th>
                                <th class="js-pipeline-stages pipeline-info">默认经办人</th>
                                <th class="js-pipeline-stages pipeline-info">项目类别</th>
                                <th style="min-width: 180px; float: right" >操作</th>

                            </tr>
                            </thead>
                            <tbody id="render_id">
                            </tbody>
                        </table>
                    </div>
                    <div class="gl-pagination" id="ampagination-bootstrap">

                    </div>
                </div>


            </div>
        </div>

    </div>
</div>





<div class="modal" id="modal-add">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <a class="close" data-dismiss="modal" href="#">×</a>
                <h3 class="page-title">新建项目</h3>
            </div>
            <div class="modal-body">
                <form class="js-quick-submit js-upload-blob-form form-horizontal"   action="/admin/user/add"   accept-charset="UTF-8" method="post">

                        <div class="form-group">
                            <label class="control-label" for="id_email">项目名称:<span style="color: red"> *</span></label>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="params[email]" id="id_email"  value="" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="id_display_name">项目KEY:<span style="color: red"> *</span></label>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="params[display_name]" id="id_display_name"  value="" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="id_username">项目类型:<span style="color: red"> *</span></label>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="params[username]" id="id_username"  value="" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="id_username">负责人:<span style="color: red"> *</span></label>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="params[username]" id="id_username"  value="" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="id_username">URL:<span style="color: red"> *</span></label>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="params[username]" id="id_username"  value="" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="id_password">项目描述:<span style="color: red"> *</span></label>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <textarea placeholder="" class="form-control" rows="3" maxlength="250" name="content" id="content"></textarea>
                                </div>
                            </div>
                        </div>


                    <div class="form-actions">
                        <button name="submit" type="button" class="btn btn-save" id="btn-user_add">保存</button>
                        <a class="btn btn-cancel" data-dismiss="modal" href="#">取消</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>





<script type="text/html"  id="project_tpl">
    {{#rows}}

        <tr class="commit">
            <td>
                <a href="#" class="commit-id monospace">
                    {{name}}
                </a>
            </td>
            <td>
                <a href="#" class="commit-id monospace">
                    {{key}}
                </a>
            </td>
            <td>
                <a href="#" class="commit-id monospace">
                    项目类型
                </a>
            </td>
            <td>
                <a href="#" class="commit-id monospace">
                    {{url}}
                </a>
            </td>
            <td>
                <a href="#" class="commit-id monospace">
                    项目负责人
                </a>
            </td>
            <td>
                <a href="#" class="commit-id monospace">
                    未分配
                </a>
            </td>
            <td>
                <a href="#" class="commit-id monospace">
                    未分配
                </a>
            </td>
            <td>
                <div class="controls member-controls " style="float: right">

                    <a class="user_for_edit btn btn-transparent " href="#" data-uid="{{uid}}" style="padding: 6px 2px;">编辑 </a>

                    <a class="user_for_delete btn btn-transparent  "   href="javascript:userDelete({{uid}});" style="padding: 6px 2px;">
                        <i class="fa fa-trash"></i>
                        <span class="sr-only">Remove</span>
                    </a>
                </div>
            </td>
        </tr>
    {{/rows}}

</script>

<script>
    $(function() {
        fetchList('/admin/project/filterData', 'project_tpl', 'render_id');
    });
</script>



</body>
</html>
