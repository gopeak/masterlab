
let ProjectTplModule = (function() {

    let _options = {};

    // constructor
    function ProjectTplModule (options) {
        _options = options;
    };

    ProjectTplModule.prototype.getOptions = function () {
        return _options;
    };

    ProjectTplModule.prototype.fetch = function (id) {

    };

    ProjectTplModule.prototype.add = function () {

    };

    ProjectTplModule.prototype.delete = function (project_id, module_id) {
        swal({
                title: "您确定删除吗?",
                text: "你将无法恢复它",
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
                    $.post("/project/module/delete",{project_id: project_id, module_id:module_id}, function (result) {
                        if (result.ret == 200) {
                            //location.reload();
                            notify_success('删除成功');
                            //window.location.reload();
                            $('#li_data_id_'+module_id).remove();
                        } else {
                            notify_error('删除失败');
                        }
                    });
                    swal.close();
                }else{
                    swal.close();
                }
            }
        );

    };

    ProjectTplModule.prototype.edit = function (module_id) {
        $.ajax({
            type: 'GET',
            dataType: "json",
            async: true,
            url: "/project/module/fetch_module",
            data: {module_id: module_id},
            success: function (resp) {
                auth_check(resp);
                if (resp.ret == 200) {
                    $('#mod_form_id').val(resp.data.id);
                    $('#mod_form_name').val(resp.data.name);
                    $('#mod_form_weight').val(resp.data.order_weight);
                    $('#mod_form_description').val(resp.data.description);
                } else {
                    notify_error('数据获取失败');
                }
                //$('#modal-edit-module').modal();

            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    };

    ProjectTplModule.prototype.doedit = function (module_id, name, weight, description) {
        $.ajax({
            type: 'POST',
            dataType: "json",
            async: true,
            url: "/project/module/update",
            data: {id: module_id, name: name, weight: weight, description: description},
            success: function (resp) {
                auth_check(resp);
                if (resp.ret == 200) {
                    $('#modal-edit-module-href').on('hidden.bs.modal', function (e) {
                        notify_success('操作成功');
                        ProjectTplModule.prototype.fetchAll();
                    });
                    $('#modal-edit-module-href').modal('hide');
                } else {
                    notify_error('error');
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });

    };



    ProjectTplModule.prototype.fetchAll = function ( ) {

        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: _options.filter_url,
            data: {},
            success: function (resp) {
                auth_check(resp);
                if (resp.data.modules.length) {
                    let source = $('#'+_options.list_tpl_id).html();
                    let template = Handlebars.compile(source);
                    let result = template(resp.data);
                    //console.log(result);
                    $('#' + _options.list_render_id).html(result);

                    if (resp.data.pages > 1) {
                        let options = {
                            currentPage: resp.data.page,
                            totalPages: resp.data.pages,
                            onPageClicked: function (e, originalEvent, type, page) {
                                console.log("Page item clicked, type: " + type + " page: " + page);
                                $("#filter_page").val(page);
                                _options.query_param_obj["page"] = page;
                                ProjectTplModule.prototype.fetchAll();
                            }
                        };
                        $('#ampagination-bootstrap').bootstrapPaginator(options);
                    }

                    $(".list_for_delete").click(function () {
                        ProjectTplModule.prototype.delete($(this).data("id"));
                    });

                    $(".project_module_edit_click").bind("click", function () {
                        ProjectTplModule.prototype.edit($(this).data('module_id'));
                    });
                } else {
                    defineStatusHtml({
                        wrap: '#' + _options.list_render_id,
                        message : '模块为空',
                        name: 'module'
                    });
                }
            },
            error: function (res) {
                alert("请求数据错误" + res);
            }
        });
    };

    return ProjectTplModule;
})();

