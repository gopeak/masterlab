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
        $.post(root_url+"project/label/delete",{project_id: project_id, label_id:label_id},function(result){
            if(result.ret == 200){
                notify_success('删除成功');
                $('#project_label_'+label_id).remove();
                window.location.reload();
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
                auth_check(resp);
                if (resp.data.labels.length) {
                    let source = $('#' + _options.list_tpl_id).html();
                    let template = Handlebars.compile(source);
                    let result = template(resp.data);
                    $('#' + _options.list_render_id).html(result);
                } else {
                    defineStatusHtml({
                        wrap: '#' + _options.list_render_id,
                        message : '标签为空',
                        name: 'label',
                        handleHtml: `<a class="btn btn-new js-create-label" href="${project_root_url}/settings_label_new">添加标签</a>`
                    })
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    };

    return Label;
})();

