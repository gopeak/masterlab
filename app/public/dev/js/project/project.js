
var Project = (function() {

    var _options = {};

    // constructor
    function Project(  options  ) {
        _options = options;
    };

    Project.prototype.getOptions = function() {
        return _options;
    };

    Project.prototype.fetch = function(id ) {

    }


    Project.prototype.add = function(  ) {

    }

    Project.prototype.update = function(  ) {

    }

    Project.prototype.delete = function( id ) {

    }

    Project.prototype.fetchAll = function(  ) {
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

                $(".list_for_delete").click(function(){
                    Origin.prototype.delete( $(this).data("id"));
                });

            },
            error: function (res) {
                alert("请求数据错误" + res);
            }
        });
    }

    return Project;
})();

