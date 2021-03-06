var ProjectRoles = (function () {

    var _options = {};

    // constructor
    function ProjectRoles(options) {
        _options = options;

        $("#btn-role_add").click(function () {
            ProjectRoles.prototype.add();
        });

        $("#btn-update").click(function () {
            ProjectRoles.prototype.update();
        });

        $("#btn-permission_update").click(function () {
            ProjectRoles.prototype.updatePerm();
        });

    };

    ProjectRoles.prototype.getOptions = function () {
        return _options;
    };

    ProjectRoles.prototype.setOptions = function (options) {
        for (i in  options) {
            // if( typeof( _options[options[i]] )=='undefined' ){
            _options[i] = options[i];
            // }
        }
    };

    ProjectRoles.prototype.fetchProjectRoles = function () {

        // url,  list_tpl_id, list_render_id
        var params = {format: 'json'};
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: _options.filter_url,
            data: {},
            success: function (resp) {
                auth_check(resp);
                return;
                if (resp.data.roles.length) {
                    var source = $('#' + _options.list_tpl_id).html();
                    var template = Handlebars.compile(source);
                    var result = template(resp.data);
                    $('#' + _options.list_render_id).html(result);


                    $(".list_add_user").click(function () {
                        ProjectRoles.prototype.editProjectRolesUser($(this).data("id"));
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

    ProjectRoles.prototype.edit = function (id) {

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

    ProjectRoles.prototype.initUsersSelect = function (users, join_users) {
        //console.log(prioritys)
        var issue_types_select = document.getElementById('role_user_selected_user_id');
        $('#role_user_selected_user_id').empty();
        var joinUserIdArr = [];
        for (var _key in  join_users) {
            var row = join_users[_key];
            var id = row.uid;
            joinUserIdArr.push(id);
        }
        var empty = "<option  value=''>请选择</option>";
        $('#role_user_selected_user_id').append(empty);
        for (var _key=0; _key<users.length;_key++ ) {
            var row = users[_key];
            var id = row.uid;
            if(_.indexOf(joinUserIdArr, id)===-1){
                var title = row.display_name;
                var avatar = row.avatar;
                var content ='data-content="<img class=\'float-none\' width=\'26px\' height=\'26px\'   style=\'border-radius: 50%;\' src=\''+avatar+'\'> '+title+'"';
                var opt = "<option "+content+" value='"+id+"'>"+title+"</option>";
                $('#role_user_selected_user_id').append(opt);
            }
        }
        $('.selectpicker').selectpicker('refresh');
    }

    ProjectRoles.prototype.addRoleUser = function () {
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
                    isChanged = true;
                    notify_success("提示", '操作成功');
                    let source = $('#role_user_list_tpl').html();
                    let template = Handlebars.compile(source);
                    let result = template(resp.data);
                    $('#role_user_list_render_id').html(result);

                    $(".role_user_remove").click(function () {
                        ProjectRoles.prototype._deleteProjectRolesUser($(this).data("id"), $(this).data("user_id"), $(this).data("project_id"), $(this).data("role_id"));
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

    ProjectRoles.prototype.editProjectRolesUser = function (id) {

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
                    ProjectRoles.prototype.initUsersSelect(resp.data.users);
                    var source = $('#role_user_list_tpl').html();
                    var template = Handlebars.compile(source);
                    var result = template(resp.data);
                    $('#role_user_list_render_id').html(result);

                    $(".role_user_remove").click(function () {
                        ProjectRoles.prototype._deleteProjectRolesUser($(this).data("id"), $(this).data("user_id"), $(this).data("project_id"), $(this).data("role_id"));
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

    ProjectRoles.prototype.addProjectRolesUser = function () {
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
                        ProjectRoles.prototype._deleteProjectRolesUser($(this).data("id"), $(this).data("user_id"), $(this).data("project_id"), $(this).data("role_id"));
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


    ProjectRoles.prototype.add = function () {

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

    ProjectRoles.prototype.update = function () {

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

    ProjectRoles.prototype._delete = function (id) {
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
                    window.location.reload();
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    ProjectRoles.prototype._deleteProjectRolesUser = function (id, user_id, project_id, role_id) {
        if (!window.confirm('您确认删除该项吗?')) {
            return false;
        }
        console.log($("li[data-user-id='0'] a")[0]);
        let method = 'POST';
        $.ajax({
            type: method,
            dataType: "json",
            data: {id: id, user_id: user_id, project_id: project_id, role_id: role_id},
            url: _options.delete_role_user_url,
            success: function (resp) {
                auth_check(resp);
                notify_success(resp.msg);
                if (resp.ret == 200) {
                    isChanged = true;
                    $('#role_user_id_'+id).remove();
                    //$("li[data-user-id='0'] a")[0].click();
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    return ProjectRoles;
})();


