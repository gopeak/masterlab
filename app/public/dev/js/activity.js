
var Activity = (function() {

    var _options = {};

    // constructor
    function Activity(  options  ) {
        _options = options;
    };

    Activity.prototype.getOptions = function() {
        return _options;
    };

    Activity.prototype.setOptions = function( options ) {
        for( i in  options )  {
            // if( typeof( _options[options[i]] )=='undefined' ){
            _options[i] = options[i];
            // }
        }
    };

    Activity.prototype.fetchByUser = function(  ) {

        // url,  list_tpl_id, list_render_id
        var params = {  format:'json' };
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: '/activity/fetchByUser',
            data: {} ,
            success: function (resp) {

                var source = $('#activity_tpl').html();
                var template = Handlebars.compile(source);
                var result = template(resp.data);
                $('#activity_list').html(result);
            },
            error: function (res) {
                alert("请求数据错误" + res);
            }
        });
    }

    return Activity;
})();

