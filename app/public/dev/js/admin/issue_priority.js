
var IssuePriority = (function() {

    var _options = {};

    // constructor
    function IssuePriority(  options  ) {
        _options = options;

        $("#btn-issue_priority_add").click(function(){
            IssuePriority.prototype.add();
        });

        $("#btn-issue_priority_update").click(function(){
            IssuePriority.prototype.update();
        });

    };

    IssuePriority.prototype.getOptions = function() {
        return _options;
    };

    IssuePriority.prototype.setOptions = function( options ) {
        for( i in  options )  {
           // if( typeof( _options[options[i]] )=='undefined' ){
                _options[i] = options[i];
           // }
        }
    };

    IssuePriority.prototype.fetchIssuePrioritys = function(  ) {

        // url,  list_tpl_id, list_render_id
        var params = {  format:'json' };
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: _options.filter_url,
            data: $('#'+_options.filter_form_id).serialize() ,
            success: function (resp) {

                var source = $('#'+_options.list_tpl_id).html();
                var template = Handlebars.compile(source);
                var result = template(resp.data);
                $('#' + _options.list_render_id).html(result);

                $(".list_for_edit").click(function(){
                    IssuePriority.prototype.edit( $(this).attr("data-value") );
                });

                $(".list_for_delete").click(function(){
                    IssuePriority.prototype._delete( $(this).attr("data-value") );
                });

            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    IssuePriority.prototype.edit = function(id ) {

        var method = 'get';
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: _options.get_url+"?id="+id,
            data: { id:id} ,
            success: function (resp) {

                $("#modal-issue_priority_edit").modal();
                $("#edit_id").val(resp.data.id);
                $("#edit_name").val(resp.data.name);
                $("#edit_font_awesome").val(resp.data.font_awesome);
                $("#edit_description").val(resp.data.description);
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    IssuePriority.prototype.add = function(  ) {

        var method = 'post';
        var params = $('#form_add').serialize();
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: _options.add_url,
            data: params ,
            success: function (resp) {
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

    IssuePriority.prototype.update = function(  ) {

        var method = 'post';
        var params = $('#form_edit').serialize();
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: _options.update_url,
            data: params ,
            success: function (resp) {
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

    IssuePriority.prototype._delete = function(id ) {

        if  (!window.confirm('Are you sure delete this item?')) {
            return false;
        }

        var method = 'GET';
        $.ajax({
            type: method,
            dataType: "json",
            data:{id:id },
            url: _options.delete_url,
            success: function (resp) {
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

    return IssuePriority;
})();


