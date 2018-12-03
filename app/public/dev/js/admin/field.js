
var Field = (function() {

    var _options = {};

    var _add_options = {};
    var _edit_options = {};

    // constructor
    function Field(  options  ) {
        _options = options;

        $("#btn-field_add").click(function(){
            Field.prototype.add();
        });

        $("#btn-field_update").click(function(){
            Field.prototype.update();
        });

        $("#btn-options_add").click(function(){
            Field.prototype.options_add();
        });

        $("#btn-options_edit").click(function(){
            Field.prototype.options_edit();
        });
    };

    Field.prototype.getOptions = function() {
        return _options;
    };

    Field.prototype.setOptions = function( options ) {
        for( i in  options )  {
           // if( typeof( _options[options[i]] )=='undefined' ){
                _options[i] = options[i];
           // }
        }
    };

    Field.prototype.fetchFields = function(  ) {

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
                if(resp.data.fields.length){
                    var source = $('#'+_options.list_tpl_id).html();
                    var template = Handlebars.compile(source);
                    var result = template(resp.data);
                    $('#' + _options.list_render_id).html(result);

                    $(".list_for_edit").click(function(){
                        Field.prototype.edit( $(this).attr("data-value") );
                    });

                    $(".list_for_delete").click(function(){
                        Field.prototype._delete( $(this).attr("data-value") );
                    });

                    var field_types = resp.data.field_types;
                    var obj=document.getElementById('field_type_id');
                    for(var i = 0; i < field_types.length; i++){
                        obj.options.add(new Option( field_types[i].name, field_types[i].type ));
                    }
                    $('.selectpicker').selectpicker('refresh');
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

    Field.prototype.options_add = function(  ) {
        var option_name = $('#add_option_name').val();
        var option_value = $('#add_option_value').val();
        if(!option_value || !option_name){
            return ;
        }
        if(!_.has(_add_options, option_value) ){
            _add_options[option_value] = option_name;
        }
        console.log(_add_options);
        $('#add_option_name').val('');
        $('#add_option_value').val('');
        Field.prototype.options_format();
        Field.prototype.options_render('add_option_render_id',_add_options);
    }

    Field.prototype.options_edit = function(  ) {
        var option_name = $('#edit_option_name').val();
        var option_value = $('#edit_option_value').val();
        if(!option_name || !option_value){
            return ;
        }
        if(!_.has(_edit_options, option_value) ){
            _edit_options[option_value] = option_name;
        }
        console.log(_edit_options);
        $('#edit_option_name').val('');
        $('#edit_option_value').val('');
        Field.prototype.options_format();
        Field.prototype.options_render('edit_option_render_id',_edit_options);
    }


    Field.prototype.options_format = function(  ) {
        $('#add_options').val(JSON.stringify(_add_options));
        $('#edit_options').val(JSON.stringify(_edit_options));
    }

    Field.prototype.options_render = function( render_id,_add_options ) {

        var html = '';
        for( var _key in _add_options ){
            var btn_class = 'add_option_delete';
            var btn_default_class = 'add_option_default';
            if( render_id=='edit_option_render_id' ){
                btn_class = 'edit_option_delete';
                btn_default_class = 'edit_option_default';
            }
            html += '<tr class="commit">\n' +
                '      <td  ><strong>'+_key+'</strong></td>\n' +
                '      <td>--></td>\n' +
                '      <td>'+_add_options[_key]+'</td>\n' +
                '      <td  ><a class=" '+btn_default_class+' btn btn-transparent "  href="javascript:;" data-value="'+_key+'" >设置默认值</a><a class="'+btn_class+' btn btn-transparent "  href="javascript:;" data-value="'+_key+'" ><i class="fa fa-trash"></i><span class="sr-only">删除</span></a></td>\n' +
                '  </tr>';
        }
        $('#'+render_id).html(html);

        $(".add_option_delete").click(function(){
            Field.prototype.add_option_delete( $(this).attr("data-value") );
        });
        $(".edit_option_delete").click(function(){
            Field.prototype.edit_option_delete( $(this).attr("data-value") );
        });
    }
    Field.prototype.add_option_delete = function( _key ) {
        delete _add_options[_key]
        Field.prototype.options_format();
        Field.prototype.options_render('add_option_render_id',_add_options);
    }

    Field.prototype.edit_option_delete = function( _key ) {
        delete _edit_options[_key]
        Field.prototype.options_format();
        Field.prototype.options_render('edit_option_render_id',_edit_options);
    }

    Field.prototype.edit = function(id ) {

        var method = 'get';
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: _options.get_url,
            data: { id:id} ,
            success: function (resp) {

                auth_check(resp);
                $("#modal-field_edit").modal();
                $("#edit_id").val(resp.data.id);
                $("#edit_name").val(resp.data.name);
                $("#edit_description").val(resp.data.description);
                _edit_options = resp.data.options;
                $('#edit_options').val(JSON.stringify(_edit_options));
                Field.prototype.options_render('edit_option_render_id',_edit_options);
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    Field.prototype.add = function(  ) {

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

    Field.prototype.update = function(  ) {

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

    Field.prototype._delete = function(id ) {


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

    return Field;
})();


