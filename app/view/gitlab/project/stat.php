<!DOCTYPE html>
<html class="" lang="en">
<head  >

    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>
    <link href="<?=ROOT_URL?>dev/lib/bootstrap-3.3.7/css/bootstrap.css" rel="stylesheet" type="text/css"/>
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

    <div class="content-wrapper page-with-layout-nav page-with-sub-nav">
        <div class="alert-wrapper">
            <div class="flash-container flash-container-page">
            </div>
        </div>
        <div class="content" id="content-body">
            <div class="container-fluid"  >
                <div class="content-block" style="padding: 20px;">
                    <h3>项目统计</h3>
                    <div class="container-fluid" style="width:80%">
                        <div class="row">
                            <div class="col-sm-3 col-xs-12 column">
                                <h3 id="issues_count" class="header">-</h3>
                                <p class="text">总事项</p>
                            </div>
                            <div class="col-sm-3 col-xs-12 column">
                                <h3 id="no_done_count" class="header">-</h3>
                                <p class="text">未解决</p>
                            </div>
                            <div class="col-sm-3 col-xs-12 column">
                                <h3 id="closed_count" class="header">-</h3>
                                <p class="text">关闭</p>
                            </div>
                            <div class="col-sm-3 col-xs-12 column">
                                <h3 id="sprint_count" class="header">-</h3>
                                <p class="text">迭代次数</p>
                            </div>

                        </div>
                    </div>
                </div>
                <div id="multi" class="  row" style=" padding:50px">

                    <div class="col-md-6 group_panel">

                        <div class="panel panel-info">
                            <!-- Default panel contents -->
                            <div class="panel-heading tile__name " data-force="25" draggable="false" >按优先级(未解决事项)</div>

                                <!-- Table -->
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>优先级</th>
                                        <th>事项</th>
                                        <th>百分比</th>
                                    </tr>
                                    </thead>
                                    <script id="priority_stat_tpl" type="text/html" >
                                        {{#priority_stat}}
                                        <tr>
                                            <td >{{priority_html id }}</td>
                                            <td>{{count}}</td>
                                            <td>
                                                <div class="progress">
                                                    <div class="progress-bar"
                                                         role="progressbar"
                                                         aria-valuenow="{{percent}}"
                                                         aria-valuemin="0"
                                                         aria-valuemax="100"
                                                         style="min-width: 2em;width:{{percent}}%">
                                                        {{percent}}%
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        {{/priority_stat}}
                                    </script>
                                    <tbody id="priority_stat">


                                    </tbody>
                                </table>
                        </div>
                        <div class="panel panel-info">
                            <!-- Default panel contents -->
                            <div class="panel-heading tile__name " data-force="25" draggable="false" >按开发人员未解决事项)</div>
                            <div class="panel-body">
                                <!-- Table -->
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>开发者</th>
                                        <th>事项</th>
                                        <th>百分比</th>
                                    </tr>
                                    </thead>
                                    <script id="assignee_stat_tpl" type="text/html" >
                                        {{#assignee_stat}}
                                        <tr>
                                            <td>
                                                {{user_html user_id }}
                                            </td>
                                            <td  >{{count}}</td>
                                            <td>
                                                <div class="progress">
                                                    <div class="progress-bar"
                                                         role="progressbar"
                                                         aria-valuenow="{{percent}}"
                                                         aria-valuemin="0"
                                                         aria-valuemax="100"
                                                         style="min-width: 2em;width:{{percent}}%">
                                                        {{percent}}%
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        {{/assignee_stat}}
                                    </script>

                                    <tbody id="assignee_stat">

                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>

                    <div class="col-md-6 group_panel">
                        <div class="panel panel-info">
                            <!-- Default panel contents -->
                            <div class="panel-heading tile__name " data-force="25" draggable="false" >按状态(未解决事项)</div>
                            <div class="panel-body">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>状态</th>
                                        <th>事项</th>
                                        <th>百分比</th>
                                    </tr>
                                    </thead>
                                    <script id="status_stat_tpl" type="text/html" >
                                        {{#status_stat}}
                                        <tr>
                                            <td>
                                                {{status_html id}}
                                            </td>
                                            <td  >{{count}}</td>
                                            <td>
                                                <div class="progress">
                                                    <div class="progress-bar"
                                                         role="progressbar"
                                                         aria-valuenow="{{percent}}"
                                                         aria-valuemin="0"
                                                         aria-valuemax="100"
                                                         style="min-width: 2em;width:{{percent}}%">
                                                        {{percent}}%
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        {{/status_stat}}
                                    </script>

                                    <tbody id="status_stat">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="panel panel-info">
                            <!-- Default panel contents -->
                            <div class="panel-heading tile__name " data-force="25" draggable="false" >按事项类型(未解决事项)</div>
                            <div class="panel-body">
                                <!-- Table -->
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>类型</th>
                                        <th>事项</th>
                                        <th>百分比</th>
                                    </tr>
                                    </thead>
                                    <script id="type_stat_tpl" type="text/html" >
                                        {{#type_stat}}
                                        <tr>
                                            <td>
                                                {{issue_type_html id }}
                                            </td>
                                            <td  >{{count}}</td>
                                            <td>
                                                <div class="progress">
                                                    <div class="progress-bar"
                                                         role="progressbar"
                                                         aria-valuenow="{{percent}}"
                                                         aria-valuemin="0"
                                                         aria-valuemax="100"
                                                         style="min-width: 2em;width:{{percent}}%">
                                                        {{percent}}%
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        {{/type_stat}}
                                    </script>

                                    <tbody id="type_stat">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    </div>
</div>

<script src="<?=ROOT_URL?>dev/lib/handlebars-v4.0.10.js" type="text/javascript" charset="utf-8"></script>
<script src="<?=ROOT_URL?>dev/js/handlebars.helper.js" type="text/javascript" charset="utf-8"></script>
<script src="<?=ROOT_URL?>dev/js/panel.js" type="text/javascript" charset="utf-8"></script>
<script src="<?= ROOT_URL ?>dev/lib/sortable/Sortable.js"></script>

<script type="text/javascript">

    var _cur_project_id = '<?=$project_id?>';

    var _issueConfig = {
        "priority":<?=json_encode($priority)?>,
        "issue_types":<?=json_encode($issue_types)?>,
        "issue_status":<?=json_encode($issue_status)?>,
        "issue_resolve":<?=json_encode($issue_resolve)?>,
        "issue_module":<?=json_encode($project_modules)?>,
        "issue_version":<?=json_encode($project_versions)?>,
        "issue_labels":<?=json_encode($project_labels)?>,
        "users":<?=json_encode($users)?>,
        "projects":<?=json_encode($projects)?>
    };

    var $panel = null;
    var _cur_page = 1;

    $(function() {
        var options = {
        }
        window.$panel = new Panel( options );
        window.$panel.fetchProjectStat(_cur_project_id);
    });


</script>
</body>
</html>

