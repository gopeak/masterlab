let ProjectTplLabel = (function () {

    let _options = {};

    // constructor
    function ProjectTplLabel (options) {
        _options = options;
        $('')
    };

    ProjectTplLabel.prototype.getOptions = function () {
        return _options;
    };

    ProjectTplLabel.prototype.fetch = function (id) {

    };

    ProjectTplLabel.prototype.add = function (project_id) {
        let add_name_obj = $('#id_label_title');
        if (is_empty(add_name_obj.val())) {
            notify_error('参数错误', '标签名称不能为空');
            add_name_obj.focus();
            return;
        }
        $.ajax({
            type: 'POST',
            dataType: "json",
            async: true,
            url: _options.add_url,
            data: $('#form_label_create_action').serialize(),
            success: function (resp) {
                auth_check(resp);
                if (resp.ret === "200") {
                    notify_success(resp.msg);
                    ProjectTplLabel.prototype.fetchAll();
                    $('#id_label_title').val('');
                    $('#id_label_description').val('');
                    $('#modal-create-label-href').modal('hide');
                } else {
                    notify_error(resp.msg, resp.data);
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    };

    ProjectTplLabel.prototype.delete = function (project_id, label_id) {
        $.post(_options.delete_url,{project_id: project_id, id:label_id},function (result) {
            if (result.ret == 200) {
                notify_success('删除成功');
                $('#project_label_'+label_id).remove();
               // window.location.reload();
            } else {
                notify_error('删除失败');
            }
        });
    };

    ProjectTplLabel.prototype.create = function () {
        $('#modal-create-label-href').modal('show');
        $('#id_label_id').val('');
        $('#id_label_title').val('');
       //$('.js-label-color-preview').css("background-color", '');
        $('#id_label_bg_color').val('');
        $('#id_label_description').val('');
    };

    ProjectTplLabel.prototype.edit = function (label_id) {
        $.ajax({
            type: 'GET',
            dataType: "json",
            async: true,
            url: _options.get_url,
            data: {id: label_id},
            success: function (resp) {
                auth_check(resp);
                if (resp.ret == 200) {
                    $('#id_label_id').val(resp.data.id);
                    $('#id_label_title').val(resp.data.title);
                    $('.js-label-color-preview').css("background-color", resp.data.bg_color);
                    $('#id_label_bg_color').val(resp.data.bg_color);
                    $('#id_label_description').val(resp.data.description);
                } else {
                    notify_error(resp.msg, resp.data);
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    };

    ProjectTplLabel.prototype.update = function (project_id) {
        let add_name_obj = $('#form_edit_action input[name=title]');
        if (is_empty(add_name_obj.val())) {
            notify_error('参数错误', '标签名称不能为空');
            add_name_obj.focus();
            return;
        }

        $.ajax({
            type: 'POST',
            dataType: "json",
            async: true,
            url: "/project/label/update?project_id="+project_id,
            data: $('#form_edit_action').serialize(),
            success: function (resp) {
                auth_check(resp);
                if (resp.ret === "200") {
                    notify_success(resp.msg);
                    ProjectTplLabel.prototype.fetchAll();
                    $('#modal-edit-label-href').modal('hide');
                } else {
                    notify_error(resp.msg);
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    };

    ProjectTplLabel.prototype.fetchAll = function () {
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: _options.filter_url,
            data: {},
            success: function (resp) {
                auth_check(resp);
                if (resp.data.labels.length) {
                    let source = $('#' + _options.list_tpl_id).html();
                    let template = Handlebars.compile(source);
                    let result = template(resp.data);
                    $('#' + _options.list_render_id).html(result);

                    $(".label_edit_link").bind("click", function () {
                        //window.location.href = project_root_url+'/settings_label_edit?id='+$(this).data('id');
                        $('#modal-create-label-href').modal('show')
                        ProjectTplLabel.prototype.edit($(this).data('id'));
                    });

                    $(".label_edit_remove").bind("click",function () {
                        let label_id =  $(this).data('id');
                        swal({
                                title: "确认要删除该标签？",
                                text: "注:删除后，标签是无法恢复的！",
                                html: true,
                                type: "warning",
                                showCancelButton: true,
                                confirmButtonColor: "#DD6B55",
                                confirmButtonText: "确 定",
                                cancelButtonText: "取 消！",
                                closeOnConfirm: false,
                                closeOnCancel: false
                            },
                            function (isConfirm) {
                                if (isConfirm) {
                                    window.$labels.delete(window._project_id, label_id);
                                    swal.close();
                                } else {
                                    swal.close();
                                }
                            }
                        );
                    });
                } else {
                    defineStatusHtml({
                        wrap: '#' + _options.list_render_id,
                        message : '标签为空',
                        name: 'label',
                        handleHtml: `<a class="btn btn-new js-create-label" data-toggle="modal"  href="#modal-create-label-href">添加标签</a>`
                    })
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    };

    return ProjectTplLabel;
})();

