let Label = (function() {

    let _options = {};

    // constructor
    function Label(  options  ) {
        _options = options;
    };

    Label.prototype.getOptions = function() {
        return _options;
    };

    Label.prototype.fetch = function(id ) {

    };


    Label.prototype.add = function(  ) {

    };

    Label.prototype.delete = function( project_id, label_id ) {
        $.post("/project/label/delete",{project_id: project_id, label_id:label_id},function(result){
            if(result.ret == 200){
                notify_success('删除成功');
                $('#project_label_'+label_id).remove();
            } else {
                notify_error('删除失败');
            }
        });
    };

    Label.prototype.fetchAll = function() {
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: _options.filter_url,
            data: _options.query_param_obj,
            success: function (resp) {
                let source = $('#'+_options.list_tpl_id).html();
                let template = Handlebars.compile(source);
                let result = template(resp.data);
                $('#' + _options.list_render_id).html(result);
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    };

    return Label;
})();

