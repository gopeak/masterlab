let Filter = (function () {

    let _options = {};

    // constructor
    function Filter (options) {
        _options = options;
    };

    Filter.prototype.getOptions = function () {
        return _options;
    };

    Filter.prototype.fetch = function (id) {

    };

    Filter.prototype.togglePreDefinedFilter = function(_key, action) {
        $.post(_options.togglePreDefinedFilterUrl,{'key':_key, 'action':action},function (result) {
            if (result.ret == '200') {
                notify_success(result.msg);
                window.location.reload();
            } else {
                notify_error(result.msg);
            }
        });
    };


    Filter.prototype.delete = function (id) {
        $.post(_options.delete_url,{id:id},function (result) {
            if (result.ret == '200') {
                notify_success(result.msg);
                window.location.reload();
            } else {
                notify_error(result.msg);
            }
        });
    };

    Filter.prototype.edit = function (id) {
        $.ajax({
            type: 'GET',
            dataType: "json",
            async: true,
            url: _options.fetchFilterUrl,
            data: {id: id},
            success: function (resp) {
                auth_check(resp);
                if (resp.ret == 200) {
                    $('#form_filter_id').val(resp.data.id);
                    $('#form_filter_name').val(resp.data.name);
                    $('#form_filter_is_show').val(resp.data.is_show);
                    $('#form_filter_order_weight').val(resp.data.order_weight);
                    $('#form_filter_description').val(resp.data.description);
                    $('.selectpicker').selectpicker('refresh');
                } else {
                    notify_error(resp.msg, resp.data);
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    };

    Filter.prototype.update = function () {
        let add_name_obj = $('#form_filter_name');
        if (is_empty(add_name_obj.val())) {
            notify_error('参数错误', '过滤器名称不能为空');
            add_name_obj.focus();
            return;
        }
        $.ajax({
            type: 'POST',
            dataType: "json",
            async: true,
            url: _options.updateFilterUrl,
            data: $('#form_edit_action').serialize(),
            success: function (resp) {
                auth_check(resp);
                if (resp.ret === "200") {
                    notify_success(resp.msg);
                    Filter.prototype.fetchAll();
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

    Filter.prototype.fetchAll = function () {
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: _options.filter_url,
            data: _options.query_param_obj,
            success: function (resp) {
                auth_check(resp);
                if (resp.data.filters.length) {
                    let source = $('#' + _options.list_tpl_id).html();
                    let template = Handlebars.compile(source);
                    let result = template(resp.data);
                    $('#' + _options.list_render_id).html(result);

                    $(".list_for_edit").bind("click", function () {
                        //window.location.href = project_root_url+'/settings_label_edit?id='+$(this).data('id');
                        Filter.prototype.edit($(this).data('id'));
                    });

                    $(".list_for_show").bind("click", function () {
                        Filter.prototype.togglePreDefinedFilter($(this).data('key'), 'show');
                    });
                    $(".list_for_hide").bind("click", function () {
                        Filter.prototype.togglePreDefinedFilter($(this).data('key'), 'hide');
                    });

                    $(".list_for_delete").bind("click",function () {
                        let filter_id =  $(this).data('id');
                        swal({
                                title: "确认要删除该过滤器？",
                                text: "注:删除后，过滤器是无法恢复的！",
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
                                    Filter.prototype.delete(filter_id);
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
                        message : '过滤器为空',
                        name: 'label',
                        handleHtml: `<a class="btn btn-new js-create-label" data-toggle="modal"  href="#modal-create-label-href">添加过滤器</a>`
                    })
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    };

    return Filter;
})();

