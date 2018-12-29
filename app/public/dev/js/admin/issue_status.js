
var IssueStatus = (function() {

    var _options = {};

    // constructor
    function IssueStatus(  options  ) {
        _options = options;

        $("#btn-issue_status_add").click(function(){
            IssueStatus.prototype.add();
        });

        $("#btn-issue_status_update").click(function(){
            IssueStatus.prototype.update();
        });

    };

    IssueStatus.prototype.getOptions = function() {
        return _options;
    };

    IssueStatus.prototype.setOptions = function( options ) {
        for( i in  options )  {
           // if( typeof( _options[options[i]] )=='undefined' ){
                _options[i] = options[i];
           // }
        }
    };

    IssueStatus.prototype.fetchIssueStatuss = function(  ) {

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
                if(resp.data.issue_status.length){
                    var source = $('#'+_options.list_tpl_id).html();
                    var template = Handlebars.compile(source);
                    var result = template(resp.data);
                    $('#' + _options.list_render_id).html(result);

                    $(".list_for_edit").click(function(){
                        IssueStatus.prototype.edit( $(this).attr("data-value") );
                    });

                    $(".list_for_delete").click(function(){
                        IssueStatus.prototype._delete( $(this).attr("data-value") );
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

    IssueStatus.prototype.edit = function(id ) {

        var method = 'get';
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: _options.get_url+"?id="+id,
            data: { id:id} ,
            success: function (resp) {

                auth_check(resp);
                $("#modal-issue_status_edit").modal();
                $("#edit_id").val(resp.data.id);
                $("#edit_name").val(resp.data.name);
                $("#edit_key").val(resp.data._key);
                $("#edit_font_awesome").val(resp.data.font_awesome);
                $("#edit_description").val(resp.data.description);

                $('.selectpicker').selectpicker('val', resp.data.color);
                //$('.selectpicker').selectpicker('refresh');
                $('.selectpicker').selectpicker('render');
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    IssueStatus.prototype.add = function(  ) {

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
                if( resp.ret == 200 ){
                    window.location.reload();
                }else{
                    notify_error( resp.msg );
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    IssueStatus.prototype.update = function(  ) {

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

                if( resp.ret == 200 ){
                    window.location.reload();
                }else{
                    notify_error( resp.msg );
                }

            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    IssueStatus.prototype._delete = function(id ) {

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

    return IssueStatus;
})();


