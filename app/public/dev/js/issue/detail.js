var IssueDetail = (function () {

    var _options = {};

    var _create_configs = [];
    var _tabs = [];
    var _edit_configs = [];
    var _edit_tabs = [];
    var _fields = [];
    var _field_types = [];

    var _edit_issue = {};

    var _active_tab = 'create_default_tab';

    // constructor
    function IssueDetail(options) {
        _options = options;
        //将body变正常
        $('.modal').on('hidden.bs.modal', function () {
            if ($('body').hasClass('unmask')) {
                $('body').removeClass('unmask');
            }
        });
        $('.modal').on('show.bs.modal', function () {
            IssueDetail.prototype.cleanScroll();
            $('#edit_issue_simplemde_description').parent().css('height', 'auto');
            $('#edit_issue_upload_file_attachment_uploader').parent().css('height', 'auto');
        });
    };

    //使用此函数让模态框后面的body没有滚动效果
    IssueDetail.prototype.cleanScroll = function () {
        //3.关闭模态框将body的overflow改回来
        $('body').addClass('unmask');
    };

    IssueDetail.prototype.getOptions = function () {
        return _options;
    };

    IssueDetail.prototype.setOptions = function (options) {
        for (i in  options) {
            // if( typeof( _options[options[i]] )=='undefined' ){
            _options[i] = options[i];
            // }
        }
    };

    IssueDetail.prototype.initEditFineUploader = function (issue) {

        // 文件
        //window._fineUploader.addInitialFiles(issue.edit_attachment_data);

    }

    IssueDetail.prototype.fetchIssue = function (id, isSide) {
        $('#issue_id').val(id);
        var method = 'get';
        var self = this;
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: root_url + "issue/detail/get/" + id,
            data: {},
            success: function (resp) {
                auth_check(resp);
                var _self = self;
                _fields = resp.data.fields;
                _create_configs = resp.data.configs;
                _tabs = resp.data.tabs;
                _field_types = _issueConfig.issue_types;
                _edit_issue = resp.data.issue;

                IssueDetail.prototype.initEditFineUploader(_edit_issue);
                var issue_title_selector = $('#issue_title');
                issue_title_selector.html(_edit_issue.summary);
                if (_edit_issue.postponed == 1) {
                    issue_title_selector.append(' <span style="color:#db3b21" title="逾期">逾期</span>');
                }
                if (_edit_issue.warning_delay == 1) {
                    issue_title_selector.append(' <span style="color:#fc9403" title="即将延期">即将延期</span>');
                }
                var source = $('#issuable-header_tpl').html();
                var template = Handlebars.compile(source);
                var result = template(resp.data);
                $('#issuable-header').html(result);

                if(resp.data.prev_issue_id!=0){
                    var prev_issue_link = $('#prev_issue_link');
                    prev_issue_link.removeClass('disabled');
                    prev_issue_link.attr('href','/issue/detail/index/'+resp.data.prev_issue_id);
                }
                if(resp.data.next_issue_id!=0){
                    var next_issue_link = $('#next_issue_link');
                    next_issue_link.removeClass('disabled');
                    $('#next_issue_link').attr('href','/issue/detail/index/'+resp.data.next_issue_id);
                }


                IssueDetail.prototype.fetchTimeline(id);

                if (_fineUploader) {
                    _fineUploader.addInitialFiles(resp.data.issue['attachment']);
                }

                if (isSide) {

                    $('#btn-close').data('issue_id', id);
                    $('#btn-delete').data('issue_id', id);
                    //从右边弹出页面
                    source = $('#detail-page-users_tpl').html();
                    template = Handlebars.compile(source);
                    result = template(_edit_issue);
                    $('#detail-page-users').html(result);

                    source = $('#detail-page-date_tpl').html();
                    template = Handlebars.compile(source);
                    result = template(_edit_issue);
                    $('#detail-page-date').html(result);

                    var top = $(window).scrollTop();
                    _editor_md = editormd("editor_md", {
                        width: "100%",
                        height: 240,
                        markdown: "",
                        watch: false,
                        toolbarAutoFixed: false,
                        lineNumbers: false,
                        path: root_url + "dev/lib/editor.md/lib/",
                        imageUpload: true,
                        imageFormats: ["jpg", "jpeg", "gif", "png", "bmp", "webp"],
                        imageUploadURL: root_url + "issue/detail/editormd_upload",
                        tocm: true,    // Using [TOCM]
                        emoji: true,
                        placeholder: "",
                        saveHTMLToTextarea: true,
                        toolbarIcons: "custom",
                        autoFocus: false
                    });
                }

                source = $('#issue_fields_tpl').html();
                template = Handlebars.compile(source);
                result = template(resp.data);
                $('#issue_fields').html(result);

                source = $('#allow_update_status_tpl').html();
                template = Handlebars.compile(source);
                result = template(_edit_issue);
                $('#allow_update_status').html(result);

                source = $('#allow_update_resolves_tpl').html();
                template = Handlebars.compile(source);
                result = template(_edit_issue);
                $('#allow_update_resolves').html(result);

                source = $('#detail-page-description_tpl').html();
                template = Handlebars.compile(source);
                result = template(resp.data);
                $('#detail-page-description').html(result);


                var _editormd_view = editormd.markdownToHTML("description-view", {
                    markdown: resp.data.issue.description
                });

                source = '{{make_assistants issue.assistants_arr users}}';
                template = Handlebars.compile(source);
                result = template(resp.data);
                $('#assistants_div').html(result);

                //父任务
                if (resp.data.issue.master_id != '0') {
                    source = $('#parent_issue_tpl').html();
                    template = Handlebars.compile(source);
                    result = template(_edit_issue.master_info);
                    $('#parent_issue_div').html(result);
                    $('#parent_block').removeClass('hide');
                }

                // 子任务
                source = $('#child_issues_tpl').html();
                template = Handlebars.compile(source);
                result = template(_edit_issue);
                $('#child_issues_div').html(result);

                // 自定义字段
                if (resp.data.issue.custom_field_values.length > 0) {
                    source = $('#custom_field_values_tpl').html();
                    template = Handlebars.compile(source);
                    result = template(resp.data.issue);
                    $('#custom_field_values_div').html(result);
                    $('#custom_field_values_block').removeClass('hide');
                }

                $('.allow_update_status').bind('click', function () {
                    IssueDetail.prototype.updateIssueStatus(id, $(this).data('status_id'));
                });

                $('.allow_update_resolve').bind('click', function () {
                    IssueDetail.prototype.updateIssueResolve(id, $(this).data('resolve_id'));
                });
                var follow_action = '';
                if (_edit_issue.followed == '0') {
                    follow_action = 'follow';
                    $('#btn-watch').html('关注');
                } else {
                    $('#btn-watch').html('取消关注');
                    follow_action = 'un_follow';
                }
                $('#btn-watch').bind('click', function () {
                    IssueDetail.prototype.follow(id, follow_action);
                });

                $("time").each(function (i, el) {
                    var t = moment(moment.unix(Number($(el).attr('datetime'))).format('YYYY-MM-DD HH:mm:ss')).fromNow()
                    $(el).html(t)
                });
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    IssueDetail.prototype.fetchTimeline = function (id) {
        $('#issue_id').val(id);
        var method = 'get';
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: root_url + "issue/detail/fetch_timeline/" + id,
            data: {},
            success: function (resp) {
                auth_check(resp);
                for (i = 0; i < resp.data.timelines.length; i++) {
                    var obj = resp.data.timelines[i]
                    var uid = obj.uid;
                    var type = obj.type;
                    var action = obj.action;

                    obj['user'] = _issueConfig.users[uid];
                    obj['is_cur_user'] = false;
                    if (uid == _cur_uid) {
                        obj['is_cur_user'] = true;
                    }
                    obj['is_issue_commented'] = false;
                    if (type = 'issue' && action == 'commented') {
                        obj['is_issue_commented'] = true;
                    }
                    resp.data.timelines[i] = obj;
                }

                var source = $('#timeline_tpl').html();
                var template = Handlebars.compile(source);
                var result = template(resp.data);
                $('#timelines_list').html(result);

                $(".js-note-edit2").bind("click", function () {
                    var id = $(this).data('id')
                    var editormd_div_id = "timeline-div-editormd_" + id;
                    _timelineEditormd = editormd(editormd_div_id, {
                        width: "100%",
                        height: 240,
                        path: root_url + 'dev/lib/editor.md/lib/',
                        imageUpload: true,
                        imageFormats: ["jpg", "jpeg", "gif", "png", "bmp", "webp"],
                        imageUploadURL: root_url + "/issue/detail/editormd_upload",
                        htmlDecode: "style,script,iframe",  // you can filter tags decode
                        tocm: true,    // Using [TOCM]
                        emoji: true,
                        saveHTMLToTextarea: true
                    });
                    $('#timeline-text_' + id).hide();
                    $('#note-actions_' + id).hide();
                    $('#timeline-footer-action_' + id).removeClass('hidden')
                    $('#timeline-footer-action_' + id).show();
                    $('#timeline-div-editormd_' + id).removeClass('hidden')
                    $('#timeline-div-editormd_' + id).show();

                });

                $(".btn-timeline-update").bind("click", function () {

                    var timeline_id = $(this).data('id')
                    var editormd_div_id = "timeline-div-editormd_" + timeline_id;

                    var content = _timelineEditormd.getMarkdown();
                    var content_html = _timelineEditormd.getHTML();

                    $.ajax({
                        type: 'post',
                        dataType: "json",
                        async: true,
                        url: "/issue/detail/update_timeline/",
                        data: {id: timeline_id, content: content, content_html: content_html},
                        success: function (resp) {
                            auth_check(resp);
                            if (resp.ret == '200') {
                                IssueDetail.prototype.fetchTimeline($('#issue_id').val());
                            } else {
                                notify_error(resp.msg);
                            }
                        },
                        error: function (res) {
                            notify_error("请求数据错误" + res);
                        }
                    });

                });

                $(".note-edit-cancel").bind("click", function () {

                    var id = $(this).data('id')

                    $('#timeline-text_' + id).show();
                    $('#note-actions_' + id).show();

                    $('#timeline-div-editormd_' + id).addClass('hidden')
                    $('#timeline-div-editormd_' + id).hide();

                    $('#timeline-footer-action_' + id).addClass('hidden')
                    $('#timeline-footer-action_' + id).hide();
                });

                $(".js-note-remove").bind("click", function () {

                    var msg = $(this).data('confirm2');
                    if (window.confirm(msg)) {
                        $.ajax({
                            type: 'get',
                            dataType: "json",
                            async: true,
                            url: $(this).data('url'),
                            data: {id: $(this).data('id')},
                            success: function (resp) {

                                auth_check(resp);
                                //alert(resp.msg);
                                if (resp.ret == '200') {
                                    notify_success('操作成功')
                                    IssueDetail.prototype.fetchTimeline($('#issue_id').val());
                                } else {
                                    notify_error(resp.msg);
                                }
                            },
                            error: function (res) {
                                notify_error("请求数据错误" + res);
                            }
                        });
                    }
                });

            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    IssueDetail.prototype.fetchActivity = function (issue_id, page) {
        // url,  list_tpl_id, list_render_id
        var params = {format: 'json'};
        var _key = 'activity';
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: root_url+'widget/fetchIssueActivity',
            data: {page: page, issue_id:issue_id},
            success: function (resp) {
                auth_check(resp);
                if(resp.data.activity.length){
                    var activitys = [];
                    for(var i=0; i<resp.data.activity.length;  i++) {
                        var user_id = resp.data.activity[i].user_id;
                        resp.data.activity[i].user = getValueByKey(_issueConfig.users,user_id);
                    }

                    var source = $('#'+_key+'_tpl').html();
                    var template = Handlebars.compile(source);
                    var result = template(resp.data);
                    $('#'+_key+'_wrap').html(result);
                    $(`#tool_${_key}`).find("time").each(function(i, el){
                        var t = moment(moment.unix(Number($(el).attr('datetime'))).format('YYYY-MM-DD HH:mm:ss')).fromNow()
                        $(el).html(t)
                    })

                    window._cur_activity_page = parseInt(page);
                    var pages = parseInt(resp.data.pages);
                    if (pages > 1) {
                        $('#'+_key+'_more').show();
                    }
                    $(`#toolform_${_key}`).hide();
                    $(`#tool_${_key}`).show();

                    window._cur_activity_page = parseInt(page);
                    var pages = parseInt(resp.data.pages);
                    var options = {
                        currentPage: resp.data.page,
                        totalPages: resp.data.pages,
                        onPageClicked: function (e, originalEvent, type, page) {
                            console.log("Page item clicked, type: " + type + " page: " + page);
                            //$("#filter_page").val(page);
                            //_options.query_param_obj["page"] = page;
                            IssueDetail.prototype.fetchActivity(issue_id,page);
                        }
                    };
                    $('#ampagination-activity').bootstrapPaginator(options);
                }else{
                    var emptyHtml = defineStatusHtml({
                        wrap: '#tool_'+_key,
                        message : '数据为空'
                    })
                }

            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    IssueDetail.prototype.addTimeline = function (is_reopen) {

        var issue_id = $('#issue_id').val();
        var reopen = '0';
        if (is_reopen == '1') {
            reopen = '1';
        }
        var content = _editor_md.getMarkdown();
        var content_html = _editor_md.getHTML();
        var method = 'post';
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: root_url + "issue/detail/add_timeline/",
            data: {issue_id: issue_id, content: content, content_html: content_html, reopen: reopen},
            success: function (resp) {
                auth_check(resp);
                //alert(resp.msg);
                if (resp.ret == '200') {
                    IssueDetail.prototype.fetchTimeline(issue_id);
                    _editor_md.clear();
                } else {
                    notify_error(resp.msg);
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    IssueDetail.prototype.updateIssueStatus = function (issue_id, status_id) {
        var method = 'post';
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: root_url + "issue/main/update/",
            data: {issue_id: issue_id, params: {status: status_id}},
            success: function (resp) {
                auth_check(resp);
                if (resp.ret == '200') {
                    window.location.reload();
                } else {
                    notify_error(resp.msg);
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    },

    IssueDetail.prototype.updateIssueResolve = function (issue_id, resolve_id) {
        var method = 'post';
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: root_url + "issue/main/update/",
            data: {issue_id: issue_id, params: {resolve: resolve_id}},
            success: function (resp) {
                auth_check(resp);
                if (resp.ret === '200') {
                    window.location.reload();
                } else {
                    notify_error(resp.msg);
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    },
    IssueDetail.prototype.follow = function (issue_id, follow_action) {

        var method = 'get';
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: root_url + "issue/main/" + follow_action,
            data: {issue_id: issue_id},
            success: function (resp) {
                auth_check(resp);
                if (resp.ret == '200') {
                    window.location.reload();
                } else {
                    notify_error(resp.msg);
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    return IssueDetail;
})();

