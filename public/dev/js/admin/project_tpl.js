
var PluginTemplate = (function() {

    var _options = {};

    // constructor
    function PluginTemplate( options ) {
        _options = options;
        $("#btn-project_tpl_save").click(function(){
            if($('#id_action').val()==='add'){
                PluginTemplate.prototype.add();
            }
            if($('#id_action').val()==='add'){
                PluginTemplate.prototype.update();
            }
            if($('#id_action').val()==='copy'){
                PluginTemplate.prototype.postCopy();
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

    PluginTemplate.prototype.bindEvent = function( ) {
        $('#page_layout').change(function () {
            PluginTemplate.prototype.updateSelectData({page_layout: $(this).val() });
        });
        $('#project_view').change(function () {
            PluginTemplate.prototype.updateSelectData({project_view: $(this).val() });
        });
        $('#issue_view').change(function () {
            PluginTemplate.prototype.updateSelectData({issue_view: $(this).val() });
        });
        $('#issue_type_scheme_id').change(function () {
            PluginTemplate.prototype.updateSelectData({issue_type_scheme_id: $(this).val() });
        });
        $('#issue_workflow_scheme_id').change(function () {
            PluginTemplate.prototype.updateSelectData({issue_workflow_scheme_id: $(this).val() });
        });
        $('#issue_ui_scheme_id').change(function () {
            PluginTemplate.prototype.updateSelectData({issue_ui_scheme_id: $(this).val() });
        });
    };

    PluginTemplate.prototype.updateSelectData = function(selected_data ) {

        selected_data['id'] = window.projetc_tpl_id;
        var method = 'post';
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: _options.patch_url,
            data: selected_data ,
            success: function (resp) {
                auth_check(resp);
                if( resp.ret ==='200'  ){
                    notify_success( resp.msg );
                }else{
                    notify_error( resp.msg );
                }

            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
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

                    $(".tpl_edit_link").click(function(){
                        PluginTemplate.prototype.edit($(this).data("id"));
                    });
                    $(".tpl_copy_link").click(function(){
                        PluginTemplate.prototype.copy($(this).data("id"));
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
        $("#image_bg_display").hide();
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
                var tpl = resp.data.tpl;
                $("#edit_id").val(tpl.id);
                $("#id_name").val(tpl.name);
                $('#tip_name').hide();
                $("#id_category").val(tpl.category_id);
                $("#id_description").text(tpl.description);
                $("#id_image_bg").val(tpl.image_bg);
                $("#image_bg_display").show();
                $("#image_bg_display").attr('src',tpl.image_bg);
                if (window.uploader) {
                    window.uploader.reset();
                }
                $('.selectpicker').selectpicker('refresh');
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    };

    PluginTemplate.prototype.copy = function(id ) {
        $("#modal-project_tpl").modal('show');
        $('#modal-header-title').html('复制模板');
        $("#id_action").val('copy');
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
                var tpl = resp.data.tpl;
                $("#edit_id").val(tpl.id);
                $("#id_name").val(tpl.name);
                $('#tip_name').hide();
                $("#id_category").val(tpl.category_id);
                $("#id_description").text(tpl.description);
                $("#id_image_bg").val(tpl.image_bg);
                $("#image_bg_display").show();
                $("#image_bg_display").attr('src',tpl.image_bg);
                if (window.uploader) {
                    window.uploader.reset();
                }
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
                    window.location.href = '/admin/project_tpl/edit?id='+resp.data;
                }else{
                    notify_error( resp.msg ,resp.data);
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    };


    PluginTemplate.prototype.postCopy = function(  ) {

        var method = 'post';
        var params = $('#form-plugin').serialize();
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: _options.post_copy_url,
            data: params ,
            success: function (resp) {
                auth_check(resp);
                if( resp.ret ==='200'  ){
                    //window.location.reload();
                }else{
                    notify_error( resp.msg );
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

