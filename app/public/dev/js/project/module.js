
let Module = (function() {

    let _options = {};

    // constructor
    function Module(  options  ) {
        _options = options;
    };

    Module.prototype.getOptions = function() {
        return _options;
    };

    Module.prototype.fetch = function(id ) {

    };

    Module.prototype.add = function(  ) {

    };

    Module.prototype.delete = function( project_id, module_id ) {
        $.post("/project/module/delete",{project_id: project_id, module_id:module_id},function(result){
            if(result.ret == 200){
                //location.reload();
                notify_success('删除成功');
                //window.location.reload();
                $('#li_data_id_'+module_id).remove();
            } else {
                notify_error('删除失败')
            }
        });
    };

    Module.prototype.edit = function(module_id){
        $.ajax({
            type: 'GET',
            dataType: "json",
            async: true,
            url: "/project/module/fetch_module",
            data: {module_id: module_id},
            success: function (resp) {
                auth_check(resp);
                if(resp.ret == 200){
                    $('#mod_form_id').val(resp.data.id);
                    $('#mod_form_name').val(resp.data.name);
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

    Module.prototype.doedit = function(module_id, name, description){
        $.ajax({
            type: 'POST',
            dataType: "json",
            async: true,
            url: "/project/module/update",
            data: {id: module_id, name: name, description: description},
            success: function (resp) {
                auth_check(resp);
                if(resp.ret == 200){
                    $('#modal-edit-module-href').on('hidden.bs.modal', function (e) {
                        notify_success('操作成功');
                        Module.prototype.fetchAll();
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



    Module.prototype.fetchAll = function(module_name_keyword='') {
        if(module_name_keyword != ''){
            _options.query_param_obj["page"] = 1;
        }
        _options.query_param_obj["name"] = module_name_keyword;
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: _options.filter_url,
            data: _options.query_param_obj,
            success: function (resp) {
                auth_check(resp);
                if (resp.data.modules.length) {
                    let source = $('#'+_options.list_tpl_id).html();
                    let template = Handlebars.compile(source);
                    let result = template(resp.data);
                    //console.log(result);
                    $('#' + _options.list_render_id).html(result);

                    let options = {
                        currentPage: resp.data.page,
                        totalPages: resp.data.pages,
                        onPageClicked: function (e, originalEvent, type, page) {
                            console.log("Page item clicked, type: " + type + " page: " + page);
                            $("#filter_page").val(page);
                            _options.query_param_obj["page"] = page;
                            Module.prototype.fetchAll();
                        }
                    };
                    $('#ampagination-bootstrap').bootstrapPaginator(options);

                    $(".list_for_delete").click(function(){
                        Module.prototype.delete( $(this).data("id"));
                    });

                    $(".project_module_edit_click").bind("click", function () {
                        Module.prototype.edit($(this).data('module_id'));
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

    return Module;
})();

