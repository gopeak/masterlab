/**
 * 页面下拉组件添加用户使用
 * @returns {boolean}
 */
function addGlobalPermRoleUser()
{
    var roleId = $('#role_user-role_id').val();
    var userId =  $("#role_user_selected_user_id").val();
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

/**
 *
 * @param id
 * @param user_id
 * @param role_id
 * @returns {boolean}
 */
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

var GlobalPermission = (function () {

    var _options = {};

    // constructor
    function GlobalPermission(options) {
        _options = options;
    }

    GlobalPermission.prototype.getOptions = function () {
        return _options;
    };

    GlobalPermission.prototype.setOptions = function (options) {
        for (var _key in options) {
            _options[_key] = options[_key];
        }
    };

    GlobalPermission.prototype.globalPermEdit = function (global_role_id, name)
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
    };

    GlobalPermission.prototype.globalRoleDelete = function (global_role_id)
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
    };

    GlobalPermission.prototype.globalRoleEdit = function (global_role_id)
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
    };

    GlobalPermission.prototype.globalRoleUserEdit = function (global_role_id)
    {
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
    };

    GlobalPermission.prototype.fetchPermissionGlobalRole = function (url, tpl_id, parent_id)
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
                        GlobalPermission.prototype.globalPermEdit($(this).data('id'), $(this).data('name'));
                    });

                    $(".list_add_user").click(function () {
                        GlobalPermission.prototype.globalRoleUserEdit($(this).data("id"));
                    });

                    $(".list_for_edit").click(function () {
                        GlobalPermission.prototype.globalRoleEdit($(this).data("id"));
                    });

                    $(".list_for_delete").click(function () {
                        GlobalPermission.prototype.globalRoleDelete($(this).data("id"));
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

    return GlobalPermission;
})();