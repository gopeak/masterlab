
var Org = (function() {

    var _options = {};
 

    var _active_tab = 'create_default_tab';

    // constructor
    function Org(  options  ) {
        _options = options;


    };

    Org.prototype.getOptions = function() {
        return _options;
    };

    Org.prototype.setOptions = function( options ) {
        for( i in  options )  {
            // if( typeof( _options[options[i]] )=='undefined' ){
            _options[i] = options[i];
            // }
        }
    };

    Org.prototype.fetch = function(id ) {

        $('#id').val( id );
        var method = 'get';
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: root_url+"org/get/"+id,
            data: {} ,
            success: function (resp) {
                console.log(resp)
                auth_check(resp);
                var origin  = resp.data.org;
                $('#path').val(origin.path);
                $('#path').attr("readonly","readonly");
                $('#name').val(origin.name);
                $('#description').val(origin.description);
                $('#avatar_display').attr('src',origin.avatar);
                $('#avatar_display').removeClass('hidden');
                $('input:radio[name="params[scope]"]').removeAttr('checked');
                $('#origin_scope'+origin.scope).attr("checked","checked");

            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    Org.prototype.detail = function(id ) {

        $('#id').val( id );
        var method = 'get';
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: root_url+"org/get/"+id,
            data: {} ,
            success: function (resp) {
                auth_check(resp);
                var origin  = resp.data.org;
                console.log(origin);
                $('#org_path').html(origin.path);
                $('#org_name').html(origin.name);
                $('#org_description').html(origin.description);
				if(origin.avatarExist===true){
					$('#org_avatar').attr('src',origin.avatar);
					$('#org_avatar').show();
				}
				else{
					$('#org_first_word').show();
					$('#org_first_word').html(origin.first_word);
				}
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }
    Org.prototype.fetchProjects = function(id ) {

        $('#id').val( id );
        var method = 'get';
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: root_url+"org/fetchProjects/"+id,
            data: {} ,
            success: function (resp) {
                auth_check(resp);
                console.log(resp)
                if(resp.data.projects.length){
                    var source = $('#list_tpl').html();
                    var template = Handlebars.compile(source);
                    var result = template(resp.data);
                    $('#projects_list').html(result);
                }else{
                    var emptyHtml = defineStatusHtml({
                        message : '数据为空',
                        type: 'image',
                        name: 'computer'
                    })
                    $('#projects_list').append($('<tr><td colspan="2" id="panel_assignee_issues_wrap"></td></tr>'))
                    $('#projects_list').append(emptyHtml.html)
                }
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }


    Org.prototype.add = function(  ) {

        var url = $('#origin_form').attr('action')
        var uploads = _fineUploader.getUploads({
            status: qq.status.UPLOAD_SUCCESSFUL
        });
        $('#fine_uploader_json').val(JSON.stringify(uploads))
        var method = 'post';
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: url,
            data: $('#origin_form').serialize(),
            success: function (resp) {

                auth_check(resp);
                if(!form_check(resp)){
                    return;
                }
                if( resp.ret=='200'){
                    notify_success("保存成功");
                    setTimeout(function(){window.location.href = root_url+'org'},2000);
                }else {
                    notify_error(resp.msg);
                }

            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    Org.prototype.update = function(  ) {

        var url =  root_url+'org/update';
        var uploads = _fineUploader.getUploads({
            status: qq.status.UPLOAD_SUCCESSFUL
        });
        $('#fine_uploader_json').val(JSON.stringify(uploads))
        var method = 'post';
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: url,
            data: $('#origin_form').serialize(),
            success: function (resp) {

                auth_check(resp);
                //notify_error(resp.msg);
                if( resp.ret=='200'){
                    window.location.href = root_url + 'org';
                }else {
                    notify_error(resp.msg);
                }

            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    Org.prototype.delete = function( id ) {

        if(!window.confirm("您是否确认删除该组织？")){
            return false;
        }

        $.ajax({
            type: 'get',
            dataType: "json",
            async: false,
            url:  root_url+'org/check_delete/'+id,
            success: function (resp) {

                auth_check(resp);
                if( resp.data.delete==true){
                    $.ajax({
                        type: 'post',
                        dataType: "json",
                        async: true,
                        url: root_url+'org/delete/'+id,
                        success: function (resp) {
                            auth_check(resp);
                            //notify_error(resp.msg);
                            if( resp.ret=='200'){
                                window.location.reload();
                            }else {
                                notify_error(resp.msg);
                            }
                        },
                        error: function (res) {
                            notify_error("请求数据错误" + res);
                        }
                    });
                }else {
                    notify_error(resp.data.err_msg);
                }

            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });


    }

    Org.prototype.fetchAll = function(  ) {

        // url,  list_tpl_id, list_render_id
        var params = {  format:'json' };
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: _options.filter_url,
            data: {} ,
            success: function (resp) {
                auth_check(resp);
                if(resp.data.orgs.length){
                    var source = $('#'+_options.list_tpl_id).html();
                    var template = Handlebars.compile(source);
                    var result = template(resp.data);
                    $('#' + _options.list_render_id).html(result);

                    $(".list_for_delete").click(function(){
                        Org.prototype.delete( $(this).data("id"));
                    });
                }else{
                    var emptyHtml = defineStatusHtml({
                        message : '数据为空',
                        type: 'string',
                        handleHtml: '<a href="'+root_url+'project/main/_new">创建组织</a>'
                    })
                    $('#list_render_id').append($('<tr><td colspan="5" id="list_render_id_wrap"></td></tr>'))
                    $('#list_render_id_wrap').append(emptyHtml.html)
                }
                
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    return Org;
})();

