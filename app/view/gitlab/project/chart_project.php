<!DOCTYPE html>
<html class="" lang="en">
<head  >

    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>
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
    <? require_once VIEW_PATH.'gitlab/project/common-chart-sub-nav.php';?>

    <div class="content-wrapper page-with-layout-nav page-with-sub-nav">
        <div class="alert-wrapper">
            <div class="flash-container flash-container-page">
            </div>
        </div>

        <div class="content" id="content-body">
            <div class="container-fluid container-limited">

                <div class="ci-charts prepend-top-10" id="project_charts">
                    <div class="container-fluid" style="width:80%">
                        <div class="row"  >
                                <div class="col-sm-3 col-xs-12 column">
                                    <h3 id="issues_count" class="header">562</h3>
                                    <p class="text">总事项数</p>
                                </div>
                                <div class="col-sm-3 col-xs-12 column">
                                    <h3 id="no_done_count" class="header">91</h3>
                                    <p class="text">未解决</p>
                                </div>
                                <div class="col-sm-3 col-xs-12 column">
                                    <h3 id="closed_count" class="header">0</h3>
                                    <p class="text">Backlog</p>
                                </div>
                                <div class="col-sm-3 col-xs-12 column">
                                    <h3 id="sprint_count" class="header">0</h3>
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
                                    <label class="label-light" for="user_dashboard">筛选范围
                                    </label>
                                    <select class="form-control" name="user[dashboard]" id="user_dashboard">
                                        <option value="projects">所有</option>
                                        <option value="stars">开始时间</option>
                                        <option selected="selected" value="project_activity">结束时间</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <input id="pie_refresh" type="button" name="commit" value="刷 新" class="btn ">
                                </div>

                        </div>
                        <div class="col-md-8">
                            <canvas height="260" width="260" id="project_pie"  style="max-width:400px;width: 300px;height: 300px;margin-left:20px"></canvas>
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
                                    <option selected="selected" value="assignee">每日</option>
                                    <option value="priority">每周</option>
                                    <option value="issue_type">每月</option>
                                </select>
                                <div class="help-block">

                                </div>
                            </div>
                            <div class="form-group">
                                <label class="label-light" for="time_before">几天之前
                                </label>
                                <input class="form-control" type="text" value="30" name="time_before" id="time_before">
                            </div>
                            <div class="form-group">
                                <input type="button" name="commit" value="刷 新" class="btn ">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <canvas height="360" id="chart_bar_issue_resolve"  style="max-height:400px;min-width: 609px; height: 360px;"></canvas>

                        </div>

                    </div>

                </div>

            </div>

        </div>
    </div>
</div>
<script src="<?=ROOT_URL?>dev/js/project/chart.js"></script>
<script src="<?=ROOT_URL?>dev/lib/chart.js/Chart.bundle.js"></script>
<script src="<?=ROOT_URL?>dev/lib/chart.js/samples/utils.js"></script>


<script>

    var _cur_project_id = '<?=$project_id?>';
    var ctx_pie = document.getElementById('project_pie').getContext('2d');
    var projectPie = null;

    var randomScalingFactor = function() {
        return Math.round(Math.random() * 100);
    };


    var bar_config = {
        type: 'bar',
        data:  {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            datasets: [{
                label: 'Dataset 1',
                backgroundColor: window.chartColors.red,
                data: [
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor()
                ]
            }, {
                label: 'Dataset 2',
                backgroundColor: window.chartColors.blue,
                data: [
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor()
                ]
            }]

        },
        options: {
            title: {
                display: true,
                text: '已解决和未解决'
            },
            tooltips: {
                mode: 'index',
                intersect: false
            },
            responsive: true,
            scales: {
                xAxes: [{
                    stacked: true,
                }],
                yAxes: [{
                    stacked: true
                }]
            }
        }
    };

    window.onload = function() {

        var $chartObj = new ProjectChart({});
        if(window._cur_project_id!=''){
            $chartObj.fetchPieData(_cur_project_id, $('#dataType').val());
        }

        $('#pie_refresh').bind('click',function () {
            $chartObj.fetchPieData(_cur_project_id, $('#dataType').val());
        })
        var ctx_bar = document.getElementById('chart_bar_issue_resolve').getContext('2d');
        window.myBar = new Chart(ctx_bar, bar_config);

    };


</script>


</body>
</html>

