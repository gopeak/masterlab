

function fetchSetting(url, module, tpl_id, parent_id)
{
    var params = {  module:module, format:'json' };
    $.ajax({
        type: "GET",
        dataType: "json",
        async: true,
        url: url,
        data: params ,
        success: function (resp) {
            auth_check(resp);
            if (resp.data.settings.length) {
                var source = $('#'+tpl_id).html();
                var template = Handlebars.compile(source);

                Handlebars.registerHelper("equal", function (v1, v2, options) {
                    if (v1 == v2) {
                        return options.fn(this);
                    } else {
                        return options.inverse(this);
                    }
                });

                var result = template(resp.data);

                $('#' + parent_id).html(result);
            } else {
                var emptyHtml = defineStatusHtml({
                    wrap: '#' + parent_id,
                    message : '数据为空',
                    type: 'image'
                });
            }
        },
        error: function (resp) {
            notify_error("请求数据错误" + resp);
        }
    });
}

function fetchNotifySchemeData(url, tpl_id, parent_id)
{

    var params = {format:'json'};
    $.ajax({
        type: "GET",
        dataType: "json",
        async: true,
        url: url,
        data: params ,
        success: function (res) {

            auth_check(res);

            var source = $('#'+tpl_id).html();
            var template = Handlebars.compile(source);
            var result = template(res.data);

            $('#' + parent_id).html(result);
        },
        error: function (res) {
            notify_error("请求数据错误" + res);
        }
    });
}

function fetchProjectRoles(url, tpl_id, parent_id )
{

    var params = {format:'json'};
    $.ajax({
        type: "GET",
        dataType: "json",
        async: true,
        url: url,
        data: params ,
        success: function (res) {
            auth_check(res);
            var source = $('#'+tpl_id).html();
            var template = Handlebars.compile(source);
            var result = template(res.data);

            $('#' + parent_id).html(result);
        },
        error: function (res) {
            notify_error("请求数据错误" + res);
        }
    });
}


function projectRolesAdd()
{
    var method = 'post';
    var url = root_url+'admin/system/project_role_add';
    var params = $('#form_add').serialize();
    $.ajax({
        type: method,
        dataType: "json",
        async: true,
        url: url,
        data: params ,
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

function projectRolesDelete(id)
{
    var method = 'GET';
    var url = root_url+'admin/system/project_role_delete/'+id;
    $.ajax({
        type: method,
        dataType: "json",
        url: url,
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

function fetchPermissionGlobal(url, tpl_id, parent_id)
{
    var params = {   format:'json' };
    $.ajax({
        type: "GET",
        dataType: "json",
        async: true,
        url: url,
        data: params ,
        success: function (resp) {
            auth_check(resp);
            if (resp.data.groups.length) {
                var source = $('#'+tpl_id).html();
                var template = Handlebars.compile(source);
                var result = template(resp.data);
                $('#' + parent_id).html(result);

                var select_perm_tpl = $('#select_perm_tpl').html();
                template = Handlebars.compile(select_perm_tpl);
                result = template(resp.data);
                $('#select_perm').html(result);

                var select_group_tpl = $('#select_group_tpl').html();
                template = Handlebars.compile(select_group_tpl);
                result = template(resp.data);
                $('#select_group').html(result);
            } else {
                var emptyHtml = defineStatusHtml({
                    message : '暂无数据',
                    type: 'image',
                    wrap: '#render'
                });
            }
        },
        error: function (res) {
            notify_error("请求数据错误" + res);
        }
    });
}

function permissionGlobalAdd()
{
    var method = 'post';
    var url = root_url+'admin/permission/global_permission_group_add';
    var params = $('#form_add').serialize();
    $.ajax({
        type: method,
        dataType: "json",
        async: true,
        url: url,
        data: params ,
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

function permissionGlobalDelete(id)
{

    if (!window.confirm('您确认删除该项吗?')) {
        return false;
    }

    var method = 'GET';
    var url = root_url+'admin/permission/global_permission_group_delete/?id='+id;
    $.ajax({
        type: method,
        dataType: "json",
        url: url,
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


function globalPermEdit(global_role_id, name)
{
    var ajaxUrl = "/admin/permission/perm_tree?role_id=" + global_role_id;
    $("#modal-permission_edit").modal();
    $('#perm_role_id').val(global_role_id);
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
                "url": ajaxUrl,
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

function globalRoleDelete(global_role_id)
{
    if (!window.confirm('您确认删除该项吗?')) {
        return false;
    }

    var ajaxUrl = "/admin/permission/global_permission_role_delete?role_id=" + global_role_id;
    var method = 'GET';
    $.ajax({
        type: method,
        dataType: "json",
        data: {role_id: global_role_id},
        url: ajaxUrl,
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

function globalRoleEdit(global_role_id)
{
    var ajaxUrl = "/admin/permission/get_global_permission_role?role_id=" + global_role_id;
    var method = 'get';
    $.ajax({
        type: method,
        dataType: "json",
        async: true,
        url: ajaxUrl,
        data: {role_id: global_role_id},
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

function globalRoleUserEdit(global_role_id)
{
    //new UsersSelect();
    $("#modal-role_user").modal();
    $("#role_user-role_id").val(global_role_id);
    $('#role_user_list_render_id').html('');

    var method = 'get';
    $.ajax({
        type: method,
        dataType: "json",
        async: true,
        url: "/admin/permission/fetch_global_perm_role_users",
        data: {role_id: global_role_id},
        success: function (resp) {
            auth_check(resp);
            if (resp.ret == 200) {
                var source = $('#role_user_list_tpl').html();
                var template = Handlebars.compile(source);
                var result = template(resp.data);
                $('#role_user_list_render_id').html(result);

                $(".role_user_remove").click(function () {
                    deleteGlobalPermRoleUser($(this).data("id"), $(this).data("user_id"), $(this).data("role_id"));
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

function addGlobalPermRoleUser()
{
    var roleId = $('#role_user-role_id').val();
    var userId =  $("input[name='params[select_user]']").val();

    if (is_empty(userId) || userId==0) {
        return false;
    }
    var method = 'post';
    // alert(userId);
    $.ajax({
        type: method,
        dataType: "json",
        async: true,
        url: "/admin/permission/addGlobalPermRoleUser",
        data: {role_id: roleId, user_id: userId},
        success: function (resp) {
            auth_check(resp);
            if (resp.ret == 200) {
                notify_success("提示", '操作成功');
                var source = $('#role_user_list_tpl').html();
                var template = Handlebars.compile(source);
                var result = template(resp.data);
                $('#role_user_list_render_id').html(result);

                $(".role_user_remove").click(function () {
                    deleteGlobalPermRoleUser($(this).data("id"), $(this).data("user_id"), $(this).data("role_id"));
                });
            } else {
                notify_error(resp.msg);
            }
        },
        error: function (res) {
            notify_error("请求数据错误" + res);
        }
    });
}

function deleteGlobalPermRoleUser(id, user_id, role_id)
{
    if (!window.confirm('您确认删除该项吗?')) {
        return false;
    }
    console.log($("li[data-user-id='0'] a")[0]);
    let method = 'POST';
    $.ajax({
        type: method,
        dataType: "json",
        data: {id: id, user_id: user_id, role_id: role_id},
        url: "/admin/permission/deleteGlobalPermRoleUser",
        success: function (resp) {
            auth_check(resp);
            notify_success(resp.msg);
            if (resp.ret == 200) {
                $('#role_user_id_'+id).remove();
                $("li[data-user-id='0'] a")[0].click();
            }
        },
        error: function (res) {
            notify_error("请求数据错误" + res);
        }
    });
}


function fetchPermissionGlobalRole(url, tpl_id, parent_id)
{
    var params = {format:'json'};
    $.ajax({
        type: "GET",
        dataType: "json",
        async: true,
        url: url,
        data: params ,
        success: function (resp) {
            auth_check(resp);
            if (resp.data.roles.length) {
                var source = $('#'+tpl_id).html();
                var template = Handlebars.compile(source);
                var result = template(resp.data);
                $('#' + parent_id).html(result);

                $(".list_edit_perm").click(function () {
                    globalPermEdit($(this).data('id'), $(this).data('name'));
                });

                $(".list_add_user").click(function () {
                    globalRoleUserEdit($(this).data("id"));
                });

                $(".list_for_edit").click(function () {
                    globalRoleEdit($(this).data("id"));
                });

                $(".list_for_delete").click(function () {
                    globalRoleDelete($(this).data("id"));
                });
            } else {
                var emptyHtml = defineStatusHtml({
                    message : '暂无数据',
                    type: 'image',
                    wrap: '#render'
                });
            }
        },
        error: function (res) {
            notify_error("请求数据错误" + res);
        }
    });
}


$(function () {

    if ("undefined" != typeof Handlebars.registerHelper) {
        Handlebars.registerHelper('if_eq', function (v1, v2, opts) {
            if (v1 == v2) {
                return opts.fn(this);
            } else {
                return opts.inverse(this);
            }

        });

        // 是否在数组中
        Handlebars.registerHelper('if_in_array', function (element, arr, options) {
            for (v of arr) {
                if (v === element) {
                    //则包含该元素
                    return options.fn(this);
                }
            }
            return options.inverse(this);
        });
    }

    if ("undefined" != typeof $('.colorpicker-component').colorpicker) {
        $('.colorpicker-component').colorpicker({ /*options...*/ });
    }

    $("#btn-role_add").click(function () {
        var method = 'post';
        var params = $('#form_add').serialize();
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: "/admin/permission/global_permission_role_add",
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
    });

    $("#btn-update").click(function () {
        var method = 'post';
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: "/admin/permission/global_permission_role_update",
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
    });

    $(".btn-save").click(function () {

        var method = 'post';
        var url = '';

        method =  $(this).closest('form').attr('method') ;
        url =  $(this).closest('form').attr('action') ;
        var params = $(this).closest('form').serialize();
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: url,
            data: params ,
            success: function (resp) {
                auth_check(resp);
                notify_success(resp.msg);
                setTimeout("window.location.reload();", 2000)
            },
            error: function (resp) {
                notify_error("请求数据错误" + resp);
            }
        });

    });

    $(".btn-remove").click(function () {

        var method = 'post';
        var url = '';

        method =  $(this).closest('form').attr('method') ;
        url =  $(this).closest('form').attr('action') ;
        var params = $(this).closest('form').serialize();
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: url,
            data: params ,
            success: function (resp) {
                auth_check(resp);
                notify_success(resp.msg);
                if (resp.ret == 200) {
                    window.location.reload();
                }
            },
            error: function (resp) {
                notify_error("请求数据错误" + resp);
            }
        });

    });

    $("#submit-all").on("click", function () {
        setTimeout(function () {
            window.location.reload();
        }, 300);
    });

});

