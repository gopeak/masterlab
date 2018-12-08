var Activity = (function () {

    var _options = {};

    // constructor
    function Activity(options) {
        _options = options;
    };

    Activity.prototype.getOptions = function () {
        return _options;
    };

    Activity.prototype.setOptions = function (options) {
        for (i in  options) {
            // if( typeof( _options[options[i]] )=='undefined' ){
            _options[i] = options[i];
            // }
        }
    };

    Activity.prototype.fetchCalendarHeatmap = function () {

        // url,  list_tpl_id, list_render_id
        var params = {format: 'json'};
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: root_url+'activity/fetchCalendarHeatmap',
            data: {user_id:_options.user_id},
            success: function (resp) {

                console.log(resp)
                auth_check(resp);
                var now = moment().endOf('day').toDate();
                var yearAgo = moment().startOf('day').subtract(1, 'year').toDate();
                var chartData = d3.time.days(yearAgo, now).map(function (dateElement) {
                    return {
                        ymd:dateElement.format('yyyy-mm-dd'),
                        date: dateElement,
                        count: 0
                    };
                });
                for (var i = 0; i < resp.data.heatmap.length; i++) {
                    var row = resp.data.heatmap[i];
                    for(var key in chartData){
                        if(chartData[key].ymd==row.date){
                            chartData[key].count=row.count;
                            break;
                        }
                    }
                }
                // console.log(chartData)
                var heatmap = calendarHeatmap()
                    .data(chartData)
                    .selector('.calendar-container')
                    .tooltipEnabled(true)
                    .colorRange(['#f4f7f7', '#79a8a9'])
                    .onClick(function (data) {
                        //console.log('data', data);
                    });
                heatmap();  // render the chart
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    Activity.prototype.fetchByUser = function ( page ) {

        // url,  list_tpl_id, list_render_id
        var params = {format: 'json'};
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: root_url+'activity/fetchByUser',
            data: {page:page,user_id:_options.user_id},
            success: function (resp) {
                auth_check(resp);
                if(resp.data.activity_list.length){
                    var source = $('#activity_tpl').html();
                    var template = Handlebars.compile(source);
                    var result = template(resp.data);
                    $('#activity_list').append(result);

                    window._cur_page = parseInt(page);
                    var pages = parseInt(resp.data.pages);
                    if(window._cur_page<pages){
                        $('#more_activity').removeClass('hide');
                    }else{
                        $('#more_activity').addClass('hide');
                    }
                }else{
                    var emptyHtml = defineStatusHtml({
                        wrap: '#activity_list',
                        message : '暂无数据',
                        type: 'image'
                    })
                }
                
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    return Activity;
})();

