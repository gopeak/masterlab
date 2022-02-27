function randomNumber(min, max) {
    return parseInt(Math.random() * (max - min) + min);
}
var Project = (function() {

    var _options = {};

    // constructor
    function Project(options) {
        _options = options;
    }

    Project.prototype.getOptions = function() {
        return _options;
    };

    Project.prototype.setOptions = function( options ) {
        for(var i in  options )  {
            _options[i] = options[i];
        }
    };

    Project.prototype.cloneForm = function (project_id)
    {
        var method = 'get';
        var url = '/admin/project/get/?project_id=' + project_id;
        $('#modal_form_project_id').val(project_id);
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: url,
            data: {},
            success: function (resp) {
                auth_check(resp);
                $("#modal-project_clone").modal();
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    };

    Project.prototype.doClone = function(project_id)
    {
        var method = 'post';
        var url = '/admin/project/clone/?project_id=' + project_id;
        var params = $('#form-project_clone').serialize();
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: url,
            data: params,
            success: function (resp) {
                auth_check(resp);
                if (!form_check(resp)) {
                    return;
                }
                if (resp.ret === '200') {
                    Project.prototype.fetchList('/admin/project/filterData', 'project_tpl', 'render_id', 1, 0);
                    notify_success(resp.msg, '克隆成功');
                    $('#modal-project_clone').modal('hide');
                } else {
                    notify_error('克隆失败,' + resp.msg + ": " + resp.data);
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    };

    Project.prototype.projectRemove = function (projectId, projectTypeId)
    {
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: root_url+"admin/project/delete",
            data: "project_id="+projectId+"&project_type_id="+projectTypeId,
            success: function(resp) {
                auth_check(resp);
                if (resp.ret == 200) {
                    notify_success('删除成功');
                    setTimeout(function () {
                        location.reload();
                    }, 2000);
                } else {
                    notify_error('删除失败: ' + resp.msg);
                }
            },
            error: function(res) {
                notify_error("请求数据错误" + res);
            }
        });
    };

    Project.prototype.projectArchived = function (projectId)
    {
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: root_url+"admin/project/doArchived",
            data: "project_id="+projectId,
            success: function(resp) {
                auth_check(resp);
                if (resp.ret == 200) {
                    notify_success('归档成功');
                    setTimeout(function () {
                        location.reload();
                    }, 2000);
                } else {
                    notify_error('归档失败: ' + resp.msg);
                }
            },
            error: function(res) {
                notify_error("请求数据错误" + res);
            }
        });
    };

    Project.prototype.recoverProjectArchived = function (projectId)
    {
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: root_url+"admin/project/doRecoverArchived",
            data: "project_id="+projectId,
            success: function(resp) {
                auth_check(resp);
                if (resp.ret == 200) {
                    notify_success('恢复成功');
                    setTimeout(function () {
                        location.reload();
                    }, 2000);
                } else {
                    notify_error('恢复失败: ' + resp.msg);
                }
            },
            error: function(res) {
                notify_error("请求数据错误" + res);
            }
        });
    };

    Project.prototype.fetchList = function (url, tpl_id, render_id, page, is_archived)
    {
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: url,
            data: "page="+page+"&is_archived="+is_archived,
            success: function(resp) {
                auth_check(resp);
                if(resp.data.rows.length){
                    var source = $('#' + tpl_id).html();
                    var template = Handlebars.compile(source);
                    var result = template(resp.data);
                    $('#' + render_id).html(result);

                    var options = {
                        currentPage: resp.data.page,
                        totalPages: resp.data.pages,
                        onPageClicked: function(e,originalEvent,type,page){
                            console.log("Page item clicked, type: "+type+" page: "+page);
                            Project.prototype.fetchList('/admin/project/filterData', tpl_id, render_id, page, is_archived);
                        }
                    };

                    //取消分页
                    //$('#ampagination-bootstrap').bootstrapPaginator(options);


                    $(".js_admin_do_archived").click(function () {
                        var projectId = $(this).data('id');
                        var projectName = $(this).data('name');
                        var message = "确认是否归档项目: " + projectName;

                        if (window.confirm(message + "？")) {
                            Project.prototype.projectArchived(projectId);
                            Project.prototype.fetchList('/admin/project/filterData', 'project_tpl', 'render_id', 1, 0);
                        } else { // 取消
                        }
                    });

                    $(".js_admin_do_delete").click(function () {
                        var projectId = $(this).data('project_id');
                        var projectTypeId = $(this).data('type');
                        var projectName = $(this).data('name');

                        var message = "确认是否删除项目: " + projectName+"? 删除操作将不可逆转，请谨慎操作!";
                        if (window.confirm(message)) {
                            let a = randomNumber(10, 20);
                            let b = randomNumber(2, 20);
                            let question = a + " + " + b +" = ?";
                            let ret = window.prompt(question);
                            if(parseInt(ret)===(a+b)){
                                Project.prototype.projectRemove(projectId, projectTypeId);
                                //Project.prototype.fetchList('/admin/project/filterData', 'project_tpl', 'render_id', 1, false);
                            }else{
                                alert('回答错误');
                            }
                        }
                    });

                    $(".js_admin_do_delete_archived").click(function () {
                        var projectId = $(this).data('project_id');
                        var projectTypeId = $(this).data('type');
                        var projectName = $(this).data('name');

                        var message = "确认是否删除归档项目: " + projectName;

                        if (window.confirm(message + "？")) {
                            Project.prototype.projectRemove(projectId, projectTypeId);
                            Project.prototype.fetchList('/admin/project/filterData', 'project_tpl', 'render_id', 1, 1);
                        } else { // 取消
                        }
                    });

                    $(".ja_admin_recover_archived").click(function () {
                        var projectId = $(this).data('project_id');
                        var projectName = $(this).data('name');

                        var message = "确认是否恢复项目: " + projectName;
                        if (window.confirm(message + "？")) {
                            Project.prototype.recoverProjectArchived(projectId);
                            Project.prototype.fetchList('/admin/project/filterData', 'project_tpl', 'render_id', 1, 1);
                        } else { // 取消
                        }
                    });

                    $(".js_clone_config").click(function () {
                        Project.prototype.cloneForm($(this).data("project_id"));
                    });

                } else {
                    var emptyHtml = defineStatusHtml({
                        message : '暂无数据',
                        type: 'error',
                        handleHtml: ''
                    });
                    $('#'+render_id).append($('<tr><td colspan="6" id="' + render_id + '_wrap"></td></tr>'));
                    $('#'+render_id + '_wrap').append(emptyHtml.html);
                }
            },
            error: function(res) {
                notify_error("请求数据错误" + res);
            }
        });
    };

    return Project;
})();
