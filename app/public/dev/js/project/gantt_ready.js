$(function(){
    window.$_gantAjax = new Gantt({});
    // 聚焦模式切换
    $('#toggle_focus_mode').bind('click',function(){
        $('.main-sidebar').toggleClass('hidden');
        $('.with-horizontal-nav').toggleClass('hidden');
        $('.layout-nav').toggleClass('hidden');
    });

    $('#btn-add').bind('click',function(){
        let err = {};
        if(is_empty(trimStr($('#gantt_summary').val()))){
            err['summary'] = '标题不能为空';
        }
        if(is_empty(trimStr($('#gantt_priority').val()))){
            err['priority'] = '优先级不能为空';
        }
        if(is_empty(trimStr($('#gantt_status').val()))){
            err['status'] = '状态不能为空';
        }
        if(is_empty(trimStr($('#gantt_assignee').val()))){
            err['assignee'] = '经办人不能为空';
        }
        if(is_empty($('#gantt_start_date').val())){
            err['start_date'] = '开始日期不能为空';
        }
        let due_date = trimStr($('#gantt_due_date').val());
        if(is_empty($('#gantt_due_date').val())){
            err['due_date'] = '截止日期不能为空';
        }
        // priority
        $('#tip-summary').addClass('hide');
        $('#tip-priority').addClass('hide');
        $('#tip-status').addClass('hide');
        $('#tip-assignee').addClass('hide');
        $('#tip-start_date').addClass('hide');
        $('#tip-due_date').addClass('hide');
        if(!is_empty(err)){
            for (var key in err) {
                $('#tip-'+key).html(err[key]);
                $('#tip-'+key).removeClass('hide');
            }
            notify_warn('提示','表单验证未通过');
            return;
        }

        if($('#action').val()=='update'){
            window.$_gantAjax.updateSyncServerTask();
        }else{
            window.$_gantAjax.addSyncServerTask();
        }
    });

    $('#modal-team').on('show.bs.modal', function (e) {

    })

    $('#modal-create-issue').on('show.bs.modal', function (e) {
        window.$_gantAjax.initIssueType(_project_issue_types);
        window.$_gantAjax.initPriority(window._issueConfig.priority);
        window.$_gantAjax.initStatus(window._issueConfig.issue_status);

    })

    $('.gantt-content').css('height', $(document).height() - 200 + 'px')

})