
let Version = (function() {

    let _options = {};

    // constructor
    function Version(  options  ) {
        _options = options;
    };

    Version.prototype.getOptions = function() {
        return _options;
    };

    Version.prototype.fetch = function(id) {

    };


    Version.prototype.add = function() {

    };

    Version.prototype.release = function(project_id, version_id) {
        $.post("/project/version/release",{project_id: project_id, version_id:version_id},function(result){
            if(result.ret == 200){
                notify_success('发布成功');
                Version.prototype.fetchAll();
            } else {
                notify_error('failed');
                console.log(result);
            }

        });
    };

    Version.prototype.delete = function(project_id, version_id) {
        $.post("/project/version/delete",{project_id: project_id, version_id:version_id},function(result){
            if(result.ret == 200){
                //location.reload();
                notify_success('删除成功');
                $('#li_data_id_'+version_id).remove();
            } else {
                notify_error('删除失败');
            }
        });
    };

    Version.prototype.edit = function(version_id){
        $.ajax({
            type: 'GET',
            dataType: "json",
            async: true,
            url: "/project/version/fetch_version",
            data: {version_id: version_id},
            success: function (resp) {
                auth_check(resp);
                if(resp.ret == 200){
                    $('#ver_form_id').val(resp.data.id);
                    $('#ver_form_name').val(resp.data.name);
                    $('#ver_form_start_date').val(resp.data.start_date);
                    $('#ver_form_release_date').val(resp.data.release_date);
                    $('#ver_form_description').val(resp.data.description);
                } else {
                    notify_error('数据获取失败');
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    };

    Version.prototype.doedit = function(version_id, name, description, start_date, release_date){
        $.ajax({
            type: 'POST',
            dataType: "json",
            async: true,
            url: "/project/version/update",
            data: {id: version_id, name: name, description: description, start_date:start_date, release_date:release_date},
            success: function (resp) {
                auth_check(resp);
                if(resp.ret == 200){
                    $('#modal-edit-version-href').on('hidden.bs.modal', function (e) {
                        notify_success('操作成功');
                        Version.prototype.fetchAll();
                    });
                    $('#modal-edit-version-href').modal('hide');
                } else {
                    notify_error('error');
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });

    };



    Version.prototype.fetchAll = function(version_name_keyword = '') {
        if(version_name_keyword != ''){
            _options.query_param_obj["page"] = 1;
        }
        _options.query_param_obj["name"] = version_name_keyword;
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: _options.filter_url,
            data: _options.query_param_obj,
            success: function (resp) {
                auth_check(resp);
                if (resp.data.versions.length) {
                    let source = $('#'+_options.list_tpl_id).html();
                    let template = Handlebars.compile(source);

                    Handlebars.registerHelper('if_eq', function(v1, v2, opts) {
                        if(v1 == v2)
                            return opts.fn(this);
                        else
                            return opts.inverse(this);
                    });


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
                            Version.prototype.fetchAll();
                        }
                    };
                    $('#ampagination-bootstrap').bootstrapPaginator(options);



                    $(".list_for_delete").click(function(){
                        Version.prototype.delete( $(this).data("id"));
                    });

                    $(".project_version_edit_click").bind("click", function () {
                        Version.prototype.edit($(this).data('version_id'));
                    });
                } else {
                    defineStatusHtml({
                        wrap: '#' + _options.list_render_id,
                        message : '版本为空',
                        name: "version"
                    });
                }

            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    };

    return Version;
})();

