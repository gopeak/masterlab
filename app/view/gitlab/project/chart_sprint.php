<!DOCTYPE html>
<html class="" lang="en">
<head>

    <? require_once VIEW_PATH . 'gitlab/common/header/include.php'; ?>
</head>
<body class="" data-group="" data-page="projects:issues:index" data-project="xphp">
<? require_once VIEW_PATH . 'gitlab/common/body/script.php'; ?>

<section class="has-sidebar page-layout max-sidebar">
    <? require_once VIEW_PATH . 'gitlab/common/body/page-left.php'; ?>

    <div class="page-layout page-content-body">
<? require_once VIEW_PATH . 'gitlab/common/body/header-content.php'; ?>

<script>
    var findFileURL = "";
</script>
<div class="page-with-sidebar">
    <? require_once VIEW_PATH . 'gitlab/project/common-page-nav-project.php'; ?>
    <? require_once VIEW_PATH . 'gitlab/project/common-chart-sub-nav.php'; ?>

    <div class="content-wrapper page-with-layout-nav page-with-sub-nav">
        <div class="alert-wrapper">


            <div class="flash-container flash-container-page">
            </div>


        </div>
        <div class="content padding-0" id="content-body">
            <div class="container-fluid container-limited">
                <h4 class="padding-t-20">概 览 </h4>
                <div class="ci-charts prepend-top-10" id="sprint_charts">
                    <div class="row charts-info">
                        <div class="col-md-5">
                            <ul class="row">
                                <li class="col-sm-4 col-xs-12 column text-center">
                                    <h3 id="issues_count" class="header"></h3>
                                    <p class="text">事项数</p>
                                </li>
                                <li class="col-sm-4 col-xs-12 column text-center">
                                    <h3 id="no_done_count" class="header"></h3>
                                    <p class="text">未解决</p>
                                </li>
                                <li class="col-sm-4 col-xs-12 column text-center">
                                    <h3 id="closed_count" class="header">  </h3>
                                    <p class="text">已关闭</p>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-7 charts-right-info">
                            <p class="light">
                                迭代倒计时
                            </p>
                            <div id="getting-started" style="font-size: 48px;">
                            </div>
                        </div>
                    </div>
                    <hr>
                    <h4>
                        燃尽图
                    </h4>
                    <div id="burndown_line_wrap" class="prepend-top-default">

                        <canvas height="360" id="burndown_line" width="1248"
                                style="width: 1248px; height: 360px;"></canvas>
                    </div>
                    <hr>
                    <h4>
                        速率图
                    </h4>
                    <div id="speed_line_wrap" class="prepend-top-default">

                        <canvas height="360" id="speed_line" width="1248"
                                style="width: 1248px; height: 360px;"></canvas>
                    </div>

                    <hr>
                    <h4>饼状图 </h4>
                    <div class="row prepend-top-default">
                        <div class="col-md-4">
                            <form class="form-horizontal">
                                <div class="form-group">
                                    <label for="dataType" class="col-sm-2 control-label">数据:</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" name="dataType" id="dataType">
                                            <option selected="selected" value="assignee">经办人</option>
                                            <option value="priority">优先级</option>
                                            <option value="issue_type">事项类型</option>
                                            <option value="status">状态</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-6">
                                        <input id="pie_refresh" type="button" name="commit" value="刷 新" class="btn ">
                                    </div>
                                </div>

                            </form>


                        </div>
                        <div id="sprint_pie_wraper" class="col-md-8">
                            <canvas height="260" width="260" id="sprint_pie"
                                    style="max-width:300px;width: 300px;height: 300px;margin-left:20px"></canvas>
                        </div>
                    </div>

                    <hr>
                    <h4>解决与未解决事项对比报告 </h4>
                    <div class="row prepend-top-default">
                        <canvas  id="sprint_bar"
                                style="max-height:600px;min-width: 609px; ;"></canvas>
                    </div>


                </div>
            </div>

        </div>
    </div>
</div>

    </div>
</section>
<script src="<?= ROOT_URL ?>dev/js/project/chart.js"></script>
<script src="<?= ROOT_URL ?>dev/lib/chart.js/Chart.bundle.js"></script>
<script src="<?= ROOT_URL ?>dev/lib/chart.js/samples/utils.js"></script>
<script src="<?= ROOT_URL ?>dev/lib/jquery.countdown/jquery.countdown.js"></script>


<script>

    var _cur_project_id = '<?=@$project_id?>';
    var _active_sprint_id = '<?=@$activeSprint['id']?>';

    var ctx_sprint_pie = document.getElementById('sprint_pie').getContext('2d');
    var ctx_sprint_bar = document.getElementById('sprint_bar').getContext('2d');
    var ctx_burndown_line = document.getElementById('burndown_line').getContext('2d');
    var ctx_speed_line = document.getElementById('speed_line').getContext('2d');

    var sprint_pie = null;
    var sprint_bar = null;
    var burndown_line = null;
    var speed_line = null;

    window.onload = function () {

        var project_id = window._cur_project_id;
        var sprintId = window._active_sprint_id;
        var dataType = $('#dataType').val();
        var by_time = 'date';

        var $chartObj = new ProjectChart({});
        $chartObj.fetchSprintIssue(sprintId);
        if (sprintId != '') {
            $chartObj.fetchSprintPieData(sprintId, dataType);
            $chartObj.fetchSprintBarData(sprintId, by_time);
            $chartObj.fetchSprintBurnDownData(sprintId);
            $chartObj.fetchSprintSpeedData(sprintId);
        }

        $('#pie_refresh').bind('click', function () {
            var dataType = $('#dataType').val();
            $chartObj.fetchSprintPieData(sprintId, dataType);
        });
    };


</script>

<script type="text/javascript">
    $(function () {
        var sprint_end_date = '<?=@$activeSprint['end_date']?>';
        $('#getting-started').countdown(sprint_end_date, function (event) {
            $(this).html(event.strftime('%w 周 %d 天 %H:%M:%S'));
        });
    });

</script>

</body>
</html>

