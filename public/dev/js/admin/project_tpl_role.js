var ProjectTplRole = (function () {

    var _options = {};

    // constructor
    function ProjectTplRole(options) {
        _options = options;

        $("#btn-role_add").click(function () {
            ProjectTplRole.prototype.add();
        });

        $("#btn-role-update").click(function () {
            ProjectTplRole.prototype.update();
        });

        $("#btn-permission_update").click(function () {
            ProjectTplRole.prototype.updatePerm();
        });

    };

    ProjectTplRole.prototype.getOptions = function () {
        return _options;
    };

    ProjectTplRole.prototype.setOptions = function (options) {
        for (i in  options) {
            // if( typeof( _options[options[i]] )=='undefined' ){
            _options[i] = options[i];
            // }
        }
    };

    ProjectTplRole.prototype.fetchAll = function () {

        // url,  list_tpl_id, list_render_id
        // alert(_options.filter_url);
        var params = {format: 'json'};
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: _options.filter_url,
            data: $('#' + _options.filter_form_id).serialize(),
            success: function (resp) {
                auth_check(resp);
                if (resp.data.roles.length) {
                    var source = $('#' + _options.list_tpl_id).html();
                    var template = Handlebars.compile(source);
                    var result = template(resp.data);
                    console.log(result);
                    $('#' + _options.list_render_id).html(result);

                    $(".list_edit_perm").click(function () {
                        ProjectTplRole.prototype.permEdit($(this).data('id'), $(this).data('name'));
                    });

                    $(".list_for_edit").click(function () {
                        ProjectTplRole.prototype.edit($(this).data('id'));
                    });

                    $(".list_for_delete").click(function () {
                        ProjectTplRole.prototype._delete($(this).data("id"));
                    });
                } else {
                    defineStatusHtml({
                        wrap: '#' + _options.list_render_id,
                        message : '角色为空'
                    });
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    ProjectTplRole.prototype.edit = function (id) {
        $("#modal-role_edit").modal();
        var method = 'get';
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: _options.get_url,
            data: {id: id},
            success: function (resp) {
                auth_check(resp);
                if (resp.ret == 200) {
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

    ProjectTplRole.prototype.editProjectTplRoleUser = function (id) {

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
                auth_check(resp);
                if (resp.ret == 200) {
                    var source = $('#role_user_list_tpl').html();
                    var template = Handlebars.compile(source);
                    var result = template(resp.data);
                    $('#role_user_list_render_id').html(result);

                    $(".role_user_remove").click(function () {
                        ProjectTplRole.prototype._deleteProjectTplRoleUser($(this).data("id"), $(this).data("user_id"), $(this).data("project_id"), $(this).data("role_id"));
                    });
                } else {
                    notify_error("请求数据错误:" + resp.msg);
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    ProjectTplRole.prototype.addProjectTplRoleUser = function () {


        var roleId = $('#role_user-role_id').val();
        var userId =  $("#role_user_selected_user_id").val();

        if(is_empty(userId) || userId==0){
            return false;
        }
        let method = 'post';
       // alert(userId);
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: _options.role_user_add_url,
            data: {role_id: roleId, user_id: userId},
            success: function (resp) {
                auth_check(resp);
                if (resp.ret == 200) {
                    notify_success("提示", '操作成功');
                    let source = $('#role_user_list_tpl').html();
                    let template = Handlebars.compile(source);
                    let result = template(resp.data);
                    $('#role_user_list_render_id').html(result);

                    $(".role_user_remove").click(function () {
                        ProjectTplRole.prototype._deleteProjectTplRoleUser($(this).data("id"), $(this).data("user_id"), $(this).data("project_id"), $(this).data("role_id"));
                    });
                } else {
                    notify_error( resp.msg );
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    ProjectTplRole.prototype.permEdit = function (id, name) {
        $("#modal-permission_edit").modal();
        $('#perm_role_id').val(id);
        $("#perm_role_name").val(name);

        var treeContainer = $('#container');
        //清空树状
        treeContainer.data('jstree', false).empty();
        treeContainer.unbind();
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

    ProjectTplRole.prototype.updatePerm = function () {

        var method = 'post';
        var params = $('#form_permission_edit').serialize();
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: _options.update_perm_url,
            data: params,
            success: function (resp) {

                auth_check(resp);
                if (resp.ret == 200) {
                    notify_success("执行成功");
                    $("#modal-permission_edit").modal('hide');
                    //window.location.reload();
                } else {
                    notify_error(resp.msg, resp.data);
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }


    ProjectTplRole.prototype.add = function () {

        var method = 'post';
        var params = $('#form_add_role').serialize();
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: _options.add_url,
            data: params,
            success: function (resp) {
                auth_check(resp);
                if (resp.ret == 200) {
                    $('#role_description').val('');
                    $('#role_name').val('');
                    notify_success(resp.msg);
                    ProjectTplRole.prototype.fetchAll();
                }else{
                    notify_error(resp.msg,resp.data);
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    ProjectTplRole.prototype.update = function () {

        var method = 'post';
        //var params = $('#form_add_role').serialize();
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: _options.update_url,
            data: $('#form_edit').serialize(),
            success: function (resp) {
                auth_check(resp);
                if (resp.ret == 200) {
                    notify_success(resp.msg);
                    $("#modal-role_edit").modal('hide');
                    ProjectTplRole.prototype.fetchAll();
                }else{
                    notify_error(resp.msg,resp.data);
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    ProjectTplRole.prototype._delete = function (id) {
        if (!window.confirm('您确认删除该项吗?')) {
            return false;
        }
        var method = 'GET';
        $.ajax({
            type: method,
            dataType: "json",
            data: {id: id},
            url: _options.delete_url,
            success: function (resp) {
                auth_check(resp);
                notify_success(resp.msg);
                if (resp.ret == 200) {
                    ProjectTplRole.prototype.fetchAll();
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    return ProjectTplRole;
})();


