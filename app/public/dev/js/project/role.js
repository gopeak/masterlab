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

        $("#btn-permission_update").click(function () {
            Role.prototype.updatePerm();
        });

        $("#btn-role_user_save").click(function () {
            Role.prototype.addRoleUser();
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

                $(".list_edit_perm").click(function () {
                    Role.prototype.permEdit($(this).data('id'), $(this).data('name'));
                });

                $(".list_add_user").click(function () {
                    Role.prototype.editRoleUser($(this).data("id"));
                });

                $(".list_for_edit").click(function () {
                    Role.prototype.edit($(this).data('id'));
                });

                $(".list_for_delete").click(function () {
                    Role.prototype._delete($(this).data("id"));
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

    Role.prototype.editRoleUser = function (id) {

        $("#modal-role_user").modal();
        $("#role_user-role_id").val(id);
        $('#role_user_list_render_id').html('');
        var method = 'get';
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: _options.role_user_fetch_url,
            data: {role_id: id},
            success: function (resp) {
                if (resp.ret == 200) {
                    var source = $('#role_user_list_tpl').html();
                    var template = Handlebars.compile(source);
                    var result = template(resp.data);
                    $('#role_user_list_render_id').html(result);
                } else {
                    notify_error("请求数据错误:" + resp.msg);
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    Role.prototype.addRoleUser = function () {

        let roleId = $('#role_user-role_id').val();
        let userId = $("input[name='params[select_user]']").val();
        let method = 'post';
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: _options.role_user_add_url,
            data: {role_id: roleId, user_id: userId},
            success: function (resp) {
                if (resp.ret == 200) {
                    notify_success("提示", '操作成功');
                    let source = $('#role_user_list_tpl').html();
                    let template = Handlebars.compile(source);
                    let result = template(resp.data);
                    $('#role_user_list_render_id').html(result);
                } else {
                    notify_error("请求数据错误:" + resp.msg);
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    Role.prototype.permEdit = function (id, name) {

        $("#modal-permission_edit").modal();
        $('#perm_role_id').val(id);
        $("#perm_role_name").val(name);

        var treeContainer = $('#container');
        //清空树状
        treeContainer.data('jstree', false).empty();
        //请求生成
        treeContainer.jstree({
            "plugins": ["checkbox"],
            'core': {
                'data': {
                    "url": _options.tree_url + '?role_id=' + id,
                    "dataType": "json"
                }
            }
        });

        //点击切换
        $('#container').on("changed.jstree", function (e, data) {
            $("#permission_ids").val(data.selected);
        });
        //全选和展开
        $(document).on("click", "#checkall", function () {
            treeContainer.jstree($(this).prop("checked") ? "check_all" : "uncheck_all");
        });
    }

    Role.prototype.updatePerm = function () {

        var method = 'post';
        var params = $('#form_permission_edit').serialize();
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: _options.update_perm_url,
            data: params,
            success: function (resp) {

                if (resp.ret == 200) {
                    notify_success("执行成功");
                    $("#modal-permission_edit").modal('hide')
                } else {
                    notify_error(resp.msg, resp.data);
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


