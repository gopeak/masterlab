var LogOperation = (function () {

    var _options = {};

    // constructor
    function LogOperation(options) {
        _options = options;
    };

    LogOperation.prototype.getOptions = function () {
        return _options;
    };

    LogOperation.prototype.setOptions = function (options) {
        for (i in  options) {
            // if( typeof( _options[options[i]] )=='undefined' ){
            _options[i] = options[i];
            // }
        }
    };

    LogOperation.prototype.fetchByUser = function ( page ) {

        // url,  list_tpl_id, list_render_id
        var params = {format: 'json'};
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: root_url+'log_operation/fetchByUser',
            data: {page:page,user_id:_options.user_id},
            success: function (resp) {
                auth_check(resp);
                if(resp.data.logs.length){
                    var source = $('#log_operation_tpl').html();
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

    return LogOperation;
})();

