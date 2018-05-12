
var Backlog = (function() {

    var _options = {};
 

    // constructor
    function Backlog(  options  ) {
        _options = options;


    };

    Backlog.prototype.getOptions = function() {
        return _options;
    };

    Backlog.prototype.setOptions = function( options ) {
        for( i in  options )  {
            // if( typeof( _options[options[i]] )=='undefined' ){
            _options[i] = options[i];
            // }
        }
    };

    Backlog.prototype.fetch = function(id ) {

        $('#id').val( id );
        var method = 'get';
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: "/agile/backlog/fetch/"+id,
            data: {} ,
            success: function (resp) {

            },
            error: function (res) {
                alert("请求数据错误" + res);
            }
        });
    }



    Backlog.prototype.fetchAll = function(  ) {

        // url,  list_tpl_id, list_render_id
        var params = {  format:'json' };
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: _options.filter_url,
            data: {} ,
            success: function (resp) {

                var source = $('#'+_options.list_tpl_id).html();
                var template = Handlebars.compile(source);
                var result = template(resp.data);
                $('#' + _options.list_render_id).html(result);
            },
            error: function (res) {
                alert("请求数据错误" + res);
            }
        });
    }

    return Backlog;
})();

