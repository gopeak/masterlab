
var Workflow = (function() {

    var _options = {};

    // constructor
    function Workflow(  options  ) {
        _options = options;

        $(".btn-workflow_add").click(function(){
            Workflow.prototype.add();
        });

        $(".btn-workflow_update").click(function(){
            Workflow.prototype.update();
        });

    };

    Workflow.prototype.getOptions = function() {
        return _options;
    };

    Workflow.prototype.setOptions = function( options ) {
        for( i in  options )  {
           // if( typeof( _options[options[i]] )=='undefined' ){
                _options[i] = options[i];
           // }
        }
    };

    Workflow.prototype.fetchWorkflow = function(  ) {

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
                    var source = $('#'+_options.list_tpl_id).html();
                    var template = Handlebars.compile(source);
                    var result = template(resp.data);
                    $('#' + _options.list_render_id).html(result);

                    $(".list_for_edit").click(function(){
                        Workflow.prototype.edit( $(this).attr("data-value") );
                    });

                    $(".list_for_delete").click(function(){
                        Workflow.prototype._delete( $(this).attr("data-value") );
                    });
                }else{
                    var emptyHtml = defineStatusHtml({
                        message : '暂无数据',
                        handleHtml: ''
                    })
                    $('#'+_options.list_render_id).append($('<tr><td colspan="5" id="' + _options.list_render_id + '_wrap"></td></tr>'))
                    $('#'+_options.list_render_id + '_wrap').append(emptyHtml.html)
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    Workflow.prototype.edit = function(id ) {

        var method = 'get';
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: _options.get_url+"?id="+id,
            data: { id:id} ,
            success: function (resp) {

                auth_check(resp);
                $("#modal-workflow_edit").modal();
                $("#edit_id").val(resp.data.id);
                $("#edit_name").val(resp.data.name); 
                $("#edit_description").text(resp.data.description);
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    Workflow.prototype.getDesignerData = function(  ) {

        var instance = window.jsp;
        var connections = [];
        $.each(instance.getConnections(), function (idx, connection) {
            connections.push(
                {
                    id:connection.id,
                    sourceId: connection.sourceId,
                    targetId: connection.targetId
                }
            );
        });

        var _blocks = []
        $("#canvas .w").each(function (idx, elem) {
            var $elem = $(elem);
            _blocks.push({
                id: $elem.attr('id'),
                positionX: parseInt($elem.css("left"), 10),
                positionY: parseInt($elem.css("top"), 10),
                innerHTML:$elem.html(),
                innerText:$elem.text(),

            });
        });
        var canvas_data = {
            blocks:_blocks,
            connections:connections
        };
        var serializedData = JSON.stringify(canvas_data);
        return serializedData;
        $('#workflow_json').text(serializedData);


    }

    Workflow.prototype.add = function(  ) {

        $('#workflow_json').text(Workflow.prototype.getDesignerData());

        var method = 'post';
        var params = $('#new_workflow').serialize();
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
                    window.location.href='/admin/workflow';
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    Workflow.prototype.update = function(  ) {

        $('#workflow_json').text(Workflow.prototype.getDesignerData());
        console.log( $('#workflow_json').text() );
        $.ajax({
            type: 'post',
            dataType: "json",
            async: true,
            url: $('#form_edit').attr('action'),
            data: $('#form_edit').serialize() ,
            success: function (resp) {
                auth_check(resp);
                notify_success( resp.msg );
                if( resp.ret == 200 ){
                    window.location.href='/admin/workflow';
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    Workflow.prototype._delete = function(id ) {

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

    return Workflow;
})();


