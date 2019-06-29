<!DOCTYPE html>
<html class="" lang="en">
<head>

    <? require_once VIEW_PATH . 'gitlab/common/header/include.php'; ?>
    <script src="<?= ROOT_URL ?>dev/js/admin/log_operating.js?v=<?=$_version?>" type="text/javascript" charset="utf-8"></script>
    <script src="<?= ROOT_URL ?>dev/lib/handlebars-v4.0.10.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?= ROOT_URL ?>dev/lib/bootstrap-select/js/bootstrap-select.js" type="text/javascript" charset="utf-8"></script>
    <link href="<?= ROOT_URL ?>dev/lib/bootstrap-select/css/bootstrap-select.css" rel="stylesheet">
    <script src="<?= ROOT_URL ?>dev/lib/bootstrap-paginator/src/bootstrap-paginator.js?v=<?= $_version ?>" type="text/javascript"></script>

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
                <div class="row has-side-margin-left">
                    <div class="col-lg-12">
                        <div class="top-area">
                            <ul class="nav-links">
                                <li class="active" data-value="">
                                    <a id="state-opened" title="操作日志列表" href="/admin/log_base/index"><span> 操作日志列表 </span>
                                    </a>
                                </li>
                            </ul>
                            <div class="nav-controls">
                                <form id="log_filter_form" action="<?= ROOT_URL ?>admin/log_base/index" accept-charset="UTF-8" method="get">

                                    <input name="page" id="filter_page" type="hidden" value="1">
                                    <input name="action" id="filter_action" type="hidden" value="">

                                    <input type="search" name="username" id="filter_username" placeholder="用户名/用户名称"
                                           class="form-control search-text-input input-short" spellcheck="false" value=""/>

                                    <input type="search" name="remark" id="filter_remark" placeholder="描述   "
                                           class="form-control search-text-input input-short" spellcheck="false" value=""/>


                                    <div class="dropdown inline prepend-left-10">
                                        <button class="dropdown-toggle" data-toggle="dropdown" type="button" aria-expanded="false">
                                            <span class="light" id="action_view" data-title-origin="操作类型"> 操作类型</span>
                                            <i class="fa fa-chevron-down"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-align-right dropdown-menu-sort">
                                            <li class="action_li" data-action="新增" data-title="新增"><a href="#"> 新增 </a></li>
                                            <li class="action_li" data-action="编辑" data-title="编辑"><a href="#"> 编辑 </a></li>
                                            <li class="action_li" data-action="删除" data-title="删除"><a href="#"> 删除 </a></li>
                                        </ul>
                                    </div>

                                    <a class="btn btn-gray  " id="btn-log_filter" href="#">
                                        <i class="fa fa-filter"></i> &nbsp;查询
                                    </a>

                                    <a class="btn  href=" #" onclick="logFormReset()" >
                                    &nbsp;<i class="fa fa-undo"></i> &nbsp;
                                    </a>

                                </form>
                            </div>

                        </div>
                        <div class="content-list">

                            <div class="table-holder">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th class="js-pipeline-info pipeline-info">序号</th>
                                        <th class="js-pipeline-info pipeline-info">用户</th>
                                        <th class="js-pipeline-date pipeline-date">用户名称</th>
                                        <th class="js-pipeline-info pipeline-info">模块</th>
                                        <th class="js-pipeline-date pipeline-date">页面</th>
                                        <th class="js-pipeline-date pipeline-date">操作类型</th>
                                        <th class="js-pipeline-date pipeline-date">时间</th>
                                        <th class="js-pipeline-stages pipeline-info">详情描述</th>
                                        <th style="">变更细节</th>
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
</div>


<div class="modal" id="modal-log_edit">
    <div class="modal-dialog">
        <div class="modal-content modal-middle">
            <div class="modal-header">
                <a class="close" data-dismiss="modal" href="#">×</a>
                <h3 class="modal-header-title">变更细节</h3>
            </div>
            <div class="modal-body">
                <table class="table ci-table">
                    <thead>
                    <tr>
                        <th class="js-pipeline-info pipeline-info">字段</th>
                        <th class="js-pipeline-commit pipeline-commit">变更前</th>
                        <th class="js-pipeline-stages pipeline-info">变更后</th>
                    </tr>
                    </thead>

                    <tbody id="render_detail_id">


                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

</div>
</section>

<script type="text/html" id="log_tpl">
    {{#logs}}
    <tr class="commit">
        <td>
            <span class="monospace branch-name">{{id}}</span>
        </td>
        <td>
            <span class="monospace branch-name">{{user_name}}</span>
        </td>
        <td>
            <span class="monospace branch-name">{{real_name}}</span>
        </td>
        <td>
            <span class="monospace branch-name">{{module}}</span>
        </td>
        <td>
            <span class="monospace branch-name">{{page}}</span>
        </td>
        <td>
            <span class="monospace branch-name">{{action}}</span>
        </td>
        <td>
            <span class="monospace branch-name">{{time_str}}</span>
        </td>
        <td>
            <span class="monospace branch-name">{{remark}}</span>
        </td>
        <td>
            <div class="controls member-controls ">
                <a class="btn btn-transparent log_for_edit" href="#" data-id="{{id}}" style="padding: 6px 2px;"><i class="fa fa-eye"></i> 查看细节</a>
            </div>
        </td>
    </tr>
    {{/logs}}

</script>

<script type="text/html" id="data_tpl">
    {{#detail}}
    <tr class="commit">
        <td>
                <span class="list-item-name">
                    <strong>
                        {{field}}
                    </strong>
                </span>
        </td>
        <td class="col-md-4">
            <span class="monospace branch-name">{{before}}</span>
        </td>
        <td>
            {{#if code}}
            <span class="monospace branch-name"><font color=#ff1722>{{now}}</font></span>
            {{else}}
            <span class="monospace branch-name">{{now}}</span>
            {{/if}}

        </td>
    </tr>
    {{/detail}}
</script>

<script type="text/javascript">

    $(function () {

        fetchLogs('/admin/log_operating/filter', 'log_tpl', 'render_id');


        $("#btn-log_filter").click(function () {
            $('#ampagination-bootstrap').empty();
            fetchLogs('/admin/log_operating/filter', 'log_tpl', 'render_id');
        });


    });

</script>
</body>
</html>