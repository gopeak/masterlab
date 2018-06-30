$.prototype.serializeObject = function () {
    var a, o, h, i, e;
    a = this.serializeArray();
    o = {};
    h = o.hasOwnProperty;
    for (i = 0; i < a.length; i++) {
        e = a[i];
        if (!h.call(o, e.name)) {
            o[e.name] = e.value;
        }
    }
    return o;
};

var IssueMain = (function () {

    var _options = {};

    var _create_configs = [];
    var _tabs = [];
    var _edit_configs = [];
    var _edit_tabs = [];
    var _fields = [];
    var _field_types = [];
    var _edit_issue = {};
    var _allow_add_status = [];
    var _allow_update_status = [];

    var _active_tab = 'create_default_tab';

    // constructor
    function IssueMain(options) {
        _options = options;

        $("#btn-issue_type_add").click(function () {
            IssueMain.prototype.add();
        });

        $("#btn-issue_type_update").click(function () {
            IssueMain.prototype.update();
        });

    };

    IssueMain.prototype.getOptions = function () {
        return _options;
    };

    IssueMain.prototype.setOptions = function (options) {
        for (i in  options) {
            // if( typeof( _options[options[i]] )=='undefined' ){
            _options[i] = options[i];
            // }
        }
    };

    IssueMain.prototype.updateSysFilter = function (filter) {
        console.log(_options.query_param_obj);
        if (filter == 'all') {
            delete _options.query_param_obj['sys_filter'];
        } else {
            _options.query_param_obj["sys_filter"] = filter;
        }
        console.log(_options.query_param_obj);
    }

    IssueMain.prototype.saveFilter = function (name) {
        console.log(window.gl.DropdownUtils.getSearchQuery());
        var searchQuery = window.gl.DropdownUtils.getSearchQuery();
        if (name != '' && searchQuery != null && searchQuery != '') {
            //alert(searchQuery);
            var params = {format: 'json'};
            $.ajax({
                type: "GET",
                dataType: "json",
                async: true,
                url: '/issue/main/save_filter',
                data: {name: name, filter: encodeURIComponent(searchQuery)},
                success: function (resp) {
                    if (resp.ret == '200') {
                        alert('保存成功');
                        window.qtipApi.hide()
                    } else {
                        alert('保存失败,错误信息:'.resp.msg);
                    }

                },
                error: function (res) {
                    alert("请求数据错误" + res);
                }
            });
        } else {
            alert('参数为空!');
        }

    }


    IssueMain.prototype.initCreateIssueType = function (issue_types, on_change) {

        var issue_types_select = document.getElementById('create_issue_types_select');
        $('#create_issue_types_select').empty();

        var first_issue_type = {};
        for (var i = 0; i < issue_types.length; i++) {
            if (i == 0) {
                first_issue_type = issue_types[i];
            }
            issue_types_select.options.add(new Option(issue_types[i].name, issue_types[i].id));
        }
        if (on_change) {
            $("#create_issue_types_select").bind("change", function () {
                IssueMain.prototype.fetchCreateUiConfig($(this).val(), 'create', issue_types);

            })
        }

        if (first_issue_type) {
            $("#create_issue_types_select").find("option[value='" + first_issue_type.id + "']").attr("selected", true);
            IssueMain.prototype.fetchCreateUiConfig(first_issue_type.id, 'create', issue_types);
        }

        $('.selectpicker').selectpicker('refresh');

    }

    IssueMain.prototype.initEditIssueType = function (issue_type_id, issue_types) {

        var issue_types_select = document.getElementById('edit_issue_types_select');
        $('#edit_issue_types_select').empty();

        for (var i = 0; i < issue_types.length; i++) {
            if (i == 0) {
                first_issue_type = issue_types[i];
            }
            issue_types_select.options.add(new Option(issue_types[i].name, issue_types[i].id));
        }

        if (issue_type_id) {
            $("#edit_issue_types_select").find("option[value='" + issue_type_id + "']").attr("selected", true);
        }

        $('.selectpicker').selectpicker('refresh');

    }

    IssueMain.prototype.onChangeCreateProjectSelected = function (project_id) {

        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: '/issue/main/fetch_issue_type',
            data: {project_id: project_id},
            success: function (resp) {
                IssueMain.prototype.initCreateIssueType(resp.data.issue_types, true);
            },
            error: function (res) {
                alert("请求数据错误" + res);
            }
        });
    }

    IssueMain.prototype.onChangeEditProjectSelected = function (project_id) {

        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: '/issue/main/fetch_issue_type',
            data: {project_id: project_id},
            success: function (resp) {
                IssueMain.prototype.initEditIssueType(resp.data.issue_types, true);
            },
            error: function (res) {
                alert("请求数据错误" + res);
            }
        });
    }

    IssueMain.prototype.fetchIssueMains = function () {

        // url,  list_tpl_id, list_render_id
        var params = {format: 'json'};
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: _options.filter_url,
            data: _options.query_param_obj,
            success: function (resp) {

                _issueConfig.priority = window.priority = resp.data.priority;
                _issueConfig.issue_types = window.issue_type = resp.data.issue_types;
                _issueConfig.issue_status = window.issue_status = resp.data.issue_status;
                _issueConfig.issue_resolve = window.issue_resolve = resp.data.issue_resolve;
                _issueConfig.issue_module = window.issue_module = resp.data.issue_module;
                _issueConfig.users = window.users = resp.data.users;
                _issueConfig.projects = window.projects = resp.data.projects;

                var source = $('#' + _options.list_tpl_id).html();
                var template = Handlebars.compile(source);
                var result = template(resp.data);
                $('#' + _options.list_render_id).html(result);
                console.log(resp.data)
                $('.created_text').each(function (el) {
                    var time = $(this).text().trim()
                    if (time) {
                        $(this).html(moment(time).fromNow())
                    }
                })

                $('.updated_text').each(function (el) {
                    var time = $(this).text().trim()
                    if (time) {
                        $(this).html(moment(time).fromNow())
                    }
                })

                var options = {
                    currentPage: resp.data.page,
                    totalPages: resp.data.pages,
                    onPageClicked: function (e, originalEvent, type, page) {
                        console.log("Page item clicked, type: " + type + " page: " + page);
                        $("#filter_page").val(page);
                        _options.query_param_obj["page"] = page;
                        IssueMain.prototype.fetchIssueMains();
                    }
                }
                $('#ampagination-bootstrap').bootstrapPaginator(options);

                console.log(_issueConfig.issue_types);
                if (_cur_project_id != '') {
                    var issue_types = [];
                    for (key in _issueConfig.issue_types) {
                        issue_types.push(_issueConfig.issue_types[key]);
                    }
                    IssueMain.prototype.initCreateIssueType(issue_types, false);
                }

                $(".issue_edit_href").bind("click", function () {
                    IssueMain.prototype.fetchEditUiConfig($(this).data('issue_id'), 'update');
                });

                $(".issue_copy_href").bind("click", function () {
                    IssueMain.prototype.fetchEditUiConfig($(this).data('issue_id'), 'copy');
                });

                $(".issue_convert_child_href").bind("click", function () {
                    IssueMain.prototype.displayConvertChild($(this).data('issue_id'), 'copy');
                });

                $(".issue_backlog_href").bind("click", function () {
                    IssueMain.prototype.joinBacklog($(this).data('issue_id'));
                });

                $(".issue_sprint_href").bind("click", function () {
                    IssueMain.prototype.displayJoinSprint($(this).data('issue_id'));
                });

                $(".issue_delete_href").bind("click", function () {
                    IssueMain.prototype.displayDelete($(this).data('issue_id'));
                });

                $("#btn-join_sprint").bind("click", function () {
                    var sprint_id = $("input[name='join_sprint']:checked").val();
                    var issue_id = $('#join_sprint_issue_id').val();
                    if (sprint_id) {
                        IssueMain.prototype.joinSprint(sprint_id, issue_id);
                    } else {
                        alert('请选择Sprint');
                    }
                });

                $("#btn-modal_delete").bind("click", function () {
                    var issue_id = $('#children_list_issue_id').val();
                    if (issue_id) {
                        IssueMain.prototype.delete(issue_id);
                    } else {
                        alert('请选择Sprint');
                    }
                });

                $("#btn-convertChild").bind("click", function () {
                    var issue_id = $('#current_issue_id').val();
                    if (issue_id) {
                        IssueMain.prototype.convertChild(issue_id);
                    } else {
                        alert('事项id传递错误');
                    }
                });


            },
            error: function (res) {
                alert("请求数据错误" + res);
            }
        });
    }

    IssueMain.prototype.displayConvertChild = function (issue_id) {

        $('#current_issue_id').val(issue_id);
        $('#btn-parent_select_issue').data('issue-id', issue_id);
        $('#modal-choose_parent').modal('show');
    }

    IssueMain.prototype.convertChild = function (issue_id) {

        var master_id = $("input[name='parent_select_issue_id']").val();
        $.ajax({
            type: 'post',
            dataType: "json",
            async: true,
            url: "/issue/main/convertChild",
            data: {issue_id: issue_id, master_id:master_id},
            success: function (resp) {
                if (resp.ret != '200') {
                    alert('删除失败:' + resp.msg);
                    return;
                }
                alert('操作成功');
                window.location.reload();
            },
            error: function (res) {
                alert("请求数据错误" + res);
            }
        });
    }

    IssueMain.prototype.joinBacklog = function (issue_id) {
        $.ajax({
            type: 'post',
            dataType: "json",
            async: true,
            url: "/agile/joinBacklog",
            data: {issue_id: issue_id},
            success: function (resp) {

                if (resp.ret != '200') {
                    alert('加入 Sprint 失败');
                    return;
                }
                alert('操作成功');
                window.location.reload();
            },
            error: function (res) {
                alert("请求数据错误" + res);
            }
        });
    }

    IssueMain.prototype.displayJoinSprint = function (issue_id) {

        $.ajax({
            type: 'get',
            dataType: "json",
            async: true,
            url: "/agile/fetchSprints",
            data: {project_id: _cur_project_id, issue_id: issue_id},
            success: function (resp) {

                if (resp.ret != '200') {
                    alert('获取Sprints失败:' + resp.msg);
                    return;
                }

                var source = $('#sprint_list_tpl').html();
                var template = Handlebars.compile(source);
                var result = template(resp.data);
                $('#sprint_list_div').html(result);
                $('#join_sprint_issue_id').val(issue_id);
                $('#modal-join_sprint').modal('show');

            },
            error: function (res) {
                alert("请求数据错误" + res);
            }
        });

    }

    IssueMain.prototype.joinSprint = function (sprint_id, issue_id) {

        $.ajax({
            type: 'post',
            dataType: "json",
            async: true,
            url: "/agile/joinSprint",
            data: {sprint_id: sprint_id, issue_id: issue_id},
            success: function (resp) {
                if (resp.ret != '200') {
                    alert('加入 Sprint 失败:' + resp.msg);
                    return;
                }
                alert('操作成功');
                window.location.reload();
            },
            error: function (res) {
                alert("请求数据错误" + res);
            }
        });
    }

    IssueMain.prototype.displayDelete = function (issue_id) {

        $.ajax({
            type: 'get',
            dataType: "json",
            async: true,
            url: "/issue/main/getChildIssues",
            data: {issue_id: issue_id},
            success: function (resp) {

                if (resp.ret != '200') {
                    alert('获取Sprints失败:' + resp.msg);
                    return;
                }

                var source = $('#children_list_tpl').html();
                var template = Handlebars.compile(source);
                var result = template(resp.data);
                $('#children_list_div').html(result);
                $('#children_list_issue_id').val(issue_id);
                $('#modal-children_list').modal('show');

                if (resp.data.children.length > 0) {
                    $('#children_list_title').show();
                    $('#children_empty_state_title').hide();
                    $('#empty_children_state').hide();
                } else {
                    $('#children_list_title').hide();
                    $('#children_empty_state_title').show();
                    $('#empty_children_state').show();

                }

            },
            error: function (res) {
                alert("请求数据错误" + res);
            }
        });

    }

    IssueMain.prototype.delete = function (issue_id) {

        $.ajax({
            type: 'post',
            dataType: "json",
            async: true,
            url: "/issue/main/delete",
            data: {issue_id: issue_id},
            success: function (resp) {
                if (resp.ret != '200') {
                    alert('删除失败:' + resp.msg);
                    return;
                }
                alert('操作成功');
                window.location.reload();
            },
            error: function (res) {
                alert("请求数据错误" + res);
            }
        });
    }

    IssueMain.prototype.fetchCreateUiConfig = function (issue_type_id, issue_types) {

        IssueMain.prototype.initForm();
        var method = 'get';
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: "/issue/main/fetchUiConfig",
            data: {issue_type_id: issue_type_id, project_id: _cur_project_id},
            success: function (resp) {

                _fields = resp.data.fields
                _create_configs = resp.data.configs;
                _tabs = resp.data.tabs;
                _field_types = issue_types;
                _allow_add_status = resp.data.allow_add_status;

                // create default tab
                var default_tab_id = 0;
                var html = IssueForm.prototype.makeCreateHtml(_create_configs, _fields, default_tab_id, _allow_add_status);

                $('#create_default_tab').html(html);

                // create other tab
                for (var i = 0; i < _tabs.length; i++) {
                    var order_weight = parseInt(_tabs[i].order_weight) + 1
                    IssueForm.prototype.uiAddTab('create', _tabs[i].name, order_weight);
                    var html = IssueForm.prototype.makeCreateHtml(_create_configs, _fields, order_weight);
                    var id = '#create_ui_config-create_tab-' + order_weight
                    $(id).html(html);
                }
                if (_tabs.length > 1) {
                    $('#create_header_hr').hide();
                    $('#create_tabs').show();
                } else {
                    $('#create_header_hr').show();
                    $('#create_tabs').hide();
                }

                IssueMain.prototype.refreshForm(false);

                $('#a_create_default_tab').click();

            },
            error: function (res) {
                alert("请求数据错误" + res);
            }
        });
    }

    IssueMain.prototype.add = function () {

        for (k in _simplemde) {
            if (typeof(_simplemde[k]) == 'object') {
                $('#' + k).val(_simplemde[k].value());
            }
        }

        for (k in window._fineUploader) {
            if (typeof(_fineUploader[k]) == 'object') {
                var uploads = _fineUploader[k].getUploads({
                    status: qq.status.UPLOAD_SUCCESSFUL
                });
                var id = k.replace('_uploader', '');
                $('#' + id).val(JSON.stringify(uploads));
            }
        }
        for (k in window._fineUploaderFile) {
            if (typeof(_fineUploaderFile[k]) == 'object') {
                var uploads = _fineUploaderFile[k].getUploads({
                    status: qq.status.UPLOAD_SUCCESSFUL
                });
                var id = k.replace('_uploader', '');
                $('#' + id).val(JSON.stringify(uploads));
            }
        }

        var form_value_objs = $('#create_issue').serializeObject();
        console.log(form_value_objs);
        var method = 'post';
        var post_data = $('#create_issue').serialize();
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: "/issue/main/add",
            data: post_data,
            success: function (resp) {

                console.log(resp);
                if (resp.ret == '200') {
                    alert('保存成功');
                    window.location.reload();
                } else {
                    alert('保存失败,错误信息:'.resp.msg);
                }

            },
            error: function (res) {
                alert("请求数据错误" + res);
            }
        });
    }

    IssueMain.prototype.update = function () {

        for (k in _simplemde) {
            if (typeof(_simplemde[k]) == 'object') {
                $('#' + k).val(_simplemde[k].value());
            }
        }

        for (k in window._fineUploader) {
            if (typeof(_fineUploader[k]) == 'object') {
                var uploads = _fineUploader[k].getUploads({
                    status: qq.status.UPLOAD_SUCCESSFUL
                });
                var id = k.replace('_uploader', '');
                $('#' + id).val(JSON.stringify(uploads));
            }
        }
        for (k in window._fineUploaderFile) {
            if (typeof(_fineUploaderFile[k]) == 'object') {
                var uploads = _fineUploaderFile[k].getUploads({
                    status: qq.status.UPLOAD_SUCCESSFUL
                });
                var id = k.replace('_uploader', '');
                $('#' + id).val(JSON.stringify(uploads));
            }
        }

        var form_value_objs = $('#edit_issue').serializeObject();
        console.log(form_value_objs);
        var method = 'post';
        var post_data = $('#edit_issue').serialize();
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: "/issue/main/update",
            data: post_data,
            success: function (resp) {

                console.log(resp);
                if (resp.ret == '200') {
                    alert('保存成功');
                    window.location.reload();
                } else {
                    alert('保存失败,错误信息:'.resp.msg);
                }

            },
            error: function (res) {
                alert("请求数据错误" + res);
            }
        });
    }


    IssueMain.prototype.initForm = function () {
        //_simplemde = {};

        for (k in _simplemde) {
            _simplemde[k].toTextArea();
            _simplemde[k] = null;
        }
        _simplemde = {};

        for (k in window._fineUploader) {
            //console.log("_fineUploader:"+k);
            //$('#'+k).reset();
            $('#' + k).empty();
            window._fineUploader[k] = null;
        }
        window._fineUploader = {};

        for (k in window._fineUploaderFile) {
            //$('#'+k).reset();
            console.log($('#' + k));
            $('#' + k).empty();
            window._fineUploaderFile[k] = null;
        }
        window._fineUploaderFile = {};
    }


    IssueMain.prototype.refreshForm = function (is_edit) {

        $('.selectpicker').selectpicker('refresh');

        $(".simplemde_text").each(function (i) {
            var id = $(this).attr('id');
            if (typeof(_simplemde[id]) == 'undefined') {
                var mk = new SimpleMDE({
                    element: document.getElementById(id),
                    autoDownloadFontAwesome: false,
                    status: false
                });
                _simplemde[id] = mk;
            }

        })

        new UsersSelect();
        new LabelsSelect();
        new MilestoneSelect();
        IssueForm.prototype.bindNavTabClick();
        var deleteFileEnabled = true;
        if (is_edit) {
            deleteFileEnabled = false;
        }
        $(".fine_uploader_img").each(function (i) {
            var id = $(this).attr('id');
            //if( typeof(window._fineUploader[id])=='undefined' ){
            var uploader = new qq.FineUploader({
                element: document.getElementById(id),
                template: 'qq-template-gallery',
                request: {
                    endpoint: '/issue/main/upload'
                },
                deleteFile: {
                    enabled: deleteFileEnabled,
                    endpoint: "/issue/main/upload_delete"
                },
                validation: {
                    allowedExtensions: ['jpeg', 'jpg', 'gif', 'png']
                }
            });
            window._fineUploader[id] = uploader;
            //}
        })

        $(".fine_uploader_attchment").each(function (i) {
            var id = $(this).attr('id');
            console.log("fine_uploader_attchment:" + id);
            if (typeof(window._fineUploaderFile[id]) == 'undefined') {

                var uploader = new qq.FineUploader({
                    element: document.getElementById(id),
                    template: 'qq-template-gallery',
                    request: {
                        endpoint: '/issue/main/upload'
                    },
                    deleteFile: {
                        enabled: deleteFileEnabled,
                        endpoint: "/issue/main/upload_delete"
                    },
                    validation: {
                        acceptFiles: ['image/*', 'application/xls', 'application/x-7z-compressed', 'application/zip', 'application/x-rar', 'application/vnd.ms-powerpoint', 'application/pdf', 'text/csv', 'application/vnd.openxmlformats-officedocument.spreadsheetml.template', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-excel', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'],
                        allowedExtensions: ['jpeg', 'jpg', 'gif', 'png', '7z', 'zip', 'rar', 'bmp', 'csv', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pdf', 'xlt', 'xltx', 'txt'],
                    }
                });
                window._fineUploaderFile[id] = uploader;
            }

        })

        $(".laydate_input_date").each(function (i) {
            var id = $(this).attr('id');
            laydate.render({
                elem: '#' + id
            });

        });

    }

    IssueMain.prototype.initEditFineUploader = function (issue) {

        // 图片
        for (k in window._fineUploader) {
            if (typeof(_fineUploader[k]) == 'object') {
                if (k.indexOf('edit_') == 0) {
                    var field_name = k.replace('edit_issue_upload_img_', '');
                    field_name = field_name.replace('_uploader', '');
                    var edit_attachment_data = issue[field_name];
                    if (typeof(edit_attachment_data) != 'undefined') {
                        _fineUploader[k].addInitialFiles(edit_attachment_data);
                    }
                }
            }
        }
        // 文件
        for (k in window._fineUploaderFile) {
            if (typeof(_fineUploaderFile[k]) == 'object') {
                if (k.indexOf('edit_') == 0) {
                    var field_name = k.replace('edit_issue_upload_file_', '');
                    field_name = field_name.replace('_uploader', '');
                    var edit_attachment_data = issue[field_name];
                    if (typeof(edit_attachment_data) != 'undefined') {
                        _fineUploaderFile[k].addInitialFiles(edit_attachment_data);
                    }

                }
            }
        }

    }
    IssueMain.prototype.fetchEditUiConfig = function (issue_id, form_type) {

        $('#modal-edit-issue_title').html('编辑事项');
        if (form_type == 'copy') {
            $('#form_type').val('copy');
            $('#modal-edit-issue_title').html('复制事项');
        }
        IssueMain.prototype.initForm();

        $('#edit_issue_id').val(issue_id);
        var method = 'get';
        var type = 'edit';
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: "/issue/main/fetch_issue_edit",
            data: {issue_id: issue_id},
            success: function (resp) {

                _fields = resp.data.fields
                _create_configs = resp.data.configs;
                _tabs = resp.data.tabs;
                _field_types = resp.issue_types;
                _edit_issue = resp.data.issue;

                _issueConfig.priority = resp.data.priority;
                _issueConfig.issue_types = resp.data.issue_types;
                _issueConfig.issue_status = resp.data.issue_status;
                _issueConfig.issue_resolve = resp.data.issue_resolve;
                _issueConfig.issue_module = resp.data.project_module;
                _issueConfig.issue_version = resp.data.project_version;
                _issueConfig.issue_labels = resp.data.issue_labels;

                $('edit_project_id').val(_edit_issue.project_id);
                $('edit_issue_type').val(_edit_issue.issue_type);

                IssueMain.prototype.initEditIssueType(_edit_issue.issue_type, _issueConfig.issue_types);
                //alert(resp.data.configs);
                // create default tab
                var default_tab_id = 0;
                var html = IssueForm.prototype.makeEditHtml(_create_configs, _fields, default_tab_id, _edit_issue);
                $('#edit_default_tab').html(html);
                $('#edit_default_tab').show();

                // create other tab
                for (var i = 0; i < _tabs.length; i++) {
                    var order_weight = parseInt(_tabs[i].order_weight) + 1
                    IssueForm.prototype.uiAddTab('edit', _tabs[i].name, order_weight);
                    var html = IssueForm.prototype.makeEditHtml(_create_configs, _fields, order_weight);
                    var id = '#edit_ui_config-edit_tab-' + order_weight
                    $(id).html(html);
                }
                if (_tabs.length > 1) {
                    $('#edit_tabs').show();
                } else {
                    $('#edit_tabs').hide();
                }

                $('#modal-edit-issue').modal();

                IssueMain.prototype.refreshForm(true);
                IssueMain.prototype.initEditFineUploader(_edit_issue);

            },
            error: function (res) {
                alert("请求数据错误" + res);
            }
        });
    }

    return IssueMain;
})();


