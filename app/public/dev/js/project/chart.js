var ProjectChart = (function () {

    var _options = {};

    // constructor
    function ProjectChart(options) {
        _options = options;
    };

    ProjectChart.prototype.getOptions = function () {
        return _options;
    };

    ProjectChart.prototype.setOptions = function (options) {
        for (i in  options) {
            // if( typeof( _options[options[i]] )=='undefined' ){
            _options[i] = options[i];
            // }
        }
    };

    ProjectChart.prototype.fetchProjectPieData = function (project_id, data_type, start_date, end_date) {
        // url,  list_tpl_id, list_render_id
        var params = {format: 'json'};
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: '/project/chart/fetchProjectChartPie',
            data: {
                project_id: project_id,
                data_type: data_type,
                start_date: start_date,
                end_date: end_date
            },
            success: function (resp) {
                console.log(resp.data);
                if (window.projectPie) {
                    window.projectPie.destroy();
                }
                window.projectPie = new Chart(window.ctx_pie, resp.data);
            },
            error: function (res) {
                alert("请求数据错误" + res);
            }
        });
    }

    ProjectChart.prototype.fetchSprintPieData = function (sprint_id, data_type) {
        // url,  list_tpl_id, list_render_id
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: '/project/chart/fetchSprintChartPie',
            data: {
                sprint_id: sprint_id,
                data_type: data_type,
            },
            success: function (resp) {
                console.log(resp.data);
                if (window.sprint_pie) {
                    window.sprint_pie.destroy();
                }
                window.sprint_pie = new Chart(window.ctx_sprint_pie, resp.data);
            },
            error: function (res) {
                alert("请求数据错误" + res);
            }
        });
    }

    ProjectChart.prototype.fetchProjectBarData = function (project_id, by_time, within_date) {
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: '/project/chart/fetchProjectChartBar',
            data: {project_id: project_id, by_time: by_time, within_date: within_date},
            success: function (resp) {
                console.log(resp.data);
                var options = {
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
                if (window.projectBar) {
                    window.projectBar.destroy();
                }
                resp.data.options = options;
                window.projectBar = new Chart(window.ctx_bar, resp.data);
            },
            error: function (res) {
                alert("请求数据错误" + res);
            }
        });
    }

    ProjectChart.prototype.fetchSprintBarData = function (sprint_id, by_time) {
        var params = {format: 'json'};
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: '/project/chart/fetchSprintChartBar',
            data: {sprint_id: sprint_id, by_time: by_time},
            success: function (resp) {
                console.log(resp.data);
                var options = {
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
                if (window.sprint_bar) {
                    window.sprint_bar.destroy();
                }
                resp.data.options = options;
                window.sprint_bar = new Chart(window.ctx_sprint_bar, resp.data);
            },
            error: function (res) {
                alert("请求数据错误" + res);
            }
        });
    }

    ProjectChart.prototype.fetchSprintBurnDownData = function (sprint_id) {
        var params = {format: 'json'};
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: '/project/chart/fetchSprintBurnDownLine',
            data: {sprint_id: sprint_id},
            success: function (resp) {
                console.log(resp.data);
                var options = {
                    title: {
                        display: true,
                        text: '燃尽图'
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
                if (window.burndown_line) {
                    window.burndown_line.destroy();
                }
                resp.data.options = options;
                window.burndown_line = new Chart(window.ctx_burndown_line, resp.data);
            },
            error: function (res) {
                alert("请求数据错误" + res);
            }
        });
    }

    ProjectChart.prototype.fetchSprintSpeedData = function (sprint_id) {
        var params = {format: 'json'};
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: '/project/chart/fetchSprintSpeedLine',
            data: {sprint_id: sprint_id},
            success: function (resp) {
                console.log(resp.data);
                var options = {
                    title: {
                        display: true,
                        text: '速率图'
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
                if (window.speed_line) {
                    window.speed_line.destroy();
                }
                resp.data.options = options;
                window.speed_line = new Chart(window.ctx_speed_line, resp.data);
            },
            error: function (res) {
                alert("请求数据错误" + res);
            }
        });
    }
    return ProjectChart;
})();

