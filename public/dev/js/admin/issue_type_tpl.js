
var IssueTypeTpl = (function() {

    var _options = {};

    // constructor
    function IssueTypeTpl(  options  ) {
        _options = options;

        $("#btn-issue_type_add").click(function(){
            IssueTypeTpl.prototype.add();
        });

        $("#btn-issue_type_update").click(function(){
            IssueTypeTpl.prototype.update();
        });
    };

    IssueTypeTpl.prototype.getOptions = function() {
        return _options;
    };

    IssueTypeTpl.prototype.setOptions = function( options ) {
        for( i in  options )  {
           // if( typeof( _options[options[i]] )=='undefined' ){
                _options[i] = options[i];
           // }
        }
    };

    IssueTypeTpl.prototype.fetchAll = function(  ) {

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
                if(resp.data.tpls.length){
                    var source = $('#'+_options.list_tpl_id).html();
                    var template = Handlebars.compile(source);
                    var result = template(resp.data);
                    $('#' + _options.list_render_id).html(result);

                    $(".list_for_edit").click(function(){
                        IssueTypeTpl.prototype.edit( $(this).attr("data-value") );
                    });

                    $(".list_for_bind ").click(function(){
                        IssueTypeTpl.prototype.bind_edit( $(this).attr("data-value") );
                    });
                    $(".list_for_delete").click(function(){
                        IssueTypeTpl.prototype._delete( $(this).attr("data-value") );
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

    IssueTypeTpl.prototype.bind_edit = function(id ) {

        var method = 'get';
        var url =_options.get_bind_url;
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: url,
            data: {id:id} ,
            success: function (resp) {

                auth_check(resp);
                $("#modal-bind_issue_types").modal();
                $("#bind_tpl_id").val( id );

                var obj3 = document.getElementById('for_issue_types');
                obj3.options.length = 0;
                for(var i = 0; i < resp.data.issue_types.length; i++){
                    obj3.options.add(new Option( resp.data.issue_types[i].name, resp.data.issue_types[i].id ));
                }
                $('.selectpicker').selectpicker('refresh');
                $('#for_issue_types').selectpicker('refresh');
                $('#for_issue_types').selectpicker('val', resp.data.bind_issue_types);
                $('.selectpicker').selectpicker();

            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    IssueTypeTpl.prototype.bindIssueTypes= function( ) {

        var method = 'post';
        var url =_options.bind_url;
        var params = $('#form-for_issue_types').serialize();
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: url,
            data: params ,
            success: function (resp) {
                auth_check(resp);

                if( resp.ret == 200 ){
                    window.location.reload();
                    notify_success( resp.msg);
                }else{
                    notify_error( resp.msg ,resp.data );
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    IssueTypeTpl.prototype.edit = function(id ) {

        var method = 'get';
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: _options.get_url,
            data: { id:id} ,
            success: function (resp) {

                auth_check(resp);
                $("#modal-issue_type_edit").modal();
                $("#edit_id").val(resp.data.id);
                $("#edit_name").val(resp.data.name);
                $("#edit_content").val(resp.data.content);
                _editor_edit = editormd("edit_description", {
                    width: "100%",
                    height: 300,
                    markdown: resp.data.content,
                    watch: false,
                    lineNumbers: false,
                    path: root_url+'dev/lib/editor.md/lib/',
                    imageUpload: true,
                    imageFormats: ["jpg", "jpeg", "gif", "png", "bmp", "webp"],
                    imageUploadURL: root_url+"issue/detail/editormd_upload",
                    tocm: true,    // Using [TOCM]
                    emoji: true,
                    saveHTMLToTextarea: true,
                    toolbarIcons: "custom",
                    placeholder: "",
                    autoFocus: false
                });
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    IssueTypeTpl.prototype.add = function(  ) {

        var method = 'post';
        $("#add_content").val(_editor_add.getMarkdown());
        var params = $('#form_add').serialize();
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: _options.add_url,
            data: params ,
            success: function (resp) {
                auth_check(resp);
               // notify_success( resp.msg );
                if( resp.ret == 200 ){
                    window.location.reload();
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    IssueTypeTpl.prototype.update = function(  ) {

        var method = 'post';
        $("#edit_content").val(_editor_edit.getMarkdown());
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

    IssueTypeTpl.prototype._delete = function(id ) {

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

    return IssueTypeTpl;
})();


