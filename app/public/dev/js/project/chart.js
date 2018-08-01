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

    ProjectChart.prototype.fetchPieData = function (project_id, sprint_id,data_type, start_date, end_date) {
        // url,  list_tpl_id, list_render_id
        var params = {format: 'json'};
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: '/project/chart/fetchProjectChartPie',
            data: {project_id: project_id, sprint_id:sprint_id,data_type: data_type, start_date: start_date, end_date: end_date},
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
    ProjectChart.prototype.fetchBarData = function (project_id, sprint_id,by_time, within_date) {
        // url,  list_tpl_id, list_render_id
        var params = {format: 'json'};
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: '/project/chart/fetchProjectChartBar',
            data: {project_id: project_id,sprint_id:sprint_id, by_time: by_time, within_date: within_date},
            success: function (resp) {
                console.log(resp.data);
                var options =  {
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

    ProjectChart.prototype.fetchSprintBarData = function (project_id, sprint_id) {
        // url,  list_tpl_id, list_render_id
        var params = {format: 'json'};
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: '/project/chart/fetchProjectChartBar',
            data: {project_id: project_id,sprint_id:sprint_id},
            success: function (resp) {
                console.log(resp.data);
                var options =  {
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

    return ProjectChart;
})();

