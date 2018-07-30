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
                <h4>概 览 </h4>
                <div class="ci-charts prepend-top-10" id="sprint_charts">
                    <div class="row" style="padding: 20px;">
                        <div class="col-md-4 ">
                            <ul>
                                <li>
                                    事项数:
                                    <strong> 94769 </strong>
                                </li>
                                <li>
                                    未解决:
                                    <strong> 40300 </strong>
                                </li>
                                <li>
                                    已解决:
                                    <strong> 47710 </strong>
                                </li>
                            </ul>

                        </div>
                        <div class="col-md-6">
                                <p class="light">
                                    迭代倒计时
                                </p>
                                <div id="getting-started" style="font-size: 48px;">
                                </div>
                        </div>
                    </div>
                    <hr>
                    <div class="prepend-top-default">
                        <p class="light">
                            燃尽图 (27 Jun - 27 Jul)
                        </p>
                        <canvas height="360" id="chart_line_sprint_burndown" width="1248" style="width: 1248px; height: 360px;"></canvas>
                    </div>
                    <hr>
                    <div class="prepend-top-default">
                        <p class="light">
                            速率图 (27 Jun - 27 Jul)
                        </p>
                        <canvas height="360" id="monthChart" width="1248" style="width: 1248px; height: 360px;"></canvas>
                    </div>

                    <hr>
                    <h4>饼状图 </h4>
                    <div class="row prepend-top-default">
                        <div class="col-md-4">
                            <form class="form-horizontal">
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">数据:</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" name="user[layout]" id="user_layout">
                                            <option selected="selected" value="assignee">经办人</option>
                                            <option value="priority">优先级</option>
                                            <option value="issue_type">事项类型</option>
                                            <option value="status">状态</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label"></label>
                                    <div class="col-sm-10">
                                        作为显示的统计的数据依据
                                    </div>
                                </div>
                            </form>


                        </div>
                        <div class="col-md-8">
                            <canvas height="260" width="260" id="project_pie"  style="max-width:300px;width: 300px;height: 300px;margin-left:20px"></canvas>
                        </div>
                    </div>

                    <hr>
                    <h4>解决与未解决事项对比报告 </h4>
                    <div class="row prepend-top-default">


                            <canvas height="360" id="chart_bar_issue_resolve"  style="max-height:400px;min-width: 609px; height: 360px;"></canvas>


                    </div>


                </div>
            </div>

        </div>
    </div>
</div>
<script src="<?=ROOT_URL?>dev/lib/chart.js/Chart.bundle.js"></script>
<script src="<?=ROOT_URL?>dev/lib/chart.js/samples/utils.js"></script>
<script src="<?=ROOT_URL?>dev/lib/jquery.countdown/jquery.countdown.js"></script>


<script>


    var randomScalingFactor = function() {
        return Math.round(Math.random() * 100);
    };
    var projectPie = null;
    var pie_config = {
        type: 'pie',
        data: {
            datasets: [{
                data: [
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                ],
                backgroundColor: [
                    window.chartColors.red,
                    window.chartColors.orange,
                    window.chartColors.yellow,
                    window.chartColors.green,
                    window.chartColors.blue,
                ],
                label: 'Dataset 1'
            }],
            labels: [
                'Red',
                'Orange',
                'Yellow',
                'Green',
                'Blue'
            ]
        },
        options: {
            responsive: true
        }
    };


    var MONTHS = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'];
    var burndown_config = {
        type: 'line',
        data: {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            datasets: [{
                label: '按照完成状态',
                backgroundColor: window.chartColors.red,
                borderColor: window.chartColors.red,
                data: [
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor()
                ],
                fill: false,
            }, {
                label: '按照解决结果',
                fill: false,
                backgroundColor: window.chartColors.blue,
                borderColor: window.chartColors.blue,
                data: [
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor()
                ],
            }]
        },
        options: {
            responsive: true,
            title: {
                display: true,
                text: '燃尽图 (20 Jul - 27 Jul)'
            },
            tooltips: {
                mode: 'index',
                intersect: false,
            },
            hover: {
                mode: 'nearest',
                intersect: true
            },
            scales: {
                xAxes: [{
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: 'Month'
                    }
                }],
                yAxes: [{
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: 'Value'
                    }
                }]
            }
        }
    };

    window.onload = function() {
        var ctx1 = document.getElementById('chart_bar_issue_resolve').getContext('2d');
        window.myBar = new Chart(ctx1, {
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
        });
        var ctx = document.getElementById('chart_line_sprint_burndown').getContext('2d');
        window.myLine = new Chart(ctx, burndown_config);

        var ctx_pie = document.getElementById('project_pie').getContext('2d');
        window.projectPie = new Chart(ctx_pie, pie_config);
    };


</script>

<script type="text/javascript">
    $(function() {

        $('#getting-started').countdown('2018/08/31', function(event) {
            $(this).html(event.strftime('%w weeks %d days %H:%M:%S'));
        });
    });

</script>

</body>
</html>

