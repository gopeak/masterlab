var Backlog = (function () {

    var _options = {};

    var _sprint_id = -2;

    var _target_type = 'inner';

    // constructor
    function Backlog(options) {
        _options = options;
    };

    Backlog.prototype.getOptions = function () {
        return _options;
    };

    Backlog.prototype.setOptions = function (options) {
        for (i in  options) {
            // if( typeof( _options[options[i]] )=='undefined' ){
            _options[i] = options[i];
            // }
        }
    };

    Backlog.prototype.fetch = function (id) {

        $('#id').val(id);
        var method = 'get';
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: root_url+"agile/backlog/fetch/" + id,
            data: {},
            success: function (resp) {
                auth_check(resp);
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    Backlog.prototype.addSprint = function () {
        $.ajax({
            type: 'post',
            dataType: "json",
            async: true,
            url: root_url+"agile/addSprint",
            data: $('#form_sprint_add').serialize(),
            success: function (resp) {
                auth_check(resp);
                if (resp.ret != '200') {
                    notify_error('创建迭代失败:' + resp.msg);
                    return;
                }
                notify_success('操作成功');
                window.location.reload();
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    Backlog.prototype.updateSprint = function () {
        $.ajax({
            type: 'post',
            dataType: "json",
            async: true,
            url: root_url+"agile/updateSprint",
            data: $('#form_sprint_edit').serialize(),
            success: function (resp) {
                auth_check(resp);
                if (resp.ret != '200') {
                    notify_error('更新迭代失败:' + resp.msg);
                    return;
                }
                notify_success('操作成功');
                window.location.reload();
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    Backlog.prototype.deleteSprint = function (sprint_id) {
        swal({
                title: "确认要删除该迭代？",
                text: "注:删除后迭代中的事项将会移动到待办事项中",
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
                    $.ajax({
                        type: 'post',
                        dataType: "json",
                        async: true,
                        url: root_url+"agile/deleteSprint",
                        data: {sprint_id:sprint_id},
                        success: function (resp) {
                            auth_check(resp);
                            if (resp.ret != '200') {
                                notify_error('删除迭代失败:' + resp.msg);
                                return;
                            }
                            notify_success('操作成功');
                            window.location.reload();
                        },
                        error: function (res) {
                            notify_error("请求数据错误" + res);
                        }
                    });
                }else{
                    swal.close();
                }
            });

    }

    Backlog.prototype.joinSprint = function (issue_id, sprint_id) {
        $.ajax({
            type: 'post',
            dataType: "json",
            async: true,
            url: root_url+"agile/joinSprint",
            data: {issue_id: issue_id, sprint_id: sprint_id},
            success: function (resp) {
                auth_check(resp);
                if (resp.ret != '200') {
                    notify_error('加入 Sprint 失败:' + resp.msg);
                    return;
                }
                $('#backlog_issue_' + issue_id).remove();
                notify_success('操作成功');
                //window.location.reload();
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    Backlog.prototype.joinBacklog = function (issue_id) {
        $.ajax({
            type: 'post',
            dataType: "json",
            async: true,
            url: root_url+"agile/joinBacklog",
            data: {issue_id: issue_id},
            success: function (resp) {
                auth_check(resp);
                if (resp.ret != '200') {
                    notify_error('加入 Backlog 失败:' + resp.msg);
                    return;
                }
                $('#backlog_issue_' + issue_id).remove();
                notify_success('操作成功');
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }
    Backlog.prototype.joinClosed = function (issue_id) {
        $.ajax({
            type: 'post',
            dataType: "json",
            async: true,
            url: root_url+"agile/joinClosed",
            data: {issue_id: issue_id},
            success: function (resp) {
                auth_check(resp);
                if (resp.ret != '200') {
                    notify_error('加入 Backlog 失败:' + resp.msg);
                    return;
                }
                $('#backlog_issue_' + issue_id).remove();
                notify_success('操作成功');
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    Backlog.prototype.updateBacklogSprintWeight = function (issue_id, prev_issue_id, next_issue_id, issue_list_type) {
        $.ajax({
            type: 'post',
            dataType: "json",
            async: true,
            url: root_url+"agile/updateBacklogSprintWeight",
            data: {
                issue_id: issue_id,
                prev_issue_id: prev_issue_id,
                next_issue_id: next_issue_id,
                type: issue_list_type
            },
            success: function (resp) {
                auth_check(resp);
                if (resp.ret != '200') {
                    notify_error(resp.msg);
                    return;
                }
                notify_success('操作成功');
                //window.location.reload();
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }


    Backlog.prototype.setSprintActive = function (sprint_id) {
        $.ajax({
            type: 'post',
            dataType: "json",
            async: true,
            url: root_url+"agile/setSprintActive",
            data: {sprint_id: sprint_id},
            success: function (resp) {
                auth_check(resp);
                if (resp.ret != '200') {
                    notify_error('服务器错误:' + resp.msg);
                    return;
                }
                notify_success('操作成功');
                window.location.reload();
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    Backlog.prototype.fetchAll = function (project_id) {

        // url,  list_tpl_id, list_render_id
        loading.show('#backlog_render_id','加载中');
        var params = {format: 'json'};
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: root_url+"agile/fetch_backlog_issues/" + project_id,
            data: {},
            success: function (resp) {
                auth_check(resp);
                loading.hide('#backlog_render_id');
                if (resp.ret != '200') {
                    notify_error( resp.msg, resp.data);
                    return;
                }

                if (resp.data.issues.length) {
                    $('#backlog_count').html(resp.data.issues.length)
                    var source = $('#backlog_issue_tpl').html();
                    var template = Handlebars.compile(source);
                    var result = template(resp.data);
                    $('#backlog_render_id').html(result);
                } else {
                    defineStatusHtml({
                        wrap: '#backlog_render_id',
                        message : '暂无待办事项',
                        name: 'backlog'
                    });
                }

                $('#backlog_list').show();
                $('#backlog_list').removeClass('hidden');
                $('#closed_list').hide();
                $('#closed_list').addClass('hidden');
                $('#sprint_list').hide();
                $('#sprint_list').addClass('hidden');

            },
            error: function (res) {
                loading.hide('#backlog_render_id');
                notify_error("请求数据错误" + res);
            }
        });
    }

    Backlog.prototype.fetchClosedIssues = function (project_id) {

        // url,  list_tpl_id, list_render_id
        loading.show('#closed_render_id');
        var params = {format: 'json'};
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: root_url+'agile/fetchClosedIssuesByProject',
            data: {id: project_id},
            success: function (resp) {
                auth_check(resp);
                loading.hide('#closed_render_id');
                if (resp.ret != '200') {
                    notify_error('服务器错误:' + resp.msg);
                    return;
                }

                if(resp.data.issues.length) {
                    $('#closed_count').html(resp.data.issues.length)
                    var source = $('#closed_issue_tpl').html();
                    var template = Handlebars.compile(source);
                    var result = template(resp.data);
                    $('#closed_render_id').html(result);
                } else {
                    defineStatusHtml({
                        wrap: '#closed_render_id',
                        message : '没有已关闭的事项',
                        name: 'sprint'
                    });
                }

                $('#backlog_list').hide();
                $('#sprint_list').hide();
                $('#closed_list').show();
                $('#closed_list').removeClass('hidden');

            },
            error: function (res) {
                loading.hide('#closed_render_id');
                notify_error("请求数据错误" + res);
            }
        });
    }

    Backlog.prototype.fetchSprintIssues = function (sprint_id) {

        // url,  list_tpl_id, list_render_id
        var params = {format: 'json'};
        loading.show('#sprint_render_id');
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: root_url+'agile/fetchSprintIssues',
            data: {id: sprint_id,sort_field:window.$sort_field,sort_by:window.$sort_by},
            success: function (resp) {
                auth_check(resp);
                loading.hide('#sprint_render_id');
                if (resp.ret != '200') {
                    console.log('服务器错误:' + resp.msg);
                    return;
                }
                $('.classification-backlog').addClass('hidden');
                $('#sprint_list').removeClass('hidden');

                if(!objIsEmpty(resp.data.sprint)){
                    $('#sprint_name').html(resp.data.sprint.name)
                    $('#sprint_count').html(resp.data.issues.length)

                    var source = $('#sprint_issue_tpl').html();
                    var template = Handlebars.compile(source);
                    var result = template(resp.data);
                    $('#sprint_list').removeClass('hidden');
                    $('#sprint_list').css('display','block')
                    $('#sprint_render_id').html(result);

                }else{
                    // notify_error('当前项目没有迭代');
                    defineStatusHtml({
                        wrap: '#sprint_render_id',
                        message : '当前项目没有迭代',
                        name: 'sprint',
                        handleHtml: '<a class="btn btn-new" data-toggle="modal" data-target="#modal-sprint_add">创建迭代</a>'
                    });
                }

            },
            error: function (res) {
                loading.hide('#sprint_render_id');
                notify_error("请求数据错误" + res);
            }
        });
    }

    Backlog.prototype.fetchSprints = function (project_id) {

        // url,  list_tpl_id, list_render_id
        var params = {format: 'json'};
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: root_url+'agile/fetchSprints/' + project_id,
            data: {},
            success: function (resp) {
                auth_check(resp);
                if (resp.ret != '200') {
                    notify_error('服务器错误:' + resp.msg);
                    return;
                }
                var source = $('#sprints_list_tpl').html();
                var template = Handlebars.compile(source);
                var result = template(resp.data);
                $('#sprints_list_div').html(result);

                Backlog.prototype.dragToSprint();
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    Backlog.prototype.showEditSprint = function (sprint_id) {

        $('#edit_sprint_id').val(sprint_id);
        var params = {format: 'json'};
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: root_url+'agile/fetchSprint/' + sprint_id,
            data: {},
            success: function (resp) {
                if (resp.ret != '200') {
                    notify_error('服务器错误:' + resp.msg);
                    return;
                }

                $('#sprint_edit_name').val(resp.data.name);
                $('#sprint_edit_description').val(resp.data.description);
                $('#sprint_edit_start_date').val(resp.data.start_date);
                $('#sprint_edit_end_date').val(resp.data.end_date);
                $('#modal-sprint_edit').modal();
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }


    Backlog.prototype.dragToSprint = function () {

        var id = ''
        $(".classification-side").on('click', '.classification-item', function () {
            if($(this).hasClass('open')) return;
            var children = $(this).siblings()
            Backlog.prototype.fetchSprintIssues($(this).data('id'));
            $(this).addClass('open')
            children.each(function(i, el){
                if($(el).hasClass('open')) $(el).removeClass('open')
            })
        })

        $(".classification-item, .drag_to_backlog_closed")
            .on('dragenter', function (event) {
                event.preventDefault();
                $(this).addClass("classification-out-line");
                console.log('enter')
            })
            .on('dragover', function (event) {
                event.preventDefault();
                $(this).addClass("classification-out-line");
            })
            .on('drop', function (event) {
                event.preventDefault();
                id = $(this).data('id');
                $(this).removeClass("classification-out-line");
                console.log('drop')
            })
            .on('dragleave', function (event) {
                event.preventDefault();
                console.log('dragleave')
                console.log('sprint_id:' + $(this).data('id'));
                _sprint_id = $(this).data('id');
                _target_type = $(this).data('type');

                $(this).removeClass("classification-out-line");
            })
            .on('mouseleave', function (event) {
                $(this).removeClass("classification-out-line");
            })


        var items = document.getElementsByClassName('classification-backlog-inner');

        if(window._drag_issue_perm) {
            [].forEach.call(items, function (el) {
                Sortable.create(el, {
                    group: 'item',
                    animation: 150,
                    ghostClass: 'classification-out-line',
                    onEnd: function (evt) {
                        console.log('_target_type:' + _target_type);
                        var issue_id = $(evt.item).data('id');
                        var form_type = $(evt.item).data('type');
                        console.log('issue_list_type:', form_type)
                        _sprint_id = parseInt(_sprint_id);
                        if (_target_type == 'sprint') {
                            if (_sprint_id && issue_id) {
                                Backlog.prototype.joinSprint(issue_id, _sprint_id);
                                _sprint_id = null;
                            }
                        }
                        if (_target_type == 'backlog' && issue_id) {
                            Backlog.prototype.joinBacklog(issue_id);
                        }
                        if (_target_type == 'closed' && issue_id) {
                            Backlog.prototype.joinClosed(issue_id);
                        }
                        if (_target_type == 'inner' && form_type != 'closed') {
                            if (issue_id) {
                                var prev_issue_id = $(evt.item).prev().data('id');
                                var next_issue_id = $(evt.item).next().data('id');
                                if (typeof(prev_issue_id) == "undefined") {
                                    prev_issue_id = '0';
                                }
                                if (typeof(next_issue_id) == "undefined") {
                                    next_issue_id = '0';
                                }
                                console.log(prev_issue_id, issue_id, next_issue_id)
                                Backlog.prototype.updateBacklogSprintWeight(issue_id, prev_issue_id, next_issue_id, form_type);
                            }
                        }
                    }
                })
            })
        }
    }

    return Backlog;
})();

