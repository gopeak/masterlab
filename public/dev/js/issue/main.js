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

var _cur_form_project_id = "";
var _cur_project_key = "crm";
var _issue_length = 0;
var _issue_item_cur = 0;
var _issues_list = [];
var _issue_cur_page = 1;
var _issue_total_pages = 1;

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

    var _temp_data = {};
    var _default_data = null;
    var   _default_issue_type_id = 1;
    var _last_create_issue_data = null;

    // constructor
    function IssueMain(options) {
        _options = options;
        if(window._default_issue_type_id){
            _default_issue_type_id = window._default_issue_type_id;
        }
        if(window.last_create_issue_data){
            _last_create_issue_data = window.last_create_issue_data;
        }
        if(_last_create_issue_data && ('issue_type' in _last_create_issue_data)){
            _default_issue_type_id = _last_create_issue_data.issue_type;
        }

        IssueMain.prototype.initProjectSelect();
        $("#btn-issue_type_add").click(function () {
            IssueMain.prototype.add();
        });

        // project_select

        $("#btn-issue_type_update").click(function () {
            IssueMain.prototype.update();
        });

        //将body变正常
        $('.modal').on('hidden.bs.modal', function () {
            if ($('body').hasClass('unmask')) {
                $('body').removeClass('unmask');
            }
        });
        $('.modal').on('show.bs.modal', function () {
            IssueMain.prototype.cleanScroll();
            $('#create_issue_simplemde_description').parent().css('height', 'auto');
            $('#create_issue_upload_file_attachment_uploader').parent().css('height', 'auto');
        });
        $('.modal .nav.nav-tabs').on('show.bs.tab', function () {
            $('#create_issue_simplemde_description').parent().css('height', 'auto');
            $('#create_issue_upload_file_attachment_uploader').parent().css('height', 'auto');
        });
        //关闭左侧面板，以及点击出现左侧面板
        $('#issuable-header').on('click', function (e) {
            if ($(e.target).hasClass('fa-times')) {
                $('.float-right-side').hide();
                $('.maskLayer').addClass('hide');
                $('#list_render_id tr.active').removeClass('active');
                $('#detail_render_id .issue-box').removeClass('issue-box-active');
            }
        });

        Handlebars.registerHelper("addOne", function (index, options) {
            return parseInt(index) + 1;
        });

        IssueMain.prototype.pasteImage();
    };

    IssueMain.prototype.getOptions = function () {
        return _options;
    };

    IssueMain.prototype.setOptions = function (options) {
        for (i in options) {
            // if( typeof( _options[options[i]] )=='undefined' ){
            _options[i] = options[i];
            // }
        }
    };

    //使用此函数让模态框后面的body没有滚动效果
    IssueMain.prototype.cleanScroll = function () {
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
        window.is_save_filter = '1';
        var searchQuery = window.$filterSreach.getCurrentSearchesStr();
        var is_project_filter = $("#is_project_filter").is(':checked');
        var is_project_filter_value = is_project_filter ? "1" :"0";
        if (trimStr(name) == '') {
            notify_warn('过滤器名称不能为空哦!');
            return;
        }
        console.log(searchQuery)
        if( searchQuery == null ||  trimStr(searchQuery) == ''){
            notify_warn('过滤器为空或者你需要先点击“搜索”操作');
            return;
        }
        //notify_success(searchQuery);
        var params = { format: 'json' };
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: root_url + 'issue/main/save_filter',
            data: {
                project_id: window._cur_project_id,
                name: name,
                filter: encodeURIComponent(searchQuery),
                sort_field: $sort_field,
                sort_by: $sort_by ,
                is_project_filter:is_project_filter_value
            },
            success: function (resp) {
                auth_check(resp);
                if (resp.ret == '200') {
                    notify_success('保存成功');
                    setTimeout('window.location.reload()', 1000);
                    //window.qtipApi.hide()
                    $('#custom-filter-more').qtip('api').toggle(false);
                } else {
                    notify_error( resp.msg);
                }

            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });


    }

    IssueMain.prototype.initProjectSelect = function () {

        var $selectObj = $('#create_project_select');
        $selectObj.empty();

        for (var i = 0; i < window._issueConfig.projects.length; i++) {
            let project = window._issueConfig.projects[i];
            let content = '<img width="26px" height="26px" class= "float-none" style="border-radius: 50%;" src="' + project.avatar + '" >' + project.name + ''
            let opt = "<option data-key='"+project.key+"' data-content='" + content + "' value='" + project.id + "'>" + project.name + "</option>";
            $selectObj.append(opt);
        }
        $selectObj.val(window.cur_project_id);
        $('.selectpicker').selectpicker('refresh');

        $selectObj.bind("change", function () {
            IssueMain.prototype.onChangeCreateProjectSelected($(this).val(), $(this).data('key'));
        });

    }

    IssueMain.prototype.initCreateIssueType = function (issue_types, on_change) {

        var issue_types_select = $('#create_issue_types_select');
        issue_types_select.empty();

        var first_issue_type = {};
        for (var i = 0; i < issue_types.length; i++) {
            if (_default_issue_type_id == issue_types[i].id) {
                first_issue_type = issue_types[i];
            }
            var content = "<div class=issue-types-icon><i class=" + issue_types[i].font_awesome + "></i> " + issue_types[i].name + "</div>"
            issue_types_select.append("<option data-content='" + content + "' value='" + issue_types[i].id + "'>" + issue_types[i].name + "</option>")
        }
        // console.log(issue_types_select)
        if (on_change) {
            $("#create_issue_types_select").bind("change", function () {
                console.log($(this).val(), issue_types)
                IssueMain.prototype.fetchCreateUiConfig($(this).val(), issue_types);
            })
        }

        if(JSON.stringify(first_issue_type) == "{}"){
            first_issue_type = issue_types[0];
        }
        if (first_issue_type) {
            $("#create_issue_types_select").find("option[value='" + first_issue_type.id + "']").attr("selected", true);
            IssueMain.prototype.fetchCreateUiConfig(first_issue_type.id, issue_types);
        }

        $('.selectpicker').selectpicker('refresh');

    }

    IssueMain.prototype.initEditIssueType = function (issue_type_id, issue_types, issue_id) {


        var issue_types_select = document.getElementById('edit_issue_types_select');
        var elm = $('#edit_issue_types_select');
        elm.empty();
        var first_issue_type = {};
        for (let issue_type of issue_types) {
            if (issue_type_id == issue_type.id) {
                first_issue_type = issue_type;
            }
            elm.append("<option value='" + issue_type.id + "'>" + issue_type.name + "</option>");
        }

        if (issue_type_id) {
            elm.find("option[value='" + issue_type_id + "']").attr("selected", true);
        }

        elm.bind("change", function () {
            IssueMain.prototype.fetchEditUiConfig(issue_id, 'edit', $(this).val());
        })

        $('.selectpicker').selectpicker('refresh');

    }

    IssueMain.prototype.onChangeCreateProjectSelected = function (project_id, key) {
        _cur_form_project_id = project_id;
        _cur_project_key = key;
        //_default_issue_type_id =
        var project = getArrayValue(window._issueConfig.projects, 'id', project_id);
        if(project){
            _default_issue_type_id = project.default_issue_type_id;
        }

        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: root_url + 'issue/main/fetch_issue_type',
            data: { project_id: project_id },
            success: function (resp) {
                auth_check(resp);
                IssueMain.prototype.initCreateIssueType(resp.data.issue_types, true);
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    IssueMain.prototype.updateUserIssueView = function (issue_view) {
        $.ajax({
            type: "POST",
            dataType: "json",
            async: true,
            url: root_url + 'user/updateIssueView',
            data: { issue_view: issue_view },
            success: function (resp) {
                auth_check(resp);
               // if (issue_view !== 'detail') {
                    window.location.reload();
               // }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }


    IssueMain.prototype.updateUserTreeIsShowClosed = function (issue_tree_is_closed) {
        $.ajax({
            type: "POST",
            dataType: "json",
            async: true,
            url: root_url + 'user/updateUserTreeIsShowClosed',
            data: { issue_tree_is_closed: issue_tree_is_closed },
            success: function (resp) {
                // if (issue_view !== 'detail') {
                // }
                if(resp.ret=='200'){
                    $('#btn-go_search').click();
                }

            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    IssueMain.prototype.updateUserTreeExpand = function (issue_tree_is_expand) {
        $.ajax({
            type: "POST",
            dataType: "json",
            async: true,
            url: root_url + 'user/updateUserTreeExpand',
            data: { issue_tree_is_expand: issue_tree_is_expand },
            success: function (resp) {
                // if (issue_view !== 'detail') {
                // }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    IssueMain.prototype.updateUserTreeRangeData = function (range) {
        $.ajax({
            type: "POST",
            dataType: "json",
            async: true,
            url: root_url + 'user/updateUserTreeRangeData',
            data: { tree_range_data: range },
            success: function (resp) {
                // if (issue_view !== 'detail') {
                $('#btn-go_search').click();
                // }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    IssueMain.prototype.initIssueItem = function () {
        _issues_list.forEach(function (val, index) {
            if (parseInt(val.id) === parseInt(_issue_id)) {
                _issue_item_cur = index;
            }
        });

        var $prev = $(".detail-pager .previous");
        var $next = $(".detail-pager .next");

        if (_issue_cur_page === 1 && _issue_item_cur === 0) {
            $prev.addClass("disabled");
        } else {
            $prev.removeClass("disabled");
        }

        if (_issue_cur_page === _issue_total_pages && _issue_item_cur === (_issues_list.length - 1)) {
            $next.addClass("disabled");
        } else {
            $next.removeClass("disabled");
        }
    }

    IssueMain.prototype.prevIssueItem = function () {
        if (_issue_item_cur === 0) {
            IssueMain.prototype.skipPager(_issue_cur_page - 1, function () {
                _issue_item_cur = _issues_list.length - 1;
                if ($("#list_render_id").length) {
                    $("#list_render_id .tree-item:last-child .commit-row-message").trigger("click");
                } else {
                    $("#detail_render_id .issue-box:last-child").trigger("click");
                }
            });
        } else {
            _issue_item_cur--;
            if ($("#list_render_id").length) {
                $("#list_render_id .tree-item").eq(_issue_item_cur).find(".commit-row-message").trigger("click");
            } else {
                $("#detail_render_id .issue-box").eq(_issue_item_cur).trigger("click");
            }
        }
    }

    IssueMain.prototype.nextIssueItem = function () {
        if (_issue_item_cur === _issues_list.length - 1) {
            IssueMain.prototype.skipPager(_issue_cur_page + 1, function () {
                _issue_item_cur = 0;
                if ($("#list_render_id").length) {
                    $("#list_render_id .tree-item:first-child .commit-row-message").trigger("click");
                } else {
                    $("#detail_render_id .issue-box:first-child").trigger("click");
                }
            });
        } else {
            _issue_item_cur++;
            if ($("#list_render_id").length) {
                $("#list_render_id  .tree-item").eq(_issue_item_cur).find('.commit-row-message').trigger("click");
            } else {
                $("#detail_render_id .issue-box").eq(_issue_item_cur).trigger("click");
            }
        }
    }

    IssueMain.prototype.skipPager = function (page, success) {
        $("#filter_page").val(page);
        _options.query_param_obj["page"] = page;

        console.log(adv_details);
        // 判断是不是高级查询
        if( adv_details.length<=0){
            IssueMain.prototype.fetchIssueMains(function () {
                if (typeof (success) != 'undefined' && typeof (success) === "function") {
                    success();
                }
            });
        }else{
            var tempData = JSON.parse(JSON.stringify(adv_details));
            var temp = tempData.map(function (n) {
                return {
                    logic: n.logic,
                    start_braces: n.start_braces,
                    field: n.field,
                    opt: n.opt,
                    value: n.value,
                    end_braces: n.end_braces
                }
            });
            var adv_data = tempData.map(function (n) {
                return n
            });
            var queryData = JSON.stringify(temp);
            IssueMain.prototype.fetchIssuesByAdvQueryIssue(queryData,success, adv_data, page);
        }
    }

    IssueMain.prototype.fetchIssueMains = function (success) {
        if(window.issue_view=='tree'){
            let  tree_range = $('#issue_view_tree_range').val();
            _options.filter_url += "&tree_range=" + tree_range;
            if ($("#issue_tree_is_closed").get(0).checked) {
                _options.filter_url += "&issue_tree_is_closed=1" ;
            }
        }
        // url,  list_tpl_id, list_render_id
        var params = { format: 'json' };
        loading.show('#' + _options.list_render_id);
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: _options.filter_url,
            data: _options.query_param_obj,
            success: function (resp) {
                IssueMain.prototype.handleRenderIssues(resp, success);
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    };

    IssueMain.prototype.fetchIssuesByAdvQueryIssue = function (jsonData, success, adv_data, page=1) {

        // let query_json = [
        //     {"logic":"and", "start_braces":"(", "field":"assignee",   "opt":"=",    "value":"1",                    "end_braces":""},
        //     {"logic":"and", "start_braces":"",  "field":"updated",    "opt":">=",   "value":"2019-11-12 22:00",    "end_braces":""},
        //     {"logic":"or",  "start_braces":"",  "field":"issue_type", "opt":"in",   "value":"1,2,3",               "end_braces":")"},
        //     {"logic":"or",  "start_braces":"(", "field":"priority",   "opt":"not in",   "value":"1,2,3",               "end_braces":""},
        //     {"logic":"and", "start_braces":"",  "field":"summary",     "opt":"regexp",    "value":"^xxx",                  "end_braces":")"}
        // ];
        // let query_json2 = [
        //     {"logic":"and", "start_braces":"(", "field":"assignee",   "opt":">=",    "value":"1",                    "end_braces":""},
        //     {"logic":"and", "start_braces":"",  "field":"updated",    "opt":"<=",   "value":"2019-11-12 22:00",    "end_braces":")"},
        //     {"logic":"and", "start_braces":"",  "field":"summary",     "opt":"regexp",    "value":encodeURIComponent("^标题[^>]+\\d+"),                  "end_braces":""}
        // ];
        let btn_adv_sumit = $('#btn-adv_submit');
        let sort_by = $('#adv_sort_by').val();
        let sort_field = $('#adv_sort_field').val();

        if(window.is_adv_filter=="1" && sort_field==""){
            sort_field = window.$sort_field;
        }

        let req_data = { project_id: window.cur_project_id, adv_query_json: jsonData, sort_field: sort_field, sort_by: sort_by,page: page };
        if(window.issue_view=='tree'){
            let  tree_range = $('#issue_view_tree_range').val();
            req_data['tree_range'] =  tree_range;
            if ($("#issue_tree_is_closed").get(0).checked) {
                req_data['issue_tree_is_closed'] =  '1';
            }
        }
        btn_adv_sumit.addClass('disabled');
        $.ajax({
            type: 'get',
            dataType: "json",
            url: "/issue/main/adv_filter",
            data: req_data,
            success: function (resp) {
                btn_adv_sumit.removeClass('disabled');
                $('#modal-adv_query').modal('hide');
                IssueMain.prototype.handleRenderIssues(resp, success);
                IssueAdvQuery.prototype.renderListAdvQuery(adv_data);
                if (sort_field!=""){
                    $(".sort_select ").removeClass("is-active");
                    $('#btn-sort_field').data('sort_field', sort_field);
                    //$('#btn-sort_field').dropdown('update')
                    var text = $(".sort_select[data-field='"+sort_field+"']").text();
                    $('#btn-sort_field').text(text);
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
                btn_adv_sumit.removeClass('disabled');
            }
        });
    };
    IssueMain.prototype.handleRenderIssues = function (resp, success) {
        auth_check(resp);
        let _issues_list = resp.data.issues;
        let _issue_length = 0;
        if (!is_empty(_issues_list)) {
            _issue_length = _issues_list.length;
        }
        _issue_cur_page = resp.data.page;
        _issue_total_pages = resp.data.total;

        $("#issue_total").text(_issue_total_pages);

        if (resp.ret !== '200') {
            notify_error(resp.msg, resp.data);
            loading.hide('#' + _options.list_render_id);
            return;
        }
        if (_issue_length > 0) {
            loading.show('#' + _options.list_render_id);
            for (let i in resp.data.issues) {
                if (resp.data.issues[i].start_date == '' || resp.data.issues[i].due_date == '') {
                    resp.data.issues[i].show_date_range = '';
                } else {
                    resp.data.issues[i].show_date_range = resp.data.issues[i].start_date + ' - ' + resp.data.issues[i].due_date;
                }
            }
            resp.data.display_fields = window.display_fields;
            resp.data.uiDisplayFields = window.uiDisplayFields;
            resp.data.issue_view  = window.issue_view ;

            var source = $('#' + _options.list_tpl_id).html();
            var template = Handlebars.compile(source);
            var result = template(resp.data);
            var table_footer_operation_tpl = $('#table_footer_operation_tpl').html();
            if (table_footer_operation_tpl != null && table_footer_operation_tpl != undefined){
                result += $('#table_footer_operation_tpl').html();
            }
            $('#' + _options.list_render_id).html(result);
            if(window.issue_view=='tree'){
                IssueMain.prototype.renderTreeTable(resp);
            }

            $('#issue_count').html(resp.data.total);
            $('#page_size').html(resp.data.page_size);

            $('#filtered-search-issue').attr("autocomplete", 'off');

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
                    IssueMain.prototype.skipPager(page);
                }
            };
            if(window.issue_view!='tree'){
                $('#ampagination-bootstrap').bootstrapPaginator(options);
            }

            //console.log(success);
            if (typeof (success) != 'undefined' && typeof (success) === "function") {
                success(resp.data);
            }

            $(".issue_edit_href").bind("click", function () {
                IssueMain.prototype.fetchEditUiConfig($(this).data('issue_id'), 'update');
            });

            $(".issue_copy_href").bind("click", function () {
                IssueMain.prototype.fetchEditUiConfig($(this).data('issue_id'), 'copy');
            });
            $(".issue_create_child").bind("click", function () {
                $("#btn-create-issue").click();
                $('#master_issue_id').val($(this).data('issue_id'));
                $('#create_master_div').show();
                $('#create_master_title').html($(this).data('title'));
            });

            $(".issue_convert_child_href").bind("click", function () {
                IssueMain.prototype.displayConvertChild($(this).data('issue_id'));
            });
            $(".issue_backlog_href").bind("click", function () {
                IssueMain.prototype.joinBacklog($(this).data('issue_id'));
            });
            $(".issue_sprint_href").bind("click", function () {
                IssueMain.prototype.displayJoinSprint($(this).data('issue_id'));
            });
            $(".issue_delete_href").bind("click", function () {
                IssueMain.prototype.delete($(this).data('issue_id'));
            });
            $(".issue_cancel_href").bind("click", function () {
                IssueMain.prototype.removeChild($(this).data('issue_id'));
            });
            // issue_follow_href
            $(".issue_follow_href").bind("click", function () {
                IssueMain.prototype.follow($(this).data('issue_id'), 'follow');
            });
            $(".issue_unfollow_href").bind("click", function () {
                IssueMain.prototype.follow($(this).data('issue_id'), 'un_follow');
            });

            $("time").each(function (i, el) {
                var t = moment(moment.unix(Number($(el).attr('datetime'))).format('YYYY-MM-DD HH:mm:ss')).fromNow()
                $(el).html(t)
            });

            $(".sprint-select > a").on("click", function(e){
                if(e.preventDefault){
                    e.preventDefault();
                 }else{
                    e.returnValue = false;
                 }
            });

            $(".module-select > a").on("click", function(e){
                if(e.preventDefault){
                    e.preventDefault();
                 }else{
                    e.returnValue = false;
                 }
            });

            $(".assignee-select > span > a").on("click", function(e){
                if(e.preventDefault){
                    e.preventDefault();
                 }else{
                    e.returnValue = false;
                 }
            });

            $(".priority-select > span").bind("dblclick", function () {
                var $self = $(this);
                var issue_id = $self.parent().data('issue_id');
                var list_box = $self.siblings(".priority-list");
                
                if (list_box.is(":visible")) {
                    return false;
                }
                list_box.slideDown(100);

                var priority_list = _issueConfig.priority;
                var html = "";
                for (let priority of priority_list) {
                    html += `<li data-color="${priority.status_color}" data-value="${priority.id}"><span style="color:${priority.status_color}" class="prepend-left-5">${priority.name}</span></li>`;
                }
                list_box.html(html);

                $(".priority-list li").on("click", function () {
                    var id = $(this).data("value");
                    var color = $(this).data("color")
                    var text = $(this).text()
                    IssueMain.prototype.updateIssuePriority(issue_id, id, $self, text, color);
                });

                $(document).on("click", function () {
                    list_box.slideUp(100);
                })
            });

            $(".module-select > a").bind("dblclick", function () {
                if(cur_project_id ===''){
                    notify_warn('提示','需要进入项目才能修改');
                    return false;
                }
                var $self = $(this);
                var issue_id = $self.parent().data('issue_id');
                var list_box = $self.siblings(".module-list");
                
                if (list_box.is(":visible")) {
                    return false;
                }
                list_box.slideDown(100);

                var module_list = _issueConfig.issue_module;
                //console.log(module_list);
                var html = "";
                for (let value of  module_list) {
                    html += `<li data-name="${value.name}" data-value="${value.k}"><span class="prepend-left-5">${value.name}</span></li>`;
                }
                list_box.html(html);

                $(".module-list li").on("click", function () {
                    var id = $(this).data("value");
                    var name = $(this).data("name")
                    var text = $(this).text()
                    IssueMain.prototype.updateIssueModule(issue_id, id, $self, text, name);
                });

                $(document).on("click", function () {
                    list_box.slideUp(100);
                });
                return false;
            });
            

            $(".sprint-select > a").bind("dblclick", function (e) {
                if(cur_project_id ===''){
                    notify_warn('提示','需要进入项目才能修改');
                    return false;
                }
                var $self = $(this);
                var issue_id = $self.parent().data('issue_id');
                var list_box = $self.siblings(".sprint-list");
                
                if (list_box.is(":visible")) {
                    return false;
                }
                list_box.slideDown(100);

                var sprint_list = _issueConfig.sprint;
                var html = "";
                for (var i = 0; i < sprint_list.length; i++) {
                    html += `<li data-name="${sprint_list[i].name}" data-value="${sprint_list[i].id}"><span class="prepend-left-5">${sprint_list[i].name}</span></li>`;
                }
                list_box.html(html);

                $(".sprint-list li").on("click", function () {
                    var id = $(this).data("value");
                    var name = $(this).data("name")
                    IssueMain.prototype.updateIssueSprint(issue_id, id, $self, name);
                });

                $(document).on("click", function () {
                    list_box.slideUp(100);
                });
                return false;
            });

            $(".assignee-select > span > a").bind("dblclick", function () {
                if(cur_project_id ===''){
                    notify_warn('提示','需要进入项目才能修改');
                    return false;
                }
                var $self = $(this);
                var issue_id = $self.parent().parent().data('issue_id');
                var list_box = $self.parent().siblings(".assignee-list");
                
                if (list_box.is(":visible")) {
                    return false;
                }
                list_box.slideDown(100);

                var assignee_list = _issueConfig.project_users;
                var html = "";
                for (var i = 0; i < assignee_list.length; i++) {
                    html += `<li data-img="${assignee_list[i].avatar}" data-name="${assignee_list[i].display_name}" data-value="${assignee_list[i].uid}"><img class="assignee-img" src="${assignee_list[i].avatar}" /><span>${assignee_list[i].display_name}</span></li>`;
                }
                list_box.html(html);

                $(".assignee-list li").on("click", function () {
                    var id = $(this).data("value");
                    var img = $(this).data("img");
                    var text = $(this).data("name");
                    IssueMain.prototype.updateIssueAssignee(issue_id, id, $self, name, img);
                });

                $(document).on("click", function () {
                    list_box.slideUp(100);
                });                
            });

            $(".resolve-select2").bind("dblclick", function () {
                var $self = $(this);
                let issue_id = $self.data('issue_id');
                let list_box = $('#ul_tree_select_'+issue_id);
                if (list_box.is(":visible")) {
                    return false;
                }
                list_box.slideDown(100);

                var resolve_list = _issueConfig.issue_resolve;
                console.log(resolve_list);
                let html = "";
                for (let i=0; i<resolve_list.length; i++) {
                    let resolve = resolve_list[i];
                   // html += `<li>1111</li>`;
                    html += `<li data-color="${resolve.color}" data-value="${resolve.id}"><span style="color:${resolve.color}" class="prepend-left-5">${resolve.name}</span></li>`;
                }
                list_box.html(html);
                console.log(list_box, html);
                list_box.children('li').on("click", function () {
                    var id = $(this).data("value");
                    var color = $(this).data("color")
                    var text = $(this).text()
                    IssueDetail.prototype.updateIssueResolve(issue_id, id, $self, text, color);
                });
                $(document).on("click", function () {
                    list_box.slideUp(100);
                })

            });

            $(".status-select .label").bind("dblclick", function () {
                let $self = $(this);
                let issue_id = $self.parent().data('issue_id');
                let list_box = $self.siblings(".status-list");

                if (list_box.is(":visible")) {
                    return false;
                }
                list_box.slideDown(100);
                loading.show(`#status-list-${issue_id}`);

                $.ajax({
                    type: 'get',
                    dataType: "json",
                    async: true,
                    url: root_url + "issue/main/fetch_issue_edit",
                    data: { issue_id: issue_id },
                    success: function (resp) {
                        auth_check(resp);
                        loading.hide(`#status-list-${issue_id}`);
                        if (resp.ret != '200') {
                            notify_error('获取状态失败:' + resp.msg);
                            return;
                        }
                        let status_list = resp.data.issue.allow_update_status;
                        let html = "";
                        for (let i=0; i<status_list.length; i++) {
                            let status = status_list[i];
                            html += `<li data-value="${status.id}" data-color="${status.color}"><span class="label label-${status.color} prepend-left-5">${status.name}</span></li>`;
                        }
                        list_box.html(html);

                        $(".status-list li").on("click", function () {
                            let id = $(this).data("value");
                            let text = $(this).text();
                            let color = $(this).data("color")
                            IssueDetail.prototype.updateIssueStatus(issue_id, id, $self, text, color)
                        });

                        $(document).on("click", function () {
                            list_box.slideUp(100);
                        })

                    },
                    error: function (res) {
                        notify_error("请求数据错误" + res);
                    }
                });
            });

            $(".date-select-edit").bind("click", function () {
                let $self = $(this);
                let issue_id = $self.data('issue_id');
                let myDate = new Date();
                laydate.render({
                    elem: this
                    , trigger: 'click'
                    , range: true
                    , done: function (value, date, endDate) {
                        $.ajax({
                            type: 'post',
                            dataType: "json",
                            async: true,
                            url: root_url + "issue/main/update",
                            data: { issue_id: issue_id, params: { start_date: date.year + '-' + date.month + '-' + date.date, due_date: endDate.year + '-' + endDate.month + '-' + endDate.date } },
                            success: function (resp) {
                                auth_check(resp);
                                if (resp.ret != '200') {
                                    notify_error('操作失败:' + resp.msg);
                                    return;
                                }
                                notify_success('操作成功');
                                //window.location.reload();
                            },
                            error: function (res) {
                                notify_error("请求数据错误" + res);
                            }
                        });
                    }
                    //,value: myDate.getFullYear() + '-' + myDate.getMonth() + '-' + myDate.getDate() + ' - ' + myDate.getFullYear() + '-' + myDate.getMonth() + '-' + myDate.getDate()
                });
            });

            IssueMain.prototype.treeBindEvent();

            $(".have_children").bind("click", function () {
                if (isFloatPart) {
                    var issue_id = $(this).data('issue_id');
                    $('#tr_subtask_' + issue_id).removeClass('hide');
                    IssueMain.prototype.fetchChildren(issue_id, 'ul_subtask_' + issue_id);
                }
            });

            $("#btn-join_sprint").bind("click", function () {
                console.log("保存")
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

        } else {
            loading.hide('#' + _options.list_render_id)
            var additionHtml = '';
            if (window._permCreateIssue) {
                var additionHtml = '<a class="btn btn-new js-create-issue">创建事项</a>';
            }
            var emptyHtml = defineStatusHtml({
                message: '没有事项数据',
                name: 'issue',
                handleHtml: additionHtml
            })
            $('#list_render_id').html($('<tr><td colspan="12" id="list_render_id_wrap"></td></tr>'))
            $('#list_render_id_wrap').append(emptyHtml.html)

            $(".js-create-issue").bind('click', function () {
                $("#btn-create-issue").trigger("click");
            })
        }
    };
    IssueMain.prototype.treeBindEvent = function () {

        $(".span-labels_edit").bind("click", function () {
            let $self = $(this);
            let issue_id_arr = $self.data('issue_id_arr').split(',');
            let issue_id = $self.data('issue_id')
            let list_box = $('#labels-list-'+issue_id);
            let is_can_ajax = 1;

            if (list_box.is(":visible")) {
                return false;
            }
            list_box.slideDown(100);
            //list_box.show();
            let labels_list = _issueConfig.issue_labels;
            let html = "";
            for (let i=0; i<labels_list.length; i++) {
                let label = labels_list[i];
                let checked = '';
                if(in_array(labels_list[i].id, issue_id_arr)){
                    checked = '<span style="margin-left: 20px" class="fa fa-check check-mark"></span>';
                }
                html += `<li data-value="${label.id}"  ><span class="label color-label " style="background-color:${label.bg_color}; color:${label.color}">${label.title}</span>${checked}</li>`;
            }
            list_box.html(html);
            setTimeout( function(){
                $(document).on("click", function (event) {
                    if($(event.target).is("#labels-list-"+issue_id+",#labels-list-"+issue_id+" *")){
                        console.log(event.target);
                    }else{
                        if($(event.target).is(".span-labels_edit *")){

                        }else{
                            list_box.slideUp(100);
                            // 这里处理获取命中的
                            var selectIdArr = [];
                            list_box.find('li').each(function(){
                                let id = $(this).data("value");
                                let fa_check = $(this).find('.fa-check');
                                if(fa_check.length>0){
                                    selectIdArr.push(id);
                                }
                            });

                            if(is_can_ajax!=1){
                                return;
                            }
                            if(is_empty(selectIdArr) && is_empty(issue_id_arr)){
                                return;
                            }
                            if( selectIdArr.join(',') == issue_id_arr.join(',')){
                                return;
                            }
                            $.ajax({
                                type: 'post',
                                dataType: "json",
                                async: true,
                                url: root_url + "issue/main/update",
                                data: { issue_id: issue_id, params: {labels: selectIdArr} ,ignore_param:1},
                                success: function (resp) {
                                    auth_check(resp);
                                    if (resp.ret != '200') {
                                        notify_error('操作失败:' + resp.msg);
                                        return;
                                    }
                                    notify_success('操作成功');
                                   // window.location.reload();
                                    let html = '';
                                    let issue_id_arr_str = selectIdArr.join(',');
                                    html += make_label_html(selectIdArr);
                                    html += '<span data-issue_id="'+issue_id+'" data-issue_id_arr="'+issue_id_arr_str+'" style="margin-left: 4px;cursor: pointer;color:#1b69b6;" class="span-labels_edit hide">';
                                    html +=  '<i class="fa fa-pencil">'
                                    html += '</span>';
                                    html += '<div id="div-labels-list-'+issue_id+'"  class="item-list-select labels-select" data-issue_id="'+issue_id+'">'
                                    html += '<ul  id="labels-list-'+issue_id+'" class="item-data-list labels-list"></ul>';
                                    html += '</div>';
                                    $self.parent().html(html);
                                    is_can_ajax = 0;
                                    IssueMain.prototype.treeBindEvent()

                                },
                                error: function (res) {
                                    notify_error("请求数据错误" + res);
                                }
                            });
                        }
                    }
                })
            }, 1000);
            $(".labels-list li").on("click", function () {
                let id = $(this).data("value");
                let fa_check = $(this).find('.fa-check');
                console.log(fa_check.length);
                if(fa_check.length>0){
                    fa_check.remove();
                }else{
                    $(this).append('<span style="margin-left: 20px" class="fa fa-check check-mark"></span>');
                }
            });
        });

        $(".span-assistants_edit").bind("click", function () {
            let $self = $(this);
            let assistants_arr = $self.data('assistants').split(',');
            let issue_id = $self.data('issue_id')
            let list_box = $('#assistants-list-'+issue_id);
            let is_can_ajax = 1;

            if (list_box.is(":visible")) {
                return false;
            }
            list_box.slideDown(100);
            //list_box.show();
            let users_list = _issueConfig.users;
            let html = "";
            for (let i=0; i<users_list.length; i++) {
                let user = users_list[i];
                let checked = '';
                if(in_array(users_list[i].uid, assistants_arr)){
                    checked = '<span style="float: right" class="fa fa-check check-mark"></span>';
                }
                html += `<li data-value="${user.uid}" style="text-align: left;" > <img width="26px" height="26px"  style="border-radius: 50%;"  title="${user.username}@${user.display_name}" src="${user.avatar}" /> ${checked}</li>`;
            }
            list_box.html(html);
            setTimeout( function(){
                $(document).on("click", function (event) {
                    if($(event.target).is("#assistants-list-"+issue_id+",#assistants-list-"+issue_id+" *")){
                        console.log(event.target);
                    }else{
                        if($(event.target).is(".span-assistants_edit *")){

                        }else{
                            list_box.slideUp(100);
                            // 这里处理获取命中的
                            var selectIdArr = [];
                            list_box.find('li').each(function(){
                                let id = $(this).data("value");
                                let fa_check = $(this).find('.fa-check');
                                if(fa_check.length>0){
                                    selectIdArr.push(id);
                                }
                            });

                            if(is_can_ajax!=1){
                                return;
                            }
                            if(is_empty(selectIdArr) && is_empty(assistants_arr)){
                                return;
                            }
                            if( selectIdArr.join(',') == assistants_arr.join(',')){
                                return;
                            }
                            $.ajax({
                                type: 'post',
                                dataType: "json",
                                async: true,
                                url: root_url + "issue/main/update",
                                data: { issue_id: issue_id, params: {assistants: selectIdArr} ,ignore_param:1},
                                success: function (resp) {
                                    auth_check(resp);
                                    if (resp.ret != '200') {
                                        notify_error('操作失败:' + resp.msg);
                                        return;
                                    }
                                    notify_success('操作成功');
                                    // window.location.reload();
                                    let html = '';
                                    if(is_table_display_avatar=='1'){
                                        html += issue_assistants_avatar(selectIdArr)
                                    }else{
                                        html += issue_assistants_display_name(selectIdArr)
                                    }
                                    let assistants_str = selectIdArr.join(',');
                                    html += '<span data-issue_id="'+issue_id+'" data-assistants="'+assistants_str+'" style="margin-left: 4px;cursor: pointer;color:#1b69b6;" class="span-assistants_edit hide">';
                                    html +=  '<i class="fa fa-pencil">'
                                    html += '</span>';
                                    html += '<div id="div-assistants-list-'+issue_id+'"  class="item-list-select assistants-select" data-issue_id="'+issue_id+'">'
                                    html += '<ul  style="text-align: left;"  id="assistants-list-'+issue_id+'" class="item-data-list assistants-list"></ul>';
                                    html += '</div>';
                                    $self.parent().html(html);
                                    is_can_ajax = 0;
                                    IssueMain.prototype.treeBindEvent()

                                },
                                error: function (res) {
                                    notify_error("请求数据错误" + res);
                                }
                            });
                        }
                    }
                })
            }, 1000);
            $(".assistants-list li").on("click", function () {
                let id = $(this).data("value");
                let fa_check = $(this).find('.fa-check');
                console.log(fa_check.length);
                if(fa_check.length>0){
                    fa_check.remove();
                }else{
                    $(this).append('<span  style="float: right"  class="fa fa-check check-mark"></span>');
                }
            });
        });
        $(".min_width_300").mouseenter(function() {
            $(this).children(".summary_children ").show();
        });
        $(".min_width_300").mouseleave(function() {
            $(this).children(".summary_children ").hide();
        });

        $(".td-labels-class").mouseenter(function() {
            $(this).children(".span-labels_edit").show();
        });
        $(".td-labels-class").mouseleave(function() {
            $(this).children(".span-labels_edit").hide();
        });
        $(".td-assistants-class").mouseenter(function() {
            $(this).children(".span-assistants_edit").show();
        });
        $(".td-assistants-class").mouseleave(function() {
            $(this).children(".span-assistants_edit").hide();
        });
    }
    IssueMain.prototype.renderTreeTable = function (resp) {
        var columns = [
            { field: 'check',  checkbox: true, formatter: function (value, row, index) {
                    if (row.check == true) {
                        // console.log(row.serverName);
                        //设置选中
                        return {  checked: true };
                    }
                }
            },
            {field: 'summary',  title: '标 题' , class:"min_width_300",  formatter:  function (value, row, index) {
                    let html = '<a  href="javascript:linkIssue('+row.id+')"   class="commit-row-message" >';
                    html += lightSearch(value, row.search);
                    html += '</a>';
                    if(row.warning_delay =='1'){
                        html += '<span style="color:#fc9403;margin-left: 4px" title="即将延期">即将延期</span>';
                    }
                    if(row.postponed =='1'){
                        html += '<span style="color:#db3b21;margin-left: 4px" title="逾期">逾期</span>';
                    }
                    if(row.have_children >0){
                        html += '<span class="badge"  style=";margin-left: 4px" title="拥有的子任务数">'+row.have_children+'</span>';
                    }
                    html += '<span class="summary_children hide">';
                    html += '<a title="以新标签页打开此事项" target="_blank" href="/issue/detail/index/'+row.id+'" class="" style="margin-left:4px;"  ><i class="fa fa-link" ></i></a>';
                    html += IssueMain.prototype.getTreeOptHtml(row)
                    html += '</span>';
                    return html
                }
            },
        ];

        let column = {field: 'issue_num',  title: '编 号', sortable: true,  align: 'left', formatter:  function (value, row, index) {
                return '#'+value
            }
        }
        columns.push( column)

        if(isInArray(resp.data.display_fields,'issue_type')){
            let column = {field: 'issue_type',  title: '类 型', sortable: true,  align: 'center', formatter:  function (value, row, index) {
                    return issue_type_short_html(value)
                }
            }
            columns.push( column)
        }
        if(isInArray(resp.data.display_fields,'priority')){
            let column = {field: 'priority',  title: '优先级', sortable: true,  align: 'center', formatter:  function (value, row, index) {
                    let html = ''
                    html += '<div title="双击可直接修改" class="item-list-select priority-select" data-issue_id="'+row.id+'" id="priority-list-'+row.id+'" style="cursor: pointer;">'
                    html += priority_html(value);
                    html += '<ul class="item-data-list priority-list"></ul>';
                    html += '</div>';
                    return html
                }
            }
            columns.push( column)
        }
        if(isInArray(resp.data.display_fields,'project_id')){
            let column = {field: 'project_id',  title: '项 目',   align: 'center', formatter:  function (value, row, index) {
                    return make_project(value)
                }
            }
            columns.push( column)
        }
        if(isInArray(resp.data.display_fields,'module')){
            let column = {field: 'module',  title: '模 块', sortable: true,  align: 'center', formatter:  function (value, row, index) {
                    let html = ''
                    html += '<div  title="双击可直接修改" class="item-list-select module-select" data-issue_id="'+row.id+'" id="module-list-'+row.id+'">'
                    html += module_html(value);
                    html += '<ul class="item-data-list module-list"></ul>';
                    html += '</div>';
                    return html
                }
            }
            columns.push( column)
        }
        if(isInArray(resp.data.display_fields,'sprint')){
            let column = {field: 'sprint',  title: '迭 代', sortable: true,  align: 'center', formatter:  function (value, row, index) {
                    let html = ''
                    html += '<div  title="双击可直接修改" class="item-list-select sprint-select" data-issue_id="'+row.id+'" id="sprint-list-'+row.id+'">'
                    html += make_issue_sprint(value);
                    html += '<ul class="item-data-list sprint-list"></ul>';
                    html += '</div>';
                    return html
                }
            }
            columns.push( column)
        }
        if(isInArray(resp.data.display_fields,'label')){
            let column = {field: 'label',  title: '标 签', class:"td-labels-class",  align: 'left', formatter:  function (value, row, index) {
                    let html = '';
                    let issue_id_arr_str = row.label_id_arr.join(',');
                    html += make_label_html(row.label_id_arr);
                    html += '<span data-issue_id="'+row.id+'" data-issue_id_arr="'+issue_id_arr_str+'" style="margin-left: 4px;cursor: pointer;color:#1b69b6;" class="span-labels_edit hide">';
                    html +=  '<i class="fa fa-pencil">'
                    html += '</span>';
                    html += '<div id="div-labels-list-'+row.id+'"  class="item-list-select labels-select" data-issue_id="'+row.id+'">'
                    html += '<ul  id="labels-list-'+row.id+'" class="item-data-list labels-list"></ul>';
                    html += '</div>';
                    return html;
                }
            }
            columns.push( column)
        }

        if(isInArray(resp.data.display_fields,'weight')){
            let column = {field: 'weight',  title: '权重值', sortable: true,  align: 'center', formatter:  function (value, row, index) {
                    return value
                }
            }
            columns.push( column)
        }
        if(isInArray(resp.data.display_fields,'assignee')){
            let column = {field: 'assignee',  title: '经办人', sortable: true,  align: 'center', formatter:  function (value, row, index) {
                    let html = ''
                    html += '<div  title="双击可直接修改" class="item-list-select assignee-select" data-issue_id="'+row.id+'" id="assignee-list-'+row.id+'">'
                    if(resp.data.is_table_display_avatar=='1'){
                        html += user_html(value)
                    }else{
                        html += user_html_display_name(value)
                    }
                    html += '<ul class="item-data-list assignee-list"></ul>';
                    html += '</div>';
                    return html
                }
            }
            columns.push( column)
        }
        if(isInArray(resp.data.display_fields,'reporter')){
            let column = {field: 'reporter',  title: '报告人', sortable: true,  align: 'center', formatter:  function (value, row, index) {
                    if(resp.data.is_table_display_avatar=='1'){
                        return user_html(value)
                    }else{
                        return user_html_display_name(value)
                    }
                }
            }
            columns.push( column)
        }
        if(isInArray(resp.data.display_fields,'assistants')){
            let column = {field: 'assistants',  title: '协助人', class:"td-assistants-class", align: 'center', formatter:  function (value, row, index) {
                    let html = '';
                    if(resp.data.is_table_display_avatar=='1'){
                        html += issue_assistants_avatar(row.assistants_arr)
                    }else{
                        html += issue_assistants_display_name(row.assistants_arr)
                    }
                    html += '<span data-issue_id="'+row.id+'" data-assistants="'+row.assistants+'" style="margin-left: 4px;cursor: pointer;color:#1b69b6;" class="span-assistants_edit hide">';
                    html +=  '<i class="fa fa-pencil">'
                    html += '</span>';
                    html += '<div id="div-assistants-list-'+row.id+'"  class="item-list-select assistants-select" data-issue_id="'+row.id+'">'
                    html += '<ul style="text-align: left;" id="assistants-list-'+row.id+'" class="item-data-list assistants-list"></ul>';
                    html += '</div>';
                    return html;
                }
            }
            columns.push( column)
        }
        if(isInArray(resp.data.display_fields,'status')){
            let column = {field: 'status',  title: '状 态', sortable: true,  align: 'center', formatter:  function (value, row, index) {
                    let html = ''
                    html += '<div title="双击可直接修改" class="item-list-select status-select" data-issue_id="'+row.id+'" id="status-list-'+row.id+'">'
                    html += status_html(value);
                    html += '<ul class="item-data-list status-list"></ul>';
                    html += '</div>';
                    return html
                }
            }
            columns.push( column)
        }
        if(isInArray(resp.data.display_fields,'resolve')){
            let column = {field: 'resolve',  title: '解决结果', sortable: true,  align: 'center', formatter:  function (value, row, index) {
                    let html = ''
                    html += '<div title="双击可直接修改" style="cursor: pointer"  class="item-list-select resolve-select2" data-issue_id="'+row.id+'" id="resolve-list-'+row.id+'">'
                    html += resolve_html(value);
                    html += '<ul id="ul_tree_select_'+row.id+'" class="item-data-list resolve-select2"></ul>';
                    html += '</div>';
                    return html
                }
            }
            columns.push( column)
        }
        if(isInArray(resp.data.display_fields,'environment')){
            let column = {field: 'environment',  title: '环 境', sortable: true,  align: 'center', formatter:  function (value, row, index) {
                    return value
                }
            }
            columns.push( column)
        }
        if(isInArray(resp.data.display_fields,'plan_date')){
            let column = {field: 'plan_date',  title: '计划日期', sortable: true,  align: 'center', formatter:  function (value, row, index) {
                let html = '<small class="no-value date-select-edit" id="date-select-show-'+row.id+'" data-issue_id="'+row.id+'" style="display:block;width: 100%;height: 20px;cursor:pointer;">'+row.show_date_range+'\n' +
                    '</small>';
                return  html;
                }
            }
            columns.push( column)
        }
        if(isInArray(resp.data.display_fields,'resolve_date')){
            let column = {field: 'resolve_date',  title: '解决日期', sortable: true,  align: 'center', formatter:  function (value, row, index) {
                    return value
                }
            }
            columns.push( column)
        }
        if(isInArray(resp.data.display_fields,'modifier')){
            let column = {field: 'modifier',  title: '修改人', sortable: true,  align: 'center', formatter:  function (value, row, index) {
                    if(resp.data.is_table_display_avatar=='1'){
                        return user_html(value)
                    }else{
                        return user_html_display_name(value)
                    }
                }
            }
            columns.push( column)
        }
        if(isInArray(resp.data.display_fields,'master_id')){
            let column = {field: 'master_id',  title: '父任务', sortable: true,  align: 'center', formatter:  function (value, row, index) {
                    if(row.have_children=='1'){
                        return '是'
                    }else{
                        return '否'
                    }
                }
            }
            columns.push( column)
        }
        if(isInArray(resp.data.display_fields,'created')){
            let column = {field: 'created',  title: '创建时间', sortable: true,  align: 'center', formatter:  function (value, row, index) {
                    return row.created_text
                }
            }
            columns.push( column)
        }
        if(isInArray(resp.data.display_fields,'updated')){
            let column = {field: 'updated',  title: '更新时间', sortable: true,  align: 'center', formatter:  function (value, row, index) {
                    return row.updated_text
                }
            }
            columns.push( column)
        }
        let  columnOpt = {field: 'operate', class:"min_width_80",  title: '操 作',  align: 'center',events : operateEvents, formatter:  function (value, row, index) {
                let html = '';
                html += '<span class="summary_children">';
                html += IssueMain.prototype.getTreeOptHtml(row)
                html += '</span>';
                return html;
            }
        }
        columns.push( columnOpt)
        if(is_tree_table_init==0){
            $tree_table.bootstrapTable({
                data: resp.data.issues,
                idField: 'id',
                dataType:'json',
                columns: columns,
                // bootstrap-table-treegrid.js 插件配置 -- start
                //在哪一列展开树形
                treeShowField: 'summary',
                //指定父id列
                parentIdField: 'master_id',
                onResetView: function(data) {
                    //console.log('load');
                    $tree_table.treegrid({
                        initialState: 'expanded',// 所有节点都折叠  collapsed | expanded
                        // initialState: 'expanded',// 所有节点都展开，默认展开
                        treeColumn: 1,
                        // expanderExpandedClass: 'glyphicon glyphicon-minus',  //图标样式
                        // expanderCollapsedClass: 'glyphicon glyphicon-plus',
                        onChange: function() {
                            $tree_table.bootstrapTable('resetWidth');
                        }
                    });
                    //只展开树形的第一级节点
                    $tree_table.treegrid('getRootNodes').treegrid('expand');
                },
                onCheck:function(row){
                    var datas = $tree_table.bootstrapTable('getData');
                    // 勾选子类
                   // selectChilds(datas,row,"id","master_id",true);
                    // 勾选父类
                    //selectParentChecked(datas,row,"id","master_id")
                    // 刷新数据
                    $tree_table.bootstrapTable('load', datas);
                },
                onUncheck:function(row){
                    var datas = $tree_table.bootstrapTable('getData');
                    selectChilds(datas,row,"id","master_id",false);
                    $tree_table.bootstrapTable('load', datas);
                },
                // bootstrap-table-treetreegrid.js 插件配置 -- end
            });
            is_tree_table_init = 1;
        }else{
            $tree_table.bootstrapTable('load', resp.data.issues);
        }

        $('.fixed-table-body').css("min-height", '600px');
        IssueMain.prototype.treeExpandOr(resp.data.issue_tree_is_expand);
    };
    IssueMain.prototype.treeExpandOr = function (issue_tree_is_expand) {
        if (issue_tree_is_expand=='1') {
            $(".treegrid-expander-collapsed").each(function () {
                    $(this).click();
                }
            );
        }else{
            $(".treegrid-expander-expanded").each(function () {
                    $(this).click();
                }
            );
        }
    }

    IssueMain.prototype.getTreeOptHtml = function (row) {
        let html = '';
        if(window._is_admin|| isInArray(window._projectPermArr,'CREATE_ISSUES')){
            html += '<a title="添加子任务" id="i-add-children-'+row.id+'" href="#" class="RoleOfadd issue_create_child" style="margin-left:5px;"  data-issue_id="'+row.id+'"  ><i class="fa fa-plus" ></i></a>';
        }
        if(window._is_admin|| isInArray(window._projectPermArr,'EDIT_ISSUES')){
            html += '<a title="编辑事项" href="#" class="RoleOfedit issue_edit_href" style="margin-left:4px;"  data-issue_id="'+row.id+'" ><i class="fa fa-pencil-square-o" ></i></a>';
        }
        html += '<div class="js-notification-dropdown notification-dropdown project-action-button dropdown inline">';
        html += '<div class="js-notification-toggle-btns">';
        html += '<div class="">';
        html += '<a class="dropdown-new  notifications-btn " style="margin-left:4px;" href="#" data-target="dropdown-15-31-Project" data-toggle="dropdown"  type="button" aria-expanded="false">';
        html += '...';
        html += '</a>';
        html += '<ul class="dropdown dropdown-menu dropdown-menu-no-wrap dropdown-menu-selectable" style="left:-120px;width:160px;min-width:140px; ">';
        if(window._is_admin || isInArray(window._projectPermArr,'CREATE_ISSUES')) {
            html += '<li class="aui-list-item"><a href="javascript:;" class="issue_copy_href"  data-issue_id="'+row.id+'"  >复制</a></li>';
        }
        if(row.master_id!="0"){
            if(window._is_admin || isInArray(window._projectPermArr,'EDIT_ISSUES')){
                html += '<li class="aui-list-item"><a href="javascript:;" class="issue_cancel_href"   title="取消子任务"  data-issue_id="'+row.id+'" >取消子任务</a></li>';
            }
        }

        if(window._is_admin || isInArray(window._projectPermArr,'EDIT_ISSUES')){
            html += '<li class="aui-list-item"><a href="javascript:;" class="issue_convert_child_href"   title="转为子任务"  data-issue_id="'+row.id+'" >转为子任务</a></li>';
        }

        if(window._is_admin || isInArray(window._projectPermArr,'EDIT_ISSUES')) {
            if (row.sprint == '0') {
                html += '<li class="aui-list-item"><a href="javascript:;"  title="添加到迭代"  class="issue_sprint_href" data-issue_id="' + row.id + '" >添加到迭代</a></li>';
            } else {
                html += '<li class="aui-list-item"><a href="javascript:;"  title="转换为待办事项"  class="issue_backlog_href" data-issue_id="' + row.id + '" >转换为待办事项</a></li>';
            }
        }
        if(row.is_followed==2){
            html += '<li class="aui-list-item"><a href="javascript:;"  title="关注"  class="issue_follow_href" data-issue_id="'+row.id+'" >关注</a></li>';
        }else{
            html += '<li class="aui-list-item"><a href="javascript:;"  title="取消关注"  class="issue_unfollow_href" data-issue_id="'+row.id+'" >取消关注</a></li>';
        }
        if(window._is_admin|| isInArray(window._projectPermArr,'DELETE_ISSUES')){
            html += '<li class="aui-list-item"><a href="javascript:;" class="issue_delete_href"  style="color:red"  title="删除事项"  data-issue_id="'+row.id+'" >删除</a></li>';
        }
        html += '</ul>';
        html += '</div></div></div>';

        return html;
    }
    IssueMain.prototype.displayConvertChild = function (issue_id) {
        $('#current_issue_id').val(issue_id);
        $('#btn-parent_select_issue').data('issue-id', issue_id);
        $.ajax({
            type: 'get',
            dataType: "json",
            async: true,
            url:  "/issue/main/autocomplete",
            data: { issue_id: issue_id, init: true },
            success: function (resp) {
                $('#parent_select_issue_id').select2({data: resp.data});
                $('#modal-choose_parent').modal('show');
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    };

    IssueMain.prototype.convertChild = function (issue_id) {

        var master_id = $("#parent_select_issue_id").val();
        $.ajax({
            type: 'post',
            dataType: "json",
            async: true,
            url: root_url + "issue/main/convertChild",
            data: { issue_id: issue_id, master_id: master_id },
            success: function (resp) {
                auth_check(resp);
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

    IssueMain.prototype.removeChild = function (issue_id) {
        $.ajax({
            type: 'post',
            dataType: "json",
            async: true,
            url: root_url + "issue/main/removeChild",
            data: { issue_id: issue_id },
            success: function (resp) {
                auth_check(resp);
                if (resp.ret != '200') {
                    notify_error('操作失败:' + resp.msg);
                    return;
                }
                notify_success('操作成功');
                setTimeout(function(){
                    window.location.reload();
                }, 600);

            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    };

    IssueMain.prototype.follow = function (issue_id, follow_action) {

        var method = 'get';
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: root_url + "issue/main/" + follow_action,
            data: { issue_id: issue_id },
            success: function (resp) {
                auth_check(resp);
                if (resp.ret == '200') {
                    notify_success('操作成功');
                    setTimeout(function(){
                        window.location.reload();
                    }, 600);
                } else {
                    notify_error(resp.msg);
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    IssueMain.prototype.fetchChildren = function (issue_id, display_id) {
        loading.show('#' + display_id);
        $.ajax({
            type: 'get',
            dataType: "json",
            async: true,
            url: root_url + "issue/main/getChildIssues",
            data: { issue_id: issue_id },
            success: function (resp) {

                auth_check(resp);
                if (resp.ret != '200') {
                    notify_error('获取子任务失败:' + resp.msg);
                    return;
                }
                var source = $('#main_children_list_tpl').html();
                var template = Handlebars.compile(source);
                var result = template(resp.data);
                console.log(resp.data);
                $('#' + display_id).html(result);
                loading.hide('#' + display_id);

            },
            error: function (res) {
                loading.hide('#' + display_id);
                notify_error("请求数据错误" + res);
            }
        });
    }

    IssueMain.prototype.joinBacklog = function (issue_id) {
        $.ajax({
            type: 'post',
            dataType: "json",
            async: true,
            url: root_url + "agile/joinBacklog",
            data: { issue_id: issue_id },
            success: function (resp) {

                auth_check(resp);
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
            url: root_url + "agile/fetchSprints",
            data: { project_id: _cur_project_id, issue_id: issue_id },
            success: function (resp) {

                auth_check(resp);
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
            url: root_url + "agile/joinSprint",
            data: { sprint_id: sprint_id, issue_id: issue_id },
            success: function (resp) {
                auth_check(resp);
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
            url: root_url + "issue/main/getChildIssues",
            data: { issue_id: issue_id },
            success: function (resp) {

                auth_check(resp);
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
        swal({
            title: "您确定删除该事项吗?",
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
            function (isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        type: 'post',
                        dataType: "json",
                        async: true,
                        url: root_url + "issue/main/delete",
                        data: { issue_id: issue_id },
                        success: function (resp) {
                            auth_check(resp);
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
                } else {
                    swal.close();
                }
            });
    }

    IssueMain.prototype.detailDelete = function (issue_id) {
        swal({
            title: "您确定删除该事项吗?",
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
            function (isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        type: 'post',
                        dataType: "json",
                        async: true,
                        url: root_url + "issue/main/delete",
                        data: { issue_id: issue_id },
                        success: function (resp) {
                            auth_check(resp);
                            if (resp.ret != '200') {
                                notify_error('删除失败:' + resp.msg);
                                return;
                            }
                            notify_success('操作成功');
                            if (cur_path_key != '') {
                                window.location.href = cur_path_key;
                            } else {
                                window.location.href = '/';
                            }

                        },
                        error: function (res) {
                            notify_error("请求数据错误" + res);
                        }
                    });
                } else {
                    swal.close();
                }
            });
    }
    IssueMain.prototype.detailClose = function (issue_id) {

        $.ajax({
            type: 'post',
            dataType: "json",
            async: true,
            url: root_url + "issue/main/close",
            data: { issue_id: issue_id },
            success: function (resp) {
                auth_check(resp);
                if (resp.ret != '200') {
                    notify_error('关闭事项失败:' + resp.msg);
                    return;
                }
                notify_success(resp.msg);
                window.location.reload();
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    IssueMain.prototype.getSelectedIdArr = function () {
        var checked_issue_id_arr = new Array();
        if(window.issue_view=='tree'){
            var selRows = $tree_table.bootstrapTable("getSelections");
            if(selRows.length > 0){
                $.each(selRows,function(i) {
                    checked_issue_id_arr.push(this.id);
                });
            }

        }else{
            $.each($("input[name='check_issue_id_arr']"), function () {
                if (this.checked) {
                    checked_issue_id_arr.push($(this).val());
                }
            });
        }
        console.log(checked_issue_id_arr);
        return checked_issue_id_arr;
    }

    IssueMain.prototype.batchDelete = function () {

        swal({
            title: "您确定删除选择的事项吗?",
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
            function (isConfirm) {
                if (isConfirm) {
                    var checked_issue_id_arr = IssueMain.prototype.getSelectedIdArr();
                    $.ajax({
                        type: 'post',
                        dataType: "json",
                        async: true,
                        url: root_url + "issue/main/batchDelete",
                        data: { issue_id_arr: checked_issue_id_arr },
                        success: function (resp) {
                            auth_check(resp);
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
                } else {
                    swal.close();
                }
            });
    }

    IssueMain.prototype.batchUpdate = function (field, value) {
        var checked_issue_id_arr = IssueMain.prototype.getSelectedIdArr();
        $.ajax({
            type: 'post',
            dataType: "json",
            async: true,
            url: root_url + "issue/main/batchUpdate",
            data: { issue_id_arr: checked_issue_id_arr, field: field, value: value },
            success: function (resp) {
                auth_check(resp);
                if (resp.ret != '200') {
                    notify_error('操作失败:' + resp.msg);
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

    IssueMain.prototype.batchMoveProject = function (field, value) {
        var checked_issue_id_arr = IssueMain.prototype.getSelectedIdArr();
        console.log(checked_issue_id_arr);
        let project_id = $('#move_project_id').val();
        let is_delete_current = $('#is_delete_current').val();
        let module = $('#move-module').val();
        let sprint = $('#move-sprint').val();
        let effect_version = $('#move-effect_version').val();
        let fix_version = $('#move-fix_version').val();
        let labels = $('#move-labels').val();
        loading.show('#displayMoveProject' );
        $.ajax({
            type: 'post',
            dataType: "json",
            async: true,
            url: root_url + "issue/main/batchMoveProject",
            data: {
                project_id:project_id,
                is_delete_current:is_delete_current,
                issue_id_arr: checked_issue_id_arr,
                labels:labels,
                module:module,
                sprint: sprint,
                effect_version: effect_version,
                fix_version:fix_version
            },
            success: function (resp) {
                loading.hide('#displayMoveProject');
                auth_check(resp);
                if (resp.ret != '200') {
                    notify_error('操作失败:' + resp.msg);
                    return;
                }
                notify_success('操作成功');
                window.location.reload();
            },
            error: function (res) {
                loading.hide('#displayMoveProject');
                notify_error("请求数据错误" + res);
            }
        });
    }

    IssueMain.prototype.displayMoveProject = function (project_id, project_name) {

        var checked_issue_id_arr = IssueMain.prototype.getSelectedIdArr();
        if(is_empty(checked_issue_id_arr)){
            notify_warn('请先选择事项');
            return false;
        }
        $('#move_project_id').val(project_id);
        $('#move-header-title').html('移动至项目:'+project_name);
        // /issue/main/getProjectRelateData
        loading.show('#displayMoveProject' );
        $.ajax({
            type: 'get',
            dataType: "json",
            async: true,
            url: "/issue/main/getProjectRelateData",
            data: {  project_id: project_id },
            success: function (resp) {
                let move_select = $('#move-module');
                for (let i = 0; i < resp.data.project_modules.length; i++) {
                    let row = resp.data.project_modules[i];
                    move_select.append("<option   value='" + row.id + "'>" + row.name + "</option>")
                }
                move_select = $('#move-sprint');
                for (let i = 0; i < resp.data.project_sprints.length; i++) {
                    let row = resp.data.project_sprints[i];
                    move_select.append("<option   value='" + row.id + "'>" + row.name + "</option>")
                }
                move_select = $('#move-labels');
                for (let i = 0; i < resp.data.project_labels.length; i++) {
                    let row = resp.data.project_labels[i];
                    move_select.append("<option   value='" + row.id + "'>" + row.title + "</option>")
                }
                move_select = $('#move-effect_version');
                for (let i = 0; i < resp.data.project_versions.length; i++) {
                    let row = resp.data.project_versions[i];
                    move_select.append("<option   value='" + row.id + "'>" + row.name + "</option>")
                }
                move_select = $('#move-fix_version');
                for (let i = 0; i < resp.data.project_versions.length; i++) {
                    let row = resp.data.project_versions[i];
                    move_select.append("<option   value='" + row.id + "'>" + row.name + "</option>")
                }
                $('.selectpicker').selectpicker('refresh');
                loading.hide('#displayMoveProject');

            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
        console.log(checked_issue_id_arr);
        $('#modal-move-project').modal('show');
    }


    // saveUserIssueDisplayFields
    IssueMain.prototype.saveUserIssueDisplayFields = function () {

        var displayFieldsArr = new Array()
        $.each($("input[name='display_fields[]']"), function () {
            if (this.checked) {
                displayFieldsArr.push($(this).val());
            }
        });
        console.log(displayFieldsArr);
        $.ajax({
            type: 'post',
            dataType: "json",
            async: true,
            url: root_url + "user/saveIssueDisplayFields",
            data: { display_fields: displayFieldsArr, project_id: cur_project_id },
            success: function (resp) {
                auth_check(resp);
                if (resp.ret != '200') {
                    notify_error('操作失败:' + resp.msg);
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

    IssueMain.prototype.checkedAll = function () {
        if(window.issue_view!='tree'){
            $('input[name="check_issue_id_arr"]').each(function () {
                $(this).prop("checked", !$(this).prop("checked"));
            });
        }else{
            $('input[name="btSelectAll"]').click()
        }
    }



    IssueMain.prototype.fetchCreateUiConfig = function (issue_type_id, issue_types) {
        loading.show('#create_default_tab');
        IssueMain.prototype.initForm();
        var method = 'get';
        var temp = IssueMain.prototype.getFormData();
        if (_default_data) {
            for ([_key, _value] of Object.entries(temp)) {
                if (_value !== _default_data[_key]) {
                    _temp_data[_key] = _value;
                }
            }
        }
        if (_last_create_issue_data) {
            for ([_key, _value] of Object.entries(_last_create_issue_data)) {
                _temp_data[_key] = _value;
            }
        }

        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: root_url + "issue/main/fetchUiConfig",
            data: { issue_type_id: issue_type_id, project_id: _cur_project_id },
            success: function (resp) {
                auth_check(resp);
                loading.hide('#create_default_tab');
                _fields = resp.data.fields
                _create_configs = resp.data.configs;
                _tabs = resp.data.tabs;
                _field_types = issue_types;
                _allow_add_status = resp.data.allow_add_status;
                // _project_issue_types = resp.data.issue_types;
                $('#a_create_default_tab').parent().siblings("li").remove();
                // create default tab
                var default_tab_id = 0;
                var html = IssueForm.prototype.makeCreateHtml(_create_configs, _fields, default_tab_id, _allow_add_status, _temp_data);
                $('#create_default_tab').siblings(".tab-pane").remove();
                $('#create_default_tab').html(html);

                // create other tab
                for (var i = 0; i < _tabs.length; i++) {
                    var order_weight = parseInt(_tabs[i].order_weight) + 1;
                    IssueForm.prototype.uiAddTab('create', _tabs[i].name, _tabs[i].id);
                    html = IssueForm.prototype.makeCreateHtml(_create_configs, _fields, _tabs[i].id, _allow_add_status, _temp_data);
                    var id = '#create_ui_config-create_tab-' + _tabs[i].id;
                    $(id).html(html);
                }

                if (_tabs.length > 0) {
                    $('#create_header_hr').hide();
                    $('#create_tabs').show();
                } else {
                    $('#create_header_hr').show();
                    $('#create_tabs').hide();
                }
                IssueMain.prototype.refreshForm(issue_type_id, false);
                $('#a_create_default_tab').click();


                _default_data = IssueMain.prototype.getFormData();

                window._curIssueId = '';
                window._curTmpIssueId = randomString(6) + "-" + (new Date().getTime()).toString();

                /*
                 * websocket广州宣讲添加
                if (typeof (_is_ai_cmd_create) != "undefined") {
                    if (_ws_summary) {
                        $('#create_issue_text_summary').val(_ws_summary);
                    }
                    $('#create_issue_priority').val('3');
                    $('.selectpicker').selectpicker('refresh');
                    $('.assign-to-me-link ').click();
                }
                */

            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    };

    IssueMain.prototype.getFormData = function () {
        var _temp = $('#create_issue').serializeObject();
        var temp_data = {};
        for ([key, value] of Object.entries(_temp)) {
            var str = key.split("[");
            var _key = "";
            if (str[1]) {
                _key = str[1].split("]")[0];
            }

            if (_key !== "" && _key !== "issue_type") {
                temp_data[_key] = value;
            }
        }
        return JSON.parse(JSON.stringify(temp_data));
    };

    IssueMain.prototype.add = function () {
        // 置灰提交按钮
        var submitBtn = $("#btn-add");
        submitBtn.addClass('disabled');

        for (k in _simplemde) {
            if (typeof (_simplemde[k]) == 'object') {
                $('#' + k).val(_simplemde[k].value());
            }
        }

        for (k in window._fineUploader) {
            if (typeof (_fineUploader[k]) == 'object') {
                var uploads = _fineUploader[k].getUploads({
                    status: qq.status.UPLOAD_SUCCESSFUL
                });
                var id = k.replace('_uploader', '');
                $('#' + id).val(JSON.stringify(uploads));
            }
        }
        for (k in window._fineUploaderFile) {
            if (typeof (_fineUploaderFile[k]) == 'object') {
                var uploads = _fineUploaderFile[k].getUploads({
                    status: qq.status.UPLOAD_SUCCESSFUL
                });
                var id = k.replace('_uploader', '');
                $('#' + id).val(JSON.stringify(uploads));
            }
        }

        var form_value_objs = $('#create_issue').serializeObject();
        var method = 'post';
        var post_data = $('#create_issue').serialize();

        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: root_url + "issue/main/add",
            data: post_data,
            single: 'single',
            mine: true, // 当single重复时用自身并放弃之前的ajax请求
            success: function (resp) {
                auth_check(resp);
                if (!form_check(resp)) {
                    submitBtn.removeClass('disabled');
                    return;
                }
                if (resp.ret == '200') {
                    notify_success(resp.msg);
                    window.location.reload();
                } else {
                    notify_error(resp.msg);
                }
                submitBtn.removeClass('disabled');

            },
            error: function (res) {
                notify_error("请求数据错误" + res);
                submitBtn.removeClass('disabled');
            }
        });
    }

    IssueMain.prototype.update = function () {
        // 置灰提交按钮
        var submitBtn = $("#btn-update");
        submitBtn.addClass('disabled');

        for (k in _simplemde) {
            if (typeof (_simplemde[k]) == 'object') {
                $('#' + k).val(_simplemde[k].value());
            }
        }

        for (k in window._fineUploader) {
            if (typeof (_fineUploader[k]) == 'object') {
                var uploads = _fineUploader[k].getUploads({
                    status: qq.status.UPLOAD_SUCCESSFUL
                });
                var id = k.replace('_uploader', '');
                $('#' + id).val(JSON.stringify(uploads));
            }
        }
        for (k in window._fineUploaderFile) {
            if (typeof (_fineUploaderFile[k]) == 'object') {
                var uploads = _fineUploaderFile[k].getUploads({
                    status: qq.status.UPLOAD_SUCCESSFUL
                });
                var id = k.replace('_uploader', '');
                $('#' + id).val(JSON.stringify(uploads));
            }
        }

        var form_value_objs = $('#edit_issue').serializeObject();
        var method = 'post';
        var post_data = $('#edit_issue').serialize();

        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: root_url + "issue/main/update",
            data: post_data,
            success: function (resp) {
                auth_check(resp);
                if (!form_check(resp)) {
                    submitBtn.removeClass('disabled');
                    return;
                }
                if (resp.ret == '200') {
                    notify_success('保存成功');
                    window.location.reload();
                } else {
                    notify_error('保存失败,错误信息:' + resp.msg);
                    submitBtn.removeClass('disabled');
                }

            },
            error: function (res) {
                notify_error("请求数据错误" + res);
                submitBtn.removeClass('disabled');
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
            // console.log($('#' + k));
            $('#' + k).empty();
            window._fineUploaderFile[k] = null;
        }
        window._fineUploaderFile = {};
    }


    IssueMain.prototype.refreshForm = function (issue_type_id, is_edit) {
        $('.selectpicker').selectpicker('refresh');
        var toolbars = [
            "bold", "italic", "heading", "|",
            "quote", "unordered-list", "ordered-list", "|",
            "link", "image", "table", "|",
            "preview", "side-by-side", "fullscreen", "|"
        ];
        var desc_tpl_value = '';
        if (!is_edit && _description_templates != null) {
            var issue_type = null;
            for (let arr of _issueConfig.issue_types) {
                if (arr.id == issue_type_id) {
                    issue_type = arr;
                }
            }
            //console.log( issue_type);
            if (issue_type != null) {
                for (var i = 0; i < _description_templates.length; i++) {
                    var tpl = _description_templates[i];
                    if (tpl.id == issue_type.form_desc_tpl_id) {
                        desc_tpl_value = tpl.content;
                    }
                }
            }
        }
        // alert(desc_tpl_value);
        toolbars.push("guide");


        $(".simplemde_text").each(function (i) {
            var id = $(this).attr('id');
            _editor_md = editormd(id, {
                width: "100%",
                height: 220,
                watch: false,
                markdown: desc_tpl_value,
                path: root_url + 'dev/lib/editor.md/lib/',
                imageUpload: true,
                imageFormats: ["jpg", "jpeg", "gif", "png", "bmp", "webp"],
                imageUploadURL: root_url + "issue/detail/editormd_upload",
                tocm: true,    // Using [TOCM]
                emoji: true,
                saveHTMLToTextarea: true,
                toolbarIcons: "custom"
            });
        });
        IssueForm.prototype.bindNavTabClick();
        var deleteFileEnabled = true;
        if (is_edit) {
            deleteFileEnabled = true;
        }
        $(".fine_uploader_img").each(function (i) {
            var id = $(this).attr('id');
            //if( typeof(window._fineUploader[id])=='undefined' ){
            var uploader = new qq.FineUploader({
                element: document.getElementById(id),
                template: 'qq-template-gallery',
                request: {
                    endpoint: root_url + 'issue/main/upload?project_id=' + window._cur_project_id
                },
                deleteFile: {
                    enabled: deleteFileEnabled,
                    endpoint: root_url + "issue/main/upload_delete/" + window._cur_project_id
                },
                validation: {
                    allowedExtensions: ['jpeg', 'jpg', 'gif', 'png','JPEG', 'JPG', 'GIF', 'PNG']
                }
            });
            window._fineUploader[id] = uploader;
            //}
        })

        $(".fine_uploader_attchment").each(function (i) {
            var id = $(this).attr('id');

            if (typeof (window._fineUploaderFile[id]) == 'undefined') {

                var uploader = new qq.FineUploader({
                    element: document.getElementById(id),
                    template: 'qq-template-gallery',
                    request: {
                        endpoint: root_url + 'issue/main/upload?project_id=' + window._cur_project_id
                    },
                    deleteFile: {
                        enabled: deleteFileEnabled,
                        endpoint: root_url + "issue/main/upload_delete/" + window._cur_project_id
                    },
                    validation: {
                        acceptFiles: ['image/*', 'application/xls', 'application/x-7z-compressed', 'application/zip', 'application/x-rar', 'application/vnd.ms-powerpoint', 'application/pdf', 'text/csv', 'application/vnd.openxmlformats-officedocument.spreadsheetml.template', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-excel', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'],
                        allowedExtensions: ['jpeg', 'jpg', 'gif', 'png', '7z', 'zip', 'rar', 'bmp', 'csv', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pdf', 'xlt', 'xltx', 'txt'],
                    }
                });

                window._curFineAttachmentUploader = window._fineUploaderFile[id] = uploader;
            }
        })

        $(".laydate_input_date").each(function (i) {
            var id = $(this).attr('id');
            laydate.render({
                elem: '#' + id
            });
        });

        $(".button_radio label").bind("click", function () {
            $(this).parent().children().removeClass('active');
            $(this).parent().children().css('color', '#67626294');
            $(this).addClass('active');
            $(this).css("color", $(this).data('color'));
            let for_id = $(this).data('for_id');
            let for_value = $(this).data('for_value');
            $('#' + for_id).val(for_value);
        });

    }

    IssueMain.prototype.initEditFineUploader = function (issue) {

        // 图片
        for (k in window._fineUploader) {
            if (typeof (_fineUploader[k]) == 'object') {
                if (k.indexOf('edit_') == 0) {
                    var field_name = k.replace('edit_issue_upload_img_', '');
                    field_name = field_name.replace('_uploader', '');
                    var edit_attachment_data = issue[field_name];
                    console.log(edit_attachment_data);
                    if (typeof (edit_attachment_data) != 'undefined') {
                        _fineUploader[k].addInitialFiles(edit_attachment_data);
                    }
                }
            }
        }
        // 文件
        for (k in window._fineUploaderFile) {
            if (typeof (_fineUploaderFile[k]) == 'object') {
                if (k.indexOf('edit_') == 0) {
                    var field_name = k.replace('edit_issue_upload_file_', '');
                    field_name = field_name.replace('_uploader', '');
                    var edit_attachment_data = issue[field_name];
                    // console.log(edit_attachment_data);
                    if (typeof (edit_attachment_data) != 'undefined') {
                        var arr = Object.keys(edit_attachment_data);
                        if (arr.length > 0) {
                            _fineUploaderFile[k].addInitialFiles(edit_attachment_data);
                        }
                    }

                }
            }
        }
    }

    IssueMain.prototype.fetchEditUiConfig = function (issue_id, form_type, updatedIssueTypeId) {
        if (typeof MM != 'undefined') {
            MM.App.editing = true;
        }

        var self = this;
        $('#modal-edit-issue_title').html('编辑事项');
        if (form_type == 'copy') {
            $('#form_type').val('copy');
            $('#modal-edit-issue_title').html('复制事项');
        }

        IssueMain.prototype.initForm();
        var add_arg = '';
        if (!is_empty(updatedIssueTypeId)) {
            add_arg = '?issue_type=' + updatedIssueTypeId;
        }
        $('#edit_issue_id').val(issue_id);

        var method = 'get';
        var type = 'edit';
        $('#modal-edit-issue').modal();
        loading.show('.issue-modal-content', '加载中')
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: root_url + "issue/main/fetch_issue_edit" + add_arg,
            data: { issue_id: issue_id },
            success: function (resp) {
                loading.closeAll();
                auth_check(resp);
                _fields = resp.data.fields;
                _create_configs = resp.data.configs;
                _tabs = resp.data.tabs;
                _field_types = _issueConfig.issue_types;
                _edit_issue = resp.data.issue;
                _cur_form_project_id = _edit_issue.project_id;

                IssueForm.prototype.makeProjectField(_edit_issue, function () {
                    if (is_empty(updatedIssueTypeId)) {
                        IssueMain.prototype.initEditIssueType(_edit_issue.issue_type, _field_types, _edit_issue.id);
                    }
                    $('#edit_project_id').val(_edit_issue.project_id);
                    if (is_empty(updatedIssueTypeId)) {
                        $('#edit_issue_type').val(_edit_issue.issue_type);
                    } else {
                        $('#edit_issue_type').val(updatedIssueTypeId);
                    }

                    var a_edit_default_tab = $('#a_edit_default_tab');
                    a_edit_default_tab.parent().siblings("li").remove();

                    //notify_success(resp.data.configs);
                    // create default tab
                    var default_tab_id = 0;
                    var html = IssueForm.prototype.makeEditHtml(_create_configs, _fields, default_tab_id, _edit_issue);
                    $("#edit_default_tab").siblings(".tab-pane").remove();
                    $("#edit_default_tab").html(html).show();

                    // create other tab
                    for (var i = 0; i < _tabs.length; i++) {
                        var order_weight = parseInt(_tabs[i].order_weight) + 1;
                        IssueForm.prototype.uiAddTab('edit', _tabs[i].name, _tabs[i].id);
                        var html = IssueForm.prototype.makeEditHtml(_create_configs, _fields, _tabs[i].id, _edit_issue);
                        var id = '#edit_ui_config-edit_tab-' + _tabs[i].id;
                        // edit_ui_config-edit_tab-20
                        $(id).html(html);
                    }

                    if (_tabs.length > 0) {
                        $('#edit_tabs').show();
                    } else {
                        $('#edit_tabs').hide();
                    }


                    IssueMain.prototype.refreshForm(_edit_issue.issue_type, true);
                    IssueMain.prototype.initEditFineUploader(_edit_issue);

                    // 支持移动端上传附件
                    window._curTmpIssueId = randomString(6) + "-" + (new Date().getTime()).toString();
                    window._curIssueId = issue_id;
                    $('#editform_tmp_issue_id').val(window._curTmpIssueId);

                    a_edit_default_tab.click();

                });
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    IssueMain.prototype.pasteImage = function () {
        document.addEventListener('paste', function (event) {
            var items = (event.clipboardData || window.clipboardData).items;
            var file = null;

            if ($(event.target).parents(".editormd").length <= 0) {
                return false;
            }

            if (items && items.length) {
                // 搜索剪切板items
                for (var i = 0; i < items.length; i++) {
                    if (items[i].type.indexOf('image') !== -1) {
                        file = items[i].getAsFile();
                        break;
                    }
                }
            } else {
                //alert("当前浏览器不支持");
                return;
            }
            if (!file) {
                //alert("粘贴内容非图片");
                return;
            }
            loading.show('body', "截图上传中");
            // 这里是上传
            var xhr = new XMLHttpRequest();
            // 上传进度
            if (xhr.upload) {
                xhr.upload.addEventListener('progress', function (event) {
                    // log.innerHTML = '正在上传，进度：' + Math.round(100 * event.loaded / event.total) / 100 + '%';
                }, false);
            }
            // 上传结束
            xhr.onload = function () {
                var responseText = JSON.parse(xhr.responseText);
                _editor_md.insertValue(responseText.data.md_text);

                loading.closeAll();
                // log.innerHTML = '上传成功，地址是：' + responseText.data.url;
            };
            xhr.onerror = function () {
                alert("网络异常，上传失败");
            };
            xhr.open('POST', '/issue/main/pasteUpload', true);
            xhr.setRequestHeader('FILENAME', encodeURIComponent(file.name));
            xhr.send(file);
        });
    }

    IssueMain.prototype.updateIssuePriority = function (issue_id, priority_id, target, text, color) {
        var method = 'post';
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: root_url + "issue/main/update/",
            data: { issue_id: issue_id, params: { priority: priority_id } },
            success: function (resp) {
                auth_check(resp);
                if (resp.ret === '200') {
                    target.text(text)
                    target.css('color', color)
                    notify_success('操作成功');
                } else {
                    notify_error(resp.msg);
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    IssueMain.prototype.updateIssueModule = function (issue_id, module_id, target, name) {
        var method = 'post';
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: root_url + "issue/main/update/",
            data: { issue_id: issue_id, params: { module: module_id } },
            success: function (resp) {
                auth_check(resp);
                if (resp.ret === '200') {
                    target.text(name)
                    target.attr('href', "?state=opened&模块=" + name);
                    notify_success('操作成功');
                } else {
                    notify_error(resp.msg);
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    IssueMain.prototype.updateIssueSprint = function (issue_id, sprint_id, target, name) {
        var method = 'post';
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: root_url + "issue/main/update/",
            data: { issue_id: issue_id, params: { sprint: sprint_id } },
            success: function (resp) {
                auth_check(resp);
                if (resp.ret === '200') {
                    target.text(name)
                    target.attr('href', "?state=opened&迭代=" + name);
                    notify_success('操作成功');
                } else {
                    notify_error(resp.msg);
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    IssueMain.prototype.updateIssueAssignee = function (issue_id, assignee_id, target, name, img) {
        var method = 'post';
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: root_url + "issue/main/update/",
            data: { issue_id: issue_id, params: { assignee: assignee_id } },
            success: function (resp) {
                auth_check(resp);
                if (resp.ret === '200') {
                    target.attr("href", "/user/profile/" + assignee_id);
                    target.find("img").attr("data-original-title", name);
                    target.find("img").attr('src', img);
                    notify_success('操作成功');
                } else {
                    notify_error(resp.msg);
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    return IssueMain;
})();


