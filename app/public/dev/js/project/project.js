
var Project = (function() {

    var _options = {};

    // constructor
    function Project(  options  ) {
        _options = options;
    }

    Project.prototype.getOptions = function() {
        return _options;
    };

    Project.prototype.fetch = function(id ) {

    };


    Project.prototype.add = function(  ) {

    };

    Project.prototype.update = function(  ) {

    };

    Project.prototype.delete = function( id ) {

    };

    Project.prototype.fetchAll = function(  ) {
        // url,  list_tpl_id, list_render_id
        var params = {  format:'json' };
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: _options.filter_url,
            data: params ,
            success: function (resp) {
                auth_check(resp);
                if(resp.data.projects.length){
                    var source = $('#'+_options.list_tpl_id).html();
                    var template = Handlebars.compile(source);
                    var result = template(resp.data);
                    $('#' + _options.list_render_id).html(result);

                    $(".list_for_delete").click(function(){
                        Project.prototype.delete( $(this).data("id"));
                    });
                }else{
                    var emptyHtml = defineStatusHtml({
                        wrap: '#list_render_id',
                        message : '数据为空',
                        type: 'image',
                        handleHtml: '<a class="btn btn-default btn-sm" href="#">返回首页</a> <a class="btn btn-success btn-sm" href="/project/main/_new">创建项目</a>'
                    })
                }
                
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    };

    return Project;
})();

