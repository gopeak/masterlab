var Permission = (function () {

    var _options = {};

    // constructor
    function Permission(options) {
        _options = options;
        $("#btn-permission_update").click(function () {
            Permission.prototype.update();
        });
    };

    Permission.prototype.getOptions = function () {
        return _options;
    };

    Permission.prototype.setOptions = function (options) {
        for (i in  options) {
            // if( typeof( _options[options[i]] )=='undefined' ){
            _options[i] = options[i];
            // }
        }
    };

    Permission.prototype.fetchPermissionDetail = function (url, tpl_id, parent_id) {

        var params = {format: 'json'};
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: url,
            data: params,
            success: function (res) {
                auth_check(resp);
                if(res.data.roles.length){
                    var source = $('#' + tpl_id).html();
                    var template = Handlebars.compile(source);
                    var result = template(res.data);
                    $('#' + parent_id).html(result);

                    $(".list_for_edit").click(function () {
                        Permission.prototype.get($(this).attr("data-value"));
                    });
                }else{
                    var emptyHtml = defineStatusHtml({
                        message : '暂无数据',
                        type: 'error',
                        handleHtml: '',
                        wrap: '#render_id'
                    })
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }


    Permission.prototype.get = function (id) {
        var method = 'get';
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: _options.get_url,
            data: {id: id},
            success: function (resp) {
                auth_check(resp);
                $("#modal-permission_edit").modal();
                $("#edit_id").val(resp.data.id);
                $("#edit_name").val(resp.data.name);
                $("#edit_description").val(resp.data.description);
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
        //清空树状
        $('#container').data('jstree', false).empty();
        //请求生成
        $('#container').jstree({
            "plugins": ["checkbox"],
            'core': {
                'data': {
                    "url": _options.tree_url + id,
                    "dataType": "json"
                }
            }
        });

    }


    Permission.prototype.update = function () {

        var method = 'post';
        var params = $('#form_edit').serialize();
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: _options.update_url,
            data: params,
            success: function (resp) {
                auth_check(resp);
                notify_success(resp.msg);
                if (resp.ret == 200) {
                    window.location.reload();
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    return Permission;
})();


