<!DOCTYPE html>
<html class="" lang="en">
<head  >
    <?php require_once VIEW_PATH.'gitlab/common/header/include.php';?>
    <script src="<?=ROOT_URL?>dev/lib/handlebars-v4.0.10.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?=ROOT_URL?>dev/lib/bootstrap-paginator/src/bootstrap-paginator.js?v=<?= $_version ?>"  type="text/javascript"></script>
    <script src="<?=ROOT_URL?>dev/js/admin/project.js?v=<?=$_version?>" type="text/javascript" charset="utf-8"></script>
</head>
<body class="" data-group="" data-page="projects:issues:index" data-project="xphp">
<? require_once VIEW_PATH.'gitlab/common/body/script.php';?>

<section class="has-sidebar page-layout max-sidebar">
    <? require_once VIEW_PATH . 'gitlab/common/body/page-left.php'; ?>

    <div class="page-layout page-content-body system-page">
<?php require_once VIEW_PATH.'gitlab/common/body/header-content.php';?>

<script>
    var findFileURL = "";
</script>
<div class="page-with-sidebar">

    <?php require_once VIEW_PATH.'gitlab/admin/common-page-nav-admin.php';?>

    <div class="content-wrapper page-with-layout-nav page-with-sub-nav">
        <div class="alert-wrapper">

            <div class="flash-container flash-container-page">
            </div>

        </div>
        <div class="content" id="content-body">
            <div class="container-fluid">
                <div class="top-area">
                    <ul class="nav-links user-state-filters" style="float:left">
                        <li class="active" data-value="">
                            <a id="state-opened"  title="项目列表" ><span> 项目列表 </span>
                            </a>
                        </li>
                    </ul>
                    <div class="nav-controls" style="right: ">
                        <!--a class="btn has-tooltip" title="" href="#" data-original-title="邀请用户">
                            <i class="fa fa-rss"></i>
                        </a-->
                        <div class="project-item-select-holder">
                            <a class="btn btn-new new-project-item-select-button js-key-create" data-key-mode="new-page" href="<?=ROOT_URL?>project/main/new">
                                <i class="fa fa-plus"></i>
                                新建项目
                            </a>
                        </div>
                    </div>
                </div>

                <div class="content-list pipelines">
                    <div class="table-holder">
                        <table class="table">
                            <thead>
                            <tr>
                                <th class="js-pipeline-info pipeline-info">名称</th>
                                <th class="js-pipeline-info pipeline-info">KEY</th>
                                <th class="js-pipeline-info pipeline-info">项目类型</th>
                                <th class="js-pipeline-commit pipeline-commit">网址</th>
                                <th class="js-pipeline-stages pipeline-info">项目负责人</th>
                                <th class="pipeline-info" style="text-align: center;">操作</th>
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

    </div>
</section>

<script type="text/html"  id="project_tpl">
    {{#rows}}
        <tr class="commit">
            <td>
                <a href="/{{path}}/{{key}}" class="commit-id monospace" target="_blank">
                    {{name}}
                </a>
            </td>
            <td>
                <a href="/{{path}}/{{key}}" class="commit-id monospace" target="_blank">
                    {{key}}
                </a>
            </td>
            <td>
                <a href="javascript:void(0);" class="commit-id monospace">
                    {{type_name}}
                </a>
            </td>
            <td>
                <a href="{{url}}" class="commit-id monospace" target="_blank">
                    {{url}}
                </a>
            </td>
            <td>
                <a href="javascript:void(0)" class="commit-id monospace">
                    {{leader_display}}
                </a>
            </td>
            <td>
                <div class="controls member-controls " style="float: right">
                    <a class="user_for_edit btn btn-transparent " href="<?=ROOT_URL?>/{{path}}/{{key}}/settings" data-uid="{{uid}}" style="padding: 6px 2px;" target="_blank">编辑 </a>

                    <a class="user_for_delete btn btn-transparent" style="padding: 6px 2px;" onClick="projectDelete({{id}}, {{type}}, '{{name}}')" >
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
        fetchList('/admin/project/filterData', 'project_tpl', 'render_id', 1);
    });

    function projectDelete(projectId, projectTypeId, projectName) {
        var message="是否确认删除项目 "+projectName;

        if (window.confirm(message+"？")) {
            projectRemove(projectId, projectTypeId);
            fetchList('/admin/project/filterData', 'project_tpl', 'render_id', 1);
        } else {
            // 取消
        }

    }
</script>


<div class="modal fade" tabindex="-1" role="dialog" id="myModal">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content modal-middle">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">提示</h4>
            </div>
            <div class="modal-body">
                <p>是否确认删除？</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">确定</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>
</body>
</html>
