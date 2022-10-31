
let Sprint = (function() {

    let _options = {};

    // constructor
    function Sprint(  options  ) {
        _options = options;
    };

    Sprint.prototype.getOptions = function() {
        return _options;
    };

    Sprint.prototype.active = function(sprint_id) {
        $.post("/agile/setSprintActive",{sprint_id:sprint_id},function(resp){
            if(resp.ret ==="200" ){
                notify_success(resp.msg, resp.data);
                Sprint.prototype.fetchAll();
            } else {
                notify_error(resp.msg, resp.data);
                console.log(resp);
            }
        });
    };
    Sprint.prototype.pause = function(sprint_id) {
        $.post("/agile/setSprintPause",{sprint_id:sprint_id},function(resp){
            if(resp.ret ==="200" ){
                notify_success(resp.msg, resp.data);
                Sprint.prototype.fetchAll();
            } else {
                notify_error(resp.msg, resp.data);
                console.log(resp);
            }
        });
    };

    Sprint.prototype.delete = function(sprint_id) {
        swal({
                title: "确认要删除该迭代？",
                text: "注:删除后，迭代是无法恢复的！",
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
                    $.post("/agile/deleteSprint",{sprint_id:sprint_id},function(result){
                        if(result.ret ==="200" ){
                            //location.reload();
                            notify_success(result.msg, result.data);
                            //$('#li_data_id_'+sprint_id).remove();
                            Sprint.prototype.fetchAll();
                        } else {
                            notify_error(result.msg, result.data);
                        }
                    });
                    swal.close();
                }else{
                    swal.close();
                }
            }
        );

    };

    Sprint.prototype.edit = function(sprint_id){
        $('#modal-edit-sprint'). modal('show');
        $.ajax({
            type: 'GET',
            dataType: "json",
            async: true,
            url: "/agile/fetchSprint/"+sprint_id,
            data: {sprint_id: sprint_id},
            success: function (resp) {
                auth_check(resp);
                if(resp.ret ==="200" ){
                    $('#edit_id').val(resp.data.id);
                    $('#edit_name').val(resp.data.name);
                    $('#edit_start_date').val(resp.data.start_date);
                    $('#edit_end_date').val(resp.data.end_date);
                    $('#edit_description').val(resp.data.description);
                    $('#l_edit_status_'+resp.data.status).addClass('active');
                    $('#edit_status_'+resp.data.status).attr('checked',true);
                    $('#edit_status_'+resp.data.status).click();
                    $('#edit_active_'+resp.data.active).attr('checked',true);
                    $('#edit_active_'+resp.data.active).click();
                } else {
                    notify_error(resp.msg, resp.data);
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    };

    Sprint.prototype.update = function( ){
        $.ajax({
            type: 'POST',
            dataType: "json",
            async: true,
            url: "/agile/updateSprint",
            data: $('#form_edit_action').serialize(),
            success: function (resp) {
                auth_check(resp);
                if(resp.ret ==="200" ){
                    notify_success(resp.msg, resp.data);
                    Sprint.prototype.fetchAll();
                    $('#modal-edit-sprint').modal('hide');
                } else {
                    notify_error(resp.msg);
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    };

    Sprint.prototype.add = function( ){

        let add_name_obj = $('#add_name');
        if(is_empty(add_name_obj.val())){
            notify_error('参数错误', '迭代名称不能为空');
            add_name_obj.focus();
            return;
        }

        $.ajax({
            type: 'POST',
            dataType: "json",
            async: true,
            url: "/agile/addSprint",
            data: $('#form_add_action').serialize(),
            success: function (resp) {
                auth_check(resp);
                if(resp.ret ==="200" ){
                    notify_success(resp.msg, resp.data);
                    Sprint.prototype.fetchAll();
                    $('#add_name').val('');
                    $('#add_start_date').val('');
                    $('#add_end_date').val('');
                    $('#add_description').val('');
                } else {
                    notify_error(resp.msg, resp.data);
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    };

    Sprint.prototype.fetchAll = function() {
   
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: _options.filter_url,
            data: _options.query_param_obj,
            success: function (resp) {
                auth_check(resp);
                if (resp.data.sprints.length) {
                    let source = $('#'+_options.list_tpl_id).html();
                    let template = Handlebars.compile(source);

                    let result = template(resp.data);
                    //console.log(result);
                    $('#' + _options.list_render_id).html(result);

                    $(".list_for_set_active").click(function(){
                        Sprint.prototype.active( $(this).data("id"));
                    });
                    $(".list_for_set_pause").click(function(){
                        Sprint.prototype.pause( $(this).data("id"));
                    });

                    $(".list_for_delete").click(function(){
                        Sprint.prototype.delete( $(this).data("id"));
                    });

                    $(".list_for_edit").bind("click", function () {
                        Sprint.prototype.edit($(this).data('id'));
                    });
                } else {
                    defineStatusHtml({
                        wrap: '#' + _options.list_render_id,
                        message : '迭代数据为空',
                        name: "sprint"
                    });
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    };

    return Sprint;
})();

