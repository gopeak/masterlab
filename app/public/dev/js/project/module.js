
let Module = (function() {

    let _options = {};

    // constructor
    function Module(  options  ) {
        _options = options;
    };

    Module.prototype.getOptions = function() {
        return _options;
    };

    Module.prototype.fetch = function(id ) {

    };


    Module.prototype.add = function(  ) {

    };

    Module.prototype.update = function(  ) {

    };

    Module.prototype.delete = function( id ) {

    };

    Module.prototype.fetchAll = function(  ) {
        // url,  list_tpl_id, list_render_id
        let params = {  format:'json' };
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: _options.filter_url,
            data: {} ,
            success: function (resp) {
                let source = $('#'+_options.list_tpl_id).html();
                let template = Handlebars.compile(source);
                let result = template(resp.data);
                console.log(result);
                $('#' + _options.list_render_id).html(result);

                $(".list_for_delete").click(function(){
                    Module.prototype.delete( $(this).data("id"));
                });
            },
            error: function (res) {
                alert("请求数据错误" + res);
            }
        });
    };

    return Module;
})();

