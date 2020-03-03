var Gantt = (function () {

    var _options = {};

    // constructor
    function Gantt(options) {
        _options = options;

    };

    Gantt.prototype.getOptions = function () {
        return _options;
    };

    Gantt.prototype.setOptions = function (options) {
        for (i in  options) {
            // if( typeof( _options[options[i]] )=='undefined' ){
            _options[i] = options[i];
            // }
        }
    };

     Gantt.prototype.initIssueType = function (issue_types) {
        //console.log(issue_types)
        var issue_types_select = document.getElementById('gantt_issue_type');
        $('#gantt_issue_type').empty();

        for (var _key in  issue_types) {
            issue_types_select.options.add(new Option(issue_types[_key].name, issue_types[_key].id));
        }
        console.log(issue_types_select);
        $('.selectpicker').selectpicker('refresh');
    }

    Gantt.prototype.initPriority = function (prioritys) {
        //console.log(prioritys)
        var issue_types_select = document.getElementById('priority');
        $('#gantt_priority').empty();

        for (var _key in  prioritys) {
            var row = prioritys[_key];
            var id = row.id;
            var title = row.name;
            var color = row.status_color;
            var opt = "<option data-content=\"<span style='color:" + color + "'>" + title + "</span>\" value='"+id+"'>"+title+"</option>";
            $('#gantt_priority').append(opt);
        }
        //data-content="<span style='color:red'>紧 急</span>"
        $('.selectpicker').selectpicker('refresh');
    }

    Gantt.prototype.initStatus = function (status) {
        //console.log(status)
        var issue_types_select = document.getElementById('gantt_status');
        $('#gantt_status').empty();

        for (var _key in  status) {
            var row = status[_key];
            var id = row.id;
            var title = row.name;
            var color = row.color;
            var opt = "<option data-content=\"<span class='label label-" + color + "'>" + title + "</span>\" value='"+id+"'>"+title+"</option>";
            //console.log(opt)
            $('#gantt_status').append(opt);
        }
        $('.selectpicker').selectpicker('refresh');
    }

    Gantt.prototype.fetchGanttSetting = function (project_id) {

        var url = '/project/gantt/fetchSetting/'+project_id;
        $.ajax({
            type: 'GET',
            dataType: "json",
            data: {},
            url: url,
            success: function (resp) {
                auth_check(resp);
                if(resp.ret==="200"){
                    $("#source_"+resp.data.source_type).attr('checked', 'true');
                    $("#is_display_backlog_"+resp.data.is_display_backlog).attr('checked', 'true');
                    $('#hide_issue_types').val(resp.data.hide_issue_types);
                    let source = $('#tpl_holiday_a').html();
                    let template = Handlebars.compile(source);
                    let result = template(resp.data);
                    $('#holidays_list' ).html(result);
                    $('#holiday_dates').val(JSON.stringify(resp.data.holidays));
                    Gantt.prototype.bindRemoveHolidayDate();
                    source = $('#tpl_extra_holiday_a').html();
                    template = Handlebars.compile(source);
                    result = template(resp.data);
                    $('#extra_holidays_list' ).html(result);
                    $('#extra_holiday_dates').val(JSON.stringify(resp.data.extra_holidays));
                    Gantt.prototype.bindRemoveExtraHolidayDate();
                    $('.selectpicker').selectpicker('refresh');
                    $('#modal-setting').modal('show');
                }else{
                    notify_error("获取甘特图数据源失败:" + resp.msg);
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });

        $('.selectpicker').selectpicker('refresh');
    }

    Gantt.prototype.bindRemoveHolidayDate = function( ) {
        $("#holidays_list a").bind("click",function(){
            let date = $(this).data('date');
            let dateArr = JSON.parse($('#holiday_dates').val());
            dateArr.remove(date);
            $(this).remove();
            $('#holiday_dates').val(JSON.stringify(dateArr));
        });
    };

    Gantt.prototype.bindRemoveExtraHolidayDate = function( ) {
        $("#extra_holidays_list a").bind("click",function(){
            let date = $(this).data('date');
            let dateArr = JSON.parse($('#extra_holiday_dates').val());
            dateArr.remove(date);
            $(this).remove();
            $('#extra_holiday_dates').val(JSON.stringify(dateArr));
        });
    };


    Gantt.prototype.saveGanttSetting = function( ) {
        let source_type_value = $("input[name='source']:checked").val();
        let method = 'POST';
        let url = '/project/gantt/saveSetting/'+window._cur_project_id;
        let holiday_dates_str = $('#holiday_dates').val();
        let extra_holiday_dates_str = $('#extra_holiday_dates').val();
        let is_display_backlog_value = $("input[name='is_display_backlog']:checked").val();
        let post_data = {source_type:source_type_value, holiday_dates:holiday_dates_str,extra_holiday_dates:extra_holiday_dates_str}
        post_data['is_display_backlog'] = is_display_backlog_value;
        post_data['hide_issue_types'] = $('#hide_issue_types').val();
        $.ajax({
            type: method,
            dataType: "json",
            data: post_data,
            url: url,
            success: function (resp) {
                auth_check(resp);
                if( resp.ret === "200" ){
                    notify_success(resp.msg);
                    setTimeout("window.location.reload();", 1200)
                    //window.ge.loadProject(loadGanttFromServer(window._cur_project_id));
                } else {
                    notify_error(resp.msg);
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    };

    Gantt.prototype.initEditIssueForm = function( task ) {
        $('#gantt_summary').val('');
        $('#gantt_issue_type').val('3');
        $('#gantt_priority').val('3');
        $('#gantt_status').val('1');
        $('#assignee').val('');
        $('#gantt_assignee').val(window.current_uid);
        $('#gantt_start_date').val('');
        $('#gantt_due_date').val('');
        $('#edit_duration').html('');
        $('#gantt_progress').val('');
        $('#gantt_is_start_milestone').attr("checked", false);
        $('#gantt_is_end_milestone').attr("checked", false);
        $('#gantt_sprint').val(task.sprint_id);
        $('#sprint_name').html(task.sprint_name);
        $('.selectpicker').selectpicker('refresh');

        if(is_empty(_gantt_editor_md)){
            _gantt_editor_md = editormd('description_md', {
                width: "640px",
                height: 220,
                watch: false,
                markdown: '',
                path: root_url + 'dev/lib/editor.md/lib/',
                imageUpload: true,
                imageFormats: ["jpg", "jpeg", "gif", "png", "bmp", "webp"],
                imageUploadURL: root_url + "issue/detail/editormd_upload",
                tocm: true,    // Using [TOCM]
                emoji: true,
                saveHTMLToTextarea: true,
                toolbarIcons: "custom"
            });
        }else{
            _gantt_editor_md.setMarkdown('');
        }


    };

    Gantt.prototype.makeEditIssueForm = function( task, editOnlyAssig ) {

        Gantt.prototype.initEditIssueForm(task);
        $('#modal-create-issue').modal('show');
        loading.show('#modal-body');
        $('#issue_id').val(task.id);
        $('#action').val('update');

        $.ajax({
            type: 'get',
            dataType: "json",
            async: true,
            url: root_url + "issue/detail/get/" + task.id+'?from=gantt',
            data: {},
            success: function (resp) {
                loading.hide('#modal-body');
                auth_check(resp);
                var issue = resp.data.issue;
                $('#gantt_summary').val(issue.summary);
                $('#gantt_master_issue_id').val(issue.master_id);
                $('#gantt_issue_type').val(issue.issue_type);
                $('#gantt_priority').val(issue.priority);
                $('#gantt_status').val(issue.gantt_status);
                $('#assignee').val(issue.assignee);
                $('#gantt_assignee').val(issue.assignee);
                $('#gantt_sprint').val(issue.sprint);
                $('#gantt_start_date').val(issue.start_date);
                $('#gantt_due_date').val(issue.due_date);
                $('#edit_duration').html(issue.duration);
                $('#gantt_progress').val(issue.progress);
                if(issue.is_start_milestone!='0'){
                    $('#gantt_is_start_milestone').attr("checked", true);
                }
                if(issue.is_end_milestone!='0'){
                    $('#gantt_is_end_milestone').attr("checked", true);
                }
                $('.selectpicker').selectpicker('refresh');

                let user = getUser(window._issueConfig.users, issue.assignee);
                if(!is_empty(user)){
                    $('#user_dropdown-toggle-text').html(user.display_name);
                }

                let sprint = getObjectValue(window._issueConfig.sprint, issue.sprint);
                if(is_empty(sprint.id)){
                    $('#sprint_name').html('待办事项');
                }else{
                    $('#sprint_name').html(sprint.name);
                }
                _gantt_editor_md.setMarkdown(issue.description);


            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    };

    Gantt.prototype.syncAddLastTask = function (task) {
        console.log("syncAddLastTask:",  task)
        if(task.name===''){
            return;
        }

        let sprint = getObjectValue(_issueConfig.sprint,task.sprint_id);
        let start_date = timestampToDate(task.start,'Y-m-d');
        let due_date = timestampToDate(task.end,'Y-m-d');
        if(!is_empty(sprint) && is_empty(start_date)){
            start_date = sprint.start_date;
        }
        if(!is_empty(sprint) && is_empty(due_date)){
            due_date = sprint.end_date;
        }
        let is_start_milestone = null;
        if(task.startIsMilestone){
            is_start_milestone = 1;
        }else{
            is_start_milestone = 0;
        }
        let is_end_milestone = null;
        if(task.endIsMilestone){
            is_end_milestone = 1;
        }else{
            is_end_milestone = 0;
        }
        let assignee = '';
        if(task.assignee){
            assignee = task.assignee[0];
        }

        var params = {};
        params = {
            project_id:window.cur_project_id,
            sprint:task.sprint_id,
            issue_type:2,
            summary:task.name,
            status:1,
            assignee:assignee,
            start_date:start_date,
            due_date:due_date,
            progress:0,
            is_start_milestone: is_start_milestone,
            is_end_milestone: is_end_milestone,
            description:''
        }
        let prev_task = null;
        if(window.ge.tasks.length>1){
            prev_task = window.ge.tasks[window.ge.tasks.length-2];
        }
        if(!is_empty(prev_task.id)){
            params['below_id'] = prev_task.id;
        }

        var url = '/issue/main/add?from_gantt=1&from_module=gantt';

        $.ajax({
            type: 'post',
            dataType: "json",
            url: url,
            data: {params:params},
            success: function (resp) {
                auth_check(resp);
                if(!form_check(resp)){
                    return;
                }
                if (resp.ret === '200') {
                    var ret;
                    for (var i = 0; i < window.ge.tasks.length; i++) {
                        var tsk = window.ge.tasks[i];
                        if (tsk.id == task.id) {
                            window.ge.tasks[i].syncedServer = true;
                            window.ge.tasks[i].id = resp.data;
                            window.ge.tasks[i].code = '#'+resp.data;
                            window.ge.tasks[i].changeStatus("STATUS_DONE");
                            break;
                        }
                    }
                    notify_success(resp.msg);
                }else{
                    notify_error(resp.msg);
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    };


    Gantt.prototype.addSyncServerTask = function () {
        //console.debug("deleteCurrentTask",this.currentTask , this.isMultiRoot)
        var self = window.ge;
        var params = $("#create_issue").serialize();//{"project_id":window.cur_project_id}
        var url = '/issue/main/add?from_gantt=1&from_module=gantt';

        $.ajax({
            type: 'post',
            dataType: "json",
            url: url,
            data: params,
            success: function (resp) {
                auth_check(resp);
                if(!form_check(resp)){
                    return;
                }
                if (resp.ret == '200') {
                    notify_success(resp.msg);
                    $('#modal-create-issue').modal('hide');
                    let action = $("#add_gantt_dir").val();
                    let id = resp.data;
                    let name = $('#gantt_summary').val();
                    let code = "#"+id;
                    let sprint_id = $('#gantt_sprint').val();
                    let sprint_name = $('#sprint_name').html();
                    let sprint = getObjectValue(window._issueConfig.sprint, sprint_id);
                    let start_date = $('#gantt_start_date').val().replace(/-/g, '/');// 把所有-转化成/
                    let startTime = 0;
                    if(start_date==="" && !isUndefined(sprint.start_date)){
                        start_date = sprint.start_date;
                    }
                    startTime = (new Date(start_date).getTime());
                    let due_date =  $('#gantt_due_date').val().replace(/-/g, '/');
                    let endTime = 0;
                    if(due_date==="" && !isUndefined(sprint.end_date)){
                        due_date = sprint.end_date;
                    }
                    endTime = (new Date(due_date).getTime());
                    let duration = parseInt($('#gantt_duration').val());

                    if(action==='addAboveCurrentTask'){
                        self.addAboveCurrentTask(id, name, code, startTime, endTime, duration, sprint_id,sprint_name);
                    }
                    if(action==='addBelowCurrentTask'){
                        self.addBelowCurrentTask(id, name, code, startTime, endTime, duration, sprint_id,sprint_name);
                    }
                }else{
                    notify_error(resp.msg);
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    };


    Gantt.prototype.updateSyncServerTask = function () {
        //console.debug("deleteCurrentTask",this.currentTask , this.isMultiRoot)
        var self = window.ge;

        $('#modal-create-issue').modal('hide');
        var taskId = $("#issue_id").val();
        var task = self.getTask(taskId); // get task again because in case of rollback old task is lost

        self.beginTransaction();
        task.name = $("#gantt_summary").val();
        task.description = window._gantt_editor_md.getMarkdown();
        task.code = "#"+taskId;
        task.progress = parseInt($("#gantt_progress").val());
        //task.duration = parseInt(taskEditor.find("#duration").val()); //bicch rimosso perchè devono essere ricalcolata dalla start end, altrimenti sbaglia
        task.startIsMilestone = $("#gantt_is_start_milestone").is(":checked");
        task.endIsMilestone = $("#gantt_is_end_milestone").is(":checked");

        task.type = '';
        task.typeId = '';
        task.relevance = 0;
        task.progressByWorklog=  false;//taskEditor.find("#progressByWorklog").is(":checked");

        //set assignments
        var cnt=0;

        //change dates
        let start_date = $("#gantt_start_date").val();
        let due_date = $("#gantt_due_date").val();
        console.log(start_date, due_date);
        if(!is_empty(start_date) && !is_empty(due_date)){
            task.setPeriod(Date.parseString(start_date).getTime(), Date.parseString(due_date).getTime() + (3600000 * 22));
        }

        //change status
        // task.changeStatus($("#status").val());

        if (self.endTransaction()) {
            //var taskEditor =  new GridEditor(this);
            //taskEditor.find(":input").updateOldValue();
            //closeBlackPopup();
        }
        var params = $("#create_issue").serialize();//{"project_id":window.cur_project_id}
        var url = '/issue/main/update?from_gantt=1&from_module=gantt';
        $.ajax({
            type: 'post',
            dataType: "json",
            url: url,
            data: params,
            success: function (resp) {
                auth_check(resp);
                if(!form_check(resp)){
                    notify_success("提交参数错误",resp.msg);
                    return;
                }
                if (resp.ret == 200) {
                    notify_success(resp.msg);

                }else{
                    notify_error(resp.msg);
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    };

    Gantt.prototype.updateDuration = function (issue_id, project_id, params, rowtr, dates) {
        params['project_id'] = project_id;
        var url = '/issue/main/update?issue_id='+issue_id+'&project_id='+project_id+'&from_gantt=1&from_module=gantt';
        if(params!==null){
            $.ajax({
                type: 'GET',
                dataType: "json",
                data: {params:params},
                url: url,
                success: function (resp) {
                    auth_check(resp);
                    if(resp.ret==="200"){
                        //notify_error(resp.msg , resp.data);
                        rowtr.find("[name=duration]").val(resp.data.duration)
                        for (var i = 0; i < window.ge.tasks.length; i++) {
                            var tsk = window.ge.tasks[i];
                            if (tsk.id == issue_id) {
                                window.ge.tasks[i].duration = parseInt(resp.data.duration);
                                try{
                                    window.ge.beginTransaction();
                                    window.ge.changeTaskDates(task, dates.start, dates.end);
                                    window.ge.endTransaction();
                                }catch (e) {
                                    console.log(e.name,e.message);
                                    window.ge.endTransaction();
                                }

                                break;
                            }
                        }
                    }else{
                        notify_error(resp.msg , resp.data);
                    }
                },
                error: function (res) {
                    notify_error("请求数据错误" + res);
                }
            });
        }
    };

    Gantt.prototype.updateIssue = function (issue_id, params) {
        //console.debug("deleteCurrentTask",this.currentTask , this.isMultiRoot)
        var self = window.ge;
        let project_id = window._cur_project_id;
        params['project_id'] = project_id;
        var url = '/issue/main/update?issue_id='+issue_id+'&project_id='+project_id+'&from_gantt=1&from_module=gantt';
        $.ajax({
            type: 'post',
            dataType: "json",
            url: url,
            data: {params:params},
            success: function (resp) {
                auth_check(resp);
                if(!form_check(resp)){
                    notify_success("提交参数错误",resp.msg);
                    return;
                }
                if (resp.ret == 200) {
                    notify_success(resp.msg);

                }else{
                    notify_error(resp.msg);
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    };

    Gantt.prototype.deleteTask = function(taskId, params ) {

        $.ajax({
            type: 'post',
            dataType: "json",
            async: true,
            url: root_url+"issue/main/update",
            data: {issue_id: taskId, params: params},
            success: function (resp) {
                auth_check(resp);
                if (resp.ret != '200') {
                    notify_error('操作失败:' + resp.msg);
                    return;
                }
                notify_success('操作成功');
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    };

    Gantt.prototype.fetchResource = function (project_id) {

        var url = '/project/member/fetchAll/'+project_id;
        $.ajax({
            type: 'GET',
            dataType: "json",
            data: {},
            url: url,
            success: function (resp) {
                auth_check(resp);
                if (resp.data.project_users.length) {
                    let source = $('#member_list_tpl').html();
                    let template = Handlebars.compile(source);
                    let result = template(resp.data);
                    console.log(result);
                    $('#ul_member_content' ).html(result);
                    $(".select-item-for-user").selectpicker({ title: "请选择角色", showTick: true, iconBase: "fa", tickIcon: "fa-check"});

                    $("select.select-item-for-user").each(function () {
                        var $self = $(this);
                        var ids = $self.data("ids") + "";
                        var val = ids.split(",");
                        var id = $self.data("select_id");
                        $("#" + id).selectpicker("val", val);
                    });
                    var newRes=[];
                    for (var j=0;j<resp.data.project_users.length;j++){
                        let user_id = resp.data.project_users[j].uid;
                        let user_name = resp.data.project_users[j].user_name;
                        newRes.push({id:user_id, name:user_name})
                    }
                    window.ge.resources=newRes;

                } else {

                }
                //$('#modal-team').show();
                $('#modal-team').modal('show');
                $("#role_select").selectpicker({title: "请选择角色",  showTick: true, iconBase: "fa", tickIcon: "fa-check"});
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });

        $('.selectpicker').selectpicker('refresh');
    };

    Gantt.prototype.addResource = function( ) {

        let user_id = $('#issue_assignee_id').val();
        let user_name = user_id;
        let role_id = $('#role_select').val();

        let method = 'POST';
        let url = '/project/role/add_project_member_roles';
        $.ajax({
            type: method,
            dataType: "json",
            data: {project_id: window._cur_project_id, user_id:user_id, role_id:role_id},
            url: url,
            success: function (resp) {
                auth_check(resp);
                if( resp.ret === "200" ){
                    //window.location.reload();
                    Gantt.prototype.fetchResource(window._cur_project_id);
                    notify_success(resp.msg);

                } else {
                    notify_error(resp.msg);
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    };

    Gantt.prototype.saveMemberRole = function (user_id) {
        let role_id = $("#selectpicker_uid_" + user_id).val();
        let method = 'POST';
        let url = '/project/role/modify_project_user_has_roles';
        $.ajax({
            type: method,
            dataType: "json",
            data: {user_id:user_id, project_id:window._cur_project_id, role_id:role_id},
            url: url,
            success: function (resp) {
                swal.close();
                auth_check(resp);
                if( resp.ret === "200" ){
                    Gantt.prototype.fetchResource(window._cur_project_id);
                    notify_success(resp.msg);
                } else {
                    notify_error(resp.msg);
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    };

    Gantt.prototype.delMember = function(user_id, displayname,projectname) {

        swal({
                title: '您确认移除 ' + projectname + ' 的成员 '+ displayname +' 吗?',
                text: "该用户将不能访问此项目",
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
                    let method = 'POST';
                    let url = '/project/role/delete_project_user';
                    $.ajax({
                        type: method,
                        dataType: "json",
                        data: {user_id:user_id, project_id:window._cur_project_id},
                        url: url,
                        success: function (resp) {
                            swal.close();
                            auth_check(resp);
                            if( resp.ret === "200" ){
                                Gantt.prototype.fetchResource(window._cur_project_id);
                            } else {
                                notify_error(resp.msg);
                            }
                        },
                        error: function (res) {
                            notify_error("请求数据错误" + res);
                        }
                    });
                }else{
                    swal.close();
                }
            }
        );
    };

    Gantt.prototype.fetchGanttBeHiddenIssueList = function (project_id, page) {

        var url = '/project/gantt/fetchGanttBeHiddenIssueList/'+project_id;
        $.ajax({
            type: 'GET',
            dataType: "json",
            data: {"page": page},
            url: url,
            success: function (resp) {
                auth_check(resp);
                if (resp.ret==="200") {
                    let source = $('#be_hidden_issue_list_tpl').html();
                    let template = Handlebars.compile(source);
                    let result = template(resp.data);
                    //console.log(result);
                    $('#tr_be_hidden_issue_list_content').html(result);

                    if (Number(resp.data.total) < 1) {
                        defineStatusHtml({
                            wrap: '#tr_be_hidden_issue_list_content_empty',
                            message : '没有数据',
                            name: 'backlog',
                            handleHtml: ``
                        })
                    } else {
                        $('#tr_be_hidden_issue_list_content_empty').empty();
                    }

                    if (resp.data.pages > 1) {
                        let options = {
                            currentPage: resp.data.page,
                            totalPages: resp.data.pages,
                            onPageClicked: function (e, originalEvent, type, page) {
                                console.log("Page item clicked, type: " + type + " page: " + page);
                                Gantt.prototype.fetchGanttBeHiddenIssueList(project_id, page);
                            }
                        };
                        $('#ampagination-bootstrap').bootstrapPaginator(options);
                    }

                    $('.js-masterlab-behidden-clicked').click(function(){
                        var id = $(this).data('id');
                        Gantt.prototype.recoverBeHiddenIssue(project_id, id);
                    });

                    $('#modal_be_hidden_issue_list').modal('show');
                } else {
                    notify_error("请求数据源失败:" + resp.msg);
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    };

    Gantt.prototype.recoverBeHiddenIssue = function (project_id, issue_id) {
        var url = '/project/gantt/recoverGanttBeHiddenIssue/'+project_id;
        $.ajax({
            type: 'GET',
            dataType: "json",
            data: {"issue_id": issue_id},
            url: url,
            success: function (resp) {
                auth_check(resp);
                if (resp.ret==="200") {
                    window.ge.loadProject(loadGanttFromServer(project_id));
                    $(".js-hidden-row-id-"+issue_id).remove();
                    if ($("#tr_be_hidden_issue_list_content tr").length > 0) {
                    } else {
                        defineStatusHtml({
                            wrap: '#tr_be_hidden_issue_list_content_empty',
                            message : '没有数据',
                            name: 'backlog',
                            handleHtml: ``
                        })
                    }
                    notify_success(resp.msg);
                } else {
                    notify_error("请求数据源失败:" + resp.msg);
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    };


    Gantt.prototype.syncMoveUpServer = function (current_id, target_id) {

        var method = 'post';
        var params = {"project_id":window.cur_project_id,"current_id":current_id,"target_id":target_id}
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: '/project/gantt/moveUpIssue',
            data: params,
            success: function (resp) {
                if (resp.ret == 200) {
                    notify_success(resp.msg);
                }else{
                    notify_error(resp.msg);
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    Gantt.prototype.syncMoveDownServer = function (current_id, target_id) {

        var method = 'post';
        var params = {"project_id":window.cur_project_id,"current_id":current_id,"target_id":target_id}
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: '/project/gantt/moveDownIssue',
            data: params,
            success: function (resp) {
                if (resp.ret == '200') {
                    notify_success(resp.msg);
                }else{
                    notify_error(resp.msg);
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }



    Gantt.prototype.computeTaskRowDuration = function(task, start_date, due_date,rowtr){
        let project_id = window._cur_project_id;
        if(start_date!=='' && due_date!==''){
            var url = '/issue/main/getDuration/?project'+project_id;
            $.ajax({
                type: 'GET',
                dataType: "json",
                data: {project_id:project_id, start_date:start_date, due_date:due_date },
                url: url,
                success: function (resp) {
                    auth_check(resp);
                    if(resp.ret==="200"){
                        //notify_error(resp.msg , resp.data);
                        rowtr.find("[name=duration]").val(resp.data)
                        for (var i = 0; i < window.ge.tasks.length; i++) {
                            var tsk = window.ge.tasks[i];
                            if (tsk.id == task.id) {
                                window.ge.tasks[i].duration = parseInt(resp.data);
                                let startTime = (new Date(start_date).getTime());
                                console.log('startTime:',startTime);
                                break;
                            }
                        }
                    }else{
                        notify_error(resp.msg , resp.data);
                    }
                },
                error: function (res) {
                    notify_error("请求数据错误" + res);
                }
            });
        }
    }


    return Gantt;
})();


