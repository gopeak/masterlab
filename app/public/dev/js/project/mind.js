let MindAjax = (function () {

    let _options = {};

    // constructor
    function MindAjax(options) {
        _options = options;
    };

    MindAjax.prototype.getOptions = function () {
        return _options;
    };

    MindAjax.prototype.initIssueType = function (issue_types) {
        //console.log(issue_types)
        var issue_types_select = document.getElementById('create_issue_types_select');
        $('#create_issue_types_select').empty();

        for (var _key in  issue_types) {

            issue_types_select.options.add(new Option(issue_types[_key].name, issue_types[_key].id));
        }
        console.log(issue_types_select);
        $('.selectpicker').selectpicker('refresh');
    }

    MindAjax.prototype.initPriority = function (prioritys) {
        //console.log(prioritys)
        var issue_types_select = document.getElementById('priority');
        $('#priority').empty();

        for (var _key in  prioritys) {
            var row = prioritys[_key];
            var id = row.id;
            var title = row.name;
            var color = row.status_color;
            var opt = "<option data-content=\"<span style='color:" + color + "'>" + title + "</span>\" value='"+id+"'>"+title+"</option>";
            $('#priority').append(opt);
        }
        //data-content="<span style='color:red'>紧 急</span>"
        $('.selectpicker').selectpicker('refresh');
    }

    MindAjax.prototype.initStatus = function (status) {
        //console.log(status)
        var issue_types_select = document.getElementById('gantt_status');
        $('#gantt_status').empty();

        for (var _key in  status) {
            var row = status[_key];
            var id = row.id;
            var title = row.name;
            var color = row.color;
            var opt = "<option data-content=\"<span class='label label-" + color + "'>" + title + "</span>\" value='"+id+"'>"+title+"</option>";
            console.log(opt)
            $('#gantt_status').append(opt);
        }
        $('.selectpicker').selectpicker('refresh');
    }


    MindAjax.prototype.updateSyncServerIssue = function () {
        //console.debug("deleteCurrentTask",this.currentTask , this.isMultiRoot)
        $('#modal-create-issue').modal('hide');
        let issue = {};
        let taskId = $("#issue_id").val();

        issue.name = $("#summary").val();
        issue.description = $("#description").val();
        issue.progress = parseInt($("#progress").val());
        //task.duration = parseInt(taskEditor.find("#duration").val()); //bicch rimosso perchè devono essere ricalcolata dalla start end, altrimenti sbaglia
        issue.startIsMilestone = $("#is_start_milestone").is(":checked");
        issue.endIsMilestone = $("#is_end_milestone").is(":checked");

        var params = $("#create_issue").serialize();//{"project_id":window.cur_project_id}
        var url = '/issue/main/update';
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


    MindAjax.prototype.addSyncServerIssue = function () {
        //console.debug("deleteCurrentTask",this.currentTask , this.isMultiRoot)
        let self = this;

        let params = $("#create_issue").serialize();//{"project_id":window.cur_project_id}
        let url = '/issue/main/add';

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
                if (resp.ret === '200') {
                    notify_success(resp.msg);
                    $('#modal-create-issue').modal('hide');

                }else{
                    notify_error(resp.msg);
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    };

    MindAjax.prototype.fetchAll = function (project_id, params) {
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: '/project/mind/fetchMindIssues/' + project_id,
            data: params,
            success: function (resp) {
                auth_check(resp);
                if (resp.data.length) {

                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    };

    MindAjax.prototype.updateModalFormIssue  = function () {
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
        loading.show('.issue-modal-content', '正在请求服务器执行更新')
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: root_url + "issue/main/update",
            data: post_data,
            success: function (resp) {
                loading.closeAll();
                auth_check(resp);
                if (!form_check(resp)) {
                    submitBtn.removeClass('disabled');
                    return;
                }
                if (resp.ret === '200') {
                    notify_success('保存成功');
                    $('#modal-edit-issue').modal('hide');
                    let issue_id = $('#edit_issue_id').val();
                    $('#issue_'+issue_id+'_text').html($('#edit_issue_text_summary').val());
                } else {
                    notify_error('保存失败,错误信息:' + resp.msg);
                    submitBtn.removeClass('disabled');
                }


            },
            error: function (res) {
                loading.closeAll();
                notify_error("请求数据错误" + res);
                submitBtn.removeClass('disabled');
            }
        });
    }

    MindAjax.prototype.fetchSettings = function () {
        loading.show('#setting-modal-body', '正在加载数据');
        var params = {format: 'json'};
        var project_id = window._cur_project_id;
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: '/project/mind/fetchSetting/' + project_id,
            data: {project_id: project_id},
            success: function (resp) {
                auth_check(resp);
                loading.closeAll();
                let setting = resp.data;
                $('#default_source_' + setting.default_source).prop("checked", "checked");
                if (setting.default_source === 'all') {
                    $('#default_source_id_container').hide();
                } else {
                    $('#default_source_id_container').show();
                }
                $('#default_source_id').val(setting.default_source_id);
                $('#fold_count').val(setting.fold_count);
                if (setting.is_display_label == '1') {
                    $('#is_display_label').attr('checked', true);
                } else {
                    $('#is_display_label').removeAttr('checked');
                }


            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    };

    MindAjax.prototype.saveSettings = function () {
        loading.show('#setting-modal-body', '正在执行');
        var params = {format: 'json'};
        var project_id = window._cur_project_id;
        if($('#checkbox-is_display_label').prop("checked")){
            $('#is_display_label').val('1');
        }else{
            $('#is_display_label').val('0');
        }
        $.ajax({
            type: "POST",
            dataType: "json",
            async: true,
            url: '/project/mind/saveSetting/?project_id=' + project_id,
            data: $('#form_mind_setting').serialize(),
            success: function (resp) {
                auth_check(resp);
                loading.closeAll();
                notify_success('操作成功');
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    };

    MindAjax.prototype.delete = function (issue_id) {
        $.ajax({
            type: 'post',
            dataType: "json",
            async: true,
            url: root_url + "issue/main/delete",
            data: { issue_id: issue_id },
            success: function (resp) {
                auth_check(resp);
                if (resp.ret !== '200') {
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

    MindAjax.prototype.add = function (item, text, fnc) {

        let post_data = {summary:text}

        // 初始必填项
        if(!post_data.project_id){
            post_data.project_id = window._cur_project_id;
        }
        if(!post_data.issue_type){
            post_data.issue_type = '3';
        }
        if(!post_data.assignee){
            post_data.assignee = window.current_uid ;
        }
        if(!post_data.priority){
            post_data.priority = '3';
        }

        let source_range_el = $('#source_range');
        if(source_range_el.val()!=='all'){
            post_data.sprint = source_range_el.val();
        }
        let parentItem = item.getParent();
        let id_arr = parentItem._id.split('_');
        if(id_arr[1]){
            let groupByField = id_arr[0];
            if(groupByField==='project' || groupByField==='issue'){
                if(groupByField==='issue' && id_arr[1]){
                    post_data['master_issue_id'] = id_arr[1];
                }
            }else{
                post_data[groupByField] = id_arr[1];
            }
        }

        console.log(post_data);
        if(!post_data.summary){
            notify_error('事项标题不能为空');
            return;
        }
        var method = 'post';
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: "/issue/main/add?source=mind&project="+window._cur_project_id,
            data:  {params:post_data},
            single: 'single',
            mine: true, // 当single重复时用自身并放弃之前的ajax请求
            success: function (resp) {
                auth_check(resp);
                if (!form_check(resp)) {
                    return;
                }
                if (resp.ret === '200') {
                    item.setId('issue_'+resp.data)
                    notify_success(resp.msg);
                } else {
                    var action = new MM.Action.RemoveItem(item);
                    MM.App.action(action);
                    notify_error(resp.msg);
                }
                if(jQuery.type(fnc) === "function"){
                    fnc();
                }
            },
            error: function (res) {
                var action = new MM.Action.RemoveItem(item);
                MM.App.action(action);
                notify_error("请求数据错误" + res);
            }
        });
    }

    MindAjax.prototype.update = function (issue_id, post_data, fnc) {
        // 初始必填项
        if(!post_data.project_id){
            post_data.project_id = window._cur_project_id;
        }

        var method = 'post';
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: "/issue/main/update?project="+window._cur_project_id,
            data: {params:post_data,issue_id:issue_id},
            success: function (resp) {
                auth_check(resp);
                if (!form_check(resp)) {
                    return;
                }
                if (resp.ret === '200') {
                    notify_success('更新成功');
                } else {
                    notify_error('更新失败,错误信息:' + resp.msg);
                    console.error(resp.msg)
                }
                if(jQuery.type(fnc) === "function"){
                    fnc();
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    MindAjax.prototype.updateIssueFormat = function (issue_id, format, fnc) {
        // 初始必填项
        let project_id = window._cur_project_id;
        let source = $('#source_range').val();
        let group_by = '';
        if(source==='all'){
            group_by = $('#all-group_by').val();
        }else{
            group_by = $('#sprint-group_by').val();
        }
        let params = '';
        params = 'project_id='+project_id+'&source='+source+'&group_by='+group_by+'&issue_id='+issue_id

        var method = 'post';
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: "/project/mind/saveIssueFormat?"+params,
            data: format,
            success: function (resp) {
                auth_check(resp);
                if (!form_check(resp)) {
                    return;
                }
                if (resp.ret === '200') {
                    //notify_success('更新成功');
                    console.log(resp.msg)
                } else {
                    //notify_error('更新失败,错误信息:' + resp.msg);
                    console.error(resp.msg)
                }
                if(jQuery.type(fnc) === "function"){
                    fnc();
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    MindAjax.prototype.updateSecondFormat = function (group_by_id, format, fnc) {
        // 初始必填项
        let project_id = window._cur_project_id;
        let source = $('#source_range').val();
        let group_by = '';
        if(source==='all'){
            group_by = $('#all-group_by').val();
        }else{
            group_by = $('#sprint-group_by').val();
        }
        let params = '';
        params = 'project_id='+project_id+'&source='+source+'&group_by='+group_by+'&group_by_id='+group_by_id

        var method = 'post';
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: "/project/mind/saveSecondFormat?"+params,
            data: format,
            success: function (resp) {
                auth_check(resp);
                if (!form_check(resp)) {
                    return;
                }
                if (resp.ret === '200') {
                    //notify_success('更新成功');
                } else {
                    //notify_error('更新失败,错误信息:' + resp.msg);
                    console.error(resp.msg)
                }
                if(jQuery.type(fnc) === "function"){
                    fnc();
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    MindAjax.prototype.updateProjectFormat = function (project_id, format, fnc) {
        // 初始必填项
        let params = 'project_id='+project_id
        var method = 'post';
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: "/project/mind/saveProjectFormat?"+params,
            data: format,
            success: function (resp) {
                auth_check(resp);
                if (!form_check(resp)) {
                    return;
                }
                if (resp.ret === '200') {
                    //notify_success('更新成功');
                    console.log(resp.msg)
                } else {
                    //notify_error('更新失败,错误信息:' + resp.msg);
                    console.error(resp.msg)
                }
                if(jQuery.type(fnc) === "function"){
                    fnc();
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    MindAjax.prototype.updateSprintFormat = function (sprint_id, format, fnc) {
        // 初始必填项
        let params = 'sprint_id='+sprint_id

        var method = 'post';
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: "/project/mind/saveSprintFormat?"+params,
            data: format,
            success: function (resp) {
                auth_check(resp);
                if (!form_check(resp)) {
                    return;
                }
                if (resp.ret === '200') {
                    notify_success('更新成功');
                    console.log(resp.msg)
                } else {
                    //notify_error('更新失败,错误信息:' + resp.msg);
                    console.error(resp.msg)
                }
                if(jQuery.type(fnc) === "function"){
                    fnc();
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    return MindAjax;
})();

