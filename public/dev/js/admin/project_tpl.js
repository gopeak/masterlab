
var PluginTemplate = (function() {

    var _options = {};

    // constructor
    function PluginTemplate( options ) {
        _options = options;
        $("#btn-project_tpl_save").click(function(){
            if($('#id_action').val()==='add'){
                PluginTemplate.prototype.add();
            }else{
                PluginTemplate.prototype.update();
            }
        });
        $("#btn-create_project_tpl").click(function(){
            PluginTemplate.prototype.create();
        });

    };

    PluginTemplate.prototype.getOptions = function() {
        return _options;
    };

    PluginTemplate.prototype.setOptions = function( options ) {
        for( i in  options )  {
           // if( typeof( _options[options[i]] )=='undefined' ){
                _options[i] = options[i];
           // }
        }
    };

    PluginTemplate.prototype.fetchAll = function(  ) {

        // url,  list_tpl_id, list_render_id
        var params = {  format:'json',category_id:window.category_id };
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: _options.filter_url,
            data: params,
            success: function (resp) {
                auth_check(resp);
                if(resp.data.project_tpls.length>0){

                    var source = $('#'+_options.list_tpl_id).html();
                    var template = Handlebars.compile(source);
                    var result = template(resp.data);
                    $('#' + _options.list_render_id).html(result);

                    $(".list_for_install").click(function(){
                        PluginTemplate.prototype.install( $(this).attr("data-value") );
                    });

                    $(".list_for_uninstall").click(function(){
                        PluginTemplate.prototype.uninstall( $(this).attr("data-value") );
                    });

                    $(".list_for_edit").click(function(){
                        PluginTemplate.prototype.edit( $(this).attr("data-value") );
                    });

                    $(".list_for_delete").click(function(){
                        PluginTemplate.prototype._delete( $(this).attr("data-value") );
                    });
                }else{
                    var emptyHtml = defineStatusHtml({
                        message : '暂无数据',
                        handleHtml: ''
                    })
                    $('#'+_options.list_render_id).html($('<div class="row" id="' + _options.list_render_id + '_wrap"></div>'))
                    $('#'+_options.list_render_id + '_wrap').append(emptyHtml.html)
                }

            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    };


    PluginTemplate.prototype.create = function( ) {
        $("#modal-project_tpl").modal('show');
        $('#modal-header-title').html('创建模板');
        $('#form-plugin')[0].reset();
        $("#id_action").val('add');
        $("#id_name").attr('readonly', false);
        $('#tip_name').show();
        $("#id_image_bg").val('');
        $("#id_category").val('');
        $("#id_category").selectpicker('refresh');
        console.log(window.uploader)
        window.uploader.reset();

    };

    PluginTemplate.prototype.edit = function(id ) {

        $("#modal-project_tpl").modal('show');
        $('#modal-header-title').html('编辑模板');
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
                $("#id_category").val(resp.data.type);
                $("#id_description").text(resp.data.description);
                $("#id_image_bg").val(resp.data.image_bg);

                $('.selectpicker').selectpicker('refresh');
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    };



    PluginTemplate.prototype.add = function(  ) {

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
                    alert('保存成功,跳转下一页');
                }else{
                    notify_error( resp.msg ,resp.data);
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    };

    PluginTemplate.prototype.update = function(  ) {

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

    PluginTemplate.prototype.patch = function( params ) {

        var method = 'post';
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: _options.update_url,
            data: params ,
            success: function (resp) {
                auth_check(resp);
                if( resp.ret ==='200'  ){
                     return true;
                }else{
                    return false;
                }

            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    };

    PluginTemplate.prototype.install = function(name ) {

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
                    window.location.reload();
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    };

    PluginTemplate.prototype.uninstall = function(id ) {

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
                    window.location.reload();
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    };

    PluginTemplate.prototype._delete = function(name ) {

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

    return PluginTemplate;
})();

