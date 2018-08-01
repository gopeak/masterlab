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

    ProjectChart.prototype.fetchPieData = function (project_id, data_type) {
        // url,  list_tpl_id, list_render_id
        var params = {format: 'json'};
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: '/project/chart/fetchProjectChartPie',
            data: {project_id: project_id,data_type:data_type },
            success: function (resp) {
                console.log(resp.data);
                if(window.projectPie){
                    window.projectPie.destroy();
                }
                window.projectPie = new Chart(window.ctx_pie, resp.data);
            },
            error: function (res) {
                alert("请求数据错误" + res);
            }
        });
    }

    return ProjectChart;
})();

