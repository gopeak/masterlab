
let ProjectTplModule = (function() {

    let _options = {};

    // constructor
    function ProjectTplModule (options) {
        _options = options;

        $("#btn-module_add").click(function () {
            ProjectTplModule.prototype.add();
        });

        $("#btn-module-update").click(function () {
            ProjectTplModule.prototype.update();
        });


    };

    ProjectTplModule.prototype.getOptions = function () {
        return _options;
    };


    ProjectTplModule.prototype.add = function () {
        var method = 'post';
        var params = $('#form_add_module').serialize();
        console.log(params)
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: _options.add_url,
            data: params,
            success: function (resp) {
                auth_check(resp);
                notify_success(resp.msg);
                if (resp.ret == 200) {
                    // window.location.reload();
                    $('#module_description').val('');
                    $('#module_name').val('');
                    ProjectTplModule.prototype.fetchAll();
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    };

    ProjectTplModule.prototype.delete = function ( module_id) {
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
                    $.post( _options.delete_url,{id:module_id}, function (result) {
                        if (result.ret == 200) {
                            //location.reload();
                            notify_success('删除成功');
                            ProjectTplModule.prototype.fetchAll();
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
        $("#modal-mudule_edit").modal();
        $.ajax({
            type: 'GET',
            dataType: "json",
            async: true,
            url: _options.get_url,
            data: {id: module_id},
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

    ProjectTplModule.prototype.update = function (module_id, name, weight, description) {
        $.ajax({
            type: 'POST',
            dataType: "json",
            async: true,
            url: _options.update_url,
            data: $('#form-module_edit').serialize(),
            success: function (resp) {
                auth_check(resp);
                if (resp.ret == 200) {
                    notify_success('操作成功');
                    ProjectTplModule.prototype.fetchAll();
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
                    $(".module_list_for_edit").click(function () {
                        ProjectTplModule.prototype.edit($(this).data('id'));
                    });
                    $(".module_list_for_delete").click(function () {
                        ProjectTplModule.prototype.delete($(this).data("id"));
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

