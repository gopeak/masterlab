<!DOCTYPE html>
<html class="" lang="en">
<head>

    <? require_once VIEW_PATH . 'gitlab/common/header/include.php'; ?>
    <script src="<?= ROOT_URL ?>dev/lib/handlebars-v4.0.10.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?= ROOT_URL ?>dev/lib/bootstrap-select/js/bootstrap-select.js" type="text/javascript" charset="utf-8"></script>
    <link href="<?= ROOT_URL ?>dev/lib/bootstrap-select/css/bootstrap-select.css" rel="stylesheet">
    <script src="<?= ROOT_URL ?>dev/lib/bootstrap-paginator/src/bootstrap-paginator.js?v=<?= $_version ?>" type="text/javascript"></script>
    <script src="<?= ROOT_URL ?>dev/js/admin/log_slow_sql.js?v=<?=$_version?>" type="text/javascript" charset="utf-8"></script>

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
        <div class=" ">
            <div class="content" id="content-body">
                <?php include VIEW_PATH . 'gitlab/admin/common_system_left_nav.php'; ?>
                <div class="container-fluid" style="margin-left: 160px">

                    <div class="top-area">
                        <ul class="nav-links" style="float:left">
                            <li class="active" data-value="">
                                <a id="state-opened" title="慢sql日志" href="<?=ROOT_URL?>admin/log_operating/slow_sql"><span> 慢sql日志 </span>
                                </a>
                            </li>
                        </ul>
                        <div class="nav-controls row-fixed-content" style="float: left;margin-left: 80px">
                            <form id="log_filter_form" action="<?=ROOT_URL?>admin/log_operating/slow_sql" accept-charset="UTF-8" method="get">
                                <div class="dropdown inline prepend-left-10">
                                    <button class="dropdown-toggle" data-toggle="dropdown" type="button" aria-expanded="false">
                                        <span class="light" id="action_view" data-title-origin="操作类型"> 选择日志文件</span>
                                        <i class="fa fa-chevron-down"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-align-right dropdown-menu-sort">
                                        <?php if(empty($log_files)){ ?>
                                            <li><a href="#"> 没有日志文件 </a></li>
                                        <?php }else{
                                        foreach ($log_files as $log_file) {?>
                                            <li class="action_li" data-filename="<?= $log_file?>"><a href="#"> slow-<?= $log_file?> </a></li>
                                        <?php } } ?>
                                    </ul>
                                </div>
                            </form>
                        </div>

                    </div>

                    <div class="content-list pipelines">

                        <div class="table-holder">
                            <table class="table ci-table">
                                <thead>
                                <tr>
                                    <th class="js-pipeline-info pipeline-info">时间</th>
                                    <th class="js-pipeline-info pipeline-info">SQL</th>
                                    <th class="js-pipeline-date pipeline-date">用时</th>
                                    <th style="">调用堆栈</th>
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
</section>

<script type="text/html" id="log_tpl">
    {{#list}}
    <tr class="commit">
        <td>
            <span class="monospace branch-name">{{date}}</span>
        </td>
        <td>
            <span class="monospace branch-name">{{sql}}</span>
        </td>
        <td>
            <span class="monospace branch-name">{{exec_time}}</span>
        </td>
        <td>
            <div class="controls member-controls ">
                <a class="btn btn-transparent item-display" href="javascript:void(0);" data-index="{{@index}}" style="padding: 6px 2px;">
                    查看上下文
                </a>
            </div>
        </td>
    </tr>
    <tr class="stack-data-tr item-display-data-{{@index}}" aria-expanded="true" style="display: none;">
        <td colspan="4">
            <div style="white-space: pre-wrap;background: #333;color: #fff; padding: 10px;">
                {{stack}}
            </div>
        </td>
    </tr>
    {{/list}}

</script>

<script>
    $(function () {
        //fetchLogs('/admin/log_operating/fetch_slow_sql_list', 'log_tpl', 'render_id');
        $(".action_li").click(function () {
            filename = $(this).data('filename');
            fetchLogs('/admin/log_operating/fetch_slow_sql_list', filename, 'log_tpl', 'render_id');
        });
    });
</script>
</body>
</html>