let MindAjax = (function () {

    let _options = {};

    // constructor
    function MindAjax(options) {
        _options = options;
    };

    MindAjax.prototype.getOptions = function () {
        return _options;
    };


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


    return MindAjax;
})();

