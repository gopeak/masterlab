var Role = (function () {

    var _options = {};

    // constructor
    function Role(options) {
        _options = options;

        $("#btn-role_add").click(function () {
            Role.prototype.add();
        });

        $("#btn-update").click(function () {
            Role.prototype.update();
        });

        $(".list_for_edit").click(function () {
            Role.prototype.edit($(this).data('id'));
        });

    };

    Role.prototype.getOptions = function () {
        return _options;
    };

    Role.prototype.setOptions = function (options) {
        for (i in  options) {
            // if( typeof( _options[options[i]] )=='undefined' ){
            _options[i] = options[i];
            // }
        }
    };

    Role.prototype.fetchRoles = function () {

        // url,  list_tpl_id, list_render_id
        var params = {format: 'json'};
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: _options.filter_url,
            data: $('#' + _options.filter_form_id).serialize(),
            success: function (resp) {

                var source = $('#' + _options.list_tpl_id).html();
                var template = Handlebars.compile(source);
                var result = template(resp.data);
                $('#' + _options.list_render_id).html(result);

                $(".list_for_edit").click(function () {
                    Role.prototype.edit($(this).attr("data-value"));
                });
                $(".list_edit_perm").click(function () {
                    Role.prototype.edit($(this).attr("data-value"));
                });
                $(".list_add_user").click(function () {
                    Role.prototype.edit($(this).attr("data-value"));
                });
                $(".list_for_delete").click(function () {
                    Role.prototype._delete($(this).attr("data-value"));
                });

            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    Role.prototype.edit = function (id) {

        var method = 'get';
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: _options.get_url,
            data: {id: id},
            success: function (resp) {
                if (resp.ret == 200) {
                    $("#modal-role_edit").modal();
                    $("#edit_id").val(resp.data.id);
                    $("#edit_name").val(resp.data.name);
                    $("#edit_description").text(resp.data.description);
                } else {
                    notify_error("请求数据错误:" + resp.msg);
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }


    Role.prototype.add = function () {

        var method = 'post';
        var params = $('#form_add_role').serialize();
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: _options.add_url,
            data: params,
            success: function (resp) {
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

    Role.prototype.update = function () {

        var method = 'post';
        var params = $('#form_add_role').serialize();
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: _options.update_url,
            data: $('#form_edit').serialize(),
            success: function (resp) {
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

    Role.prototype._delete = function (id) {

        if (!window.confirm('Are you sure delete this item?')) {
            return false;
        }

        var method = 'GET';
        $.ajax({
            type: method,
            dataType: "json",
            data: {id: id},
            url: _options.delete_url,
            success: function (resp) {
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

    return Role;
})();


