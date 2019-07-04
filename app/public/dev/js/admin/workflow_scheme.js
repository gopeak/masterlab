
var WorkflowScheme = (function() {

    var _options = {};

    var _issue_types = [];
    var _workflow = [];
    var _add_issue_type_workflow = {};
    var _edit_issue_type_workflow = {};

    // constructor
    function WorkflowScheme(  options  ) {
        _options = options;

        $("#btn-workflow_scheme_add").click(function(){
            WorkflowScheme.prototype.add();
        });

        $("#btn-workflow_scheme_update").click(function(){
            WorkflowScheme.prototype.update();
        });

        $("#btn-issue_type_workflow_add").click(function(){
            WorkflowScheme.prototype.issue_type_workflow_add();
        });

        $("#btn-issue_type_workflow_edit").click(function(){
            WorkflowScheme.prototype.issue_type_workflow_edit();
        });
    };

    WorkflowScheme.prototype.getOptions = function() {
        return _options;
    };

    WorkflowScheme.prototype.setOptions = function( options ) {
        for( i in  options )  {
           // if( typeof( _options[options[i]] )=='undefined' ){
                _options[i] = options[i];
           // }
        }
    };

    WorkflowScheme.prototype.fetchWorkflowSchemes = function(  ) {

        // url,  list_tpl_id, list_render_id
        var params = {  format:'json' };
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: _options.filter_url,
            data: $('#'+_options.filter_form_id).serialize() ,
            success: function (resp) {
                auth_check(resp);
                if(resp.data.workflow.length){
                    _workflow = resp.data.workflow;
                    _issue_types = resp.data.issue_types;
                    var source = $('#'+_options.list_tpl_id).html();
                    var template = Handlebars.compile(source);
                    var result = template(resp.data);
                    $('#' + _options.list_render_id).html(result);

                    $(".list_for_edit").click(function(){
                        WorkflowScheme.prototype.edit( $(this).attr("data-value") );
                    });

                    $(".list_for_delete").click(function(){
                        WorkflowScheme.prototype._delete( $(this).attr("data-value") );
                    });
                    $("#btn-issue_type_workflow_add").click(function(){
                        WorkflowScheme.prototype.issue_type_workflow_add(   );
                    });

                    var issue_types = resp.data.issue_types;
                    var obj=document.getElementById('issue_type_ids');
                    for(var i = 0; i < issue_types.length; i++){
                        obj.options.add(new Option( issue_types[i].name, issue_types[i].id ));
                    }
                    var obj=document.getElementById('edit_issue_type_ids');
                    for(var i = 0; i < issue_types.length; i++){
                        obj.options.add(new Option( issue_types[i].name, issue_types[i].id ));
                    }

                    var workflow = resp.data.workflow;
                    var obj=document.getElementById('workflow_id');
                    for(var i = 0; i < workflow.length; i++){
                        obj.options.add(new Option( workflow[i].name, workflow[i].id ));
                    }
                    var obj=document.getElementById('edit_workflow_id');
                    for(var i = 0; i < workflow.length; i++){
                        obj.options.add(new Option( workflow[i].name, workflow[i].id ));
                    }
                    $('.selectpicker').selectpicker('refresh');
                }else{
                    var emptyHtml = defineStatusHtml({
                        message : '暂无数据',
                        handleHtml: ''
                    })
                    $('#'+_options.list_render_id).append($('<tr><td colspan="4" id="' + _options.list_render_id + '_wrap"></td></tr>'))
                    $('#'+_options.list_render_id + '_wrap').append(emptyHtml.html)
                }
                

            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    WorkflowScheme.prototype.issue_type_workflow_add = function(  ) {
        var issue_type_ids = $('#issue_type_ids').val();
        var workflow_id = $('#workflow_id').val();
        if(!issue_type_ids || !workflow_id){
            return ;
        }
        for(var i = 0; i < issue_type_ids.length; i++){
            var _key = issue_type_ids[i]+'@'+workflow_id
            if(!_.has(_add_issue_type_workflow, _key) ){
                var issue_name = WorkflowScheme.prototype.getIssueTypeName(issue_type_ids[i]);
                var workflow_name = WorkflowScheme.prototype.getWorkflowName(workflow_id)
                _add_issue_type_workflow[_key] = {issue_type_id:issue_type_ids[i],workflow_id:workflow_id};
            }
        }
        console.log(_add_issue_type_workflow);
        WorkflowScheme.prototype.issue_type_workflow_format();
        WorkflowScheme.prototype.issue_type_workflow_render('add_list_render_id',_add_issue_type_workflow);
    }

    WorkflowScheme.prototype.issue_type_workflow_edit = function(  ) {
        var issue_type_ids = $('#edit_issue_type_ids').val();
        var workflow_id = $('#edit_workflow_id').val();
        if(!issue_type_ids || !workflow_id){
            return ;
        }
        for(var i = 0; i < issue_type_ids.length; i++){
            var _key = issue_type_ids[i]+'@'+workflow_id
            if(!_.has(_edit_issue_type_workflow, _key) ){
                var issue_name = WorkflowScheme.prototype.getIssueTypeName(issue_type_ids[i]);
                var workflow_name = WorkflowScheme.prototype.getWorkflowName(workflow_id)
                _edit_issue_type_workflow[_key] = {issue_type_id:issue_type_ids[i],workflow_id:workflow_id};
            }
        }
        console.log(_edit_issue_type_workflow);
        WorkflowScheme.prototype.issue_type_workflow_format();
        WorkflowScheme.prototype.issue_type_workflow_render('edit_list_render_id',_edit_issue_type_workflow);
    }

    WorkflowScheme.prototype.issue_type_workflow_format = function(  ) {
        $('#add_issue_type_workflow').val(JSON.stringify(_add_issue_type_workflow));
        $('#edit_issue_type_workflow').val(JSON.stringify(_edit_issue_type_workflow));
    }

    WorkflowScheme.prototype.add_issue_type_workflow_delete = function( _key ) {

        delete _add_issue_type_workflow[_key]
        console.log(_add_issue_type_workflow);
        WorkflowScheme.prototype.issue_type_workflow_format();
        WorkflowScheme.prototype.issue_type_workflow_render('add_list_render_id',_add_issue_type_workflow);
    }

    WorkflowScheme.prototype.edit_issue_type_workflow_delete = function( _key ) {

        delete _edit_issue_type_workflow[_key]
        console.log(_edit_issue_type_workflow);
        WorkflowScheme.prototype.issue_type_workflow_format();
        WorkflowScheme.prototype.issue_type_workflow_render('edit_list_render_id',_edit_issue_type_workflow);
    }

    WorkflowScheme.prototype.issue_type_workflow_render = function( render_id,issue_type_workflow ) {

        var html = '<tr class="commit">\n' +
            '                                        <td  ><strong>未分配的问题类型</strong></td>\n' +
            '                                        <td>--></td>\n' +
            '                                        <td>默认工作流</td>\n' +
            '                                        <td  ></td>\n' +
            '                                    </tr>';
        for( var _key in issue_type_workflow ){
            var issue_type_name = WorkflowScheme.prototype.getIssueTypeName(issue_type_workflow[_key].issue_type_id);
            var workflow_name = WorkflowScheme.prototype.getWorkflowName(issue_type_workflow[_key].workflow_id);
            var btn_class = 'add_issue_workflow_delete';
            if( render_id=='edit_list_render_id' ){
                btn_class = 'edit_issue_workflow_delete';
            }
            html += '<tr class="commit">\n' +
                '      <td  ><strong>'+issue_type_name+'</strong></td>\n' +
                '      <td>--></td>\n' +
                '      <td>'+workflow_name+'</td>\n' +
                '      <td  ><a class="'+btn_class+' btn btn-transparent "  href="javascript:;" data-value="'+_key+'" ><i class="fa fa-trash"></i><span class="sr-only">Remove</span></a></td>\n' +
                '  </tr>';
        }
        $('#'+render_id).html(html);

        $(".add_issue_workflow_delete").click(function(){
            WorkflowScheme.prototype.add_issue_type_workflow_delete( $(this).attr("data-value") );
        });
        $(".edit_issue_workflow_delete").click(function(){
            WorkflowScheme.prototype.edit_issue_type_workflow_delete( $(this).attr("data-value") );
        });
    }



    WorkflowScheme.prototype.getIssueTypeName = function( issue_id ) {

        console.log(_issue_types)
        for(var i = 0; i < _issue_types.length; i++){
            if( _issue_types[i].id==issue_id ){
                return _issue_types[i].name;
            }
        }
        return '';
    }

    WorkflowScheme.prototype.getWorkflowName = function( workflow_id ) {

        for(var i = 0; i < _workflow.length; i++){
            if( _workflow[i].id==workflow_id ){
                return _workflow[i].name;
            }
        }
        return '';
    }

    WorkflowScheme.prototype.edit = function(id ) {

        var method = 'get';
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: _options.get_url,
            data: { id:id} ,
            success: function (resp) {

                auth_check(resp);
                $("#modal-workflow_scheme_edit").modal();
                $("#edit_id").val(resp.data.scheme.id);
                $("#edit_name").val(resp.data.scheme.name);
                $("#edit_description").val(resp.data.scheme.description);

                var scheme_data = resp.data.scheme_data;
                for(var i = 0; i < scheme_data.length; i++){
                    var issue_type_id = scheme_data[i].issue_type_id;
                    var workflow_id = scheme_data[i].workflow_id;
                    var _key = issue_type_id+'@'+workflow_id
                    if(!_.has(_edit_issue_type_workflow, _key) ){
                        _edit_issue_type_workflow[_key] = {issue_type_id:issue_type_id,workflow_id:workflow_id};
                    }
                }
                $('#edit_issue_type_workflow').val(JSON.stringify(_edit_issue_type_workflow));
                WorkflowScheme.prototype.issue_type_workflow_render('edit_list_render_id',_edit_issue_type_workflow);

            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    WorkflowScheme.prototype.add = function(  ) {

        var method = 'post';
        var params = $('#form_add').serialize();
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: _options.add_url,
            data: params ,
            success: function (resp) {
                auth_check(resp);
                notify_success( resp.msg );
                if( resp.ret == 200 ){
                     window.location.reload();
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    WorkflowScheme.prototype.update = function(  ) {

        var method = 'post';
        var params = $('#form_edit').serialize();
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: _options.update_url,
            data: params ,
            success: function (resp) {
                auth_check(resp);
                notify_success( resp.msg );
                if( resp.ret == 200 ){
                    window.location.reload();
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    WorkflowScheme.prototype._delete = function(id ) {

        if  (!window.confirm('您确认删除该项吗?')) {
            return false;
        }

        var method = 'GET';
        $.ajax({
            type: method,
            dataType: "json",
            data:{id:id },
            url: _options.delete_url,
            success: function (resp) {
                auth_check(resp);
                notify_success( resp.msg );
                if( resp.ret == 200 ){
                    window.location.reload();
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    return WorkflowScheme;
})();


