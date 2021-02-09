let Catalog = (function () {

    let _options = {};

    // constructor
    function Catalog (options) {
        _options = options;
    };

    Catalog.prototype.getOptions = function () {
        return _options;
    };

    Catalog.prototype.fetch = function (id) {

    };


    Catalog.prototype.add = function () {
        let el_form = $('#form-catalog');
        $.ajax({
            type: 'POST',
            dataType: "json",
            async: true,
            url: "/project/catalog/add",
            data: el_form.serialize(),
            success: function (resp) {
                auth_check(resp);
                if (resp.ret === "200") {
                    notify_success(resp.msg, resp.data);
                    Catalog.prototype.fetchAll();
                    $('#modal-form-catalog').modal('hide');
                } else {
                    notify_error(resp.msg, resp.data);
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    };

    Catalog.prototype.delete = function (project_id, id) {
        $.post(root_url+"project/catalog/delete",{project_id: project_id, id:id},function (result) {
            if (result.ret == '200') {
                notify_success(result.msg, result.data);
                $('#project_label_'+id).remove();

            } else {
                notify_error(result.msg, result.data);
            }
        });
    };

    Catalog.prototype.edit = function (id) {
        $('#modal-form-catalog').modal('show');
        $('#action').val('update');
        $('#catalog_id').val(id);
        loading.show('#modal-body');
        $.ajax({
            type: 'GET',
            dataType: "json",
            async: true,
            url: "/project/catalog/fetch",
            data: {id: id},
            success: function (resp) {
                auth_check(resp);
                loading.closeAll();
                if (resp.ret == '200') {
                    $('#input-name').val(resp.data.name);
                    Catalog.prototype.initProjectLabel(resp.data.label_id_json);
                    $('#input-font_color').val(resp.data.font_color);
                    $('#textarea-description').text(resp.data.description);
                    $('#input-order_weight').val(resp.data.order_weight);
                } else {
                    notify_error(resp.msg, resp.data);
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    };

    Catalog.prototype.update = function () {
        let el_form = $('#form-catalog');
        $.ajax({
            type: 'POST',
            dataType: "json",
            async: true,
            url: "/project/catalog/update",
            data: el_form.serialize(),
            success: function (resp) {
                auth_check(resp);
                if (resp.ret === "200") {
                    notify_success(resp.msg, resp.data);
                    Catalog.prototype.fetchAll();
                    $('#modal-form-catalog').modal('hide');
                } else {
                    notify_error(resp.msg, resp.data);
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    };


    Catalog.prototype.initProjectLabel = function (label_id_arr) {
        //console.log(label_id_arr)
        let el_select = $('#select-label_id_arr');
        el_select.empty();
        for (let i=0; i< _issueConfig.issue_labels.length;i++) {
            let row = _issueConfig.issue_labels[i];
            let id = row.id;
            let title = row.title;
            let selected = '';
            if(in_array(id, label_id_arr)){
                selected = 'selected';
            }
            let opt = '<option value="' + id + '"  ' + selected + '>' + title + '</option>';
            // console.log(opt)
            el_select.append(opt);
        }
        $('.selectpicker').selectpicker('refresh');

    };

    Catalog.prototype.fetchAll = function () {
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: _options.filter_url,
            data: _options.query_param_obj,
            success: function (resp) {
                auth_check(resp);
                if (resp.data.catalogs.length) {
                    let source = $('#' + _options.list_tpl_id).html();
                    let template = Handlebars.compile(source);
                    let result = template(resp.data);
                    $('#' + _options.list_render_id).html(result);

                    $(".label_edit_link").bind("click", function () {
                        //window.location.href = project_root_url+'/settings_label_edit?id='+$(this).data('id');
                        Catalog.prototype.edit($(this).data('id'));
                    });

                    $(".label_edit_remove").bind("click",function () {
                        let label_id =  $(this).data('id');
                        swal({
                                title: "确认要删除该分类？",
                                text: "注:删除后，分类是无法恢复的！",
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
                                    Catalog.prototype.delete(window._project_id, label_id);
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
                        message : '分类为空',
                        name: 'label',
                        handleHtml: ``
                    })
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    };

    return Catalog;
})();

