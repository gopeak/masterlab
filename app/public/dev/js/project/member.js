let Member = (function() {

    let _options = {};

    // constructor
    function Member(  options  ) {
        _options = options;
    };

    Member.prototype.getOptions = function() {
        return _options;
    };

    Member.prototype.fetch = function(id ) {

    };

    Member.prototype.add = function(  ) {

        let user_id = $('#issue_assignee_id').val();
        let role_id = $('#role_select').val();

        let method = 'POST';
        let url = '/project/role/add_project_member_roles';
        $.ajax({
            type: method,
            dataType: "json",
            data: {project_id: window._cur_project_id, user_id:user_id, role_id:role_id},
            url: url,
            success: function (resp) {
                auth_check(resp);
                if( resp.ret == 200 ){
                    //window.location.reload();
                    notify_success(resp.msg);
                } else {
                    notify_error(resp.msg);
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    };


    Member.prototype.fetchAll = function() {
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
                        message : '团队成员为空',
                        name: 'label',
                        handleHtml: `<a class="btn btn-new js-create-label" href="${project_root_url}/settings_project_member">团队成员为空</a>`
                    })
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    };

    Member.prototype.saveMemberRole = function (user_id, project_id) {
        let role_id = $("#selectpicker_uid_" + user_id).val();
        let method = 'POST';
        let url = '/project/role/modify_project_user_has_roles';
        $.ajax({
            type: method,
            dataType: "json",
            data: {user_id:user_id, project_id:project_id, role_id:role_id},
            url: url,
            success: function (resp) {
                auth_check(resp);
                if( resp.ret == 200 ){
                    //window.location.reload();
                    notify_success(resp.msg);
                } else {
                    notify_error(resp.msg);
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    Member.prototype.delMember = function(user_id, project_id, displayname,projectname) {

        swal({
                title: '您确认移除 ' + projectname + ' 的成员 '+ displayname +' 吗?',
                text: "该用户将不能访问此项目",
                html: true,
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "确 定",
                cancelButtonText: "取 消！",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm){
                if (isConfirm) {
                    let method = 'POST';
                    let url = '/project/role/delete_project_user';
                    $.ajax({
                        type: method,
                        dataType: "json",
                        data: {user_id:user_id, project_id:project_id},
                        url: url,
                        success: function (resp) {
                            auth_check(resp);
                            if( resp.ret == 200 ){
                                window.location.reload();
                            } else {
                                notify_error(resp.msg);
                            }
                        },
                        error: function (res) {
                            notify_error("请求数据错误" + res);
                        }
                    });
                }else{
                    swal.close();
                }
            }
        );
    }


    return Member;
})();

