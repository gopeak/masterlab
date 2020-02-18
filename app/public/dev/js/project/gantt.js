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
        var issue_types_select = document.getElementById('create_issue_types_select');
        $('#create_issue_types_select').empty();

        for (var _key in  issue_types) {
            issue_types_select.options.add(new Option(issue_types[_key].name, issue_types[_key].id));
        }
        console.log(issue_types_select);
        $('.selectpicker').selectpicker('refresh');
    }

    Gantt.prototype.initPriority = function (prioritys) {
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
            console.log(opt)
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
        $.ajax({
            type: method,
            dataType: "json",
            data: {source_type:source_type_value, is_display_backlog:is_display_backlog_value,holiday_dates:holiday_dates_str,extra_holiday_dates:extra_holiday_dates_str},
            url: url,
            success: function (resp) {
                auth_check(resp);
                if( resp.ret === "200" ){
                    notify_success(resp.msg);
                    setTimeout("window.location.reload();", 2000)
                } else {
                    notify_error(resp.msg);
                }
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
    }

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
    }

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
    }
    return Gantt;
})();


