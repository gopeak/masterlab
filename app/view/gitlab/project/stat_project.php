<!DOCTYPE html>
<html class="" lang="en">
<head  >

    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>


    <script src="<?=ROOT_URL?>dev/lib/notify/bootstrap-notify/dist/bootstrap-notify.min.js"></script>
    <script src="<?=ROOT_URL?>dev/lib/chart.js/Chart.bundle.js"></script>
    <script src="<?=ROOT_URL?>dev/lib/chart.js/samples/utils.js"></script>

    <link href="<?=ROOT_URL?>dev/lib/bootstrap-3.3.7/css/bootstrap.css" rel="stylesheet" type="text/css"/>
    <link href="<?=ROOT_URL?>gitlab/assets/application.css?v=<?=$_version?>" rel="stylesheet">
    <link href="<?=ROOT_URL?>dev/css/dashboard.css?v=<?=$_version?>" rel="stylesheet">
    <link href="<?=ROOT_URL?>dev/css/statistics.css?v=<?=$_version?>" rel="stylesheet">
</head>
<body class="" data-group="" data-page="projects:issues:index" data-project="xphp">
<? require_once VIEW_PATH.'gitlab/common/body/script.php';?>

<div class="has-sidebar page-layout max-sidebar">
    <? require_once VIEW_PATH . 'gitlab/common/body/page-left.php'; ?>

    <div class="page-layout page-content-body">
<? require_once VIEW_PATH.'gitlab/common/body/header-content.php';?>

<script>
    var findFileURL = "";
</script>
<div class="page-with-sidebar">
    <? require_once VIEW_PATH.'gitlab/project/common-page-nav-project.php';?>
    <? require_once VIEW_PATH . 'gitlab/project/common-stat-sub-nav.php'; ?>
    <div class="content-wrapper page-with-layout-nav page-with-sub-nav">
        <div class="alert-wrapper">
            <div class="flash-container flash-container-page">
            </div>
        </div>
        <div class="content" id="content-body">
            <div class="container-fluid padding-0"  >
                <div class="content-block padding-lg margin-b-lg content-block-header">
                    <h3 class="header-title">项目统计</h3>
                    <div class="row header-body">
                        <div class="col-sm-3 col-xs-12 column header-body-item">
                            <span id="issues_count" class="item-num">-</span>
                            <span class="item-text">总事项</span>
                        </div>
                        <div class="col-sm-3 col-xs-12 column header-body-item">
                            <span id="no_done_count" class="item-num">-</span>
                            <span class="item-text">未解决</span>
                        </div>
                        <div class="col-sm-3 col-xs-12 column header-body-item">
                            <span id="closed_count" class="item-num">-</span>
                            <span class="item-text">关闭</span>
                        </div>
                        <div class="col-sm-3 col-xs-12 column header-body-item">
                            <span id="sprint_count" class="item-num">-</span>
                            <span class="item-text">迭代次数</span>
                        </div>
                    </div>
                </div>
                <div id="multi" class="row">

                    <div class="col-md-6 group_panel">
                        <div class="panel panel-info">
                            <!-- Default panel contents -->
                            <div class="panel-heading tile__name " data-force="25" draggable="false">
                                <h3 class="panel-heading-title">按优先级(未解决事项)</h3>
                            </div>

                            <!-- Table -->
                            <div class="panel-body">
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
                                            <td>{{priority_html id }}</td>
                                            <td>{{count}}</td>
                                            <td>
                                                <div class="progress">
                                                    <div class="progress-outer">
                                                        <div class="progress-bar"
                                                             role="progressbar"
                                                             aria-valuenow="{{percent}}"
                                                             aria-valuemin="0"
                                                             aria-valuemax="100"
                                                             style="min-width: 2em;width:{{percent}}%;
                                                             {{#lessThan percent 30}}
                                                                background-color: #f5222d;
                                                             {{/lessThan}}
                                                             {{#greaterThan percent 90}}
                                                                background-color: #168f48;
                                                             {{/greaterThan}}
                                                            ">
                                                        </div>
                                                    </div>
                                                    <span class="progress-text">{{percent}}%</span>
                                                </div>
                                            </td>
                                        </tr>
                                        {{/priority_stat}}
                                    </script>
                                    <tbody id="priority_stat">

                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="panel panel-info">
                            <!-- Default panel contents -->
                            <div class="panel-heading tile__name " data-force="25" draggable="false">
                                <h3 class="panel-heading-title">按开发人员(未解决事项)</h3>
                            </div>
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
                                                    <div class="progress-outer">
                                                        <div class="progress-bar"
                                                             role="progressbar"
                                                             aria-valuenow="{{percent}}"
                                                             aria-valuemin="0"
                                                             aria-valuemax="100"
                                                             style="min-width: 2em;width:{{percent}}%;
                                                             {{#lessThan percent 30}}
                                                                background-color: #f5222d;
                                                             {{/lessThan}}
                                                             {{#greaterThan percent 90}}
                                                                background-color: #168f48;
                                                             {{/greaterThan}}
                                                            ">
                                                        </div>
                                                    </div>
                                                    <span class="progress-text">{{percent}}%</span>
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
                            <div class="panel-heading tile__name " data-force="25" draggable="false" >
                                <h3 class="panel-heading-title">按状态</h3>
                            </div>
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
                                                    <div class="progress-outer">
                                                        <div class="progress-bar"
                                                             role="progressbar"
                                                             aria-valuenow="{{percent}}"
                                                             aria-valuemin="0"
                                                             aria-valuemax="100"
                                                             style="min-width: 2em;width:{{percent}}%;
                                                             {{#lessThan percent 30}}
                                                                background-color: #f5222d;
                                                             {{/lessThan}}
                                                             {{#greaterThan percent 90}}
                                                                background-color: #168f48;
                                                             {{/greaterThan}}
                                                            ">
                                                        </div>
                                                    </div>
                                                    <span class="progress-text">{{percent}}%</span>
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
                            <div class="panel-heading tile__name " data-force="25" draggable="false" >
                                <h3 class="panel-heading-title">按事项类型</h3>
                            </div>
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
                                                    <div class="progress-outer">
                                                        <div class="progress-bar"
                                                             role="progressbar"
                                                             aria-valuenow="{{percent}}"
                                                             aria-valuemin="0"
                                                             aria-valuemax="100"
                                                             style="min-width: 2em;width:{{percent}}%;
                                                             {{#lessThan percent 30}}
                                                                background-color: #f5222d;
                                                             {{/lessThan}}
                                                             {{#greaterThan percent 90}}
                                                                background-color: #168f48;
                                                             {{/greaterThan}}
                                                            ">
                                                        </div>
                                                    </div>
                                                    <span class="progress-text">{{percent}}%</span>
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
						
						<div class="panel panel-info">
                            <!-- Default panel contents -->
                            <div class="panel-heading tile__name " data-force="25" draggable="false" >
                                <h3 class="panel-heading-title">用户权重值</h3>
                            </div>
                            <div class="panel-body">
                                <!-- Table -->
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>用户</th>
                                        <th>权重累计</th>
                                        <th>百分比</th>
                                    </tr>
                                    </thead>
                                    <script id="weight_stat_tpl" type="text/html" >
                                        {{#weight_stat}}
                                        <tr>
                                            <td>
                                                {{user_html user_id }}
                                            </td>
                                            <td  >{{count}}</td>
                                            <td>
                                                <div class="progress">
                                                    <div class="progress-outer">
                                                        <div class="progress-bar"
                                                             role="progressbar"
                                                             aria-valuenow="{{percent}}"
                                                             aria-valuemin="0"
                                                             aria-valuemax="100"
                                                             style="min-width: 2em;width:{{percent}}%;
                                                             {{#lessThan percent 30}}
                                                                background-color: #f5222d;
                                                             {{/lessThan}}
                                                             {{#greaterThan percent 90}}
                                                                background-color: #168f48;
                                                             {{/greaterThan}}
                                                            ">
                                                        </div>
                                                    </div>
                                                    <span class="progress-text">{{percent}}%</span>
                                                </div>
                                            </td>
                                        </tr>
                                        {{/weight_stat}}
                                    </script>

                                    <tbody id="weight_stat">

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

</div>
</section>

<script src="<?=ROOT_URL?>dev/lib/handlebars-v4.0.10.js" type="text/javascript" charset="utf-8"></script>
<script src="<?=ROOT_URL?>dev/js/handlebars.helper.js?v=<?=$_version?>" type="text/javascript" charset="utf-8"></script>
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

