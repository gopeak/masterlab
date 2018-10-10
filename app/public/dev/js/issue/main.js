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

        //将body变正常
        $('.modal').on('hidden.bs.modal',function(){
            if($('body').hasClass('unmask')){
                $('body').removeClass('unmask');
            }
        });
        $('.modal').on('show.bs.modal',function(){
            IssueMain.prototype.cleanScroll();
            $('#create_issue_simplemde_description').parent().css('height','auto');
            $('#create_issue_upload_file_attachment_uploader').parent().css('height','auto');
        });
        $('.modal .nav.nav-tabs').on('show.bs.tab',function(){
            $('#create_issue_simplemde_description').parent().css('height','auto');
            $('#create_issue_upload_file_attachment_uploader').parent().css('height','auto');
        });
        //关闭左侧面板，以及点击出现左侧面板
        $('#issuable-header').on('click',function(e){
            if($(e.target).hasClass('fa-times')){
                $('.float-right-side').hide();
                $('.maskLayer').addClass('hide');
                $('#list_render_id tr.active').removeClass('active');
            }
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

    //使用此函数让模态框后面的body没有滚动效果
    IssueMain.prototype.cleanScroll=function(){
        //3.关闭模态框将body的overflow改回来
        $('body').addClass('unmask');
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
            //notify_success(searchQuery);
            var params = {format: 'json'};
            $.ajax({
                type: "GET",
                dataType: "json",
                async: true,
                url: '/issue/main/save_filter',
                data: {name: name, filter: encodeURIComponent(searchQuery)},
                success: function (resp) {
                    if (resp.ret == '200') {
                        notify_success('保存成功');
                        window.qtipApi.hide()
                    } else {
                        notify_error('保存失败,错误信息:'+resp.msg);
                    }

                },
                error: function (res) {
                    notify_error("请求数据错误" + res);
                }
            });
        } else {
            notify_error('参数为空!');
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
                notify_error("请求数据错误" + res);
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
                notify_error("请求数据错误" + res);
            }
        });
    };

    IssueMain.prototype.fetchIssueMains = function (getListData) {

        // url,  list_tpl_id, list_render_id
        var params = {format: 'json'};
        loading.show('#' + _options.list_render_id);
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: _options.filter_url,
            data: _options.query_param_obj,
            success: function (resp) {
                if(resp.data.issues.length){
                    loading.show('#' + _options.list_render_id);
                    var source = $('#' + _options.list_tpl_id).html();
                    var template = Handlebars.compile(source);
                    var result = template(resp.data);
                    $('#' + _options.list_render_id).html(result);

                    $('.created_text').each(function (el) {
                        var time = $(this).text().trim();
                        if (time) {
                            $(this).html(moment(time).fromNow())
                        }
                    });

                    $('.updated_text').each(function (el) {
                        var time = $(this).text().trim()
                        if (time) {
                            $(this).html(moment(time).fromNow())
                        }
                    });

                    var options = {
                        currentPage: resp.data.page,
                        totalPages: resp.data.pages,
                        onPageClicked: function (e, originalEvent, type, page) {
                            console.log("Page item clicked, type: " + type + " page: " + page);
                            $("#filter_page").val(page);
                            _options.query_param_obj["page"] = page;
                            IssueMain.prototype.fetchIssueMains();
                        }
                    };
                    $('#ampagination-bootstrap').bootstrapPaginator(options);

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
                    $(".have_children").bind("click", function () {
                        var issue_id = $(this).data('issue_id');
                        $('#tr_subtask_'+issue_id).toggleClass('hide');
                        IssueMain.prototype.fetchChildren(issue_id, 'ul_subtask_'+issue_id);
                    });

                    $("#btn-join_sprint").bind("click", function () {
                        var sprint_id = $("input[name='join_sprint']:checked").val();
                        var issue_id = $('#join_sprint_issue_id').val();
                        if (sprint_id) {
                            IssueMain.prototype.joinSprint(sprint_id, issue_id);
                        } else {
                            notify_error('请选择Sprint');
                        }
                    });

                    $("#btn-modal_delete").bind("click", function () {
                        var issue_id = $('#children_list_issue_id').val();
                        if (issue_id) {
                            IssueMain.prototype.delete(issue_id);
                        } else {
                            notify_error('请选择Sprint');
                        }
                    });

                    $("#btn-convertChild").bind("click", function () {
                        var issue_id = $('#current_issue_id').val();
                        if (issue_id) {
                            IssueMain.prototype.convertChild(issue_id);
                        } else {
                            notify_error('事项id传递错误');
                        }
                    });
                }else{
                    loading.hide('#' + _options.list_render_id)
                    var emptyHtml = defineStatusHtml({
                        message : '数据为空',
                        handleHtml: ''
                    })
                    $('#list_render_id').append($('<tr><td colspan="12" id="list_render_id_wrap"></td></tr>'))
                    $('#list_render_id_wrap').append(emptyHtml.html)
                }
                
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    };

    IssueMain.prototype.displayConvertChild = function (issue_id) {

        $('#current_issue_id').val(issue_id);
        $('#btn-parent_select_issue').data('issue-id', issue_id);
        $('#modal-choose_parent').modal('show');
    };

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
                    notify_error('删除失败:' + resp.msg);
                    return;
                }
                notify_success('操作成功');
                window.location.reload();
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    };

    IssueMain.prototype.fetchChildren = function (issue_id ,display_id) {

        $.ajax({
            type: 'get',
            dataType: "json",
            async: true,
            url: "/issue/main/getChildIssues",
            data: {issue_id: issue_id},
            success: function (resp) {

                if (resp.ret != '200') {
                    notify_error('获取子任务失败:' + resp.msg);
                    return;
                }
                var source = $('#main_children_list_tpl').html();
                var template = Handlebars.compile(source);
                var result = template(resp.data);
                $('#'+display_id).html(result);

            },
            error: function (res) {
                notify_error("请求数据错误" + res);
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
                    notify_error('加入 Sprint 失败');
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

    IssueMain.prototype.displayJoinSprint = function (issue_id) {

        $.ajax({
            type: 'get',
            dataType: "json",
            async: true,
            url: "/agile/fetchSprints",
            data: {project_id: _cur_project_id, issue_id: issue_id},
            success: function (resp) {

                if (resp.ret != '200') {
                    notify_error('获取Sprints失败:' + resp.msg);
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
                notify_error("请求数据错误" + res);
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
                    notify_error('加入 Sprint 失败:' + resp.msg);
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

    IssueMain.prototype.displayDelete = function (issue_id) {

        $.ajax({
            type: 'get',
            dataType: "json",
            async: true,
            url: "/issue/main/getChildIssues",
            data: {issue_id: issue_id},
            success: function (resp) {

                if (resp.ret != '200') {
                    notify_error('获取Sprints失败:' + resp.msg);
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
                notify_error("请求数据错误" + res);
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
                    notify_error('删除失败:' + resp.msg);
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

    IssueMain.prototype.fetchCreateUiConfig = function (issue_type_id, issue_types) {

        loading.show('#create_default_tab');
        IssueMain.prototype.initForm();
        var method = 'get';
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: "/issue/main/fetchUiConfig",
            data: {issue_type_id: issue_type_id, project_id: _cur_project_id},
            success: function (resp) {

                loading.hide('#create_default_tab');
                _fields = resp.data.fields
                _create_configs = resp.data.configs;
                _tabs = resp.data.tabs;
                _field_types = issue_types;
                _allow_add_status = resp.data.allow_add_status;

                // create default tab
                var default_tab_id = 0;
                var html = IssueForm.prototype.makeCreateHtml(_create_configs, _fields, default_tab_id, _allow_add_status);
                $('#create_default_tab').html(html);

                console.log(_tabs);
                // create other tab
                for (var i = 0; i < _tabs.length; i++) {
                    var order_weight = parseInt(_tabs[i].order_weight) + 1;
                    IssueForm.prototype.uiAddTab('create', _tabs[i].name, _tabs[i].id);
                    var html = IssueForm.prototype.makeCreateHtml(_create_configs, _fields, _tabs[i].id,_allow_add_status);
                    var id = '#create_ui_config-create_tab-' + _tabs[i].id
                    $(id).html(html);
                }
                if (_tabs.length > 1) {
                    $('#create_header_hr').hide();
                    $('#create_tabs').show();
                } else {
                    $('#create_header_hr').show();
                    $('#create_tabs').hide();
                }

                IssueMain.prototype.refreshForm(issue_type_id,false);
                $('#a_create_default_tab').click();

            },
            error: function (res) {
                notify_error("请求数据错误" + res);
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
        console.log(post_data);
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: "/issue/main/add",
            data: post_data,
            success: function (resp) {

                console.log(resp);
                if (resp.ret == '200') {
                    notify_success('保存成功');
                    window.location.reload();
                } else {
                    notify_error('保存失败,错误信息:'+resp.msg);
                }

            },
            error: function (res) {
                notify_error("请求数据错误" + res);
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
                    notify_success('保存成功');
                    window.location.reload();
                } else {
                    notify_error('保存失败,错误信息:'+resp.msg);
                }

            },
            error: function (res) {
                notify_error("请求数据错误" + res);
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


    IssueMain.prototype.refreshForm = function (issue_type_id,is_edit) {

        $('.selectpicker').selectpicker('refresh');
        var toolbars =  [
            "bold", "italic", "heading", "|",
            "quote","unordered-list","ordered-list","|",
            "link","image","table","|",
            "preview","side-by-side","fullscreen","|"
        ];
        var desc_tpl_value = '';
        if(!is_edit && _description_templates!=null){
            var issue_type = null;
            for ( var obj_key in _issueConfig.issue_types)
            {
                if(_issueConfig.issue_types[obj_key].id == issue_type_id){
                    issue_type = _issueConfig.issue_types[obj_key];
                }
            }
            //console.log( issue_type);
            if(issue_type!=null){
                for(var i=0;i<_description_templates.length;i++){
                    var tpl = _description_templates[i];
                    if(tpl.id==issue_type.form_desc_tpl_id){
                        desc_tpl_value = tpl.content;
                    }
                }
            }
        }
        toolbars.push("guide");

        $(".simplemde_text").each(function (i) {
            var id = $(this).attr('id');
            // if (typeof(_simplemde[id]) == 'undefined') {
            //     // var mk = new SimpleMDE({
            //     //     element: document.getElementById(id),
            //     //     autoDownloadFontAwesome: false,
            //     //     toolbar:toolbars,
            //     //     initialValue:desc_tpl_value
            //     // });
            //
            //     // _simplemde[id] = mk;
            // }

            var editor_md = editormd(id, {
                width: "100%",
                height: 220,
                markdown : "",
                path : '/dev/lib/editor.md/lib/',
                imageUpload : true,
                imageFormats : ["jpg", "jpeg", "gif", "png", "bmp", "webp"],
                imageUploadURL : "/issue/detail/editormd_upload",
                tocm            : true,    // Using [TOCM]
                emoji           : true,
                saveHTMLToTextarea:true,
                toolbarIcons    : "custom"
            });
        });

        new UsersSelect();

        // new LabelsSelect();
        // new MilestoneSelect();
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
                _fields = resp.data.fields;
                _create_configs = resp.data.configs;
                _tabs = resp.data.tabs;
                _field_types = _issueConfig.issue_types;
                _edit_issue = resp.data.issue;

                $('#edit_project_id').val(_edit_issue.project_id);
                $('#edit_issue_type').val(_edit_issue.issue_type);
                $('#edit_tabs li').each(function() {
                    console.log($(this).val());
                });

                $('#edit_tabs').empty();
                var default_html = '<li role="presentation" class="active"><a id="a_edit_default_tab" href="#edit_default_tab" role="tab" data-toggle="tab">默认</a></li>';
                $('#edit_tabs').html(default_html);

                IssueMain.prototype.initEditIssueType(_edit_issue.issue_type, _issueConfig.issue_types);
                //notify_success(resp.data.configs);
                // create default tab
                var default_tab_id = 0;
                var html = IssueForm.prototype.makeEditHtml(_create_configs, _fields, default_tab_id, _edit_issue);
                $('#edit_default_tab').html(html);
                $('#edit_default_tab').show();

                // create other tab
                console.log(_tabs);
                for (var i = 0; i < _tabs.length; i++) {
                    var order_weight = parseInt(_tabs[i].order_weight) + 1
                   IssueForm.prototype.uiAddTab('edit', _tabs[i].name, _tabs[i].id);
                    var html = IssueForm.prototype.makeEditHtml(_create_configs, _fields, _tabs[i].id, _edit_issue);
                    var id = '#edit_ui_config-edit_tab-' + _tabs[i].id;
                    // edit_ui_config-edit_tab-20
                    $(id).html(html);
                }
                if (_tabs.length > 1) {
                    $('#edit_tabs').show();
                } else {
                    $('#edit_tabs').hide();
                }

                $('#modal-edit-issue').modal();

                IssueMain.prototype.refreshForm(_edit_issue.issue_type, true);
                IssueMain.prototype.initEditFineUploader(_edit_issue);

                $('#a_edit_default_tab').click();
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    return IssueMain;
})();


