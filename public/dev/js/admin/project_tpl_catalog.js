let ProjectTplCatalog = (function () {

    let _options = {};

    // constructor
    function ProjectTplCatalog (options) {
        _options = options;
        $('#btn-catalog_create').click(function () {
            // $('#form-catalog').resetForm();
            $('#modal-catalog_title').html('新增分类');
            $('#catalog_action').val('add');
            $('#input-catalog-name').val('');
            $('#input-catalog-font_color').val('#0033CC');
            $('#form-catalog .js-label-color-preview').css("background-color", $('#input-catalog-font_color').val());
            $('#textarea-catalog-description').val('');
            window.$catalogAjax.initProjectLabel([]);
            $('#modal-form-catalog').modal('show');
        });
        $('#btn_catalog_create_save').click(function () {
            let action = $('#catalog_action').val();
            if(action==='add'){
                window.$catalogAjax.add();
            }else{
                window.$catalogAjax.update();
            }
        });
        $('#form-catalog .suggest-colors a').click(function () {
            $('#input-catalog-font_color').val($(this).data("color"));
            $('#form-catalog .js-label-color-preview').css("background-color", $(this).data("color"));
        });

    };

    ProjectTplCatalog.prototype.getOptions = function () {
        return _options;
    };

    ProjectTplCatalog.prototype.fetch = function (id) {

    };


    ProjectTplCatalog.prototype.add = function () {
        let el_form = $('#form-catalog');
        $.ajax({
            type: 'POST',
            dataType: "json",
            async: true,
            url: _options.add_url,
            data: el_form.serialize(),
            success: function (resp) {
                auth_check(resp);
                if (resp.ret === "200") {
                    notify_success(resp.msg, resp.data);
                    ProjectTplCatalog.prototype.fetchAll();
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

    ProjectTplCatalog.prototype.delete = function ( id) {

        $.ajax({
            type: 'POST',
            dataType: "json",
            async: true,
            url: _options.delete_url,
            data: {id: id},
            success: function (resp) {
                auth_check(resp);
                loading.closeAll();
                if (resp.ret == '200') {
                    notify_success(resp.msg, resp.data);
                    $('#project_catalog_'+id).remove();
                } else {
                    notify_error(resp.msg, resp.data);
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });

    };

    ProjectTplCatalog.prototype.edit = function (id) {
        $('#modal-form-catalog').modal('show');
        $('#action').val('update');
        $('#catalog_id').val(id);
        $('#modal-catalog_title').html('编辑分类');
        loading.show('#modal-body');
        $.ajax({
            type: 'GET',
            dataType: "json",
            async: true,
            url: _options.get_url,
            data: {id: id},
            success: function (resp) {
                auth_check(resp);
                loading.closeAll();
                if (resp.ret == '200') {
                    $('#input-catalog-name').val(resp.data.name);
                    ProjectTplCatalog.prototype.initProjectLabel(resp.data.label_id_json);
                    $('#input-catalog-font_color').val(resp.data.font_color);
                    $('#textarea-catalog-description').text(resp.data.description);
                    $('#input-catalog-order_weight').val(resp.data.order_weight);
                } else {
                    notify_error(resp.msg, resp.data);
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    };

    ProjectTplCatalog.prototype.update = function () {
        let el_form = $('#form-catalog');
        $.ajax({
            type: 'POST',
            dataType: "json",
            async: true,
            url: _options.update_url,
            data: el_form.serialize(),
            success: function (resp) {
                auth_check(resp);
                if (resp.ret === "200") {
                    notify_success(resp.msg, resp.data);
                    ProjectTplCatalog.prototype.fetchAll();
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


    ProjectTplCatalog.prototype.initProjectLabel = function (label_id_arr) {
        // console.log(label_id_arr)
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: window.label_options.filter_url,
            data: {},
            success: function (resp) {
                auth_check(resp);
                if (resp.data.labels.length) {
                    let el_select = $('#select-label_id_arr');
                    el_select.empty();
                    for (let i=0; i< resp.data.labels.length;i++) {
                        let row = resp.data.labels[i];
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
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });



    };

    ProjectTplCatalog.prototype.fetchAll = function () {
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: _options.filter_url,
            data: {},
            success: function (resp) {
                auth_check(resp);
                if (resp.data.catalogs.length) {

                    let source = $('#' + _options.list_tpl_id).html();
                    let template = Handlebars.compile(source);
                    let result = template(resp.data);
                    $('#' + _options.list_render_id).html(result);
                    for(let i=0;i<resp.data.catalogs.length; i++){
                        let labels_html = '';
                        let  label_arr = JSON.parse(resp.data.catalogs[i]['label_id_json']);
                        if(label_arr){
                            for(let j=0;j<label_arr.length; j++){
                                let label = getArrayValue(resp.data.labels, 'id', label_arr[j]);
                                console.log(label)
                                if(label){
                                    labels_html += '<a class=" " style="margin-left:6px;color:gray">'+label['title']+'</a>';
                                }
                            }
                        }
                        $('#catalog-labels-html-'+resp.data.catalogs[i].id).html(labels_html);
                    }
                    $(".catalog_edit_link").bind("click", function () {
                        //window.location.href = project_root_url+'/settings_label_edit?id='+$(this).data('id');
                        ProjectTplCatalog.prototype.edit($(this).data('id'));
                    });

                    $(".catalog_edit_remove").bind("click",function () {
                        let catalog_id =  $(this).data('id');
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
                                    ProjectTplCatalog.prototype.delete(catalog_id);
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

    return ProjectTplCatalog;
})();

