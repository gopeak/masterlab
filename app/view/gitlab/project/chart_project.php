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

                <div class="ci-charts prepend-top-10" id="project_charts">
                    <div class="container-fluid" style="width:80%">
                        <div class="row">
                            <div class="col-sm-3 col-xs-12 column text-center">
                                <h3 id="issues_count" class="header">-</h3>
                                <p class="text">总事项数</p>
                            </div>
                            <div class="col-sm-3 col-xs-12 column text-center">
                                <h3 id="no_done_count" class="header">-</h3>
                                <p class="text">未解决</p>
                            </div>
                            <div class="col-sm-3 col-xs-12 column text-center">
                                <h3 id="closed_count" class="header">-</h3>
                                <p class="text">已关闭</p>
                            </div>
                            <div class="col-sm-3 col-xs-12 column text-center">
                                <h3 id="sprint_count" class="header">-</h3>
                                <p class="text">迭代次数</p>
                            </div>

                        </div>
                    </div>
                    <hr>
                    <h4>饼状图 </h4>
                    <div class="row prepend-top-default">
                        <div class="col-md-4">

                            <div class="form-group">
                                <label class="label-light" for="user_layout">数据
                                </label>
                                <select class="form-control" name="dataType" id="dataType">
                                    <option selected="selected" value="assignee">经办人</option>
                                    <option value="priority">优先级</option>
                                    <option value="issue_type">事项类型</option>
                                    <option value="status">状态</option>
                                </select>
                                <div class="help-block">
                                    作为显示的统计的数据依据
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="label-light" for="user_dashboard">开始时间
                                </label>
                                <input type="text" class="laydate_input_date form-control" name="start_date" placeholder="yyyy-MM-dd HH:mm:ss"
                                       id="laydate_start_date" value="" lay-key="1">
                            </div>
                            <div class="form-group">
                                <label class="label-light" for="user_dashboard">结束时间
                                </label>
                                <input type="text" class="laydate_input_date form-control" name="end_date" placeholder="yyyy-MM-dd HH:mm:ss"
                                       id="laydate_end_date" value="" lay-key="2">
                            </div>
                            <div class="form-group">
                                <input id="pie_refresh" type="button" name="commit" value="刷 新" class="btn ">
                            </div>

                        </div>
                        <div id="project_pie_wrap" class="col-md-8">
                            <canvas height="260" width="260" id="project_pie"
                                    style="max-width:400px;width: 300px;height: 300px;margin:0 auto;"></canvas>
                        </div>
                    </div>

                    <hr>
                    <h4>解决与未解决事项对比报告 </h4>
                    <div class="row prepend-top-default">

                        <div class="col-md-4">
                            <p class="light">
                                映射出特定期间已创建和已解决问题的对比情况，这可以帮助你了解整体待办事项处于增长状态还是减少状态。
                            </p>
                            <div class="form-group">
                                <label class="label-light" for="by_time">时间
                                </label>
                                <select class="form-control" name="by_time" id="by_time">
                                    <option selected="selected" value="date">按天</option>
                                    <option value="week">按周</option>
                                    <option value="month">按月</option>
                                </select>
                                <div class="help-block">

                                </div>
                            </div>
                            <div class="form-group">
                                <label class="label-light" for="within_date">几天以内
                                </label>
                                <input class="form-control" type="text" value="30" name="within_date" id="within_date">
                            </div>
                            <div class="form-group">
                                <label class="label-light" for="bar_refresh">
                                </label>
                                <input id="bar_refresh" type="button" name="commit" value="刷 新" class="btn ">
                            </div>
                        </div>
                        <div id="project_bar_wrap" class="col-md-8">
                            <!--canvas height="360" id="project_bar"
                                    style="max-height:400px;min-width: 609px; height: 360px;"></canvas-->
                            <canvas id="project_bar"></canvas>
                        </div>

                    </div>

                </div>

            </div>

        </div>
    </div>
</div>

</div>
</section>

<link href="<?= ROOT_URL ?>dev/lib/laydate/theme/default/laydate.css" rel="stylesheet">
<script src="<?= ROOT_URL ?>dev/lib/laydate/laydate.js"></script>

<script src="<?= ROOT_URL ?>dev/js/project/chart.js"></script>
<script src="<?= ROOT_URL ?>dev/lib/chart.js/Chart.bundle.js"></script>
<script src="<?= ROOT_URL ?>dev/lib/chart.js/samples/utils.js"></script>


<script>

    var _cur_project_id = '<?=$project_id?>';
    var ctx_pie = document.getElementById('project_pie').getContext('2d');
    var ctx_bar = document.getElementById('project_bar').getContext('2d');
    var projectPie = null;
    var projectBar = null;
    var randomScalingFactor = function () {
        return Math.round(Math.random() * 100);
    };

    window.onload = function () {
        lay('.laydate_input_date').each(function () {
            laydate.render({
                elem: this
                , trigger: 'click'
                , type: 'datetime'
            });
        });
        var sprintId = '';
        var dataType = $('#dataType').val();
        var startDate = '';
        var endDate = '';
        var by_time = 'date';
        var within_date = $('#within_date').val();


        var $chartObj = new ProjectChart({});
        if (window._cur_project_id != '') {
            $chartObj.fetchProjectStat(_cur_project_id);
            $chartObj.fetchProjectPieData(_cur_project_id,  dataType, startDate, endDate);
            $chartObj.fetchProjectBarData(_cur_project_id,  by_time, within_date);
        }

        $('#pie_refresh').bind('click', function () {
            var dataType = $('#dataType').val();
            var startDate = $('#laydate_start_date').val();
            var endDate = $('#laydate_end_date').val();
            $chartObj.fetchProjectPieData(_cur_project_id,  dataType, startDate, endDate);
        });

        $('#bar_refresh').bind('click', function () {
            var by_time = $('#by_time').val();
            var within_date = $('#within_date').val();
            $chartObj.fetchProjectBarData(_cur_project_id,  by_time, within_date);
        });

    };

</script>

</body>
</html>

