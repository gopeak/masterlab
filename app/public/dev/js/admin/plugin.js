
var Plugin = (function() {

    var _options = {};

    // constructor
    function Plugin( options ) {
        _options = options;
        $("#btn-plugin_save").click(function(){
            if($('#id_action').val()==='add'){
                Plugin.prototype.add();
            }else{
                Plugin.prototype.update();
            }
        });
        $("#btn-create_plugin").click(function(){
            Plugin.prototype.create();
        });

    };

    Plugin.prototype.getOptions = function() {
        return _options;
    };

    Plugin.prototype.setOptions = function( options ) {
        for( i in  options )  {
           // if( typeof( _options[options[i]] )=='undefined' ){
                _options[i] = options[i];
           // }
        }
    };

    Plugin.prototype.fetchPlugins = function(  ) {

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
                if(resp.data.plugins.length){
                    var source = $('#'+_options.list_tpl_id).html();
                    var template = Handlebars.compile(source);
                    var result = template(resp.data);
                    $('#' + _options.list_render_id).html(result);

                    $(".list_for_install").click(function(){
                        Plugin.prototype.install( $(this).attr("data-value") );
                    });

                    $(".list_for_uninstall").click(function(){
                        Plugin.prototype.uninstall( $(this).attr("data-value") );
                    });

                    $(".list_for_edit").click(function(){
                        Plugin.prototype.edit( $(this).attr("data-value") );
                    });

                    $(".list_for_delete").click(function(){
                        Plugin.prototype._delete( $(this).attr("data-value") );
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


    Plugin.prototype.create = function( ) {
        $("#modal-plugin").modal('show');
        $('#modal-header-title').html('创建插件');
        $('#form-plugin')[0].reset();
        $("#id_action").val('add');
        $("#id_name").attr('readonly', false);
        $('#tip_name').show();
        $("#id_icon").val('');
        $("#id_type").val('module');
        $("#id_type").selectpicker('refresh');
        console.log(window.uploader)
        window.uploader.reset();

    };

    Plugin.prototype.edit = function(id ) {

        $("#modal-plugin").modal('show');
        $('#modal-header-title').html('编辑插件');
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
                $("#id_name").attr('readonly', true);
                $('#tip_name').hide();
                $("#id_title").val(resp.data.title);
                $("#id_type").val(resp.data.type);
                $("#id_version").val(resp.data.version);
                $("#id_url").val(resp.data.url);
                $("#id_company").val(resp.data.company);
                $("#id_description").text(resp.data.description);
                $("#id_icon").val(resp.data.icon_file);

                $('.selectpicker').selectpicker('refresh');
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    };



    Plugin.prototype.add = function(  ) {

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

    Plugin.prototype.update = function(  ) {

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

    Plugin.prototype.install = function(name ) {

        var method = 'POST';
        $.ajax({
            type: method,
            dataType: "json",
            data:{name:name },
            url: _options.install_url,
            success: function (resp) {
                auth_check(resp);
                notify_success( resp.msg,  resp.data);
                if( resp.ret ==='200'  ){
                    //window.location.reload();
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    };

    Plugin.prototype.uninstall = function(id ) {

        if  (!window.confirm('您确认要卸载吗?')) {
            return false;
        }
        var method = 'POST';
        $.ajax({
            type: method,
            dataType: "json",
            data:{id:id },
            url: _options.uninstall_url,
            success: function (resp) {
                auth_check(resp);
                notify_success( resp.msg );
                if( resp.ret ==='200'  ){
                    //window.location.reload();
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    };

    Plugin.prototype._delete = function(name ) {

        if  (!window.confirm('您确认删除吗?删除后插件的所有文件将被清空!')) {
            return false;
        }
        var method = 'POST';
        $.ajax({
            type: method,
            dataType: "json",
            data:{name:name },
            url: _options.delete_url,
            success: function (resp) {
                auth_check(resp);
                notify_success( resp.msg );
                if( resp.ret ==='200'  ){
                    window.location.reload();
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    };

    return Plugin;
})();

