
var Webhook = (function() {

    var _options = {};

    // constructor
    function Webhook( options ) {
        _options = options;
        $("#btn-plugin_save").click(function(){
            if($('#id_action').val()==='add'){
                Webhook.prototype.add();
            }else{
                Webhook.prototype.update();
            }
        });
        $("#btn-create_plugin").click(function(){
            Webhook.prototype.create();
        });

    };

    Webhook.prototype.getOptions = function() {
        return _options;
    };

    Webhook.prototype.setOptions = function( options ) {
        for( i in  options )  {
           // if( typeof( _options[options[i]] )=='undefined' ){
                _options[i] = options[i];
           // }
        }
    };

    Webhook.prototype.fetchWebhooks = function(  ) {

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
                if(resp.data.webhooks.length){
                    var source = $('#'+_options.list_tpl_id).html();
                    var template = Handlebars.compile(source);
                    var result = template(resp.data);

                    $('#' + _options.list_render_id).html(result);

                    $(".list_for_enable").click(function(){
                        Webhook.prototype.enable( $(this).attr("data-value") );
                    });

                    $(".list_for_disable").click(function(){
                        Webhook.prototype.disable( $(this).attr("data-value") );
                    });

                    $(".list_for_edit").click(function(){
                        Webhook.prototype.edit( $(this).attr("data-value") );
                    });
                    // list_for_view_secret
                    $(".list_for_view_secret").click(function(){
                        $('#view-secret').html( $(this).attr("data-value") );
                        $("#modal-view-secret").modal('show');
                    });

                    $(".list_for_delete").click(function(){
                        Webhook.prototype._delete( $(this).attr("data-value") );
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
    };


    Webhook.prototype.create = function( ) {
        $("#modal-plugin").modal('show');
        $('#modal-header-title').html('创建Webhook');
        $('#form-plugin')[0].reset();
        $("#id_action").val('add');
        $('#tip_name').show();
        $("#id_url").val('');
        $("#id_secret_token").val('');
        $("#id_timeout").val('10');
        $("#id_description").text('');
    };

    Webhook.prototype.edit = function(id ) {

        $("#modal-plugin").modal('show');
        $('#modal-header-title').html('编辑Webhook');
        $("#id_action").val('update');
        loading.show('#modal-body');
        var method = 'get';
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: _options.get_url+"?id="+id,
            data: { id:id} ,
            success: function (resp) {
                loading.closeAll();
                auth_check(resp);
                $("#edit_id").val(resp.data.id);
                $("#id_name").val(resp.data.name);
                $('#tip_name').hide();
                $("#id_url").val(resp.data.url);
                $("#id_secret_token").val(resp.data.secret_token);
                $("#id_timeout").val(resp.data.timeout);
                $("#id_description").text(resp.data.description);
                $('#id_hook_events').val(resp.data.hook_event_arr);
                $('.selectpicker').selectpicker('refresh');
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    };

    Webhook.prototype.add = function(  ) {

        var method = 'post';
        var params = $('#form-plugin').serialize();
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: _options.add_url,
            data: params ,
            success: function (resp) {
                auth_check(resp);
                if( resp.ret ==='200'  ){
                    window.location.reload();
                }else{
                    notify_error( resp.msg ,resp.data);
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    };

    Webhook.prototype.update = function(  ) {

        var method = 'post';
        var params = $('#form-plugin').serialize();
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: _options.update_url,
            data: params ,
            success: function (resp) {
                auth_check(resp);
                if( resp.ret ==='200'  ){
                    window.location.reload();
                }else{
                    notify_error( resp.msg );
                }

            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    };

    Webhook.prototype.enable = function(id ) {

        var method = 'POST';
        $.ajax({
            type: method,
            dataType: "json",
            data:{id:id },
            url: _options.enable_url,
            success: function (resp) {
                auth_check(resp);
                notify_success( resp.msg,  resp.data);
                if( resp.ret ==='200'  ){
                    window.location.reload();
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    };

    Webhook.prototype.disable = function(id ) {

        if  (!window.confirm('您确认要停用吗?')) {
            return false;
        }
        var method = 'POST';
        $.ajax({
            type: method,
            dataType: "json",
            data:{id:id },
            url: _options.disable_url,
            success: function (resp) {
                auth_check(resp);
                notify_success( resp.msg,   resp.data );
                if( resp.ret ==='200'  ){
                    window.location.reload();
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    };

    Webhook.prototype._delete = function(id ) {

        if  (!window.confirm('您确认删除吗?')) {
            return false;
        }
        var method = 'POST';
        $.ajax({
            type: method,
            dataType: "json",
            data:{id:id},
            url: _options.delete_url,
            success: function (resp) {
                auth_check(resp);
                notify_success( resp.msg ,  resp.data);
                if( resp.ret ==='200'  ){
                    window.location.reload();
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    };

    return Webhook;
})();

